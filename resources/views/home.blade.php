@extends('layouts.app')

@section('title', 'Elenex')

@section('content')

<!-- Carrusel de Portada -->
<div id="carruselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
    
    <!-- Indicadores estilo Yape -->
    <div class="yape-indicators" id="carruselIndicators">
        <div class="yape-dot" data-bs-target="#carruselExample" data-index="0"><div class="yape-dot-fill"></div></div>
        <div class="yape-dot" data-bs-target="#carruselExample" data-index="1"><div class="yape-dot-fill"></div></div>
        <div class="yape-dot" data-bs-target="#carruselExample" data-index="2"><div class="yape-dot-fill"></div></div>
    </div>

    <div class="carousel-inner">
        <div class="carousel-item active"><img src="{{ asset('img/logo1.webp') }}" class="d-block w-100"></div>
        <div class="carousel-item"><img src="{{ asset('img/logo2.webp') }}" class="d-block w-100"></div>
        <div class="carousel-item"><img src="{{ asset('img/logo3.webp') }}" class="d-block w-100"></div>
    </div>
</div>

<!-- Controles carrusel de portada -->
<button id="prevBtn" class="custom-arrow">&#10094;</button>
<button id="nextBtn" class="custom-arrow">&#10095;</button>

<!-- Título New Arrivals -->
<div class="titulo1 reveal">
    <span>NEW ARRIVALS 🎇</span>
</div>

<!-- Carrusel de Productos New Arrivals -->
<div id="productCarousel" class="carousel slide reveal">
    <div class="carousel-inner">
        @php
            $chunksNew = $newArrivals->chunk(4); 
        @endphp
        @foreach($chunksNew as $chunkIndex => $chunk)
            <div class="carousel-item @if($chunkIndex == 0) active @endif">
                <div class="row justify-content-center g-1">
                    @foreach($chunk as $producto)
                        <div class="col-6 col-md-3 text-center">
                            <a href="{{ route('productos.show', $producto->id) }}" class="product-card">
                                <div class="product-img-wrapper">
                                @php
                                    $imagenPrincipal = $producto->variantes->first()->imagenes->first();
                                    $imagenHover = $producto->variantes->first()->imagenes->skip(1)->first();
                                @endphp

                                @if($imagenPrincipal)
                                    <img src="{{ asset('img/' . $imagenPrincipal->ruta) }}" class="product-img" alt="{{ $producto->nombre }}">
                                @endif

                                @if($imagenHover)
                                    <img src="{{ asset('img/' . $imagenHover->ruta) }}" class="product-img img-hover" alt="{{ $producto->nombre }} hover">
                                @endif
                                </div>
                                <p class="product-desc">{{ strtoupper($producto->nombre) }}</p>
                                <p class="product-price">S/{{ number_format($producto->precio,2) }}</p>
                            </a>
                        </div>
                    @endforeach

                    {{-- Ver más al final del último chunk --}}
                   @if($chunkIndex == count($chunksNew) - 1)
                    <div class="col-6 col-md-3 text-center product-card ver-mas">
                        <div class="ver-mas-title">NEW ARRIVALS</div>
                        <a href="{{ route('productos.newArrivals') }}" class="ver-mas-link">Ver más</a>
                    </div>
                @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Controles del carrusel -->
    <button id="prevProduct" class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button id="nextProduct" class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- Título Casacas -->
<div class="titulo2 reveal">
    <span> CASACAS</span>
</div>

