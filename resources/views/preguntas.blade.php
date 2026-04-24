@extends('layouts.app')

@section('title', 'Preguntas Frecuentes | Elenex')

@section('content')

<section class="faq-section">

  <h2 class="faq-title">Preguntas Frecuentes ❓</h2>

  <div class="faq-container">

    <div class="faq-item">
      <button class="faq-question">
        ¿Cuánto tarda el envío?
      </button>
      <div class="faq-answer">
        Los envíos en Lima Metropolitana tardan entre 24 a 48 horas. A provincias de 3 a 5 días hábiles.
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-question">
        ¿Puedo cambiar o devolver un producto?
      </button>
      <div class="faq-answer">
        Sí, puedes solicitar cambio o devolución dentro de los 7 días posteriores a la compra, siempre que el producto esté en buen estado.
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-question">
        ¿Qué métodos de pago aceptan?
      </button>
      <div class="faq-answer">
        Aceptamos Visa, Mastercard, Yape, Plin y PagoEfectivo.
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-question">
        ¿Cómo contacto con atención al cliente?
      </button>
      <div class="faq-answer">
        Puedes escribirnos al correo ventasonline@elenexperu.com o al WhatsApp de soporte.
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