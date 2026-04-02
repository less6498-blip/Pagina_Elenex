@extends('layouts.app')

@section('title', 'New Arrivals')

@section('content')

<div class="container" style="padding-top: 180px;">
    
    {{-- Título --}}
    <div class="text-center mb-5">
        <h1 class="fw-bold">New Arrivals 🎇</h1>
        <p class="text-muted">Descubre nuestros productos más recientes</p>
    </div>

    <div class="row g-4">
        @forelse($productos as $producto)
            <div class="col-md-6 col-lg-3 product-item">
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

                        <button class="btn btn-dark btn-custom w-100 mb-2 d-flex justify-content-center align-items-center" disabled>
                            <span>Añadir al carrito</span>
                            <img src="https://img.icons8.com/?size=100&id=3686&format=png&color=ffffff" 
                                style="width:15px; height:15px; margin-left:5px;">
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p>No hay productos en New Arrivals</p>
            </div>
        @endforelse
    </div>
</div>

@endsection