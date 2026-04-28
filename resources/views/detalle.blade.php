@extends('layouts.app')

@section('title', $producto->nombre . ' | Elenex')

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
          <img src="{{ $img->ruta }}"
               alt="Miniatura {{ $loop->iteration }}"
               class="sub-img rounded cursor-pointer {{ $loop->first ? 'active-thumb' : '' }}"
               style="width: 80px; height: 80px; object-fit: cover;">
        @endforeach
      </div>

      {{-- Imagen principal --}}
      <div class="main-image flex-grow-1">
        @if($imagenes->isNotEmpty())
          <img src="{{ $imagenes->first()->ruta }}"
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
    <button class="btn btn-buy" id="btn-comprar-ahora">Comprar ahora</button>
    
    <button
        type="button"
        class="btn btn-cart"
        id="btn-agregar-carrito"
        aria-label="Agregar {{ $producto->nombre }} al carrito"
    >
        Agregar al carrito
    </button>
</div>
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
          <a href="{{ route('productos.show', $similar->slug) }}">
            <div class="card text-center p-2" style="cursor: pointer;">
              <div style="overflow: hidden; border-radius: 5px;">
                @if($firstImage)
                  <img src="{{ $firstImage }}" alt="{{ $similar->nombre }}"
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
    subImagesContainer.innerHTML = `<img src="{{ asset('img/no-image.png') }}" class="sub-img rounded cursor-pointer active-thumb" style="width:80px;height:80px;object-fit:cover;">`;
    mainImg.src = '{{ asset("img/no-image.png") }}';
    return;
  }
  variante.imagenes.forEach((img, index) => {
    const imgElem = document.createElement("img");
    imgElem.src = img.ruta;
    imgElem.className = 'sub-img rounded cursor-pointer' + (index === 0 ? ' active-thumb' : '');
    imgElem.style.cssText = 'width:80px;height:80px;object-fit:cover;';
    imgElem.addEventListener("click", () => {
      mainImg.src = imgElem.src;
      document.querySelectorAll(".sub-img").forEach(t => t.classList.remove("active-thumb"));
      imgElem.classList.add("active-thumb");
    });
    subImagesContainer.appendChild(imgElem);
  });
  mainImg.src = variante.imagenes[0].ruta;
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
(function () {
  let thumbIndex = 0;
  const PER_VIEW = 3;

  function injectThumbNav() {
  if (document.querySelector('.thumb-wrapper')) return; // ya existe

  const wrapper = document.createElement('div');
  wrapper.className = 'thumb-wrapper';

  const btnPrev = document.createElement('button');
  btnPrev.id   = 'thumb-prev';
  btnPrev.type = 'button';
  btnPrev.innerHTML = '❮';

  const btnNext = document.createElement('button');
  btnNext.id   = 'thumb-next';
  btnNext.type = 'button';
  btnNext.innerHTML = '❯';

  subImagesContainer.parentNode.insertBefore(wrapper, subImagesContainer);
  wrapper.appendChild(btnPrev);
  wrapper.appendChild(subImagesContainer);
  wrapper.appendChild(btnNext);

  wrapper.style.cssText = 'display:flex;align-items:center;justify-content:center;gap:8px;width:100%;box-sizing:border-box;padding:0 8px;margin-top:10px;';

  const dotsContainer = document.createElement('div');
  dotsContainer.id = 'thumb-dots';
  wrapper.parentNode.insertBefore(dotsContainer, wrapper.nextSibling);

  btnPrev.addEventListener('click', () => {
    if (thumbIndex === 0) return;
    thumbIndex--;
    updateThumbCarousel(true);
  });

  btnNext.addEventListener('click', () => {
    const total = subImagesContainer.querySelectorAll('.sub-img').length;
    if (thumbIndex + PER_VIEW >= total) return;
    thumbIndex++;
    updateThumbCarousel(true);
  });
}

  function updateThumbCarousel(animate = false) {
    if (window.innerWidth > 767) return;

    const thumbs = Array.from(subImagesContainer.querySelectorAll('.sub-img'));
    const total  = thumbs.length;
    if (total === 0) return;

    if (animate) {
      thumbs.forEach(t => {
        t.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
        t.style.opacity    = '0';
        t.style.transform  = 'translateX(10px)';
      });
      setTimeout(() => {
        applyVisibility(thumbs);
        thumbs.forEach(t => {
          t.style.opacity   = '1';
          t.style.transform = 'translateX(0)';
        });
      }, 200);
    } else {
      applyVisibility(thumbs);
    }

    /* Flechas — deshabilitar en extremos */
    const btnPrev = document.getElementById('thumb-prev');
    const btnNext = document.getElementById('thumb-next');
    if (btnPrev) btnPrev.disabled = thumbIndex === 0;
    if (btnNext) btnNext.disabled = thumbIndex + PER_VIEW >= total;

    /* Puntos — 1 punto por imagen (no por página) */
    const dotsContainer = document.getElementById('thumb-dots');
    if (dotsContainer) {
      dotsContainer.innerHTML = '';
      /* Solo mostrar puntos si hay más imágenes que PER_VIEW */
      if (total > PER_VIEW) {
        const maxIndex = total - PER_VIEW; /* últimos índices posibles */
        for (let i = 0; i <= maxIndex; i++) {
          const dot = document.createElement('span');
          if (i === thumbIndex) dot.classList.add('active-dot');
          dot.addEventListener('click', () => {
            thumbIndex = i;
            updateThumbCarousel(true);
          });
          dotsContainer.appendChild(dot);
        }
      }
    }
  }

  function applyVisibility(thumbs) {
    thumbs.forEach((t, i) => {
      t.style.display = (i >= thumbIndex && i < thumbIndex + PER_VIEW) ? '' : 'none';
    });
  }

  function initMobileCarousel() {
  if (window.innerWidth <= 767) {
    injectThumbNav();
    updateThumbCarousel();
  } else {
    // ── Deshacer la inyección en desktop ──
    const wrapper = document.querySelector('.thumb-wrapper');
    if (wrapper) {
      // Sacar sub-images del wrapper y devolverla a su lugar original
      const gallery = document.querySelector('.product-gallery');
      const mainImageDiv = document.querySelector('.main-image');
      wrapper.parentNode.insertBefore(subImagesContainer, mainImageDiv);
      wrapper.remove();
    }
    // Eliminar puntos si existen
    const dots = document.getElementById('thumb-dots');
    if (dots) dots.remove();

    // Restaurar visibilidad de todas las miniaturas
    subImagesContainer.querySelectorAll('.sub-img').forEach(t => {
      t.style.display   = '';
      t.style.opacity   = '';
      t.style.transform = '';
    });
  }
}
window.addEventListener('resize', () => {
  thumbIndex = 0;
  // Permitir re-inyección al volver a móvil
  if (window.innerWidth > 767) {
    const prevBtn = document.getElementById('thumb-prev');
    if (prevBtn) prevBtn.closest('.thumb-wrapper') && (prevBtn.id = ''); // resetear guard
  }
  initMobileCarousel();
});

  const _orig = renderMiniaturas;
  renderMiniaturas = function (variante) {
    _orig(variante);
    thumbIndex = 0;
    setTimeout(() => initMobileCarousel(), 0);
  };

  colorBoxes.forEach(box => box.replaceWith(box.cloneNode(true)));
  document.querySelectorAll('.color-box').forEach(box => {
    box.addEventListener('click', () => {
      document.querySelectorAll('.color-box').forEach(c => c.classList.remove('active-color'));
      box.classList.add('active-color');
      renderTallas(box.dataset.color);
      const variantesColor = variantes.filter(v => v.color === box.dataset.color);
      const varianteFinal  = variantesColor.find(v => v.imagenes && v.imagenes.length > 0) ?? variantesColor[0];
      renderMiniaturas(varianteFinal);
    });
  });

  window.addEventListener('resize', () => { thumbIndex = 0; initMobileCarousel(); });
  setTimeout(() => initMobileCarousel(), 100);
})();
</script>

