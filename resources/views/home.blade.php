@extends('layouts.app')

@section('title', 'Elenex')

@section('content')

  <!-- Carrusel de Portada-->
<div id="carruselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">

  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carruselExample" data-bs-slide-to="0" class="active">
      <span class="progress"></span>
    </button>
    <button type="button" data-bs-target="#carruselExample" data-bs-slide-to="1">
      <span class="progress"></span>
    </button>
    <button type="button" data-bs-target="#carruselExample" data-bs-slide-to="2">
      <span class="progress"></span>
    </button>
  </div>

  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="{{ asset('img/logo1.png') }}" class="d-block w-100">
    </div>
    <div class="carousel-item">
      <img src="{{ asset('img/logo2.png') }}" class="d-block w-100">
    </div>
    <div class="carousel-item">
      <img src="{{ asset('img/logo3.png') }}" class="d-block w-100">
    </div>
  </div>

</div>

  <!-- Controles carrusel de portada-->
  <button id="prevBtn" class="custom-arrow">
    &#10094; <!-- flecha izquierda -->
  </button>
  <button id="nextBtn" class="custom-arrow">
    &#10095; <!-- flecha derecha -->
  </button>

</div>


<div class="titulo1 reveal">
  <span>NEW ARRIVALS 🔥</span>
</div>

<!-- Carrusel de productos -->
  <div id="productCarousel" class="carousel slide">
  <div class="carousel-inner">

    <!-- Contenedor Slide 1 -->
    <div class="carousel-item active">
  <div class="row justify-content-center g-1">

    <!-- ✅ Slide 1 -->
    <div class="col-6 col-md-3 text-center">
      <a href="/producto/1" class="product-card">
        <div class="product-img-wrapper">
          <img src="{{ asset('img/mojito1.png') }}" class="img-main">
          <img src="{{ asset('img/mojito2.png') }}" class="img-hover">
        </div>
        <p class="product-desc">POLO OVERSIZE PARANOIA</p>
        <p class="product-price">
          <s class="product-price" style="color:gray;">S/89.90</s> S/65.00
        </p>
      </a>
    </div>

        <div class="col-6 col-md-3 text-center">
          <a href="/producto/2" class="product-card">
            <div class="product-img-wrapper">
          <img src="{{ asset('img/over1.png') }}" class="img-main">
          <img src="{{ asset('img/over2.png') }}" class="img-hover">
          </div>
          <p class="product-desc">POLO OVERSIZE NOTHING </p>
          <p class="product-price">
            <s class="product-price" style="color:gray;">S/89.90 </s> S/65.00
          </p>
        </a>
      </div>
        
        <div class="col-6 col-md-3 text-center">
          <a href="/producto/3" class="product-card">
            <div class="product-img-wrapper">
          <img src="{{ asset('img/oververde1.png') }}" class="img-main">
          <img src="{{ asset('img/oververde2.png') }}" class="img-hover">
          </div>
          <p class="product-desc">POLO OVERSIZE NOTHING </p>
          <p class="product-price">
            <s class="product-price" style="color:gray;">S/89.90 </s> S/65.00
          </p>
        </a>
      </div>

      <div class="col-6 col-md-3 text-center">
          <a href="/producto/4" class="product-card">
            <div class="product-img-wrapper">
          <img src="{{ asset('img/bividi1.png') }}" class="img-main">
          <img src="{{ asset('img/bividi2.png') }}" class="img-hover">
          </div>
          <p class="product-desc">POLO OVERSIZE NOTHING </p>
          <p class="product-price">
            <s class="product-price" style="color:gray;">S/89.90 </s> S/65.00
          </p>
        </a>
      </div>
      </div>
        </div>

<!-- ✅ Slide 2 -->

    <div class="carousel-item">
  <div class="row justify-content-center g-1">

    <div class="col-6 col-md-3 text-center">
      <a href="/producto/5" class="product-card">
        <div class="product-img-wrapper">
          <img src="{{ asset('img/wait1.png') }}" class="img-main">
          <img src="{{ asset('img/wait2.png') }}" class="img-hover">
        </div>
        <p class="product-desc">POLO OVERSIZE PARANOIA</p>
        <p class="product-price">
          <s class="product-price" style="color:gray;">S/89.90</s> S/65.00
        </p>
      </a>
    </div>

        <div class="col-6 col-md-3 text-center">
          <a href="/producto/6" class="product-card">
            <div class="product-img-wrapper">
          <img src="{{ asset('img/nomadic1.png') }}" class="img-main">
          <img src="{{ asset('img/nomadic2.png') }}" class="img-hover">
          </div>
          <p class="product-desc">POLO OVERSIZE NOTHING </p>
          <p class="product-price">
            <s class="product-price" style="color:gray;">S/89.90 </s> S/65.00
          </p>
        </a>
      </div>
        
        <div class="col-6 col-md-3 text-center">
          <a href="/producto/7" class="product-card">
            <div class="product-img-wrapper">
          <img src="{{ asset('img/stopwars1.png') }}" class="img-main">
          <img src="{{ asset('img/stopwars2.png') }}" class="img-hover">
          </div>
          <p class="product-desc">POLO OVERSIZE NOTHING </p>
          <p class="product-price">
            <s class="product-price" style="color:gray;">S/89.90 </s> S/65.00
          </p>
        </a>
      </div>

      <div class="col-6 col-md-3 text-center product-card ver-mas">
          <div class="ver-mas-title">NEW ARRIVALS</div>
            <a href="/productos" class="ver-mas-link">Ver más</a>
        </div>
      </div>
    </div>

    <!-- Controles del carrusel de productos -->
