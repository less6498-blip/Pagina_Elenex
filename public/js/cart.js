/* ============================================================
   ELENEX — CART ENGINE
   cart.js | v1.0
   
   Arquitectura:
   ┌─────────────────────────────────────────────────────────┐
   │  CartStore   → gestión de datos (localStorage)          │
   │  CartUI      → renderizado y animaciones                │
   │  CartEvents  → event listeners centralizados            │
   └─────────────────────────────────────────────────────────┘
   
   Para migrar a PHP sessions / DB:
   Reemplaza los métodos de CartStore._load() y CartStore._save()
   por llamadas fetch() a tus endpoints de Laravel.
   ============================================================ */

'use strict';

/* ══════════════════════════════════════════════════════════════
   1. CART STORE — Capa de datos
   Toda la lógica de persistencia está aquí.
   Al migrar a Laravel: solo modifica este módulo.
══════════════════════════════════════════════════════════════ */
const CartStore = (() => {
  const STORAGE_KEY = 'elenex_cart';

  // ── Leer desde localStorage ──────────────────────────────
  function _load() {
    try {
      return JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
    } catch {
      return [];
    }
  }

  // ── Guardar en localStorage ──────────────────────────────
  function _save(items) {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(items));
  }

  // ── API pública ──────────────────────────────────────────

  /** Devuelve todos los items del carrito */
  function getAll() {
    return _load();
  }

  /**
   * Agrega un producto o incrementa su cantidad.
   * @param {Object} product - { id, name, price, image, quantity, variant? }
   * @returns {Object} item resultante
   */
  function add(product) {
    const items = _load();
    const idx   = items.findIndex(i => i.id === product.id);

    if (idx > -1) {
      items[idx].quantity += (product.quantity || 1);
    } else {
      items.push({
        id:       product.id,
        name:     product.name,
        price:    parseFloat(product.price),
        image:    product.image || '',
        variant:  product.variant || '',
        quantity: product.quantity || 1,
      });
    }
    _save(items);
    return items[idx > -1 ? idx : items.length - 1];
  }

  /**
   * Actualiza la cantidad de un item.
   * Si qty <= 0, elimina el item.
   */
  function updateQty(id, qty) {
    let items = _load();
    if (qty <= 0) {
      items = items.filter(i => i.id !== id);
    } else {
      const idx = items.findIndex(i => i.id === id);
      if (idx > -1) items[idx].quantity = qty;
    }
    _save(items);
  }

  /** Elimina un item por ID */
  function remove(id) {
    _save(_load().filter(i => i.id !== id));
  }

  /** Vacía el carrito */
  function clear() {
    _save([]);
  }

  /** Total de unidades (suma de quantities) */
  function totalItems() {
    return _load().reduce((acc, i) => acc + i.quantity, 0);
  }

  /** Subtotal en soles */
  function subtotal() {
    return _load().reduce((acc, i) => acc + (i.price * i.quantity), 0);
  }

  return { getAll, add, updateQty, remove, clear, totalItems, subtotal };
})();


