@extends('layouts.app')
@section('title', 'Checkout | Elenex')

@section('content')
<div class="checkout-wrapper" style="padding-top: 190px; padding-bottom: 60px; background: #f8f9fa; min-height: 100vh;">
  <div class="container">
    <h1 class="text-center fw-bold mb-5" style="font-weight: 700;">Finalizar Compra </h1>
  
  <div class="row g-4">

    {{-- ── COLUMNA IZQUIERDA: Formulario ── --}}
    <div class="col-lg-8">

      {{-- Datos personales --}}
      <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
          <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
            <span class="d-flex align-items-center justify-content-center bg-dark text-white rounded-circle"
                  style="width:28px;height:28px;font-size:13px;flex-shrink:0;">1</span>
            Datos de contacto
          </h5>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-medium" style="font-size:14px;">Nombre completo *</label>
              <input type="text" id="inp-nombre" placeholder="Juan García"
                     class="form-control" style="border-radius:10px;">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-medium" style="font-size:14px;">Correo electrónico *</label>
              <input type="email" id="inp-email" placeholder="juan@email.com"
                     class="form-control" style="border-radius:10px;">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-medium" style="font-size:14px;">Teléfono</label>
              <input type="tel" id="inp-telefono" placeholder="987 654 321"
                     class="form-control" style="border-radius:10px;">
            </div>
          </div>
        </div>
      </div>

      {{-- Dirección --}}
      <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
          <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
            <span class="d-flex align-items-center justify-content-center bg-dark text-white rounded-circle"
                  style="width:28px;height:28px;font-size:13px;flex-shrink:0;">2</span>
            Dirección de envío
          </h5>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-medium" style="font-size:14px;">Departamento *</label>
              <select id="inp-departamento" class="form-select" style="border-radius:10px;">
                <option value="">Seleccionar...</option>
                <option>Lima</option>
                <option>Callao</option>
                <option>Arequipa</option>
                <option>Cusco</option>
                <option>La Libertad</option>
                <option>Piura</option>
                <option>Lambayeque</option>
                <option>Junín</option>
                <option>Ica</option>
                <option>Ancash</option>
                <option>Puno</option>
                <option>Cajamarca</option>
                <option>Otro</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-medium" style="font-size:14px;">Provincia *</label>
              <input type="text" id="inp-provincia" placeholder="Lima"
                     class="form-control" style="border-radius:10px;">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-medium" style="font-size:14px;">Distrito *</label>
              <input type="text" id="inp-distrito" placeholder="Miraflores"
                     class="form-control" style="border-radius:10px;">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-medium" style="font-size:14px;">Zona de envío *</label>
              <select id="inp-zona" class="form-select" style="border-radius:10px;">
                <option value="lima">Lima Metropolitana — S/ 10.00</option>
                <option value="provincias">Provincias — S/ 20.00</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label fw-medium" style="font-size:14px;">Dirección completa *</label>
              <input type="text" id="inp-direccion" placeholder="Av. Principal 123, Dpto 4B"
                     class="form-control" style="border-radius:10px;">
            </div>
            <div class="col-12">
              <label class="form-label fw-medium" style="font-size:14px;">Referencia (opcional)</label>
              <input type="text" id="inp-referencia" placeholder="Cerca al parque, portón azul..."
                     class="form-control" style="border-radius:10px;">
            </div>
          </div>
        </div>
      </div>

      {{-- Confirmar --}}
      <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
          <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
            <span class="d-flex align-items-center justify-content-center bg-dark text-white rounded-circle"
                  style="width:28px;height:28px;font-size:13px;flex-shrink:0;">3</span>
            Confirmar pedido
          </h5>
          {{-- Botón de pago --}}
<button type="button" id="btn-pagar"
        class="btn btn-dark w-100 py-3 fw-bold"
        style="border-radius:12px;font-size:19px;">
  Pagar ahora
