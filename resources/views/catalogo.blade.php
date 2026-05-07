<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Catálogo | Elenex</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tus estilos -->
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/catalogo.css') }}">

    <!-- Icono -->
    <link rel="icon" type="image/png" href="{{ asset('img/ela.png') }}?v=2">
</head>
<body>

{{-- HEADER --}}
@include('header')

<div class="container catalog-container">

    <div class="catalog-header">
        <h1>Catálogo de Productos 🛍️</h1>

        @if(!empty($queryBusqueda))
            <p class="search-result">
                Resultados para "{{ $queryBusqueda }}"
            </p>
        @endif
    </div>

    <div class="row">
        
        {{-- SIDEBAR --}}
        <div class="col-lg-3">
            <div class="categories-wrapper">

                <div class="categories-desktop">
                    <div class="list-group">
                        <a href="{{ route('productos.catalogo') }}"
                           class="list-group-item {{ !$categoria ? 'active' : '' }}">
                            TODOS
                        </a>

                        @foreach(\App\Models\Categoria::all() as $cat)
                            <a href="{{ route('productos.catalogo', ['categoria' => $cat->nombre]) }}"
                               class="list-group-item {{ $categoria == $cat->nombre ? 'active' : '' }}">
                                {{ strtoupper($cat->nombre) }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- MOBILE: scroll horizontal --}}
                <div class="categories-mobile">
                    <div class="scroll-categories">
                        <a href="{{ route('productos.catalogo') }}"
                           class="cat-pill {{ !$categoria ? 'active' : '' }}">
                            TODOS
                        </a>

                        @foreach(\App\Models\Categoria::all() as $cat)
                            <a href="{{ route('productos.catalogo', ['categoria' => $cat->nombre]) }}"
                               class="cat-pill {{ $categoria == $cat->nombre ? 'active' : '' }}">
                                {{ strtoupper($cat->nombre) }}
                            </a>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        {{-- PRODUCTOS --}}
        <div class="col-lg-9">
            <div class="row g-4">

                @forelse($productos as $producto)
                    <div class="col-6 col-md-6 col-lg-4">
                        <div class="card product-card h-100">

                            <div class="product-img-wrapper">
                                @php
                                    $imagenPrincipal = $producto->variantes->first()->imagenes->first();
                                    $imagenHover = $producto->variantes->first()->imagenes->skip(1)->first();
                                @endphp

                                @if($imagenPrincipal)
                                    <img src="{{ str_starts_with($imagenPrincipal->ruta, 'http') ? $imagenPrincipal->ruta : asset('img/' . $imagenPrincipal->ruta) }}" class="product-img">
                                @endif

                                @if($imagenHover)
                                    <img src="{{ asset('img/' . $imagenHover->ruta) }}" class="product-img img-hover">
                                @endif
                            </div>

                            <div class="card-body d-flex flex-column justify-content-between">
    
    <div>
        <h5 class="card-title">{{ $producto->nombre }}</h5>
        <p class="price">S/ {{ number_format($producto->precio, 2) }}</p>
    </div>

    <div>
        <a href="{{ route('productos.show', $producto->slug) }}"
           class="btn btn-primary mb-2 w-100">
            Ver detalle
        </a>

        <button
    class="btn btn-dark w-100 d-flex align-items-center justify-content-center gap-2"
    onclick="addToCart({
        id:      '{{ $producto->id }}',
        name:    '{{ addslashes($producto->nombre) }}',
        price:    {{ $producto->precio }},
        image:   '{{ $imagenPrincipal ? asset("img/" . $imagenPrincipal->ruta) : "" }}',
        quantity: 1
    })"
    aria-label="Añadir {{ $producto->nombre }} al carrito"
>
    <span class="cart-btn-text">Añadir al carrito</span>
    <img src="https://img.icons8.com/?size=100&id=3686&format=png&color=000000" class="cart-icon" alt="" aria-hidden="true">
</button>
    </div>
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

<link rel="stylesheet" href="{{ asset('css/cart.css') }}">
<script src="{{ asset('js/cart.js') }}"></script>

</body>
</html>