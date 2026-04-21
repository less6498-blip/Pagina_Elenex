<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'Elenex')</title>

  <!-- ICONO -->
  <link rel="icon" type="image/png" href="{{ asset('img/ela.png') }}?v=2">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@400;600&display=swap" rel="stylesheet">

  <!-- Bootstrap PRIMERO -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


  <!-- Tus estilos -->
  <link rel="stylesheet" href="{{ asset('css/header.css') }}">
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
  <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
  <link rel="stylesheet" href="{{ asset('css/detalle.css') }}">
  <link rel="stylesheet" href="{{ asset('css/cart.css') }}">

  @stack('styles')
</head>
<body>
<div id="page-wrapper">

  @include('header')

  <main>
    @yield('content')
  </main>

  @include('footer')

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/carousel.js') }}"></script>
  <script src="{{ asset('js/cart.js') }}"></script>
  <script src="https://kit.fontawesome.com/515cfa72de.js" crossorigin="anonymous"></script>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const wrapper = document.getElementById("page-wrapper");
      if (wrapper) wrapper.classList.add("loaded");
    });
  </script>

  @stack('scripts')
</body>
</html>