</button>
<p id="form-error" class="text-danger text-center mt-3 small d-none"></p>
        </div>
      </div>

    </div>

    {{-- ── COLUMNA DERECHA: Resumen ── --}}
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 120px;">
        <div class="card-body p-4">
          <h5 class="fw-bold mb-4">Tu pedido</h5>

          {{-- Items --}}
          <div id="checkout-items" style="max-height:320px;overflow-y:auto;" class="mb-3"></div>

          {{-- Totales --}}
          <hr>
          <div class="d-flex justify-content-between text-muted small mb-2">
            <span>Subtotal</span>
            <span id="resumen-subtotal">S/ 0.00</span>
          </div>
          <div class="d-flex justify-content-between text-muted small mb-2">
            <span>Envío</span>
            <span id="resumen-envio">S/ 10.00</span>
          </div>
          <hr>
          <div class="d-flex justify-content-between fw-bold">
            <span>Total</span>
            <span id="resumen-total">S/ 0.00</span>
          </div>

          <div class="mt-3 p-3 rounded-3 text-center" style="background:#f8f9fa;">
            <small class="text-muted"> Tu pedido será procesado en 24-48h</small>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
</div>

<style>
  @media (max-width: 768px) {
    .checkout-wrapper { padding-top: 120px !important; }
  }
</style>

<script src="https://checkout.culqi.com/js/v4"></script>

<script>
const CSRF         = '{{ csrf_token() }}';
const URL_PROCESAR = '{{ route("checkout.procesar") }}';
const CULQI_PK     = '{{ env("CULQI_PUBLIC_KEY") }}';

const COSTO = {
    lima: 0.50,
    provincias: 20
};

/* =========================
   CART HELPERS
========================= */
function getCart() {
    try { return JSON.parse(localStorage.getItem('elenex_cart')) || []; }
    catch { return []; }
}

function fmt(n) {
    return 'S/ ' + parseFloat(n).toFixed(2);
}

/* =========================
   RESUMEN CHECKOUT
========================= */
function renderResumen() {
    const items = getCart();
    const zona  = document.getElementById('inp-zona').value;

    const envio = COSTO[zona] || 10;

    const subtotal = items.reduce(
        (a, i) => a + (i.price * i.quantity),
        0
    );

    const total = subtotal + envio;

    const container = document.getElementById('checkout-items');

    if (!items.length) {
        container.innerHTML = `
            <div class="text-center py-4">
                <p class="text-muted small mb-2">Tu carrito está vacío</p>
                <a href="/catalogo" class="text-dark small fw-bold">Ver productos →</a>
            </div>
        `;
    } else {
        container.innerHTML = items.map(item => `
            <div class="d-flex gap-3 align-items-center mb-3">
                <img src="${item.image || ''}"
                     style="width:64px;height:64px;object-fit:cover;border-radius:8px;border:1px solid #eee;">

                <div class="flex-grow-1">
                    <p class="mb-0 fw-semibold" style="font-size:13px;">${item.name}</p>
                    ${item.variant ? `<p class="mb-0 text-muted" style="font-size:11px;">${item.variant}</p>` : ''}
                    <p class="mb-0 fw-bold" style="font-size:13px;">
                        ${fmt(item.price * item.quantity)}
                    </p>
                </div>

                <div class="d-flex align-items-center"
                     style="border:1px solid #ddd;border-radius:8px;">
                    <button onclick="cambiarCantidad('${item.id}', -1)"
                            style="width:30px;height:30px;border:none;background:none;">−</button>

                    <span style="min-width:28px;text-align:center;">
                        ${item.quantity}
                    </span>

                    <button onclick="cambiarCantidad('${item.id}', 1)"
                            style="width:30px;height:30px;border:none;background:none;">+</button>
                </div>
            </div>
        `).join('');
    }

    document.getElementById('resumen-subtotal').textContent = fmt(subtotal);
    document.getElementById('resumen-envio').textContent    = fmt(envio);
    document.getElementById('resumen-total').textContent    = fmt(total);
    document.getElementById('btn-total-display').textContent = fmt(total);
}

/* =========================
   CANTIDAD
========================= */
function cambiarCantidad(id, delta) {
    let items = getCart();

    const idx = items.findIndex(i => i.id === id);
    if (idx === -1) return;

    items[idx].quantity += delta;

    if (items[idx].quantity <= 0) {
        items.splice(idx, 1);
    }

    localStorage.setItem('elenex_cart', JSON.stringify(items));
    renderResumen();
}

