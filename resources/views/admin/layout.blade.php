<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin') | Elenex</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body { background: #f5f5f5; }
    .sidebar { width: 240px; min-height: 100vh; background: #111; position: fixed; top: 0; left: 0; z-index: 100; }
    .sidebar .brand { padding: 20px; border-bottom: 1px solid #333; }
    .sidebar .brand img { height: 35px; }
    .sidebar .nav-link { color: #aaa; padding: 12px 20px; display: flex; align-items: center; gap: 10px; font-size: 14px; }
    .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #fff; background: #222; }
    .sidebar .nav-link i { width: 18px; }
    .main-content { margin-left: 240px; padding: 30px; }
    .topbar { background: #fff; padding: 15px 30px; margin: -30px -30px 30px; border-bottom: 1px solid #e5e5e5; display: flex; justify-content: space-between; align-items: center; }
    .stat-card { background: #fff; border-radius: 12px; padding: 20px; border: none; box-shadow: 0 1px 4px rgba(0,0,0,.08); }
    .table-card { background: #fff; border-radius: 12px; padding: 24px; box-shadow: 0 1px 4px rgba(0,0,0,.08); }
    .badge-activo { background: #d4edda; color: #155724; padding: 4px 10px; border-radius: 20px; font-size: 12px; }
    .badge-inactivo { background: #f8d7da; color: #721c24; padding: 4px 10px; border-radius: 20px; font-size: 12px; }
    .img-thumb { width: 50px; height: 50px; object-fit: cover; border-radius: 8px; }
    .variante-card { background: #f8f9fa; border-radius: 10px; padding: 15px; margin-bottom: 10px; border: 1px solid #e9ecef; }
    .color-preview { width: 24px; height: 24px; border-radius: 50%; border: 2px solid #ddd; display: inline-block; vertical-align: middle; }
  </style>
</head>
<body>

<div class="sidebar">
  <div class="brand">
    <img src="{{ asset('img/elelogo.webp') }}" alt="Elenex">
    <div style="color:#666;font-size:11px;margin-top:5px;">Panel Administrador</div>
  </div>
  <nav class="mt-3">
    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <i class="fas fa-chart-bar"></i> Dashboard
    </a>
    <a href="{{ route('admin.productos.index') }}" class="nav-link {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}">
      <i class="fas fa-box"></i> Productos
    </a>
    <a href="{{ route('admin.productos.crear') }}" class="nav-link">
      <i class="fas fa-plus-circle"></i> Agregar Producto
    </a>
    <hr style="border-color:#333;margin:10px 20px;">
    <a href="{{ route('productos.catalogo') }}" class="nav-link" target="_blank">
      <i class="fas fa-external-link-alt"></i> Ver Tienda
    </a>
    <a href="{{ route('admin.pedidos.index') }}" 
   class="nav-link {{ request()->routeIs('admin.pedidos.*') ? 'active' : '' }}">
      <i class="fas fa-shopping-bag"></i> Pedidos
    </a>
  </nav>
</div>

<div class="main-content">
  <div class="topbar">
    <h5 class="mb-0 fw-bold">@yield('page-title', 'Dashboard')</h5>
      <div class="d-flex align-items-center gap-3">
        <span style="font-size:13px;color:#666;">
        {{ Auth::guard('admin')->user()->nombre }}
        </span>
      <form action="{{ route('admin.logout') }}" method="POST">
          @csrf
      <button type="submit" class="btn btn-outline-secondary btn-sm"
            style="font-size:12px;">
          Cerrar sesión
        </button>
      </form>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>