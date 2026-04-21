@extends('layouts.app')
@section('title', 'Pedido Confirmado | Elenex')

@section('content')
<div style="padding-top:110px;padding-bottom:60px;background:#f8f9fa;min-height:100vh;">
<div class="container">
<div class="row justify-content-center">
<div class="col-lg-7">

  <div class="card border-0 shadow-sm rounded-4 p-4">

    {{-- Éxito --}}
    <div class="text-center mb-4">
      <div class="d-flex align-items-center justify-content-center rounded-circle bg-success bg-opacity-10 mx-auto mb-3"
           style="width:80px;height:80px;">
        <svg width="40" height="40" fill="none" stroke="#198754" stroke-width="2.5"
             stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
          <polyline points="20 6 9 17 4 12"/>
        </svg>
      </div>
      <h2 class="fw-bold mb-1">¡Pedido confirmado!</h2>
      <p class="text-muted">Gracias, <strong>{{ $pedido->guest_nombre }}</strong>. Pronto nos pondremos en contacto.</p>
    </div>

    {{-- Código --}}
    <div class="text-center p-3 rounded-3 mb-4" style="background:#f8f9fa;">
      <small class="text-muted text-uppercase" style="letter-spacing:2px;">Código de pedido</small>
      <h3 class="fw-bold mt-1 mb-0" style="letter-spacing:3px;">{{ $pedido->codigo_orden }}</h3>
    </div>

    {{-- Productos --}}
    <h6 class="fw-bold mb-3 text-muted text-uppercase" style="font-size:12px;letter-spacing:1px;">Productos</h6>
    <div class="mb-4">
      @foreach($pedido->detalles as $d)
      <div class="d-flex gap-3 align-items-center p-3 rounded-3 mb-2" style="border:1px solid #f0f0f0;">
        @if($d->imagen_url)
          <img src="{{ $d->imagen_url }}"
               style="width:56px;height:56px;object-fit:cover;border-radius:8px;flex-shrink:0;">
        @endif
        <div class="flex-grow-1">
          <p class="mb-0 fw-semibold" style="font-size:14px;">{{ $d->nombre_producto }}</p>
          @if($d->variante_detalle)
            <p class="mb-0 text-muted" style="font-size:12px;">{{ $d->variante_detalle }}</p>
          @endif
          <p class="mb-0 text-muted" style="font-size:12px;">
            {{ $d->cantidad }} × S/ {{ number_format($d->precio_unitario, 2) }}
          </p>
        </div>
        <p class="mb-0 fw-bold flex-shrink-0">S/ {{ number_format($d->subtotal, 2) }}</p>
      </div>
      @endforeach
    </div>

    {{-- Totales --}}
    <div class="mb-4">
      <div class="d-flex justify-content-between text-muted small mb-2">
        <span>Subtotal</span><span>S/ {{ number_format($pedido->subtotal, 2) }}</span>
      </div>
      <div class="d-flex justify-content-between text-muted small mb-2">
        <span>Envío</span><span>S/ {{ number_format($pedido->costo_envio, 2) }}</span>
      </div>
      <hr>
      <div class="d-flex justify-content-between fw-bold">
        <span>Total pagado</span>
        <span>S/ {{ number_format($pedido->total, 2) }}</span>
      </div>
    </div>

    {{-- Dirección --}}
    <div class="p-3 rounded-3 mb-4" style="background:#e8f4fd;">
      <p class="fw-semibold mb-1" style="color:#0c63e4;font-size:14px;">📦 Dirección de entrega</p>
      <p class="mb-0" style="color:#0c63e4;font-size:13px;">
        {{ $pedido->envio_direccion }}, {{ $pedido->envio_distrito }},
        {{ $pedido->envio_provincia }}, {{ $pedido->envio_departamento }}
      </p>
      @if($pedido->envio_referencia)
        <p class="mb-0 mt-1" style="color:#6ea8fe;font-size:12px;">Ref: {{ $pedido->envio_referencia }}</p>
      @endif
    </div>

    <a href="{{ route('productos.catalogo') }}"
       class="btn btn-dark w-100 py-3 fw-bold" style="border-radius:12px;">
      Seguir comprando
    </a>

  </div>
</div>
</div>
</div>
</div>
@endsection