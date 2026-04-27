@extends('layouts.app')

@section('title', 'Preguntas Frecuentes | Elenex')

@section('content')

<section class="faq-page">

  <div class="faq-card">

    <h2 class="faq-title">Preguntas Frecuentes</h2>

    <div class="faq-container">

      <div class="faq-item">
        <button class="faq-question">¿Cuánto tarda el envío?</button>
        <div class="faq-answer">
          Los envíos en Lima Metropolitana y el Callao tardan entre 12 a 24 horas. 
        </div>
      </div>

      <div class="faq-item">
  <button class="faq-question">¿Puedo cambiar o devolver un producto?</button>
  <div class="faq-answer">
    Sí, puedes solicitar un cambio o devolución dentro de los 10 días posteriores a la compra, presentando la boleta correspondiente.
    El producto debe encontrarse en buen estado, con sus condiciones originales.
    No se aceptan cambios ni devoluciones en los siguientes casos:
    <ul>
      <li>Prendas íntimas (trusas, bóxer, etc.).</li>
      <li>Productos en liquidación.</li>
      <li>Productos dañados por mal uso.</li>
    </ul>
  </div>
</div>

      <div class="faq-item">
        <button class="faq-question">¿Qué métodos de pago aceptan?</button>
        <div class="faq-answer">
          Aceptamos Visa, Mastercard, Yape, Plin y PagoEfectivo.
        </div>
      </div>

      <div class="faq-item">
        <button class="faq-question">¿Cómo contacto con atención al cliente?</button>
        <div class="faq-answer">
          Escríbenos a ventasonline@elenexperu.com o WhatsApp de soporte.
        </div>
      </div>

    </div>

  </div>

</section>

@endsection

@push('scripts')
<script>
document.querySelectorAll('.faq-question').forEach(btn => {
  btn.addEventListener('click', () => {
    const item = btn.parentElement;
    item.classList.toggle('active');
  });
});
</script>
@endpush