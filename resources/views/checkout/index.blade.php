<script src="https://checkout.culqi.com/js/v4"></script>
<script>
const CSRF          = '{{ csrf_token() }}';
const URL_PROCESAR  = '{{ route("checkout.procesar") }}';
const CULQI_PK      = '{{ env("CULQI_PUBLIC_KEY") }}';
const COSTO         = { lima: 10, provincias: 20 };

function getCart() {
    try { return JSON.parse(localStorage.getItem('elenex_cart')) || []; }
    catch { return []; }
}

function fmt(n) { return 'S/ ' + parseFloat(n).toFixed(2); }

function renderResumen() {
    const items    = getCart();
    const zona     = document.getElementById('inp-zona').value;
    const envio    = COSTO[zona] || 10;
    const subtotal = items.reduce((a, i) => a + (i.price * i.quantity), 0);
    const total    = subtotal + envio;

    const container = document.getElementById('checkout-items');
    if (!items.length) {
        container.innerHTML = `<div class="text-center py-4">
            <p class="text-muted small mb-2">Tu carrito está vacío</p>
            <a href="/catalogo" class="text-dark small fw-bold">Ver productos →</a>
        </div>`;
    } else {
        container.innerHTML = items.map(item => `
            <div class="d-flex gap-3 align-items-center mb-3">
                <div class="flex-shrink-0" style="position:relative;width:64px;height:64px;overflow:visible;">
                    <img src="${item.image || ''}" alt="${item.name}"
                         style="width:64px;height:64px;object-fit:cover;border-radius:8px;border:1px solid #eee;"
                         onerror="this.style.display='none'">
                </div>
                <div class="flex-grow-1 min-width-0">
                    <p class="mb-0 fw-semibold" style="font-size:13px;">${item.name}</p>
                    ${item.variant ? `<p class="mb-0 text-muted" style="font-size:11px;">${item.variant}</p>` : ''}
                    <p class="mb-0 fw-bold" style="font-size:13px;">${fmt(item.price * item.quantity)}</p>
                </div>
                <div class="d-flex align-items-center flex-shrink-0"
                     style="border:1px solid #dee2e6;border-radius:8px;overflow:hidden;">
                    <button onclick="cambiarCantidad('${item.id}', -1)"
                            style="width:30px;height:30px;background:none;border:none;font-size:16px;cursor:pointer;">−</button>
                    <span style="min-width:28px;text-align:center;font-size:13px;font-weight:600;">${item.quantity}</span>
                    <button onclick="cambiarCantidad('${item.id}', 1)"
                            style="width:30px;height:30px;background:none;border:none;font-size:16px;cursor:pointer;">+</button>
                </div>
            </div>
        `).join('');
    }

    document.getElementById('resumen-subtotal').textContent  = fmt(subtotal);
    document.getElementById('resumen-envio').textContent     = fmt(envio);
    document.getElementById('resumen-total').textContent     = fmt(total);
    document.getElementById('btn-total-display').textContent = fmt(total);
}

function cambiarCantidad(id, delta) {
    let items = getCart();
    const idx = items.findIndex(i => i.id === id);
    if (idx === -1) return;
    items[idx].quantity += delta;
    if (items[idx].quantity <= 0) items.splice(idx, 1);
    localStorage.setItem('elenex_cart', JSON.stringify(items));
    renderResumen();
}

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
            el.classList.add('is-invalid');
            setTimeout(() => el.classList.remove('is-invalid'), 2500);
            mostrarError('Por favor completa: ' + c.label);
            return false;
        }
    }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(document.getElementById('inp-email').value)) {
        mostrarError('El correo electrónico no es válido');
        return false;
    }
    if (!getCart().length) {
        mostrarError('Tu carrito está vacío');
        return false;
    }
    return true;
}

// Callback de Culqi
window.culqi = function() {
    if (Culqi.token) {
        procesarPago(Culqi.token.id);
    } else {
        mostrarError(Culqi.error?.user_message || 'Error al procesar el pago');
        document.getElementById('btn-pagar').disabled = false;
        document.getElementById('btn-pagar').innerHTML = '🔒 Pagar con tarjeta — ' + document.getElementById('resumen-total').textContent;
    }
};

async function procesarPago(token) {
    const zona     = document.getElementById('inp-zona').value;
    const envio    = COSTO[zona] || 10;
    const items    = getCart();
    const subtotal = items.reduce((a, i) => a + (i.price * i.quantity), 0);
    const total    = subtotal + envio;

    try {
        const res = await fetch(URL_PROCESAR, {
            method:  'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept':       'application/json',
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
            mostrarError(data.error || 'Error al procesar');
            document.getElementById('btn-pagar').disabled = false;
            document.getElementById('btn-pagar').innerHTML = '🔒 Pagar con tarjeta — ' + document.getElementById('resumen-total').textContent;
        }
    } catch (e) {
        mostrarError('Error de conexión. Intenta nuevamente.');
        document.getElementById('btn-pagar').disabled = false;
        document.getElementById('btn-pagar').innerHTML = '🔒 Pagar con tarjeta — ' + document.getElementById('resumen-total').textContent;
    }
}

document.getElementById('inp-zona').addEventListener('change', renderResumen);

document.getElementById('btn-pagar').addEventListener('click', () => {
    if (!validar()) return;

    const btn = document.getElementById('btn-pagar');
    btn.disabled  = true;
    btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Procesando...`;

    const zona  = document.getElementById('inp-zona').value;
    const envio = COSTO[zona] || 10;
    const items = getCart();
    const total = items.reduce((a, i) => a + (i.price * i.quantity), 0) + envio;

    // Configurar Culqi
    Culqi.publicKey = CULQI_PK;
    Culqi.settings({
        title:       'Elenex',
        currency:    'PEN',
        description: 'Compra en Elenex',
        amount:      Math.round(total * 100),
    });
    Culqi.options({
        lang:           'auto',
        modal:          true,
        paymentMethods: { tarjeta: true, yape: true },
        style: {
            logo:       '{{ asset("img/elelogo.webp") }}',
            maincolor:  '#000000',
            buttontext: '#ffffff',
        },
    });
    Culqi.setEmail(document.getElementById('inp-email').value);
    Culqi.open();
});

renderResumen();
</script>