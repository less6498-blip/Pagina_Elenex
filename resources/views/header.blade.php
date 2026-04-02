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
      <p>🚚 ENVIOS GRATIS POR COMPRAS MAYORES A S/150.00 A TODO LIMA</p>
    </div>
  </div>
</div>

<!-- HEADER -->
<header class="header">
  <div class="header-container">

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
        <li class="menu-item">CONJUNTOS</li>
        <li class="menu-item">
          <a href="{{ route('productos.newArrivals') }}">NEW ARRIVALS</a>
        </li>
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
// ===============================
// HEADER Y MENU VERTICAL
// ===============================
const items = document.querySelectorAll(".menu-item");
const menus = document.querySelectorAll(".mega-menu");
const overlay = document.getElementById("menu-overlay");

// Mostrar menú vertical al pasar mouse
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
      if (menu) {
        menu.style.opacity = "1";
        menu.style.visibility = "visible";
        menu.style.pointerEvents = "auto";
        overlay.classList.add("active");
      }
    } else {
      overlay.classList.remove("active");
    }
  });
});

document.querySelector(".header").addEventListener("mouseleave", () => {
  menus.forEach(menu => {
    menu.style.opacity = "0";
    menu.style.visibility = "hidden";
    menu.style.pointerEvents = "none";
  });
  overlay.classList.remove("active");
});

overlay.addEventListener("click", () => {
  menus.forEach(menu => {
    menu.style.opacity = "0";
    menu.style.visibility = "hidden";
    menu.style.pointerEvents = "none";
  });
  overlay.classList.remove("active");
});

// Header que se achica al hacer scroll
window.addEventListener("scroll", () => {
  const header = document.querySelector(".header");
  if (window.scrollY > 50) header.classList.add("scrolled");
  else header.classList.remove("scrolled");
});

// ===============================
// BUSCADOR HEADER
// ===============================
const searchOverlay = document.getElementById('search-overlay');
const searchPanel = document.querySelector('.search-panel');
const searchInput = document.getElementById('search-input');
const searchClose = document.getElementById('search-close');
const searchResults = document.getElementById('search-results');
const searchMore = document.getElementById('search-more');
const clearBtn = document.getElementById('clear-search');
const searchInfoText = document.getElementById('search-info');

let timeout;
let palabraBuscada = '';
let tieneResultados = false;

// Mapa de categorías
const categoriaMap = {
    "polo": "Polos", "polos": "Polos",
    "camisa": "Camisas", "camisas": "Camisas",
    "pantalon": "Pantalones", "pantalones": "Pantalones",
    "casaca": "Casacas", "casacas": "Casacas",
    "chaleco": "Chalecos", "chalecos": "Chalecos",
    "polera": "Poleras", "poleras": "Poleras",
    "jogger": "Joggers", "joggers": "Joggers",
    "bermuda": "Bermudas", "bermudas": "Bermudas",
    "short": "Shorts", "shorts": "Shorts",
    "accesorio": "Accesorios", "accesorios": "Accesorios"
};

// Abrir panel
document.getElementById('search-open').onclick = () => {
    searchOverlay.classList.add('active');
    requestAnimationFrame(() => searchPanel.classList.add('opening'));
    searchInput.focus();
    document.body.style.overflow = 'hidden';
};

// Cerrar panel
function cerrarPanel() {
    searchPanel.classList.remove('opening');
    searchPanel.classList.add('closing');
    setTimeout(() => {
        searchOverlay.classList.remove('active');
        searchPanel.classList.remove('closing');
        searchResults.innerHTML = '';
        searchInput.value = '';
        searchMore.style.display = 'none';
        clearBtn.classList.remove('show');
        searchInfoText.style.display = 'none'; // oculto al cerrar
        palabraBuscada = '';
        tieneResultados = false;
        document.body.style.overflow = 'auto';
    }, 350);
}
searchClose.onclick = cerrarPanel;
searchOverlay.addEventListener('click', e => { if(e.target === searchOverlay) cerrarPanel(); });

// Mostrar resultados
async function mostrarResultados(query) {
    searchResults.innerHTML = '';
    tieneResultados = false;

    if(!query){
        searchInfoText.style.display = 'none';
        searchMore.style.display = 'none';
        return;
    }

    try {
        const res = await fetch(`/api/productos/buscar?q=${encodeURIComponent(query)}`);
        let productos = await res.json();

        if(!productos || productos.length === 0){
            searchResults.innerHTML = `<div style="color:#555;padding:20px;text-align:center;">
                No se encontraron resultados para "<strong>${query}</strong>"
            </div>`;
            searchInfoText.style.display = 'none';
            searchMore.style.display = 'none';
            return;
        }

        productos.slice(0,5).forEach((p, i) => {
            const div = document.createElement('div');
            div.className = 'search-item';
            div.innerHTML = `
                <img src="${p.imagen}">
                <div class="name">${p.nombre}</div>
                <div class="price">S/ ${parseFloat(p.precio).toFixed(2)}</div>
            `;
            div.onclick = () => window.location.href = `/productos/${p.id}`;
            searchResults.appendChild(div);
            setTimeout(() => div.classList.add('show'), i*20);
        });

        // Mostrar texto "Productos" solo cuando hay resultados
        searchInfoText.style.display = 'block';
        searchInfoText.textContent = 'Productos';
        tieneResultados = true;
        searchMore.style.display = 'block';

    } catch (err) {
        console.error(err);
        searchResults.innerHTML = `<div style="color:#555;padding:20px;text-align:center;">Error al buscar productos</div>`;
        searchInfoText.style.display = 'none';
        searchMore.style.display = 'none';
    }
}

// Input
searchInput.addEventListener('input', e => {
    palabraBuscada = e.target.value.trim();
    clearBtn.classList.toggle('show', palabraBuscada.length>0);
    clearTimeout(timeout);
    timeout = setTimeout(() => mostrarResultados(palabraBuscada), 200);
});

// Limpiar input
clearBtn.onclick = () => {
    searchInput.value = '';
    searchResults.innerHTML = '';
    searchInfoText.style.display = 'none'; // desaparece al borrar
    searchMore.style.display = 'none';
    clearBtn.classList.remove('show');
    palabraBuscada = '';
};

// Ver más
searchMore.onclick = () => {
    if(!palabraBuscada) return;
    const palabra = palabraBuscada.toLowerCase();
    let categoriaEncontrada = null;
    Object.keys(categoriaMap).forEach(k => { if(palabra.includes(k)) categoriaEncontrada = categoriaMap[k]; });
    if(categoriaEncontrada){
        window.location.href = `/catalogo/${encodeURIComponent(categoriaEncontrada)}`;
    } else {
        window.location.href = `/catalogo?query=${encodeURIComponent(palabraBuscada)}`;
    }
};
</script>

<script src="{{ asset('js/mini-carrusel.js') }}"></script>
</body>
</html>