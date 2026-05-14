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
              <input type="text" id="inp-nombre" placeholder="Juan García" maxlength="100" pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+"
                     class="form-control" style="border-radius:10px;">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-medium" style="font-size:14px;">Correo electrónico *</label>
              <input type="email" id="inp-email" placeholder="juan@email.com" maxlength="100" class="form-control"
                     style="border-radius:10px;">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-medium" style="font-size:14px;">Teléfono</label>
              <input type="tel" id="inp-telefono" placeholder="987 654 321" maxlength="11" class="form-control"
                     style="border-radius:10px;">
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
            style="border-radius:12px;font-size:15px;">
            Pagar
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
const CSRF          = '{{ csrf_token() }}';
const URL_PROCESAR  = '{{ route("checkout.procesar") }}';
const CULQI_PK      = '{{ env("CULQI_PUBLIC_KEY") }}';
const COSTO         = { lima: 0.50, provincias: 20 };

let montoFijado = 0;
let isProcessing = false;

// ======================
// CARRITO
// ======================
function getCart() {
    try { return JSON.parse(localStorage.getItem('elenex_cart')) || []; }
    catch { return []; }
}

function fmt(n) {
    return 'S/ ' + parseFloat(n).toFixed(2);
}

// ======================
// RESUMEN
// ======================
function renderResumen() {
    const items    = getCart();
    const zona     = document.getElementById('inp-zona').value;
    const envio    = COSTO[zona] || 10;

    const subtotal = items.reduce((a, i) => a + (i.price * i.quantity), 0);
    const total    = subtotal + envio;

    const container = document.getElementById('checkout-items');

    if (!items.length) {
        container.innerHTML = `
        <div class="text-center py-4">
            <p class="text-muted small mb-2">Tu carrito está vacío</p>
            <a href="/catalogo" class="text-dark small fw-bold">Ver productos →</a>
        </div>`;
    } else {
        container.innerHTML = items.map(item => `
            <div class="d-flex gap-3 align-items-center mb-3">
                <img src="${item.image || ''}" style="width:64px;height:64px;object-fit:cover;border-radius:8px;">
                <div class="flex-grow-1">
                    <p class="mb-0 fw-semibold">${item.name}</p>
                    <p class="mb-0 fw-bold">${fmt(item.price * item.quantity)}</p>
                </div>
            </div>
        `).join('');
    }

    document.getElementById('resumen-subtotal').textContent = fmt(subtotal);
    document.getElementById('resumen-envio').textContent    = fmt(envio);
    document.getElementById('resumen-total').textContent    = fmt(total);
}

// ======================
// VALIDACIÓN
// ======================
function validar() {

    const nombre = document.getElementById('inp-nombre').value.trim();
    const email = document.getElementById('inp-email').value.trim();
    const telefono = document.getElementById('inp-telefono').value.trim();
    const dni = document.getElementById('inp-dni').value.trim();

    const campos = [
        'inp-nombre',
        'inp-email',
        'inp-dni',
        'inp-departamento',
        'inp-provincia',
        'inp-distrito',
        'inp-direccion'
    ];

    for (let id of campos) {

        const el = document.getElementById(id);

        if (!el.value.trim()) {
            mostrarError('Completa los campos requeridos');
            return false;
        }
    }

    // ======================
    // NOMBRE
    // ======================
    if (nombre.length < 3 || nombre.length > 100) {
        mostrarError('Nombre inválido');
        return false;
    }

    if (!/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+$/.test(nombre)) {
        mostrarError('El nombre solo debe contener letras');
        return false;
    }

    // ======================
    // EMAIL
    // ======================
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailRegex.test(email)) {
        mostrarError('Correo electrónico inválido');
        return false;
    }

    // ======================
    // TELÉFONO
    // ======================
    if (telefono) {

        const telefonoLimpio = telefono.replace(/\s/g, '');

        if (!/^\d{9}$/.test(telefonoLimpio)) {
            mostrarError('El teléfono debe tener 9 números');
            return false;
        }
    }

    // ======================
    // DNI
    // ======================
    if (!/^\d{8}$/.test(dni)) {
        mostrarError('El DNI debe tener 8 números');
        return false;
    }

    // ======================
    // CARRITO
    // ======================
    if (!getCart().length) {
        mostrarError('Carrito vacío');
        return false;
    }

    return true;
}