<button id="prevProduct" class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button id="nextProduct" class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>
</div>
</div>

<div class="titulo2">
  <span>NUEVO EN CASACAS</span>
</div>

<!-- Contenedor Slide 2 -->
  <div id="productCarousel2" class="carousel slide">
  <div class="carousel-inner">

    <!-- ✅ Slide 1 -->
    <div class="carousel-item active">
      <div class="row justify-content-center g-1">

        <div class="col-6 col-md-3 text-center">
          <a href="producto/8" class="product-card">
            <div class="product-img-wrapper">
          <img src="{{ asset('img/wheeler.png') }}" class="img-main">
          <img src="{{ asset('img/wheeler2.png') }}" class="img-hover">
        </div>
          <p class="product-desc">CASACA HOMBRE WHEELER </p>
          <p class="product-price">
          S/124.00 
          </p>
        </a>
      </div>
      

        <div class="col-6 col-md-3 text-center">
          <a href="/producto/9" class="product-card">
            <div class="product-img-wrapper">
              <img src="{{ asset('img/trek.png') }}" class="img-main">
              <img src="{{ asset('img/trek2.png') }}" class="img-hover">
            </div>
            <p class="product-desc">CASACA TREK HOMBRE</p>
            <p class="product-price">
              <s class="product-price" style="color:gray;">S/299.90</s> S/219.90
            </p>
          </a>
        </div>

        <div class="col-6 col-md-3 text-center">
          <a href="/producto/10" class="product-card">
            <div class="product-img-wrapper">
              <img src="{{ asset('img/quik.png') }}" class="img-main">
              <img src="{{ asset('img/quik2.png') }}" class="img-hover">
            </div>
            <p class="product-desc">CASACA QUIK HOMBRE</p>
            <p class="product-price">
              <s class="product-price" style="color:gray;">S/369.90</s> S/249.90
            </p>
          </a>
        </div>

        <div class="col-6 col-md-3 text-center">
          <a href="/producto/11" class="product-card">
            <div class="product-img-wrapper">
          <img src="{{ asset('img/carnero.png') }}" class="img-main">
          <img src="{{ asset('img/carnero2.png') }}" class="img-hover">
        </div>
          <p class="product-desc">CASACA CARNERO LOND</p>
          <p class="product-price">
            <s class="product-price" class="product-price" style="color:gray;">S/249.90 </s> S/169.90
          </p>
          </a>
        </div>
      </div>
        </div>

    <!-- Slide 2 -->
    <div class="carousel-item">
      <div class="row justify-content-center g-1">

        <div class="col-6 col-md-3 text-center">
          <a href="/producto/11" class="product-card">
            <div class="product-img-wrapper">
              <img src="{{ asset('img/counter.png') }}" class="img-main">
              <img src="{{ asset('img/counter2.png') }}" class="img-hover">
            </div>
            <p class="product-desc">CASACA COUNTER HOMBRE</p>
            <p class="product-price">S/219.90</p>
          </a>
        </div>

        <div class="col-6 col-md-3 text-center">
          <a href="/producto/12" class="product-card">
            <div class="product-img-wrapper">
              <img src="{{ asset('img/carn.png') }}" class="img-main">
              <img src="{{ asset('img/carn2.png') }}" class="img-hover">
            </div>
            <p class="product-desc">CASACA CARNERO LOND BEIGE</p>
            <p class="product-price">
              <s class="product-price" style="color:gray;">S/249.90</s> S/169.90
            </p>
          </a>
        </div>

        <div class="col-6 col-md-3 text-center">
          <a href="/producto/13" class="product-card">
            <div class="product-img-wrapper">
              <img src="{{ asset('img/boxy.png') }}" class="img-main">
              <img src="{{ asset('img/boxy2.png') }}" class="img-hover">
            </div>
            <p class="product-desc">CASACA BOXY FIT NOMAD</p>
            <p class="product-price">
              <s class="product-price" style="color:gray;">S/249.90</s> S/135.00
            </p>
          </a>
        </div>

        <div class="col-6 col-md-3 text-center product-card ver-mas">
          <div class="ver-mas-title">CASACAS</div>
          <a href="/productos" class="ver-mas-link">Ver más</a>
        </div>

      </div>
    </div>

  </div>

  <!-- Controles del carrusel -->
  <button id="prevProduct2" class="carousel-control-prev" type="button" data-bs-target="#productCarousel2" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button id="nextProduct2" class="carousel-control-next" type="button" data-bs-target="#productCarousel2" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<div class="banner" style="margin-top: 40px;">
      <img src="{{ asset('img/baner.png') }}" class="d-block w-100">
    </div>