/* ══════════════════════════════════════════════════════════════
   2. CART UI — Capa de presentación
══════════════════════════════════════════════════════════════ */
const CartUI = (() => {

  // ── Selectores (cacheados una sola vez) ──────────────────
  const $ = id => document.getElementById(id);

  let badge, overlay, drawer, itemsContainer, subtotalEl,
      totalEl, checkoutBtn, emptyBtn, toastOverlay, toastEl;

  /** Inyecta en el DOM los elementos del carrito */
  function _injectHTML() {
    // ── Toast / Modal ────────────────────────────────────
    const toastHTML = `
      <div class="cart-toast-overlay" id="cartToastOverlay" role="dialog" aria-modal="true" aria-label="Producto agregado al carrito">
        <div class="cart-toast">
          <div class="cart-toast__header">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22543d" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
            Producto agregado al carrito
          </div>
          <div class="cart-toast__body">
            <img class="cart-toast__img" id="toastImg" src="" alt="">
            <div class="cart-toast__info">
              <div class="cart-toast__name" id="toastName"></div>
              <div class="cart-toast__meta" id="toastMeta"></div>
              <div class="cart-toast__price" id="toastPrice"></div>
            </div>
          </div>
          <div class="cart-toast__actions">
            <button class="cart-toast__btn cart-toast__btn--primary" id="toastViewCart">Ver carrito</button>
            <button class="cart-toast__btn cart-toast__btn--secondary" id="toastContinue">Seguir comprando</button>
          </div>
        </div>
      </div>`;

    // ── Overlay ──────────────────────────────────────────
    const overlayHTML = `<div class="cart-overlay" id="cartOverlay" aria-hidden="true"></div>`;

    // ── Drawer ───────────────────────────────────────────
    const drawerHTML = `
      <aside class="cart-drawer" id="cartDrawer" role="dialog" aria-modal="true" aria-label="Tu carrito de compras">
        <!-- Head -->
        <div class="cart-drawer__head">
          <div>
            <span class="cart-drawer__title">Tu Carrito</span>
            <span class="cart-drawer__count" id="cartDrawerCount"></span>
          </div>
          <button class="cart-drawer__close" id="cartDrawerClose" aria-label="Cerrar carrito">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <line x1="18" y1="6" x2="6" y2="18"></line>
              <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
          </button>
        </div>

        <!-- Items -->
        <div class="cart-drawer__items" id="cartItems" aria-live="polite"></div>

        <!-- Footer -->
        <div class="cart-drawer__footer" id="cartFooter">
          <div class="cart-summary">
            <div class="cart-summary__row">
              <span>Subtotal</span>
              <span id="cartSubtotal">S/ 0.00</span>
            </div>
            <div class="cart-summary__row">
              <span>Envío</span>
              <span>Calculado al pagar</span>
            </div>
            <div class="cart-summary__row cart-summary__row--total">
              <span>Total</span>
              <span id="cartTotal">S/ 0.00</span>
            </div>
          </div>
          <button class="cart-btn-checkout" id="cartCheckout" aria-label="Proceder al pago">
            Proceder al pago →
          </button>
          <button class="cart-btn-empty" id="cartEmpty" aria-label="Vaciar carrito">
            Vaciar carrito
          </button>
        </div>
      </aside>`;

    // Insertar todo al final del body
    document.body.insertAdjacentHTML('beforeend', toastHTML + overlayHTML + drawerHTML);
  }

  /** Cachea referencias al DOM inyectado */
  function _cacheRefs() {
    badge          = document.querySelector('.cart-badge');
    overlay        = $('cartOverlay');
    drawer         = $('cartDrawer');
    itemsContainer = $('cartItems');
    subtotalEl     = $('cartSubtotal');
    totalEl        = $('cartTotal');
    checkoutBtn    = $('cartCheckout');
    emptyBtn       = $('cartEmpty');
    toastOverlay   = $('cartToastOverlay');
    toastEl        = toastOverlay?.querySelector('.cart-toast');
  }

  // ── Badge ────────────────────────────────────────────────
  function updateBadge() {
    if (!badge) return;
    const count = CartStore.totalItems();
    badge.textContent = count;
    badge.style.display = count > 0 ? 'block' : 'none';

    // Animación "pop"
    badge.classList.remove('pop');
    void badge.offsetWidth; // reflow
    badge.classList.add('pop');
    setTimeout(() => badge.classList.remove('pop'), 300);
  }

  // ── Toast ────────────────────────────────────────────────
  function showToast(product) {
    if (!toastOverlay) return;
    $('toastImg').src     = product.image || '';
    $('toastImg').alt     = product.name;
    $('toastName').textContent = product.name;
    $('toastMeta').textContent = `Cantidad: ${product.quantity || 1}`;
    $('toastPrice').textContent = `S/ ${parseFloat(product.price).toFixed(2)}`;

    toastOverlay.classList.add('show');

    // Auto-close after 6s
    clearTimeout(CartUI._toastTimer);
    CartUI._toastTimer = setTimeout(hideToast, 6000);
  }

  function hideToast() {
    toastOverlay?.classList.remove('show');
  }

  // ── Drawer ───────────────────────────────────────────────
  function openDrawer() {
    renderItems();
    drawer?.classList.add('open');
    overlay?.classList.add('show');
    document.body.style.overflow = 'hidden';
  }

  function closeDrawer() {
    drawer?.classList.remove('open');
    overlay?.classList.remove('show');
    document.body.style.overflow = '';
  }

  /** Formatea precio en soles */
  function _fmt(n) {
    return `S/ ${parseFloat(n).toFixed(2)}`;
  }

  /** Genera el HTML de un item del carrito */
  function _itemHTML(item) {
    return `
      <div class="cart-item" data-id="${item.id}">
        <img class="cart-item__img" src="${item.image}" alt="${item.name}" loading="lazy">
        <div class="cart-item__info">
          <div class="cart-item__name">${item.name}</div>
          ${item.variant ? `<div class="cart-item__variant">${item.variant}</div>` : ''}
          <div class="cart-item__price">${_fmt(item.price)} / und.</div>
          <div class="cart-item__qty" role="group" aria-label="Cantidad de ${item.name}">
            <button class="cart-item__qty-btn" data-action="dec" data-id="${item.id}" aria-label="Reducir cantidad">−</button>
            <span class="cart-item__qty-val" aria-live="polite">${item.quantity}</span>
            <button class="cart-item__qty-btn" data-action="inc" data-id="${item.id}" aria-label="Aumentar cantidad">+</button>
          </div>
          <div class="cart-item__subtotal">${_fmt(item.price * item.quantity)}</div>
        </div>
        <button class="cart-item__remove" data-id="${item.id}" aria-label="Eliminar ${item.name} del carrito">×</button>
      </div>`;
  }

  /** Renderiza los items en el drawer */
  function renderItems() {
    const items = CartStore.getAll();
    const count = CartStore.totalItems();
    const sub   = CartStore.subtotal();

    // Contador en el header del drawer
    if ($('cartDrawerCount')) {
      $('cartDrawerCount').textContent = count > 0 ? `(${count} ${count === 1 ? 'item' : 'items'})` : '';
    }

    if (items.length === 0) {
      itemsContainer.innerHTML = `
        <div class="cart-empty">
          <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
          </svg>
          <div class="cart-empty__title">Tu carrito está vacío</div>
          <div class="cart-empty__sub">Agrega productos para comenzar</div>
        </div>`;
      $('cartFooter').style.display = 'none';
      return;
    }

    $('cartFooter').style.display = '';
    itemsContainer.innerHTML = items.map(_itemHTML).join('');

    // Actualizar totales
    if (subtotalEl) subtotalEl.textContent = _fmt(sub);
    if (totalEl)    totalEl.textContent    = _fmt(sub); // + shipping cuando esté disponible
  }

  return {
    _toastTimer: null,
    injectHTML:  _injectHTML,
    cacheRefs:   _cacheRefs,
    updateBadge,
    showToast,
    hideToast,
    openDrawer,
    closeDrawer,
    renderItems,
    // Exponer overlay/drawer para events
    get overlayEl() { return overlay; },
    get drawerEl()  { return drawer; },
  };
})();


