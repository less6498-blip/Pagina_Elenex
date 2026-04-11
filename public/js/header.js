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