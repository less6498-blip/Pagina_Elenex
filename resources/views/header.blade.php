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
<a href="/">
<img src="{{ asset('img/elelogo.webp') }}">
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

<!-- MENU VERTICAL -->
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
</header>
<div id="menu-overlay"></div>

<!-- BUSCADOR -->
<div class="search-panel-overlay" id="search-overlay">
  <div class="search-panel">
    
    <!-- Header del panel -->
    <div class="search-panel-header">
      <img src="https://cdn-icons-png.flaticon.com/512/622/622669.png" alt="lupa" class="search-icon">

      <div class="search-input-wrapper">
      <input type="text" id="search-input" placeholder="Buscar productos...">
      <button id="clear-search">Borrar</button>
      </div>

      <button id="search-close">✕</button>
    </div>

    <!-- Texto debajo del input -->
    <div class="search-info-text">
      Productos
    </div>

    <!-- Resultados -->
    <div id="search-results" class="search-results">
      <!-- Productos aparecerán aquí -->
    </div>

    <!-- Botón ver más -->
     <div class="search-info-text" id="search-error" style="display:none;"></div>
    <button class="search-more-btn" id="search-more" style="display:none;">VER MÁS</button>
  </div>
</div>



<!-- JS MENU -->
<script>
const items = document.querySelectorAll(".menu-item");
const menus = document.querySelectorAll(".mega-menu");
const overlay = document.getElementById("menu-overlay");

items.forEach(item => {
  item.addEventListener("mouseenter", () => {
    const id = item.dataset.menu;

    // Ocultar todos los mega-menus
    menus.forEach(menu => {
      menu.style.opacity = "0";
      menu.style.visibility = "hidden";
      menu.style.pointerEvents = "none";
    });

    // Si es Catálogo (tiene data-menu)
    if (id) {
      const menu = document.getElementById(id);
      if (menu) {
        menu.style.opacity = "1";
        menu.style.visibility = "visible";
        menu.style.pointerEvents = "auto";

        // 🔥 Mostrar overlay solo para Catálogo
        overlay.classList.add("active");
      }
    } else {
      // 🔥 Si no es Catálogo, quitar overlay
      overlay.classList.remove("active");
    }
  });
});

// Al salir del header, ocultar todo y quitar overlay
document.querySelector(".header").addEventListener("mouseleave", () => {
  menus.forEach(menu => {
    menu.style.opacity = "0";
    menu.style.visibility = "hidden";
    menu.style.pointerEvents = "none";
  });

  overlay.classList.remove("active");
});

// Cerrar si hacen click fuera
overlay.addEventListener("click", () => {
  menus.forEach(menu => {
    menu.style.opacity = "0";
    menu.style.visibility = "hidden";
    menu.style.pointerEvents = "none";
  });

  overlay.classList.remove("active");
});
</script>


<!-- ACHICAR ELEMENTOS MEDIANTE SCROLL -->
<script>
window.addEventListener("scroll", () => {
  const header = document.querySelector(".header");
  if (window.scrollY > 50) { // ajusta el valor si quieres que se achique antes o después
    header.classList.add("scrolled");
  } else {
    header.classList.remove("scrolled");
  }
});
</script>

<!-- BUSCADOR DEL HEADER 🔍 -->
<script>
const searchOverlay = document.getElementById('search-overlay');
const searchPanel = document.querySelector('.search-panel');
const searchInput = document.getElementById('search-input');
const searchClose = document.getElementById('search-close');
const searchResults = document.getElementById('search-results');
const searchMore = document.getElementById('search-more');
const clearBtn = document.getElementById('clear-search');
const searchInfoText = document.querySelector('.search-info-text');

let cerrando = false;
let timeout;
let palabraBuscada = '';
let tieneResultados = false;

// 🔓 ABRIR PANEL
document.getElementById('search-open').onclick = () => {
  searchOverlay.classList.add('active');
  requestAnimationFrame(() => searchPanel.classList.add('opening'));
  searchInput.focus();
  document.body.style.overflow = 'hidden';
  searchInfoText.style.opacity = 0;
};

