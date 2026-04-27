@extends('admin.layout')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Stats --}}
<div class="row g-4 mb-4">
  <div class="col-md-3">
    <div class="stat-card">
      <div style="font-size:13px;color:#888;">Total Productos</div>
      <div style="font-size:32px;font-weight:700;">{{ $stats['total_productos'] }}</div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="stat-card">
      <div style="font-size:13px;color:#888;">Productos Activos</div>
      <div style="font-size:32px;font-weight:700;color:#28a745;">{{ $stats['productos_activos'] }}</div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="stat-card">
      <div style="font-size:13px;color:#888;">Total Variantes</div>
      <div style="font-size:32px;font-weight:700;">{{ $stats['total_variantes'] }}</div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="stat-card">
      <div style="font-size:13px;color:#888;">Variantes Sin Stock</div>
      <a href="{{ route('admin.productos.index', ['stock' => 'sin_stock']) }}"
         style="text-decoration:none;">
        <div style="font-size:32px;font-weight:700;color:#dc3545;">
          {{ $stats['sin_stock'] }}
        </div>
        <div style="font-size:11px;color:#dc3545;margin-top:2px;">Ver variantes sin stock →</div>
      </a>
    </div>
  </div>
</div>

{{-- Tabla últimos productos --}}
<div class="table-card">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h6 class="fw-bold mb-0">Últimos productos agregados</h6>
    <a href="{{ route('admin.productos.crear') }}" class="btn btn-dark btn-sm">+ Agregar producto</a>
  </div>
  <table class="table table-hover">
    <thead style="font-size:13px;color:#888;">
      <tr>
        <th>Producto</th>
        <th>Categoría</th>
        <th>Precio</th>
        <th>Estado</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach($ultimos as $p)
      <tr>
        <td style="font-size:14px;font-weight:600;">{{ $p->nombre }}</td>
        <td style="font-size:13px;color:#888;">{{ $p->categoria->nombre ?? '-' }}</td>
        <td style="font-size:14px;">S/ {{ number_format($p->precio, 2) }}</td>
        <td>
          <span class="{{ $p->activo ? 'badge-activo' : 'badge-inactivo' }}">
            {{ $p->activo ? 'Activo' : 'Inactivo' }}
          </span>
        </td>
        <td>
          <a href="{{ route('admin.productos.editar', $p->id) }}"
             class="btn btn-outline-dark btn-sm">Editar</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

@endsection