/* ══════════════════════════════════════════════════════════════
   3. CART EVENTS — Capa de eventos
══════════════════════════════════════════════════════════════ */
const CartEvents = (() => {

  /** Configura todos los event listeners */
  function init() {
    // ── Toast: "Ver carrito" ─────────────────────────────
    document.addEventListener('click', e => {
      if (e.target.id === 'toastViewCart') {
        CartUI.hideToast();
        CartUI.openDrawer();
      }
    });

    // ── Toast: "Seguir comprando" ────────────────────────
    document.addEventListener('click', e => {
      if (e.target.id === 'toastContinue') CartUI.hideToast();
    });

    // ── Cerrar toast al click fuera ──────────────────────
    document.addEventListener('click', e => {
      if (e.target.id === 'cartToastOverlay') CartUI.hideToast();
    });

    // ── Abrir drawer desde icono del carrito ─────────────
    // Usamos delegación para que funcione con cualquier selector .cart-btn
    document.addEventListener('click', e => {
      const cartBtn = e.target.closest('.cart-btn');
      if (cartBtn && !cartBtn.hasAttribute('data-add-to-cart')) {
        e.preventDefault();
        CartUI.openDrawer();
      }
    });

    // ── Cerrar drawer ─────────────────────────────────────
    document.addEventListener('click', e => {
  if (e.target.closest('#cartDrawerClose') || e.target.id === 'cartOverlay') {
    CartUI.closeDrawer();
  }
});

    // ── Vaciar carrito ────────────────────────────────────
    document.addEventListener('click', e => {
      if (e.target.id === 'cartEmpty') {
        CartStore.clear();
        CartUI.renderItems();
        CartUI.updateBadge();
      }
    });

    // ── Checkout ──────────────────────────────────────────
    document.addEventListener('click', e => {
      if (e.target.id === 'cartCheckout') {
        // TODO: conectar con tu ruta de checkout Laravel
        // window.location.href = '/checkout';
        console.log('Checkout:', CartStore.getAll());
        alert('Conecta esta acción con tu ruta de checkout.');
      }
    });

    // ── Botones dentro del drawer (delegación) ────────────
    document.addEventListener('click', e => {
      // Botón + / -
      const qtyBtn = e.target.closest('.cart-item__qty-btn');
      if (qtyBtn) {
        const id     = qtyBtn.dataset.id;
        const action = qtyBtn.dataset.action;
        const items  = CartStore.getAll();
        const item   = items.find(i => i.id === id);
        if (!item) return;

        const newQty = action === 'inc' ? item.quantity + 1 : item.quantity - 1;
        CartStore.updateQty(id, newQty);
        CartUI.renderItems();
        CartUI.updateBadge();
      }

      // Botón ×
      const removeBtn = e.target.closest('.cart-item__remove');
      if (removeBtn) {
        CartStore.remove(removeBtn.dataset.id);
        CartUI.renderItems();
        CartUI.updateBadge();
      }
    });

    // ── Botones "Agregar al carrito" ──────────────────────
    // Escucha el evento personalizado que lanzará cada botón de producto
    document.addEventListener('cart:add', e => {
      const product = e.detail;
      if (!product?.id) return;

      CartStore.add(product);
      CartUI.updateBadge();
      CartUI.showToast(product);
    });

    // ── ESC para cerrar ───────────────────────────────────
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') {
        CartUI.hideToast();
        CartUI.closeDrawer();
      }
    });
  }

  return { init };
})();


/* ══════════════════════════════════════════════════════════════
   4. INIT — Punto de entrada
══════════════════════════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', () => {
  CartUI.injectHTML();   // 1. Inyectar HTML del carrito en el DOM
  CartUI.cacheRefs();    // 2. Cachear referencias
  CartUI.updateBadge();  // 3. Actualizar badge con datos existentes
  CartEvents.init();     // 4. Activar eventos
});


/* ══════════════════════════════════════════════════════════════
   5. HELPER GLOBAL
   Usa esta función desde cualquier botón de producto:
   
   addToCart({
     id:      '123',
     name:    'Vestido Floral',
     price:   89.90,
     image:   '/img/vestido.jpg',
     variant: 'Talla M',    // opcional
     quantity: 1            // opcional, default 1
   });
══════════════════════════════════════════════════════════════ */
window.addToCart = function(product) {
  document.dispatchEvent(new CustomEvent('cart:add', { detail: product }));
};