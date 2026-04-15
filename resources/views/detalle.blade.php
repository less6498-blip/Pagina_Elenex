@extends('layouts.app')

@section('content')
<section class="product-detail container" style="padding-top: 150px;">

  <div class="row g-4">

    {{-- Galería de imágenes --}}
    <div class="col-md-6 product-gallery d-flex">

      @php
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
        $colorMap = [
            'blanco'       => '#ffffff',
            'negro'        => '#000000',
            'acero'        => '#5d85a7',
            'oliva'        => '#356439',
            'expresso'     => '#aa8163',
            'verde-claro'  => '#c8e4c9',
            'beige'        => '#e2c9a9',
            'verde-oscuro' => '#1d3623',
            'lila'         => '#8c64ad',
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
        <div class="d-flex gap-2 flex-wrap" id="tallas-container"></div>
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
          <input type="hidden" name="variante_id" id="selectedVarianteForm" value="{{ $variante->id ?? '' }}">
          <input type="hidden" name="cantidad" id="selectedQuantity" value="1">
          <button type="submit" class="btn btn-cart">Añadir al carrito</button>
        </form>
      </div>
    </div>

  </div>
</section>

{{-- ══ PRODUCTOS SIMILARES ══ --}}
<section class="similar-products container mt-5">
  <h2 class="mb-4">Productos Similares 🛍️</h2>
  <div class="swiper similar-products-swiper position-relative">
    <div class="swiper-wrapper">
      @foreach($productosSimilares as $similar)
        @php $firstImage = $similar->variantes->first()?->imagenes->first()?->ruta; @endphp
        <div class="swiper-slide">
          <a href="{{ route('productos.show', $similar->id) }}">
            <div class="card text-center p-2" style="cursor: pointer;">
              <div style="overflow: hidden; border-radius: 5px;">
                @if($firstImage)
                  <img src="{{ asset('img/' . $firstImage) }}" alt="{{ $similar->nombre }}"
                       style="width:100%;height:100%;object-fit:cover;">
                @else
                  <div style="width:100%;height:100%;background:#f0f0f0;">Sin Imagen</div>
                @endif
              </div>
              <h6 class="card-title mb-1 mt-2" style="font-size:16px;">{{ $similar->nombre }}</h6>
              <p class="card-text fw-bold mb-1" style="font-size:15px;color:black">S/ {{ number_format($similar->precio, 2) }}</p>
            </div>
          </a>
        </div>
      @endforeach
    </div>
    <div class="swiper-button-next custom-arrow"></div>
    <div class="swiper-button-prev custom-arrow"></div>
  </div>
</section>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<style>
.custom-arrow {
  width: 27px; height: 27px; background-color: #fff;
  border: 1px solid #000; border-radius: 50%;
  position: absolute; top: 50%; transform: translateY(-50%);
  z-index: 10; cursor: pointer;
  display: flex; justify-content: center; align-items: center;
  opacity: 0.9; transition: transform 0.2s, opacity 0.2s;
}
.swiper-button-next.custom-arrow::after,
.swiper-button-prev.custom-arrow::after { font-size: 12px; color: #000; }
.swiper-button-next.custom-arrow { right: 10px; }
.swiper-button-prev.custom-arrow { left: 10px; }
.custom-arrow:hover { transform: translateY(-50%) scale(1.1); opacity: 1; }
.swiper-button-disabled.custom-arrow { opacity: 0; pointer-events: none; }
</style>

<script>
const swiper = new Swiper('.similar-products-swiper', {
  slidesPerView: 5, spaceBetween: 15, loop: true,
  navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
  breakpoints: {
    0:    { slidesPerView: 1 },
    576:  { slidesPerView: 2 },
    768:  { slidesPerView: 3 },
    992:  { slidesPerView: 4 },
    1200: { slidesPerView: 5 },
  },
});

const variantes             = @json($producto->variantes);
const colorBoxes            = document.querySelectorAll(".color-box");
const tallasContainer       = document.getElementById("tallas-container");
const selectedVarianteInput = document.getElementById("selectedVariante");
const mainImg               = document.getElementById("main-product-img");
const subImagesContainer    = document.querySelector(".sub-images");

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
  const primera = tallas.find(v => v.stock > 0);
  if (primera) {
    selectedVarianteInput.value = primera.id;
    tallasContainer.querySelector(`[data-id='${primera.id}']`)?.classList.add("selected");
  }
}

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
    imgElem.className = 'sub-img rounded cursor-pointer' + (index === 0 ? ' active-thumb' : '');
    imgElem.style.cssText = 'width:80px;height:80px;object-fit:cover;';
    imgElem.addEventListener("click", () => {
      mainImg.src = imgElem.src;
      document.querySelectorAll(".sub-img").forEach(t => t.classList.remove("active-thumb"));
      imgElem.classList.add("active-thumb");
    });
    subImagesContainer.appendChild(imgElem);
  });
  mainImg.src = '/img/' + variante.imagenes[0].ruta;
}

