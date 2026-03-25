<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Elenex</title>

  <link rel="stylesheet" href="{{ asset('css/header.css') }}">
</head>
<body>

<!-- CARRUSEL -->
<div class="mini-carrusel">
  <div class="carrusel-track">
    <div class="carrusel-item">
      <img src="{{ asset('img/fala.png') }}" width="16">
      <p>Encuéntranos en <a href="https://www.falabella.com.pe/falabella-pe/seller/ELENEX" target="_blank">falabella.com</a></p>
    </div>
    <div class="carrusel-item">
      <img src="{{ asset('img/rip.png') }}" width="14">
      <p>Encuéntranos en <a href="https://simple.ripley.com.pe/tienda/elenex-4142?type=catalog" target="_blank">ripley.com</a></p>
    </div>
  </div>
</div>

<!-- HEADER -->
<header class="header">
<div class="header-container">

<!-- LOGO -->
<div class="logo">
<a href="/">
<img src="{{ asset('img/elelogo.png') }}">
</a>
</div>

<!-- MENU -->
<nav class="nav">
<ul class="menu">

<li class="menu-item" data-menu="catalogo">
<a href="{{ route('productos.catalogo') }}">
CATÁLOGO <span class="arrow"></span>
</a>
</li>

<li class="menu-item">ACCESORIOS</li>
<li class="menu-item">CONJUNTOS</li>
<li class="menu-item">NEW ARRIVALS</li>
<li class="menu-item-especial">LIQUIDACIÓN 🔥</li>

</ul>
</nav>

<!-- RIGHT -->
<div class="header-right">

<button class="search-btn" id="search-open">
<img src="https://cdn-icons-png.flaticon.com/512/622/622669.png">
</button>

<a href="#" class="cart-btn">
  <img src="https://img.icons8.com/?size=100&id=3686&format=png&color=000000">
  <span class="cart-count">0</span>
</a>

</div>

<!-- MENU VERTICAL -->
<div class="mega-menu vertical-menu" id="catalogo">

    <div class="menu-col">
        <span>Polos</span>
        <div class="submenu">
            <a href="{{ route('productos.catalogo', ['categoria' => 'oversize']) }}">Oversize</a>
            <a href="#">Básicos</a>
        </div>
    </div>

    <div class="menu-col">
        <span>Pantalones</span>
        <div class="submenu">
            <a href="{{ route('productos.catalogo', ['categoria' => 'jean']) }}">Jean</a>
        </div>
    </div>

    <div class="menu-col">
        <span>Chalecos</span>
        <div class="submenu">
            <a href="#">Deportivos</a>
        </div>
    </div>

    <div class="menu-col">
        <span>Calzado</span>
        <div class="submenu">
            <a href="{{ route('productos.catalogo', ['categoria' => 'zapatillas']) }}">Zapatillas</a>
        </div>
    </div>

</div>

</div>
</header>

<!-- BUSCADOR -->
<div class="search-right-overlay" id="search-overlay">
<div class="search-right-container">
<img src="https://img.icons8.com/?size=100&id=7695&format=png&color=000000">
<input type="text" placeholder="Buscar productos..." class="search-input">
<button id="search-close">✕</button>
</div>
</div>

<!-- JS MENU -->
<script>
const items = document.querySelectorAll(".menu-item");
const menus = document.querySelectorAll(".mega-menu");

items.forEach(item => {
  item.addEventListener("mouseenter", () => {
    const id = item.dataset.menu;

    menus.forEach(menu => {
      menu.style.opacity = "0";
      menu.style.visibility = "hidden";
      menu.style.pointerEvents = "none";
    });

    if (id) {
      const menu = document.getElementById(id);
      if(menu){
        menu.style.opacity = "1";
        menu.style.visibility = "visible";
        menu.style.pointerEvents = "auto";
      }
    }
  });
});

document.querySelector(".header").addEventListener("mouseleave", () => {
  menus.forEach(menu => {
    menu.style.opacity = "0";
    menu.style.visibility = "hidden";
    menu.style.pointerEvents = "none";
  });
});
</script>

<!-- BUSCADOR JS -->
<script>
const openSearch = document.getElementById("search-open");
const closeSearch = document.getElementById("search-close");
const searchOverlay = document.getElementById("search-overlay");

openSearch.onclick = () => {
searchOverlay.classList.add("active");
document.body.style.overflow="hidden";
}

closeSearch.onclick = () => {
searchOverlay.classList.remove("active");
document.body.style.overflow="auto";
}

searchOverlay.addEventListener("click", function(e) {
  if(e.target === this){
    this.classList.remove("active");
    document.body.style.overflow = "auto";
  }
});
</script>

<script src="{{ asset('js/mini-carrusel.js') }}"></script>

</body>
</html>