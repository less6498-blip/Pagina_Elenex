@extends('admin.layout')
@section('title', 'Productos')
@section('page-title', 'Productos')

@php
$colorMap = [
    'blanco'       => '#ffffff',
    'negro'        => '#1a1a1a',
    'acero'        => '#5d85a7',
    'oliva'        => '#356439',
    'expresso'     => '#aa8163',
    'verde-claro'  => '#c8e4c9',
    'beige'        => '#e2c9a9',
    'verde-oscuro' => '#1d3623',
    'lila'         => '#8c64ad',
    'gris'         => '#888888',
    'azul'         => '#1d4ed8',
    'rojo'         => '#dc2626',
    'cafe'         => '#92400e',
];
@endphp

@section('content')
<div class="table-card">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h6 class="fw-bold mb-0">Todos los productos ({{ $productos->total() }})</h6>
    <a href="{{ route('admin.productos.crear') }}" class="btn btn-dark btn-sm">+ Agregar producto</a>
  </div>

 {{-- Filtros --}}
<form method="GET" class="row g-2 mb-4">
    <div class="col-md-4">
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
        <select name="stock" class="form-select form-select-sm">
            <option value="">Todo el stock</option>
            <option value="sin_stock" {{ request('stock') == 'sin_stock' ? 'selected' : '' }}>Sin stock</option>
            <option value="bajo_stock" {{ request('stock') == 'bajo_stock' ? 'selected' : '' }}>Stock bajo (≤5)</option>
            <option value="con_stock" {{ request('stock') == 'con_stock' ? 'selected' : '' }}>Con stock</option>
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-dark btn-sm w-100">Filtrar</button>
    </div>
    <div class="col-md-1">
        <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary btn-sm w-100">✕</a>
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
    {{-- Fila principal --}}
    <tr style="cursor:pointer;" onclick="toggleVariantes({{ $producto->id }})">
        <td>
            @if($imagenPrincipal)
                <img src="{{ asset('img/' . $imagenPrincipal->ruta) }}" class="img-thumb">
            @else
                <div class="img-thumb bg-light d-flex align-items-center justify-content-center">
                    <i class="fas fa-image text-muted"></i>
                </div>
            @endif
        </td>
        <td class="fw-semibold">
            {{ $producto->nombre }}
            <i class="fas fa-chevron-down ms-1" id="icon-{{ $producto->id }}"
               style="font-size:11px;color:#aaa;transition:.2s;"></i>
        </td>
        <td style="color:#888;">{{ $producto->categoria->nombre ?? '-' }}</td>
        <td>S/ {{ number_format($producto->precio, 2) }}</td>
        <td>{{ $producto->variantes->count() }}</td>
        <td>
            @if($stockTotal == 0)
                <span class="badge-inactivo">Sin stock</span>
            @elseif($stockTotal <= 5)
                <span style="background:#fff3cd;color:#856404;padding:4px 10px;border-radius:20px;font-size:12px;">
                    {{ $stockTotal }} (bajo)
                </span>
            @else
                <span class="badge-activo">{{ $stockTotal }}</span>
            @endif
        </td>
        <td>
            <span class="{{ $producto->activo ? 'badge-activo' : 'badge-inactivo' }}">
                {{ $producto->activo ? 'Activo' : 'Inactivo' }}
            </span>
        </td>
        <td onclick="event.stopPropagation()">
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

    {{-- Fila expandible con variantes --}}
    <tr id="variantes-{{ $producto->id }}" style="display:none;background:#f8f9fa;">
        <td colspan="8" style="padding:0;">
            <div style="padding:12px 20px;">
                <table class="table table-sm mb-0" style="font-size:13px;">
                    <thead>
                        <tr style="color:#888;">
                            <th>Color</th>
                            <th>Talla</th>
                            <th>Stock</th>
                            <th>SKU</th>
                            <th>Estado stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($producto->variantes as $variante)
                        <tr>
                            <td>
                                <span style="display:inline-flex;align-items:center;gap:6px;">
                                    <span style="width:14px;height:14px;border-radius:50%;
                                                 background:{{ $colorMap[strtolower($variante->color)] ?? '#999' }};
                                                 border:1px solid #ddd;display:inline-block;"></span>
                                    {{ ucfirst($variante->color) }}
                                </span>
                            </td>
                            <td><strong>{{ $variante->talla }}</strong></td>
                            <td>{{ $variante->stock }}</td>
                            <td style="color:#aaa;font-family:monospace;">{{ $variante->sku ?? '-' }}</td>
                            <td>
                                @if($variante->stock == 0)
                                    <span class="badge-inactivo">Sin stock</span>
                                @elseif($variante->stock <= 5)
                                    <span style="background:#fff3cd;color:#856404;padding:3px 8px;border-radius:20px;font-size:11px;">
                                        Stock bajo
                                    </span>
                                @else
                                    <span class="badge-activo">OK</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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

<script>
function toggleVariantes(id) {
    const fila    = document.getElementById('variantes-' + id);
    const icon    = document.getElementById('icon-' + id);
    const visible = fila.style.display !== 'none';
    fila.style.display = visible ? 'none' : 'table-row';
    icon.style.transform = visible ? 'rotate(0deg)' : 'rotate(180deg)';
}
</script>


@endsection