/* =========================
   VALIDACIÓN
========================= */
function mostrarError(msg) {
    const el = document.getElementById('form-error');
    el.textContent = msg;
    el.classList.remove('d-none');

    setTimeout(() => el.classList.add('d-none'), 4000);
}

function validar() {
    const campos = [
        { id: 'inp-nombre',       label: 'Nombre completo' },
        { id: 'inp-email',        label: 'Correo electrónico' },
        { id: 'inp-departamento', label: 'Departamento' },
        { id: 'inp-provincia',    label: 'Provincia' },
        { id: 'inp-distrito',     label: 'Distrito' },
        { id: 'inp-direccion',    label: 'Dirección' },
    ];

    for (const c of campos) {
        const el = document.getElementById(c.id);

        if (!el.value.trim()) {
            el.focus();
            mostrarError('Completa: ' + c.label);
            return false;
        }
    }

    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(document.getElementById('inp-email').value)) {
        mostrarError('Correo inválido');
        return false;
    }

    if (!getCart().length) {
        mostrarError('Tu carrito está vacío');
        return false;
    }

    return true;
}

/* =========================
   PROCESAR PAGO BACKEND
========================= */
async function procesarPago(token) {

    const zona  = document.getElementById('inp-zona').value;
    const envio = COSTO[zona] || 10;

    const items = getCart();

    const subtotal = items.reduce(
        (a, i) => a + (i.price * i.quantity),
        0
    );

    try {

        const res = await fetch(URL_PROCESAR, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                nombre:       document.getElementById('inp-nombre').value,
                email:        document.getElementById('inp-email').value,
                telefono:     document.getElementById('inp-telefono').value,
                departamento: document.getElementById('inp-departamento').value,
                provincia:    document.getElementById('inp-provincia').value,
                distrito:     document.getElementById('inp-distrito').value,
                direccion:    document.getElementById('inp-direccion').value,
                referencia:   document.getElementById('inp-referencia').value,
                zona_envio:   zona,
                culqi_token:  token,
                cart_items:   JSON.stringify(items),
            }),
        });

        const data = await res.json();

        if (data.success) {
            localStorage.removeItem('elenex_cart');
            window.location.href = data.redirect;
        } else {
            mostrarError(data.error || 'Error en el pago');
        }

    } catch (e) {
        mostrarError('Error de conexión');
    }
}

/* =========================
   CULQI CALLBACK (OBLIGATORIO)
========================= */
window.culqi = function () {

    if (Culqi.token) {
        procesarPago(Culqi.token.id);
    } else {
        mostrarError(
            Culqi.error?.user_message || 'Error al procesar pago'
        );
    }

    const btn = document.getElementById('btn-pagar');

    btn.disabled = false;
    btn.innerHTML =
        '🔒 Pagar con tarjeta — ' +
        document.getElementById('resumen-total').textContent;
};

/* =========================
   BOTÓN PAGAR
========================= */
document.getElementById('btn-pagar').addEventListener('click', () => {

    if (!validar()) return;

    const btn = document.getElementById('btn-pagar');

    btn.disabled = true;
    btn.innerHTML = `
        <span class="spinner-border spinner-border-sm me-2"></span>
        Procesando...
    `;

    const zona  = document.getElementById('inp-zona').value;
    const envio = COSTO[zona] || 10;

    const items = getCart();

    const total = items.reduce(
        (a, i) => a + (i.price * i.quantity),
        0
    ) + envio;

    /* =========================
       CONFIG CULQI (ESTABLE)
    ========================= */
    Culqi.publicKey = CULQI_PK;

    Culqi.settings({
        title: 'Elenex',
        currency: 'PEN',
        description: 'Compra en Elenex',
        amount: Math.round(total * 100),
    });

    Culqi.options({
        lang: 'auto',
        modal: true,
        paymentMethods: {
            tarjeta: true,
            yape: true
        },
        style: {
            logo: '{{ asset("img/elelogo.webp") }}',
            maincolor: '#000',
            buttontext: '#fff',
        },
    });

    Culqi.open();
});

/* =========================
   INIT
========================= */
document.getElementById('inp-zona')
    .addEventListener('change', renderResumen);

renderResumen();
</script>

@push('styles')
<style>
  body, #page-wrapper {
    background: #f8f9fa !important;
  }
</style>
@endpush
@endsection