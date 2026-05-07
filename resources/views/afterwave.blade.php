@extends('layouts.app')

@section('title', 'AFTER WAVE | Elenex')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/afterwave.css') }}">


@section('content')

<div class="container">
    
    {{-- Título --}}
    <div class="text-center mb-5">
        <h1 class="arrivals-title">"AFTER WAVE"</h1>
        <p class="text-muted" style="text-align: center;font-weight: 500px;">Descubre la nueva colección de esta temporada</p>
    </div>

    <div class="row g-4">
        @forelse($productos as $producto)
            <div class="col-md-6 col-lg-3 product-item">
                <div class="card product-card">
                    {{-- Imagen principal y hover --}}
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

                    {{-- Información --}}
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $producto->nombre }}</h5>
                        <p class="price">S/ {{ number_format($producto->precio, 2) }}</p>

                        <a href="{{ route('productos.show', $producto->slug) }}" class="btn btn-primary btn-custom mb-2">
                            Ver detalle
                        </a>

                        <button class="btn btn-dark btn-custom w-100 mb-2 d-flex justify-content-center align-items-center" 
                        onclick="addToCart({
                            id:      '{{ $producto->id }}',
                            name:    '{{ addslashes($producto->nombre) }}',
                            price:    {{ $producto->precio }},
                            image:   '{{ $imagenPrincipal ? asset("img/" . $imagenPrincipal->ruta) : "" }}',
                            quantity: 1
                        })"
                            aria-label="Añadir {{ $producto->nombre }} al carrito"
                            >
                            <span>Añadir al carrito</span>
                            <img src="https://img.icons8.com/?size=100&id=3686&format=png&color=ffffff" 
                                style="width:15px; height:15px; margin-left:5px;">
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p>No hay productos en Woman</p>
            </div>
        @endforelse
    </div>
</div>

@endsection