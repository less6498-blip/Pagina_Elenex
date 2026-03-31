@extends('layouts.app')

@section('content')
<section class="product-detail container" style="padding-top: 150px;">

  <div class="row g-9">
        {{-- Galería de imágenes --}}
    <div class="col-md-6 product-gallery d-flex">
  {{-- Miniaturas a la izquierda --}}
  <div class="sub-images d-flex flex-column gap-2 me-3">
    {{-- Imagen principal como miniatura --}}
    <img src="{{ asset('img/' . $producto->imagen) }}" 
         alt="Miniatura 1" 
         class="sub-img rounded cursor-pointer active-thumb"
         style="width: 80px; height: 80px; object-fit: cover;">

    {{-- Imagen2 si existe --}}
    @if($producto->imagen2)
      <img src="{{ asset('img/' . $producto->imagen2) }}" 
           alt="Miniatura 2" 
           class="sub-img rounded cursor-pointer"
           style="width: 80px; height: 80px; object-fit: cover;">
    @endif
  </div>

  {{-- Imagen principal --}}
  <div class="main-image flex-grow-1">
    <img src="{{ asset('img/' . $producto->imagen) }}" 
         alt="{{ $producto->nombre }}" 
         id="main-product-img" 
         class="img-fluid rounded">
  </div>
</div>

    {{-- Información del producto --}}
    <div class="col-md-6 product-info">
      <h1 class="product-title mb-3">{{ $producto->nombre }}</h1>
      <p class="product-price fs-4 fw-bold mb-4">S/ {{ number_format($producto->precio, 2) }}</p>

      <div class="product-options mb-4">
        <div class="mb-3">
          <label class="form-label fw-semibold">Color:</label>
          <input type="text" value="{{ $producto->color }}" class="form-control w-25" disabled>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Talla:</label>
          <input type="text" value="{{ $producto->talla }}" class="form-control w-25" disabled>
        </div>

        <div class="mb-3">
          <label for="quantity" class="form-label fw-semibold">Cantidad:</label>
          <input type="number" id="quantity" value="1" min="1" class="form-control w-25">
        </div>
      </div>

      <div class="product-buttons d-flex flex-column gap-3 mb-4">

    <!-- Comprar ahora arriba -->
    <button class="btn btn-buy">
        Comprar ahora 
    </button>

    <!-- Añadir al carrito abajo -->
    <form action="#" method="POST" class="d-inline">
        @csrf
        <input type="hidden" name="cantidad" id="selectedQuantity" value="1">
        <button type="submit" class="btn btn-cart">
            Añadir al carrito 
        </button>
    </form>

</div>

    </div>
  </div>
</section>

{{-- ... tu código actual de detalle.blade.php arriba ... --}}

{{-- ===================== CARRUSEL DE PRODUCTOS SIMILARES ===================== --}}
<section class="similar-products container mt-5">
    <h2 class="mb-4">Productos Similares 🛍️</h2>

    <!-- Swiper -->
    <div class="swiper similar-products-swiper position-relative">
        <div class="swiper-wrapper">
            @foreach($productosSimilares as $similar)
            <div class="swiper-slide">
                <a href="{{ route('productos.show', $similar->id) }}" style="text-decoration: none; color: inherit;">
                    <div class="card text-center p-2" style="height: 380px; cursor: pointer;">
                        <div style="height: 320px; overflow: hidden; border-radius: 5px;">
                            <img src="{{ asset('img/' . $similar->imagen) }}" 
                                 alt="{{ $similar->nombre }}" 
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <h6 class="card-title mb-1 mt-2" style="font-size: 16px;">{{ $similar->nombre }}</h6>
                        <p class="card-text fw-bold mb-1" style="font-size: 15px; color: black">S/ {{ number_format($similar->precio, 2) }}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <!-- Flechas minimalistas -->
        <div class="swiper-button-next custom-arrow"></div>
        <div class="swiper-button-prev custom-arrow"></div>
    </div>
</section>

{{-- ===================== Scripts Swiper ===================== --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
    const swiper = new Swiper('.similar-products-swiper', {
        slidesPerView: 5,
        spaceBetween: 15,
        loop: false,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            0: { slidesPerView: 1 },
            576: { slidesPerView: 2 },
            768: { slidesPerView: 3 },
            992: { slidesPerView: 4 },
            1200: { slidesPerView: 5 },
        },
    });
</script>

{{-- ===================== Estilos para flechas minimalistas ===================== --}}
<style>
/* ===================== Flechas blancas con sombra ===================== */
/* ===================== Flechas blancas con efecto hover ===================== */
.custom-arrow {
    width: 27px;
    height: 27px;
    background-color: #fff; /* círculo blanco sólido */
    border: 1px solid #000;
    border-radius: 50%;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 0.9; 
    transition: transform 0.2s, opacity 0.2s;
}

/* Triángulo indicador dentro de la flecha */
.swiper-button-next.custom-arrow::after,
.swiper-button-prev.custom-arrow::after {
    font-size: 12px;
    color: #000; /* flecha negra */
}

/* Flecha next a la derecha */
.swiper-button-next.custom-arrow {
    right: 10px;
}

/* Flecha prev a la izquierda */
.swiper-button-prev.custom-arrow {
    left: 10px;
}

/* Efecto al pasar el mouse */
.custom-arrow:hover {
    transform: translateY(-50%) scale(1.1); /* se acerca */
    opacity: 1; /* se hace totalmente visible */
}

/* Flechas inactivas se mantienen invisibles parcialmente */
.swiper-button-disabled.custom-arrow {
    opacity: 0; /* transparente, pero aún visible */
    pointer-events: none; /* no clickeable */
}
</style>

{{-- Script para galería y cantidad --}}
<script>
  const mainImg = document.getElementById("main-product-img");
  const subImgs = document.querySelectorAll(".sub-img");
  const quantityInput = document.getElementById("quantity");
  const selectedQuantity = document.getElementById("selectedQuantity");

  // Cambiar imagen principal al hacer click en miniatura
 subImgs.forEach(img => {
  img.addEventListener("click", () => {
    // Cambiar imagen principal
    mainImg.src = img.src;

    // Quitar clase activa a todas
    subImgs.forEach(i => i.classList.remove("active-thumb"));

    // Agregar clase a la seleccionada
    img.classList.add("active-thumb");
  });
});
</script>
@endsection