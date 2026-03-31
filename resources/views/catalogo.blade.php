<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo - Elenex</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tus estilos -->
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/catalogo.css') }}">
</head>
<body>

{{-- HEADER --}}
@include('header')

<div class="container" style="padding-top: 180px;">
    <h1 class="text-center mb-5" style="margin-left: 330px;">Catálogo de Productos 🛍️</h1>

    <div class="row" style="padding-top: 10px;">
        {{-- Sidebar de categorías --}}
        <div class="col-lg-3 mb-4">
            <div class="list-group" id="category-list">
                <a href="#" class="list-group-item list-group-item-action active" data-category="all">
                    TODOS
                </a>
                @foreach($categorias as $categoriaNombre => $productos)
                    <a href="#" class="list-group-item list-group-item-action" data-category="{{ $categoriaNombre }}">
                        {{ strtoupper($categoriaNombre) }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Productos --}}
        <div class="col-lg-9">
            <div class="row g-4" id="products-grid">
                @foreach($categorias as $categoriaNombre => $productos)
                    @foreach($productos as $producto)
                        <div class="col-md-6 col-lg-4 product-item" data-category="{{ $categoriaNombre }}">
                            <div class="card product-card">
                                {{-- Imagen principal y hover --}}
                                <div class="product-img-wrapper">
                                    <img src="{{ asset('img/' . $producto->imagen) }}" class="product-img" alt="{{ $producto->nombre }}">
                                    @if($producto->imagen2)
                                        <img src="{{ asset('img/' . $producto->imagen2) }}" class="product-img img-hover" alt="{{ $producto->nombre }} hover">
                                    @endif
                                </div>

                                {{-- Información --}}
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $producto->nombre }}</h5>
                                    <p class="price">S/ {{ number_format($producto->precio, 2) }}</p>

                                    <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-primary btn-custom mb-2">
                                        Ver detalle
                                    </a>

                                    <form action="#" method="POST">
                                        @csrf
                                    <button type="submit" class="btn btn-dark btn-custom w-100 mb-2 d-flex justify-content-center align-items-center">
                                        <span>Añadir al carrito</span>
                                    <img src="https://img.icons8.com/?size=100&id=3686&format=png&color=ffffff" 
                                        style="width:20px; height:20px; margin-left:5px;">
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</div>

@include('footer')

<!-- Scripts -->
<script src="https://kit.fontawesome.com/515cfa72de.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<script>
const categoryLinks = document.querySelectorAll('#category-list .list-group-item');
const products = document.querySelectorAll('.product-item');

// 👇 viene desde el controller
const categoriaDesdeURL = @json($categoria);

// 🔹 función para filtrar (tu lógica)
function filtrarCategoria(category){
    products.forEach(product => {
        if(category === 'all' || product.getAttribute('data-category') === category){
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
}

// 🔹 clicks normales (NO se rompe)
categoryLinks.forEach(link => {
    link.addEventListener('click', e => {
        e.preventDefault();

        categoryLinks.forEach(l => l.classList.remove('active'));
        link.classList.add('active');

        const category = link.getAttribute('data-category');
        filtrarCategoria(category);
    });
});

// 🔥 AQUÍ ESTÁ LA MAGIA
if(categoriaDesdeURL){
    filtrarCategoria(categoriaDesdeURL);

    categoryLinks.forEach(link => {
        if(link.getAttribute('data-category') === categoriaDesdeURL){
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
}
</script>

</body>
</html>