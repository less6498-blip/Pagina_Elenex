<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Elenex</title>

  <!-- Link al CSS externo -->
  <link rel="stylesheet" href="{{ asset('css/header.css') }}">
</head>
<body>

<!-- CARRUSEL PEQUEÑO -->
<div class="mini-carrusel">
  <div class="carrusel-track">
    <div class="carrusel-item"><img src="{{ asset('img/fala.png') }}" alt="fala" width="16" height="18"><p class="parrafo">
      Encuentranos en<a href="https://www.falabella.com.pe/falabella-pe/seller/ELENEX" class="falabella-link" target="_blank"> falabella.com</a></p></div>
    <div class="carrusel-item"><img src="{{ asset('img/rip.png') }}" alt="rip" width="14" height="14"><p class="parrafo">
      Encuentranos en <a href="https://simple.ripley.com.pe/tienda/elenex-4142?type=catalog" class="ripley-link" target="_blank"> ripley.com</a></p></div>
      <div class="carrusel-item"><img src="{{ asset('img/fala.png') }}" alt="fala"  width="16" height="18" /> <p class="parrafo">
      Encuéntranos en <a href="https://www.falabella.com.pe/falabella-pe/seller/ELENEX" class="falabella-link" target="_blank"> falabella.com</span></p>
    </div>
  </div>
</div>

  <!-- HEADER PRINCIPAL -->
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

<li class="menu-item" data-menu="ropa">
ROPA <span class="arrow"></span>
</li>

<li class="menu-item" data-menu="calzado">
CALZADO <span class="arrow"></span>
</li>

<li class="menu-item" data-menu="accesorios">
ACCESORIOS <span class="arrow"></span>
</li>

<li class="menu-item">CONJUNTOS</li>
<li class="menu-item-especial">NEW ARRIVALS</li>

</ul>

</nav>

<!-- SEARCH -->

<div class="header-right">

<button class="search-btn" id="search-open">
<img src="https://cdn-icons-png.flaticon.com/512/622/622669.png" alt="buscar">
</button>


<!-- SHOP -->
<a href="#" class="cart-btn">
  <img src="https://img.icons8.com/?size=100&id=3686&format=png&color=000000" alt="Bolsa de compras" class="cart-icon">
  <span class="cart-count">0</span>
</a>

</div>

<!-- MEGA MENUS -->

<div class="mega-menu" id="ropa">

<a href="#">Polos</a>
<a href="#">Pantalones</a>
<a href="#">Chalecos</a>
<a href="#">Shorts</a>
<a href="#">Casacas</a>

</div>

<div class="mega-menu" id="calzado">

<a href="#">Zapatillas</a>
<a href="#">Sandalias</a>

</div>

<div class="mega-menu" id="accesorios">

<a href="#">Gorras</a>

</div>
</header>

<!-- BARRA DE BUSQUEDA -->
<div class="search-right-overlay" id="search-overlay">

<div class="search-right-container">

<img src="https://img.icons8.com/?size=100&id=7695&format=png&color=000000" alt="lupa">
<input type="text" placeholder="Buscar productos..." class="search-input">

<button id="search-close">✕</button>

</div>

</div>

<!-- MENU DE ITEMS -->
<script>

const items = document.querySelectorAll(".menu-item");
const menus = document.querySelectorAll(".mega-menu");

items.forEach(item => {
  item.addEventListener("mouseenter", () => {
    const id = item.dataset.menu;

    // Ocultar todos los menús excepto el actual
    menus.forEach(menu => {
      if (menu.id !== id) {
        menu.style.opacity = "0";
        menu.style.visibility = "hidden";
        menu.style.pointerEvents = "none"; // No clicable cuando está oculto
      }
    });

    // Mostrar el menú correspondiente
    if (id) {
      const menu = document.getElementById(id);
      menu.style.opacity = "1";
      menu.style.visibility = "visible";
      menu.style.pointerEvents = "auto"; // clicable
    }
  });
});

// Cuando el mouse sale del header, ocultar todos los menús
document.querySelector(".header").addEventListener("mouseleave", () => {
  menus.forEach(menu => {
    menu.style.opacity = "0";
    menu.style.visibility = "hidden";
    menu.style.pointerEvents = "none";
  });
});
</script>

<script>

/* BUSCADOR */

const openSearch = document.getElementById("search-open");
const closeSearch = document.getElementById("search-close");
const searchOverlay = document.getElementById("search-overlay");

openSearch.onclick = () => {

searchOverlay.classList.add("active");

document.body.style.overflow="hidden"; /*bloquear scroll*/

}

closeSearch.onclick = () => {

searchOverlay.classList.remove("active");

document.body.style.overflow= "auto"; /*vuelve scroll*/

}

document.getElementById("search-overlay").addEventListener("click", function(e) {

  if(e.target === this){
    this.classList.remove("active");
    document.body.style.overflow = "auto";
  }

});

/* CONTADOR BOLSO (ejemplo) */

function addToCart(){

let count = document.querySelector(".cart-count");

count.innerText = parseInt(count.innerText) + 1;

}

</script>

<script>

window.addEventListener("scroll", function(){

const header = document.querySelector(".header");

if(window.scrollY > 50){

header.classList.add("scrolled");

}else{

header.classList.remove("scrolled");

}

});

</script>
<script src="{{ asset('js/mini-carrusel.js') }}"></script>
</body>
</html>