<!-- Carrusel de Productos Casacas -->
<div id="productCarousel2" class="carousel slide reveal">
    <div class="carousel-inner">
        @php
            $chunksCasacas = $casacas->chunk(4);
        @endphp
        @foreach($chunksCasacas as $chunkIndex => $chunk)
            <div class="carousel-item @if($chunkIndex == 0) active @endif">
                <div class="row justify-content-center g-1">
                    @foreach($chunk as $producto)
                        <div class="col-6 col-md-3 text-center">
                            <a href="{{ route('productos.show', $producto->id) }}" class="product-card">
                                <div class="product-img-wrapper">
                                     @php
                                        $imagenPrincipal = $producto->variantes->first()->imagenes->first();
                                        $imagenHover = $producto->variantes->first()->imagenes->skip(1)->first();
                                     @endphp

                                     @if($imagenPrincipal)
                                        <img src="{{ asset('img/' . $imagenPrincipal->ruta) }}" class="product-img" alt="{{ $producto->nombre }}">
                                     @endif

                                     @if($imagenHover)
                                        <img src="{{ asset('img/' . $imagenHover->ruta) }}" class="product-img img-hover" alt="{{ $producto->nombre }} hover">
                                     @endif
                                </div>
                                <p class="product-desc">{{ strtoupper($producto->nombre) }}</p>
                                <p class="product-price">S/{{ number_format($producto->precio,2) }}</p>
                            </a>
                        </div>
                    @endforeach
                    @if($chunkIndex == count($chunksCasacas) - 1)
                        <div class="col-6 col-md-3 text-center product-card ver-mas">
                            <div class="ver-mas-title">CASACAS</div>
                            <a href="{{ route('productos.catalogo', strtolower('Casacas')) }}" class="ver-mas-link">Ver más</a>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Controles del carrusel -->
    <button id="prevProduct2" class="carousel-control-prev" type="button" data-bs-target="#productCarousel2" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button id="nextProduct2" class="carousel-control-next" type="button" data-bs-target="#productCarousel2" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- Banner -->
<div class="banner reveal" style="margin-top: 40px;">
    <img src="{{ asset('img/baner.webp') }}" class="d-block w-100">
</div>

<!-- Verano / Promoción -->
<div class="verano reveal" style="margin-top: 60px; text-align: center; gap: 20px; display: flex; padding-left: 180px;">
    <img src="{{ asset('img/bividi3.webp') }}" style="width: 600px; height: auto;">
    <div style="display: flex; flex-direction: column; justify-content: flex-start;">
        <h2 style="margin: 180px 0 0 0; padding-left: 200px">¡Nuevos Bividis de Moda!</h2>
        <p style="margin: 60px 0 0 0; font-size: 20px; padding-left: 200px; color: gray;">
            ¡Prepara tu armario para el calor! El Nuevo Bividi de Hombre Elenex 
            <br><br> es la clave para un estilo casual coordinado y sin esfuerzo...
        </p>
        <a href="{{ route('productos.catalogo', strtolower('Bividis')) }}" class="btn-ver">Ver más</a>
    </div>
</div>

<!-- Carrusel de Categorías -->
<div id="productCarousel3" class="carousel slide reveal">
    <div class="carousel-inner">
        @php
            $categorias = \App\Models\Categoria::all();
            $chunks = $categorias->chunk(3); // 3 categorías por slide
        @endphp

        @foreach($chunks as $chunkIndex => $chunk)
            <div class="carousel-item @if($chunkIndex == 0) active @endif">
                <div class="row justify-content-center g-3">
                    @foreach($chunk as $categoria)
                        <div class="col-6 col-md-4 text-center">
                            <a href="{{ route('productos.catalogo', ['categoria' => $categoria->nombre]) }}" class="category-card-link">
                                <div class="category-card">
                                    <img src="{{ asset('img/'.$categoria->slug.'.webp') }}" class="category-img" alt="{{ $categoria->nombre }}">
                                    <div class="category-overlay"><span>{{ strtoupper($categoria->nombre) }}</span></div>
                                </div>
                                <div class="category-ver-mas">Ver más →</div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <!-- Controles del carrusel -->
    <button id="prevProduct3" class="carousel-control-prev" type="button" data-bs-target="#productCarousel3" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button id="nextProduct3" class="carousel-control-next" type="button" data-bs-target="#productCarousel3" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- Carrusel móvil de categorías (scroll horizontal) -->
<div class="categorias-scroll-movil">
    @foreach(\App\Models\Categoria::all() as $categoria)
        <a href="{{ route('productos.catalogo', ['categoria' => $categoria->nombre]) }}" class="categoria-scroll-item">
            <div class="category-card">
                <img src="{{ asset('img/'.$categoria->slug.'.webp') }}" class="category-img" alt="{{ $categoria->nombre }}">
                <div class="category-overlay"><span>{{ strtoupper($categoria->nombre) }}</span></div>
            </div>
            <div class="category-ver-mas">Ver más →</div>
        </a>
    @endforeach
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/product-carousel.js') }}"></script>
<script src="{{ asset('js/scroll-effects.js') }}"></script>
@endpush