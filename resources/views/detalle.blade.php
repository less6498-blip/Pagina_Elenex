@extends('layouts.app')

@section('content')
<section class="product-detail container" style="padding-top: 150px;">

  <div class="row g-4">
        {{-- Galería de imágenes --}}
    <div class="col-md-6 product-gallery d-flex">

    @php
        // Tomamos la primera variante como principal
        $variante = $producto->variantes->first();
        $imagenes = $variante ? $variante->imagenes->sortBy('orden') : collect();
    @endphp


  {{-- Miniaturas a la izquierda --}}
  <div class="sub-images d-flex flex-column gap-2 me-3">
        @foreach($imagenes as $img)
          <img src="{{ asset('img/' . $img->ruta) }}" 
               alt="Miniatura {{ $loop->iteration }}" 
               class="sub-img rounded cursor-pointer {{ $loop->first ? 'active-thumb' : '' }}"
               style="width: 80px; height: 80px; object-fit: cover;">
        @endforeach
      </div>

  {{-- Imagen principal --}}
  <div class="main-image flex-grow-1">
     @if($imagenes->isNotEmpty())
          <img src="{{ asset('img/' . $imagenes->first()->ruta) }}" 
               alt="{{ $producto->nombre }}" 
               id="main-product-img" 
               class="img-fluid rounded">
        @else
          <img src="{{ asset('img/no-image.png') }}" 
               alt="Sin imagen" 
               id="main-product-img" 
               class="img-fluid rounded">
        @endif
  </div>
</div>

    {{-- Información del producto --}}
    <div class="col-md-6 product-info">
      <h1 class="product-title mb-3">{{ $producto->nombre }}</h1>
      <p class="product-price fs-4 fw-bold mb-4">S/ {{ number_format($producto->precio, 2) }}</p>

      
     @php
// Mapeo de colores a hex válidos
$colorMap = [
    'blanco' => '#ffffff',
    'negro' => '#000000',
    'acero' => '#5d85a7',
    'gris' => '#808080',
    'rojo' => '#FF0000',
    'azul' => '#0000FF',
    // agrega todos los colores que uses
];

$colores = $producto->variantes->pluck('color')->unique();
@endphp

{{-- Colores --}}
<div class="mb-3">
    <label class="form-label fw-semibold">Color:</label>
    <div class="d-flex gap-2" id="color-container">
        @foreach($colores as $color)
            <div class="color-box cursor-pointer" 
                 data-color="{{ $color }}"
                 style="width:30px;height:30px;
                        background:{{ $colorMap[strtolower($color)] ?? '#000' }};
                        border: 1px solid #000;
                        border-radius: 4px;">
            </div>
        @endforeach
    </div>
</div>

{{-- Tallas --}}
<div class="mb-3">
    <label class="form-label fw-semibold">Talla:</label>
    <div class="d-flex gap-2 flex-wrap" id="tallas-container">
        {{-- Se llenará con JS según color seleccionado --}}
    </div>
</div>

<input type="hidden" id="selectedVariante" name="variante_id" value="">



        <div class="mb-3">
          <label for="quantity" class="form-label fw-semibold">Cantidad:</label>
          <input type="number" id="quantity" value="1" min="1" class="form-control w-25">
        </div>

      <div class="product-buttons d-flex flex-column gap-3 mb-4">
        <button class="btn btn-buy">Comprar ahora</button>

        <form action="#" method="POST" class="d-inline">
          @csrf
          <input type="hidden" name="variante_id" id="selectedVariante" value="{{ $variante->id ?? '' }}">
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
                @php
            $firstImage = $similar->variantes->first()?->imagenes->first()?->ruta;
                @endphp
            <div class="swiper-slide">
        <a href="{{ route('productos.show', $similar->id) }}">
            <div class="card text-center p-2" style="height: 380px; cursor: pointer;">
                <div style="height: 320px; overflow: hidden; border-radius: 5px;">
                    @if($firstImage)
                        <img src="{{ asset('img/' . $firstImage) }}" 
                             alt="{{ $similar->nombre }}" 
                             style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width:100%;height:100%;background:#f0f0f0;">Sin Imagen</div>
                    @endif
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
const variantes = @json($producto->variantes); // todas las variantes del producto
const colorBoxes = document.querySelectorAll(".color-box");
const tallasContainer = document.getElementById("tallas-container");
const selectedVarianteInput = document.getElementById("selectedVariante");
const mainImg = document.getElementById("main-product-img");
const subImagesContainer = document.querySelector(".sub-images");

// Función para renderizar tallas según color
function renderTallas(color) {
    tallasContainer.innerHTML = '';
    const tallas = variantes.filter(v => v.color === color);

    tallas.forEach(v => {
        const div = document.createElement("div");
        div.textContent = v.talla;
        div.className = 'talla-box' + (v.stock <= 0 ? ' disabled' : '');
        div.dataset.id = v.id;
        if (v.stock > 0) {
            div.addEventListener("click", () => {
                document.querySelectorAll(".talla-box").forEach(t => t.classList.remove("selected"));
                div.classList.add("selected");
                selectedVarianteInput.value = v.id;
            });
        }
        tallasContainer.appendChild(div);
    });

    // Seleccionar automáticamente la primera talla disponible
    const primera = tallas.find(v => v.stock > 0);
    if (primera) {
        selectedVarianteInput.value = primera.id;
        const divPrimera = tallasContainer.querySelector(`[data-id='${primera.id}']`);
        divPrimera.classList.add("selected");
    }
}

// Función para renderizar miniaturas según la variante
function renderMiniaturas(variante) {
    subImagesContainer.innerHTML = '';
    if (!variante || variante.imagenes.length === 0) {
        subImagesContainer.innerHTML = `<img src="/img/no-image.png" class="sub-img rounded cursor-pointer active-thumb" style="width:80px;height:80px;object-fit:cover;">`;
        mainImg.src = '/img/no-image.png';
        return;
    }

    variante.imagenes.forEach((img, index) => {
        const imgElem = document.createElement("img");
        imgElem.src = '/img/' + img.ruta;
        imgElem.alt = "Miniatura " + (index + 1);
        imgElem.className = 'sub-img rounded cursor-pointer' + (index === 0 ? ' active-thumb' : '');
        imgElem.style.width = '80px';
        imgElem.style.height = '80px';
        imgElem.style.objectFit = 'cover';

        // Evento click para cambiar la imagen principal
        imgElem.addEventListener("click", () => {
            mainImg.src = imgElem.src;
            document.querySelectorAll(".sub-img").forEach(t => t.classList.remove("active-thumb"));
            imgElem.classList.add("active-thumb");
        });

        subImagesContainer.appendChild(imgElem);
    });

    // Establecer la primera imagen como principal
    mainImg.src = '/img/' + variante.imagenes[0].ruta;
}

// Evento click para cada color
colorBoxes.forEach(box => {
    box.addEventListener("click", () => {
        // Desmarcar todos los colores
        colorBoxes.forEach(c => c.classList.remove("active-color"));
        box.classList.add("active-color");

        // Renderizar tallas
        renderTallas(box.dataset.color);

        // Actualizar miniaturas e imagen principal
        const varianteColor = variantes.find(v => v.color === box.dataset.color);
        renderMiniaturas(varianteColor);
    });
});

// Inicializar con primer color disponible
if (colorBoxes.length > 0) {
    colorBoxes[0].click();
}
</script>
@endsection