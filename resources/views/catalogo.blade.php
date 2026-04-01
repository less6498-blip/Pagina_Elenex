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
    <div class="list-group">
        {{-- TODOS --}}
        <a href="{{ route('productos.catalogo') }}"
           class="list-group-item list-group-item-action {{ !$categoria ? 'active' : '' }}">
            TODOS
        </a>

        {{-- LISTA DE CATEGORIAS --}}
        @foreach(\App\Models\Categoria::all() as $cat)
            <a href="{{ route('productos.catalogo', ['categoria' => $cat->nombre]) }}"
               class="list-group-item list-group-item-action {{ $categoria == $cat->nombre ? 'active' : '' }}">
                {{ strtoupper($cat->nombre) }}
            </a>
        @endforeach
    </div>
</div>

        {{-- Productos --}}
        <div class="col-lg-9">
            <div class="row g-4" id="products-grid">
                @forelse($productos as $producto)
                        <div class="col-md-6 col-lg-4 product-item">
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
                                        style="width:15px; height:15px; margin-left:5px;">
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                   @empty
            <div class="col-12 text-center">
                <p>No hay productos en esta categoría</p>
            </div>
        @endforelse
            </div>
        </div>
    </div>
</div>

@include('footer')

<!-- Scripts -->
<script src="https://kit.fontawesome.com/515cfa72de.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>



</body>
</html>