// 🔒 CERRAR PANEL
function cerrarPanel() {
  if (cerrando) return;
  cerrando = true;

  searchPanel.classList.remove('opening');
  searchPanel.classList.add('closing');

  setTimeout(() => {
    searchOverlay.classList.remove('active');
    searchPanel.classList.remove('closing');
    document.body.style.overflow = 'auto';
    searchResults.innerHTML = '';
    searchInput.value = '';
    searchMore.style.display = 'none';
    clearBtn.classList.remove('show');
    searchInfoText.style.opacity = 0;
    palabraBuscada = '';
    tieneResultados = false;
    cerrando = false;
  }, 350);
}

// ❌ BOTÓN CERRAR
searchClose.onclick = cerrarPanel;

// ❌ CLICK FUERA DEL PANEL
searchOverlay.addEventListener('click', (e) => {
  if (e.target === searchOverlay) cerrarPanel();
});

// ❌ TECLA ESC
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') cerrarPanel();
});

// 🔍 BUSCAR PRODUCTOS
async function mostrarResultados(query) {
  searchResults.innerHTML = '';
  tieneResultados = false;

  if (!query) {
    searchMore.style.display = 'none';
    searchInfoText.style.opacity = 0;
    return;
  }

  try {
    const response = await fetch(`/api/productos/buscar?q=${encodeURIComponent(query)}`);
    const productos = await response.json();

    if (!productos || productos.length === 0) {
      searchResults.innerHTML = `
        <div style="color:#555; padding:20px; text-align:center;">
          No se encontraron resultados para "<strong>${query}</strong>".<br>
          Revisa la ortografía o usa una palabra o frase diferente.
        </div>
      `;
      searchMore.style.display = 'none';
      searchInfoText.style.opacity = 0;
      return;
    }

    // Mostrar productos
    productos.forEach((p, index) => {
      const div = document.createElement('div');
      div.className = 'search-item';
      div.innerHTML = `
        <img src="${p.imagen}" alt="${p.nombre}">
        <div class="name">${p.nombre}</div>
        <div class="price">S/ ${parseFloat(p.precio).toFixed(2)}</div>
      `;
      div.addEventListener('click', () => {
        window.location.href = `/producto/${p.id}`;
      });
      searchResults.appendChild(div);
      setTimeout(() => div.classList.add('show'), index * 20);
    });

    // Mostrar botón VER MÁS solo si hay resultados
    tieneResultados = true;
    searchMore.style.display = 'block';
    searchInfoText.style.opacity = 1;
  } catch (error) {
    console.error('Error al buscar productos:', error);
    searchResults.innerHTML = `
      <div style="color:#555; padding:20px; text-align:center;">
        Ocurrió un error. Intenta nuevamente.
      </div>
    `;
    searchMore.style.display = 'none';
    searchInfoText.style.opacity = 0;
  }
}

// ✍️ INPUT: mostrar botón borrar + resultados + texto info
searchInput.addEventListener('input', (e) => {
  palabraBuscada = e.target.value.trim();

  if (palabraBuscada.length > 0) {
    clearBtn.classList.add('show');
  } else {
    clearBtn.classList.remove('show');
    searchInfoText.style.opacity = 0;
  }

  clearTimeout(timeout);
  timeout = setTimeout(() => mostrarResultados(palabraBuscada), 150);
});

// ❌ BOTÓN LIMPIAR INPUT
clearBtn.onclick = () => {
  searchInput.value = '';
  searchResults.innerHTML = '';
  searchMore.style.display = 'none';
  clearBtn.classList.remove('show');
  searchInfoText.style.opacity = 0;
  palabraBuscada = '';
  tieneResultados = false;
  searchInput.focus();
};

// 🔗 BOTÓN VER MÁS → redirige a categoría si existe, sino a búsqueda general
searchMore.onclick = () => {
  if (!tieneResultados) return;

  const palabra = palabraBuscada.trim().toLowerCase();

  // Mapear palabras a categorías existentes
  const categorias = {
    "polos": "Polos",
    "casacas": "Casacas"
  };

  let categoriaEncontrada = null;
  Object.keys(categorias).forEach(key => {
    if (palabra.includes(key)) categoriaEncontrada = categorias[key];
  });

  if (categoriaEncontrada) {
    // Redirige a la categoría
    window.location.href = `/productos/catalogo?categoria=${encodeURIComponent(categoriaEncontrada)}`;
  } else {
    // Si no hay categoría válida, va a búsqueda general
    window.location.href = `/productos/buscar?query=${encodeURIComponent(palabraBuscada)}`;
  }
};
</script>
<script src="{{ asset('js/mini-carrusel.js') }}"></script>

</body>
</html>