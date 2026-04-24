@extends('admin.layout')
@section('title', 'Productos')
@section('page-title', 'Productos')

@section('content')
<div class="table-card">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h6 class="fw-bold mb-0">Todos los productos ({{ $productos->total() }})</h6>
    <a href="{{ route('admin.productos.crear') }}" class="btn btn-dark btn-sm">+ Agregar producto</a>
  </div>

  {{-- Filtros --}}
  <form method="GET" class="row g-2 mb-4">
    <div class="col-md-5">
      <input type="text" name="buscar" value="{{ request('buscar') }}"
             placeholder="Buscar por nombre..." class="form-control form-control-sm">
    </div>
    <div class="col-md-3">
      <select name="categoria" class="form-select form-select-sm">
        <option value="">Todas las categorías</option>
        @foreach($categorias as $cat)
          <option value="{{ $cat->id }}" {{ request('categoria') == $cat->id ? 'selected' : '' }}>
            {{ $cat->nombre }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn btn-dark btn-sm w-100">Filtrar</button>
    </div>
    <div class="col-md-2">
      <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary btn-sm w-100">Limpiar</a>
    </div>
  </form>

  <div class="table-responsive">
    <table class="table table-hover align-middle" style="font-size:14px;">
      <thead style="color:#888;font-size:12px;text-transform:uppercase;">
        <tr>
          <th>Imagen</th>
          <th>Nombre</th>
          <th>Categoría</th>
          <th>Precio</th>
          <th>Variantes</th>
          <th>Stock Total</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($productos as $producto)
        @php
          $imagenPrincipal = $producto->variantes->first()?->imagenes->first();
          $stockTotal = $producto->variantes->sum('stock');
        @endphp
        <tr>
          <td>
            @if($imagenPrincipal)
              <img src="{{ asset('img/' . $imagenPrincipal->ruta) }}" class="img-thumb">
            @else
              <div class="img-thumb bg-secondary d-flex align-items-center justify-content-center">
                <i class="fas fa-image text-white" style="font-size:16px;"></i>
              </div>
            @endif
          </td>
          <td class="fw-semibold">{{ $producto->nombre }}</td>
          <td style="color:#888;">{{ $producto->categoria->nombre ?? '-' }}</td>
          <td>S/ {{ number_format($producto->precio, 2) }}</td>
          <td>{{ $producto->variantes->count() }}</td>
          <td>
            <span class="{{ $stockTotal > 0 ? 'badge-activo' : 'badge-inactivo' }}">
              {{ $stockTotal }}
            </span>
          </td>
          <td>
            <span class="{{ $producto->activo ? 'badge-activo' : 'badge-inactivo' }}">
              {{ $producto->activo ? 'Activo' : 'Inactivo' }}
            </span>
          </td>
          <td>
            <div class="d-flex gap-2">
              <a href="{{ route('admin.productos.editar', $producto->id) }}"
                 class="btn btn-outline-dark btn-sm">
                <i class="fas fa-edit"></i>
              </a>
              <a href="{{ route('productos.show', $producto->slug) }}"
                 class="btn btn-outline-secondary btn-sm" target="_blank">
                <i class="fas fa-eye"></i>
              </a>
              <form action="{{ route('admin.productos.eliminar', $producto->id) }}"
                    method="POST"
                    onsubmit="return confirm('¿Eliminar este producto?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8" class="text-center text-muted py-4">No hay productos</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $productos->withQueryString()->links() }}
</div>
@endsection