<div class="verano" style="margin-top: 60px; text-align: center; gap: 20px; display: flex; padding-left: 180px;">
      <img src="{{ asset('img/bividi3.png') }}" style="width: 600px; height: auto;">
     <div style="display: flex; flex-direction: column; justify-content: flex-start;">
    <h2 style="margin: 180px 0 0 0; padding-left: 200px">¡Nuevos Conjuntos Moda Emilio!</h2>
    <p style="margin: 60px 0 0 0; font-size: 20px; padding-left: 200px; color: gray;">¡Prepara tu armario para el calor! El Set Camisa Short Hombre Emilio 
      <br><br> es la clave para un estilo casual coordinado y sin esfuerzo...</p>
      <a href="/productos" 
     class="btn-ver">
    Ver colección
  </a>
  </div>
</div>
</div>


<!-- Carrusel de categorías -->
<div id="productCarousel3" class="carousel slide">
  <div class="carousel-inner">

    <!-- Slide 1 -->
    <div class="carousel-item active">
      <div class="row justify-content-center g-3">
        
        <div class="col-6 col-md-4 text-center">
          <a href="/productos?categoria=zapatillas" class="category-card-link">
            <div class="category-card">
              <img src="{{ asset('img/zapa.png') }}" class="category-img">
              <div class="category-overlay"><span>ZAPATILLAS</span></div>
            </div>
            <div class="category-ver-mas">Ver más →</div>
          </a>
        </div>

        <div class="col-6 col-md-4 text-center">
          <a href="/productos?categoria=shorts" class="category-card-link">
            <div class="category-card">
              <img src="{{ asset('img/short.png') }}" class="category-img">
              <div class="category-overlay"><span>SHORTS</span></div>
            </div>
            <div class="category-ver-mas">Ver más →</div>
          </a>
        </div>

        <div class="col-6 col-md-4 text-center">
          <a href="/productos?categoria=pantalones" class="category-card-link">
            <div class="category-card">
              <img src="{{ asset('img/pantalon.png') }}" class="category-img">
              <div class="category-overlay"><span>PANTALONES</span></div>
            </div>
            <div class="category-ver-mas">Ver más →</div>
          </a>
        </div>

      </div>
    </div>

    <!-- Slide 2 -->
    <div class="carousel-item">
      <div class="row justify-content-center g-3">

        <div class="col-6 col-md-4 text-center">
          <a href="/productos?categoria=casacas" class="category-card-link">
            <div class="category-card">
              <img src="{{ asset('img/casaca.png') }}" class="category-img">
              <div class="category-overlay"><span>CASACAS</span></div>
            </div>
            <div class="category-ver-mas">Ver más →</div>
          </a>
        </div>

        <div class="col-6 col-md-4 text-center">
          <a href="/productos?categoria=polos" class="category-card-link">
            <div class="category-card">
              <img src="{{ asset('img/polos.png') }}" class="category-img">
              <div class="category-overlay"><span>POLOS</span></div>
            </div>
            <div class="category-ver-mas">Ver más →</div>
          </a>
        </div>

        <div class="col-6 col-md-4 text-center">
          <a href="/productos?categoria=poleras" class="category-card-link">
            <div class="category-card">
              <img src="{{ asset('img/polera.png') }}" class="category-img">
              <div class="category-overlay"><span>POLERAS</span></div>
            </div>
            <div class="category-ver-mas">Ver más →</div>
          </a>
        </div>

      </div>
    </div>

    <!-- Slide 3 -->
     <div class="carousel-item">
      <div class="row justify-content-center g-3">

        <div class="col-6 col-md-4 text-center">
          <a href="/productos?categoria=gorras" class="category-card-link">
            <div class="category-card">
              <img src="{{ asset('img/gorra.png') }}" class="category-img">
              <div class="category-overlay"><span>Gorras</span></div>
            </div>
            <div class="category-ver-mas">Ver más →</div>
          </a>
        </div>
        </div>
        </div>


  </div>
  <!-- Controles del carrusel -->
  <button id="prevProduct3" class="carousel-control-prev" type="button" data-bs-target="#productCarousel3">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button id="nextProduct3" class="carousel-control-next" type="button" data-bs-target="#productCarousel3">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>


@endsection

@push('scripts')
<script src="{{ asset('js/product-carousel.js') }}"></script>
<script src="{{ asset('js/scroll-effects.js') }}"></script>
@endpush
