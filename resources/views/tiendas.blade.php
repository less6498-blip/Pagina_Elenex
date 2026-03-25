@extends('layouts.app')

@section('title', 'Nuestras Tiendas')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/tiendas.css') }}">
@endpush

@section('content')
<div class="tiendas-page">
    <h1 class="tiendas-title" style="padding-top: 90px">NUESTRAS TIENDAS 🛒</h1>

    <div class="carousel">
        <div class="carousel-track">

            <!-- 🔹 SLIDE 1 (6 tiendas) -->
            <div class="carousel-slide">
                <div class="tienda-card">
                    <h2>C.C CAMINOS DEL INCA</h2>
                    <p>📍 Jr. Monterrey 170, Local N°59, 1er piso</p>
                    <p>Surco - Lima, Perú</p>
                    <div class="tienda-buttons">
                        <a href="https://maps.app.goo.gl/sR5MxytA9S8jexMfA" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                            Ver en maps <i class="fas fa-arrow-up-right-from-square" style="margin-right:5px;"></i></a>
                    </div>
                </div>
                <div class="tienda-card">
                    <h2>GAMARRA</h2>
                    <p>📍 Jr. Mariscal Agustin Gamarra 940, 3er piso</p>
                    <p>La Victoria - Lima, Perú</p>
                    <div class="tienda-buttons">
                        <a href="https://maps.app.goo.gl/5jXGNLe7tDX4GJm4A" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                            Ver en maps <i class="fas fa-arrow-up-right-from-square" style="margin-right:5px;"></i></a>
                    </div>
                </div>
                <div class="tienda-card">
                    <h2>METRO CANADA</h2>
                    <p>📍 Av. Canada 1110, Local N° 1039</p>
                    <p>La Victoria - Lima, Perú</p>
                    <div class="tienda-buttons">
                        <a href="https://maps.app.goo.gl/M34CUixcN5uS1R3h7" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                            Ver en maps <i class="fas fa-arrow-up-right-from-square" style="margin-right:5px;"></i></a>
                    </div>
                </div>
                <div class="tienda-card">
                    <h2>GALERIA AZUL</h2>
                    <p>📍 Stand N° 608, sexto piso Galeria Gamarra</p>
                    <p>La Victoria - Lima, Perú</p>
                    <div class="tienda-buttons">
                        <a href="https://maps.app.goo.gl/tHnU3zf7mYMAxBn87" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                            Ver en maps <i class="fas fa-arrow-up-right-from-square" style="margin-right:5px;"></i></a>
                    </div>
                </div>
                <div class="tienda-card">
                    <h2>REAL PLAZA VILLA MARIA DEL TRIUNFO</h2>
                    <p>📍 Av. Pachacutec N° 3721-3781, Lc 310</p>
                    <p>Villa Maria del Triunfo - Lima, Perú</p>
                    <div class="tienda-buttons">
                        <a href="https://maps.app.goo.gl/1CCRDr7t3U43DZiW9" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                            Ver en maps <i class="fas fa-arrow-up-right-from-square" style="margin-right:5px;"></i></a>
                    </div>
                </div>
                <div class="tienda-card">
                    <h2>METRO SAN JUAN DE LURIGANCHO</h2>
                    <p>📍 Av. Próceres de la Independencia N° 1632</p>
                    <p>San Juan de Lurigancho - Lima, Perú</p>
                    <div class="tienda-buttons">
                        <a href="https://maps.app.goo.gl/DLwssFd1LThKiBU26" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                            Ver en maps <i class="fas fa-arrow-up-right-from-square" style="margin-right:5px;"></i></a>
                    </div>
                </div>
            </div>

            <!-- 🔹 SLIDE 2 (6 tiendas) -->
            <div class="carousel-slide">
                <div class="tienda-card">
                    <h2>MALL AVENTURA SANTA ANITA</h2>
                    <p>📍 Jr. Minería 122, piso 2, Num B-2004</p>
                    <p>Ate - Lima, Perú</p>
                    <div class="tienda-buttons">
                        <a href="https://maps.app.goo.gl/pkiGHJwiPitkzH516" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                        Ver en maps <i class="fas fa-arrow-up-right-from-square" style="margin-right:5px;"></i></a></div>
                </div>
                <div class="tienda-card">
                    <h2>MALL PLAZA BELLAVISTA</h2>
                    <p>📍 Av. Oscar R. Benavides 3866, Local A-2037/A-2041</p>
                    <p>Callao - Lima, Perú</p>
                    <div class="tienda-buttons">
                        <a href="https://maps.app.goo.gl/AeZumeicjjUyDmxq9" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                        Ver en maps <i class="fas fa-arrow-up-right-from-square" style="margin-right:5px;"></i></a></div>
                </div>
                <div class="tienda-card">
                    <h2>MALL PLAZA COMAS</h2>
                    <p>📍 Av. Los Ángeles 602, Urb. Alamedas del Retablo, N° B-3048</p>
                    <p>Comas - Lima, Perú</p>
                    <div class="tienda-buttons">
                        <a href="https://maps.app.goo.gl/mgQ1qgxFed6mSnLCA" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                        Ver en maps <i class="fas fa-arrow-up-right-from-square" style="margin-right:5px;"></i></a></div>
                </div>
                <div class="tienda-card">
                    <h2>SANTIAGO CRESPO</h2>
                    <p>📍 Calle Santiago Crespo 581</p>
                    <p>San Luis - Lima, Perú</p>
                    <div class="tienda-buttons">
                        <a href="https://maps.app.goo.gl/MpgLHADj1nZwpszo8" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                        Ver en maps <i class="fas fa-arrow-up-right-from-square" style="margin-right:5px;"></i></a></div>
                </div>
                <div class="tienda-card">
                    <h2>PLAZA AREQUIPA</h2>
                    <p>📍 Calle Portal de San Agustín 131</p>
                    <p>Arequipa - Perú</p>
                    <div class="tienda-buttons">
                        <a href="https://maps.app.goo.gl/nnFhemuLTnJtda857" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                        Ver en maps <i class="fas fa-arrow-up-right-from-square" style="margin-right:5px;"></i></a></div>
                </div>
                <div class="tienda-card">
                    <h2>CERRO COLORADO AREQUIPA</h2>
                    <p>📍 Av. Aviación 602, Centro Comercial Center, Local N° 1128</p>
                    <p>Arequipa - Perú</p>
                    <div class="tienda-buttons">
                        <a href="https://maps.app.goo.gl/VJDYDtMMNQbqN9LJA" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                        Ver en maps <i class="fas fa-arrow-up-right-from-square" style="margin-right:5px;"></i></a></div>
                </div>
            </div>

            <!-- 🔹 SLIDE 3 (3 tiendas) -->
            <div class="carousel-slide">
                <div class="tienda-card">
                    <h2>AGUAS VERDES</h2>
                    <p>📍 Av. República del Perú 202, Esquina con Jr. Ica</p>
                    <p>Tumbes - Perú</p>
                    <div class="tienda-buttons">
                        <a href="https://maps.app.goo.gl/9rMGHQ8tGSN2RFUY6" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                        Ver en maps <i class="fas fa-arrow-up-right-from-square" style="margin-right:5px;"></i></a></div>
                </div>
                <div class="tienda-card">
                    <h2>AGUAS VERDES OUTLET</h2>
                    <p>📍 Av. República del Perú N° 208, Mz. Ñ1, Lote 35</p>
                    <p>Tumbes - Perú</p>
                    <div class="tienda-buttons">
                        <a href="https://maps.app.goo.gl/T4XiSJFjJw6qcFD68" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                        Ver en maps <i class="fas fa-arrow-up-right-from-square" style="margin-right:5px;"></i></a></div>
                </div>
                <div class="tienda-card">
                    <h2>IQUITOS</h2>
                    <p>📍 Jr. Próspero 938</p>
                    <p>Loreto - Perú</p>
                    <div class="tienda-buttons">
                        <a href="https://maps.app.goo.gl/24eKaqyrGkNjk6dk7" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                            Ver en maps <i class="fas fa-arrow-up-right-from-square" style="margin-right:5px;"></i></a>
                    </div>
                </div>
            </div>

        </div>

        <!-- FLECHAS -->
        <button class="prev">❮</button>
        <button class="next">❯</button>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/tiendas.js') }}"></script>
@endpush