// ======================
// ERROR
// ======================
function mostrarError(msg) {
    const el = document.getElementById('form-error');
    el.textContent = msg;
    el.classList.remove('d-none');

    setTimeout(() => el.classList.add('d-none'), 3500);
}

// ======================
// BOTÓN PRINCIPAL
// ======================
document.getElementById('btn-pagar').addEventListener('click', () => {

    if (!validar()) return;
    if (isProcessing) return;

    const btn = document.getElementById('btn-pagar');

    btn.disabled = true;
    btn.innerHTML = "Procesando...";

    const zona  = document.getElementById('inp-zona').value;
    const envio = COSTO[zona] || 10;

    const items = getCart();
    const subtotal = items.reduce((a, i) => a + (i.price * i.quantity), 0);
    const total = subtotal + envio;

    montoFijado = Math.round(total * 100);

    Culqi.publicKey = CULQI_PK;

    Culqi.settings({
        title: "Elenex",
        currency: "PEN",
        description: "Compra",
        amount: montoFijado,
    });

    Culqi.options({
        modal: true,
        paymentMethods: { tarjeta: true, yape: true },
        style: {
            maincolor: "#000000"
        }
    });

    Culqi.open();
});

// ======================
// CALLBACK CULQI (IMPORTANTE)
// ======================
window.culqi = function () {

    const btn = document.getElementById('btn-pagar');

    if (isProcessing) return;

    if (Culqi.token) {

        isProcessing = true;

        Culqi.close();

        btn.disabled = true;
        btn.innerHTML = "Procesando...";

        procesarPago(Culqi.token.id)
            .then((data) => {

                if (data.success) {

                    localStorage.removeItem('elenex_cart');

                    btn.innerHTML = "Pago exitoso";

                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1200);

                } else {

                    isProcessing = false;

                    btn.disabled = false;
                    btn.innerHTML = "Pagar";

                    mostrarError(data.error || "Error en el pago");
                }

            })
            .catch(() => {

                isProcessing = false;

                btn.disabled = false;
                btn.innerHTML = "Pagar";

                mostrarError("Error procesando pago");

            });

    } else if (Culqi.error) {

        isProcessing = false;

        btn.disabled = false;
        btn.innerHTML = "Pagar";

        mostrarError(Culqi.error.user_message || "Pago cancelado");
    }
};

// ======================
// FORMATO TELÉFONO
// ======================
document.getElementById('inp-telefono').addEventListener('input', function(e) {

    let value = e.target.value.replace(/\D/g, '');

    value = value.substring(0, 9);

    if (value.length > 6) {
        value = value.replace(/(\d{3})(\d{3})(\d+)/, '$1 $2 $3');
    }
    else if (value.length > 3) {
        value = value.replace(/(\d{3})(\d+)/, '$1 $2');
    }

    e.target.value = value;
});

// ======================
// PROCESAR PAGO
// ======================
async function procesarPago(token) {

    try {
        const res = await fetch(URL_PROCESAR, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": CSRF,
                "Accept": "application/json"
            },
            body: JSON.stringify({
                nombre: document.getElementById('inp-nombre').value,
                email: document.getElementById('inp-email').value,
                telefono: document.getElementById('inp-telefono').value,
                dni: document.getElementById('inp-dni').value,
                departamento: document.getElementById('inp-departamento').value,
                provincia: document.getElementById('inp-provincia').value,
                distrito: document.getElementById('inp-distrito').value,
                direccion: document.getElementById('inp-direccion').value,
                referencia: document.getElementById('inp-referencia').value,
                zona_envio: document.getElementById('inp-zona').value,
                culqi_token: token,
                amount: montoFijado,
                cart_items: getCart()
            })
        });

        const data = await res.json().catch(() => null);

        if (!data) throw new Error("Respuesta inválida");

        return data;

    } catch (e) {

        return {
            success: false,
            error: "Error de conexión"
        };
    }
}

// ======================
document.getElementById('inp-zona').addEventListener('change', renderResumen);
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