colorBoxes.forEach(box => {
  box.addEventListener("click", () => {
    colorBoxes.forEach(c => c.classList.remove("active-color"));
    box.classList.add("active-color");
    renderTallas(box.dataset.color);
    const variantesColor = variantes.filter(v => v.color === box.dataset.color);
    let varianteFinal = variantesColor.find(v => v.imagenes && v.imagenes.length > 0) ?? variantesColor[0];
    renderMiniaturas(varianteFinal);
  });
});

if (colorBoxes.length > 0) colorBoxes[0].click();

/* ── Carrusel de miniaturas en móvil ── */
(function() {
  let thumbIndex = 0;
  const PER_VIEW = 3;

  function updateThumbCarousel() {
    if (window.innerWidth > 767) return;
    const thumbs = subImagesContainer.querySelectorAll('.sub-img');
    const total  = thumbs.length;
    if (total === 0) return;
    thumbs.forEach((t, i) => {
      t.style.display = (i >= thumbIndex && i < thumbIndex + PER_VIEW) ? '' : 'none';
    });
    const btnPrev = document.getElementById('thumb-prev');
    const btnNext = document.getElementById('thumb-next');
    if (btnPrev) btnPrev.style.display = thumbIndex === 0 ? 'none' : '';
    if (btnNext) btnNext.style.display = (thumbIndex + PER_VIEW >= total) ? 'none' : '';
  }

  function injectThumbNav() {
    if (document.getElementById('thumb-nav')) return;
    const wrap = document.createElement('div');
    wrap.id = 'thumb-nav';
    wrap.innerHTML = `
      <button id="thumb-prev" type="button">❮</button>
      <button id="thumb-next" type="button">❯</button>
    `;
    subImagesContainer.parentNode.insertBefore(wrap, subImagesContainer.nextSibling);
    document.getElementById('thumb-prev').addEventListener('click', () => {
      thumbIndex = Math.max(0, thumbIndex - 1);
      updateThumbCarousel();
    });
    document.getElementById('thumb-next').addEventListener('click', () => {
      const total = subImagesContainer.querySelectorAll('.sub-img').length;
      thumbIndex = Math.min(thumbIndex + 1, total - PER_VIEW);
      updateThumbCarousel();
    });
  }

  function initMobileCarousel() {
    if (window.innerWidth <= 767) {
      injectThumbNav();
      updateThumbCarousel();
    } else {
      subImagesContainer.querySelectorAll('.sub-img').forEach(t => t.style.display = '');
    }
  }

  /* ── PATCH: interceptar renderMiniaturas para resetear el carrusel ── */
  const _orig = renderMiniaturas;
  renderMiniaturas = function(variante) {
    _orig(variante);
    thumbIndex = 0;
    setTimeout(() => initMobileCarousel(), 0);
  };

  /* También parchear el listener de color para usar la versión nueva */
  colorBoxes.forEach(box => {
    box.replaceWith(box.cloneNode(true)); // elimina listeners viejos
  });
  document.querySelectorAll(".color-box").forEach(box => {
    box.addEventListener("click", () => {
      document.querySelectorAll(".color-box").forEach(c => c.classList.remove("active-color"));
      box.classList.add("active-color");
      renderTallas(box.dataset.color);
      const variantesColor = variantes.filter(v => v.color === box.dataset.color);
      let varianteFinal = variantesColor.find(v => v.imagenes && v.imagenes.length > 0) ?? variantesColor[0];
      renderMiniaturas(varianteFinal);
    });
  });

  window.addEventListener('resize', () => { thumbIndex = 0; initMobileCarousel(); });
  setTimeout(() => initMobileCarousel(), 100);
})();
</script>
@endsection