<script>
document.getElementById('btn-agregar-carrito').addEventListener('click', function () {

    // Obtener la imagen actual que se muestra en pantalla
    const imgActual = document.getElementById('main-product-img')?.src || '';

    // Obtener talla seleccionada
    const tallaSeleccionada = document.querySelector('.talla-box.selected')?.textContent?.trim() || '';

    // Obtener color seleccionado
    const colorSeleccionado = document.querySelector('.color-box.active-color')?.dataset?.color || '';

    // Obtener cantidad
    const cantidad = parseInt(document.getElementById('quantity')?.value) || 1;

    // Obtener variante ID seleccionada
    const varianteId = document.getElementById('selectedVariante')?.value || '';

    addToCart({
        id:      '{{ $producto->id }}' + '-' + varianteId, // ID único por variante
        name:    '{{ addslashes($producto->nombre) }}',
        price:    {{ $producto->precio }},
        image:   imgActual,
        variant: colorSeleccionado + (tallaSeleccionada ? ' / Talla ' + tallaSeleccionada : ''),
        quantity: cantidad
    });
});
document.getElementById('btn-comprar-ahora').addEventListener('click', function () {
    const imgActual        = document.getElementById('main-product-img')?.src || '';
    const tallaSeleccionada = document.querySelector('.talla-box.selected')?.textContent?.trim() || '';
    const colorSeleccionado = document.querySelector('.color-box.active-color')?.dataset?.color || '';
    const cantidad          = parseInt(document.getElementById('quantity')?.value) || 1;
    const varianteId        = document.getElementById('selectedVariante')?.value || '';

    // Agregar al carrito
    addToCart({
        id:      '{{ $producto->id }}' + '-' + varianteId,
        name:    '{{ addslashes($producto->nombre) }}',
        price:    {{ $producto->precio }},
        image:   imgActual,
        variant: colorSeleccionado + (tallaSeleccionada ? ' / Talla ' + tallaSeleccionada : ''),
        quantity: cantidad
    });

    // Ir directo al checkout
    window.location.href = '{{ route("checkout.index") }}';
});
</script>
@endsection