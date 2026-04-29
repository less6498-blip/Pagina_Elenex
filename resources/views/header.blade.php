<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Elenex</title>
  <link rel="stylesheet" href="{{ asset('css/header.css') }}">
  <!-- CAMBIO 2: Incluir los nuevos assets ANTES de </body> -->
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">

</head>
<body>

<!-- CARRUSEL -->
<div class="mini-carrusel">
  <div class="carrusel-track">
    <div class="carrusel-item">
      <p>ENVIOS GRATIS POR COMPRAS MAYORES A S/150.00 A TODO LIMA METROPOLITANA</p>
    </div>
  </div>
</div>

<!-- HEADER -->
<header class="header">
  <div class="header-container">

  <button class="hamburger" id="hamburger-btn" aria-label="Abrir menú">
  <span></span><span></span><span></span>
</button>

    <!-- LOGO -->
    <div class="logo">
      <a href="/"><img src="{{ asset('img/elelogo.webp') }}"></a>
    </div>

    <!-- MENU -->
    <nav class="nav">
      <ul class="menu">
        <li class="menu-item" data-menu="catalogo">
          <a href="{{ route('productos.catalogo') }}">CATÁLOGO <span class="arrow"></span></a>
        </li>
        <li class="menu-item"><a href="#">WOMAN</a></li>
        <li class="menu-item"><a href="#">KIDS</a></li>
        <li class="menu-item">
          <a href="{{ route('productos.newArrivals') }}">NEW ARRIVALS</a>
        </li>
        <li class="menu-item-especial"><a href="#">LIQUIDACIÓN</a></li>
        <li class="menu-item-coleccion"><a href="#">AFTER WAVE</a></li>
      </ul>
    </nav>

    <!-- RIGHT -->
    <div class="header-right">
      <button class="search-btn" id="search-open">
        <img src="https://cdn-icons-png.flaticon.com/512/622/622669.png">
      </button>
      <a href="#" class="cart-btn" aria-label="Abrir carrito">
  <img src="https://img.icons8.com/?size=100&id=3686&format=png&color=000000" alt="Carrito">
  <span class="cart-badge" aria-hidden="true" style="display:none;">0</span>
</a>
    </div>

    <!-- MENU VERTICAL CATEGORÍAS -->
    <div class="mega-menu vertical-menu" id="catalogo">
      <div class="menu-col">
        @foreach(\App\Models\Categoria::all() as $categoria)
          <a href="{{ route('productos.catalogo', ['categoria' => $categoria->nombre]) }}"
             class="{{ request('categoria') == $categoria->nombre ? 'activo' : '' }}">
             {{ $categoria->nombre }}
          </a>
        @endforeach
      </div>
    </div>
  </div>
</header>

<div class="drawer-overlay" id="drawer-overlay"></div>
 
<aside class="mobile-drawer" id="mobile-drawer">
  <div class="drawer-header">
    <a href="/"><img src="{{ asset('img/elelogo.webp') }}" alt="Elenex"></a>
    <button class="drawer-close" id="drawer-close">✕</button>
  </div>
  <ul class="drawer-menu">
    <li>
      <div class="drawer-toggle" id="drawer-catalogo-toggle">
        CATÁLOGO <span class="arrow"></span>
      </div>
      <ul class="drawer-submenu" id="drawer-catalogo-sub">
        @foreach(\App\Models\Categoria::all() as $categoria)
          <li>
            <a href="{{ route('productos.catalogo', ['categoria' => $categoria->nombre]) }}"
               class="{{ request('categoria') == $categoria->nombre ? 'activo' : '' }}">
              {{ $categoria->nombre }}
            </a>
          </li>
        @endforeach
      </ul>
    </li>
    <li><a href="#">WOMAN</a></li>
    <li><a href="#">KIDS</a></li>
    <li><a href="{{ route('productos.newArrivals') }}">NEW ARRIVALS</a></li>
    <li class="item-especial"><a href="#">LIQUIDACIÓN</a></li>
    <li class="item-especial-coleccion"><a href="#">AFTER WAVE</a></li>
  </ul>
</aside>

<div id="menu-overlay"></div>

<!-- BUSCADOR -->
<div class="search-panel-overlay" id="search-overlay">
  <div class="search-panel">
    <div class="search-panel-header">
      <img src="https://cdn-icons-png.flaticon.com/512/622/622669.png" alt="lupa" class="search-icon">
      <div class="search-input-wrapper">
        <input type="text" id="search-input" placeholder="Buscar productos...">
        <button id="clear-search">Borrar</button>
      </div>
      <button id="search-close">✕</button>
    </div>

    <div class="search-info-text" id="search-info">Productos</div>

    <div id="search-results" class="search-results"></div>

    <button class="search-more-btn" id="search-more" style="display:none;">VER MÁS</button>
  </div>
</div>

<script>
  (function () {
    var btn     = document.getElementById('hamburger-btn');
    var drawer  = document.getElementById('mobile-drawer');
    var overlay = document.getElementById('drawer-overlay');
    var close   = document.getElementById('drawer-close');
    var toggle  = document.getElementById('drawer-catalogo-toggle');
    var sub     = document.getElementById('drawer-catalogo-sub');
 
    function open()  { drawer.classList.add('open'); overlay.classList.add('active'); btn.classList.add('active'); document.body.style.overflow = 'hidden'; }
    function shut()  { drawer.classList.remove('open'); overlay.classList.remove('active'); btn.classList.remove('active'); document.body.style.overflow = ''; }
 
    btn.addEventListener('click', open);
    close.addEventListener('click', shut);
    overlay.addEventListener('click', shut);
 
    toggle.addEventListener('click', function () {
      var open = sub.classList.toggle('open');
      toggle.classList.toggle('open', open);
    });
  })();
</script>

<script src="{{ asset('js/header.js') }}"></script>
<script src="{{ asset('js/mini-carrusel.js') }}"></script>
<!-- ... resto del head o al final del body: -->
<script src="{{ asset('js/cart.js') }}"></script>
</body>
</html>