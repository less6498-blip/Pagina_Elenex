<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo - Elenex</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/catalogo.css') }}">

</head>
<body>

{{-- Incluir header --}}
@include('header')

<div class="container py-5">
    <h1 class="text-center mb-5" style="padding-top: 80px;">🛍️ Productos Destacados</h1>

    @php
        // Arreglos de productos con imagen principal y hover
        $polos = [
            ['main' => 'mojito1.png', 'hover' => 'mojito2.png', 'title' => 'Mojito Blanco'],
            ['main' => 'over1.png', 'hover' => 'over2.png', 'title' => 'Over Negro'],
            ['main' => 'oververde1.png', 'hover' => 'oververde2.png', 'title' => 'Over Verde'],
            ['main' => 'bividi1.png', 'hover' => 'bividi2.png', 'title' => 'Bividi Blanco'],
            ['main' => 'wait1.png', 'hover' => 'wait2.png', 'title' => 'Wait Azul'],
            ['main' => 'nomadic1.png', 'hover' => 'nomadic2.png', 'title' => 'Nomadic Blanco'],
        ];

        $casacas = [
            ['main' => 'wheeler.png', 'hover' => 'wheeler2.png', 'title' => 'Wheeler negro'],
            ['main' => 'trek.png',    'hover' =>  'trek2.png', 'title' => 'Trek verde'],
            ['main' => 'quik.png', 'hover' => 'quik2.png', 'title' => 'Quik Negro'],
            ['main' => 'carnero.png', 'hover' => 'quik2.png', 'title' => 'Carnero negro'],
            ['main' => 'counter.png', 'hover' => 'counter2.png', 'title' => 'Counter Verde'],
            ['main' => 'carn.png', 'hover' => 'carn2.png', 'title' => 'Carnero beige'],

        ];

        $pantalones = [
            ['main' => 'pantalon1.jpg', 'hover' => 'pantalon2.jpg', 'title' => 'Jean Azul'],
            ['main' => 'pantalon3.jpg', 'hover' => 'pantalon4.jpg', 'title' => 'Jean Negro'],
            ['main' => 'pantalon5.jpg', 'hover' => 'pantalon6.jpg', 'title' => 'Chino Beige'],
            ['main' => 'pantalon7.jpg', 'hover' => 'pantalon8.jpg', 'title' => 'Jogger Gris'],
            ['main' => 'pantalon9.jpg', 'hover' => 'pantalon10.jpg', 'title' => 'Cargo Verde'],
            ['main' => 'pantalon11.jpg', 'hover' => 'pantalon12.jpg', 'title' => 'Short Azul'],
        ];

        $accesorios = [
            ['main' => 'accesorio1.jpg', 'hover' => 'accesorio2.jpg', 'title' => 'Gorra'],
            ['main' => 'accesorio3.jpg', 'hover' => 'accesorio4.jpg', 'title' => 'Cinturón'],
            ['main' => 'accesorio5.jpg', 'hover' => 'accesorio6.jpg', 'title' => 'Pulsera'],
            ['main' => 'accesorio7.jpg', 'hover' => 'accesorio8.jpg', 'title' => 'Collar'],
            ['main' => 'accesorio9.jpg', 'hover' => 'accesorio10.jpg', 'title' => 'Mochila'],
            ['main' => 'accesorio11.jpg', 'hover' => 'accesorio12.jpg', 'title' => 'Gafas'],
        ];

        $calzado = [
            ['main' => 'zapato1.jpg', 'hover' => 'zapato2.jpg', 'title' => 'Zapatilla Roja'],
            ['main' => 'zapato3.jpg', 'hover' => 'zapato4.jpg', 'title' => 'Zapatilla Negra'],
            ['main' => 'zapato5.jpg', 'hover' => 'zapato6.jpg', 'title' => 'Tenis Blanco'],
            ['main' => 'zapato7.jpg', 'hover' => 'zapato8.jpg', 'title' => 'Botín Marrón'],
            ['main' => 'zapato9.jpg', 'hover' => 'zapato10.jpg', 'title' => 'Sandalia Negra'],
            ['main' => 'zapato11.jpg', 'hover' => 'zapato12.jpg', 'title' => 'Mocasin Azul'],
        ];
    @endphp

    {{-- Función para mostrar productos --}}
   @php
function renderProducts($products, $price) {
    $html = '<div class="row g-4">';
    foreach($products as $p) {
        $html .= '<div class="col-sm-6 col-md-4 col-lg-2">';
        $html .= '<div class="card h-100 product-card">';
        $html .= '<div class="product-img-wrapper">';
        $html .= '<img src="'.asset('img/'.$p['main']).'" class="img-main" alt="'.$p['title'].'">';
        $html .= '<img src="'.asset('img/'.$p['hover']).'" class="img-hover" alt="'.$p['title'].' Hover">';
        $html .= '</div>'; // cierre product-img-wrapper
        $html .= '<div class="card-body d-flex flex-column">';
        $html .= '<h5 class="card-title small">'.$p['title'].'</h5>';
        $html .= '<p class="card-text text-muted small">Descripción breve del producto.</p>';
        $html .= '<div class="mt-auto">';
        $html .= '<p class="price">'.$price.'</p>';
        $html .= '<a href="#" class="btn btn-primary w-100 btn-custom btn-sm">Ver detalle</a>';
        $html .= '<a href="#" class="btn btn-primary w-100 btn-dark btn-sm mt-2 d-flex justify-content-center align-items-center">';
        $html .= '<span>Añadir al carrito</span>';
        $html .= '<img src="https://img.icons8.com/?size=100&id=3686&format=png&color=ffffff" style="width:16px; height:16px; margin-left:5px;">';
        $html .= '</a>';
        $html .= '</div></div></div></div>';
    }
    $html .= '</div>';
    return $html;
}
@endphp

    {{-- Mostrar cada categoría --}}
    <h2 class="category-title text-capitalize mt-5">Polos</h2>
    {!! renderProducts($polos, 'S/ 79.90') !!}

    <h2 class="category-title text-capitalize mt-5">Casacas</h2>
    {!! renderProducts($casacas, 'S/ 99.90') !!}

    <h2 class="category-title text-capitalize mt-5">Pantalones</h2>
    {!! renderProducts($pantalones, 'S/ 99.90') !!}

    <h2 class="category-title text-capitalize mt-5">Accesorios</h2>
    {!! renderProducts($accesorios, 'S/ 49.90') !!}

    <h2 class="category-title text-capitalize mt-5">Calzado</h2>
    {!! renderProducts($calzado, 'S/ 129.90') !!}
    
</div>

{{-- Incluir footer --}}
@include('footer')

<script src="https://kit.fontawesome.com/515cfa72de.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>