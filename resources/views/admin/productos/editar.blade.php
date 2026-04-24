@extends('admin.layout')
@section('title', 'Editar Producto')
@section('page-title', 'Editar: {{ $producto->nombre }}')

@section('content')
<form action="{{ route('admin.productos.actualizar', $producto->id) }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')

<div class="row g-4">

  <div class="col-lg-8">

    {{-- Datos básicos --}}
    <div class="table-card mb-4">
      <h6 class="fw-bold mb-4">Información del producto</h6>
      <div class="row g-3">
        <div class="col-12">
          <label class="form-label fw-medium">Nombre *</label>
          <input type="text" name="nombre" value="{{ $producto->nombre }}" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-medium">Precio (S/) *</label>
          <input type="number" name="precio" step="0.01" value="{{ $producto->precio }}" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-medium">Categoría *</label>
          <select name="categoria_id" class="form-select" required>
            @foreach($categorias as $cat)
              <option value="{{ $cat->id }}" {{ $producto->categoria_id == $cat->id ? 'selected' : '' }}>
                {{ $cat->nombre }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-medium">Marca</label>
          <select name="marca_id" class="form-select">
            <option value="">Sin marca</option>
            @foreach($marcas as $marca)
              <option value="{{ $marca->id }}" {{ $producto->marca_id == $marca->id ? 'selected' : '' }}>
                {{ $marca->nombre }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <div class="form-check form-switch mt-4">
            <input class="form-check-input" type="checkbox" name="activo" id="activo" {{ $producto->activo ? 'checked' : '' }}>
            <label class="form-check-label" for="activo">Activo</label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-check form-switch mt-4">
            <input class="form-check-input" type="checkbox" name="nuevo" id="nuevo" {{ $producto->nuevo ? 'checked' : '' }}>
            <label class="form-check-label" for="nuevo">New Arrival</label>
          </div>
        </div>
      </div>
    </div>

    {{-- Variantes existentes --}}
    <div class="table-card mb-4">
      <h6 class="fw-bold mb-4">Variantes existentes</h6>

      @foreach($producto->variantes as $variante)
      <div class="variante-card mb-3" id="variante-card-{{ $variante->id }}">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <span class="fw-semibold" style="font-size:14px;">
            {{ $variante->color }} / {{ $variante->talla }}
          </span>
          <button type="button" class="btn btn-outline-danger btn-sm"
                  onclick="eliminarVariante({{ $variante->id }})">
            × Eliminar
          </button>
        </div>
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label" style="font-size:13px;">Talla</label>
            <select name="variantes_existentes[{{ $variante->id }}][talla]" class="form-select form-select-sm">
              @foreach(['XS','S','M','L','XL','XXL','XXXL','Única'] as $t)
                <option value="{{ $t }}" {{ $variante->talla == $t ? 'selected' : '' }}>{{ $t }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label" style="font-size:13px;">Color</label>
            <input type="text" name="variantes_existentes[{{ $variante->id }}][color]"
                   value="{{ $variante->color }}" class="form-control form-control-sm">
          </div>
          <div class="col-md-4">
            <label class="form-label" style="font-size:13px;">Stock</label>
            <input type="number" name="variantes_existentes[{{ $variante->id }}][stock]"
                   value="{{ $variante->stock }}" min="0" class="form-control form-control-sm">
          </div>

          {{-- Imágenes actuales --}}
          @if($variante->imagenes->count())
          <div class="col-12">
            <label class="form-label" style="font-size:13px;">Imágenes actuales</label>
            <div class="d-flex gap-2 flex-wrap">
              @foreach($variante->imagenes as $imagen)
              <div class="position-relative" id="img-{{ $imagen->id }}">
                <img src="{{ asset('img/' . $imagen->ruta) }}"
                     style="width:70px;height:70px;object-fit:cover;border-radius:8px;border:1px solid #ddd;">
                <button type="button"
                        onclick="eliminarImagen({{ $imagen->id }})"
                        style="position:absolute;top:-6px;right:-6px;background:#dc3545;color:#fff;
                               border:none;border-radius:50%;width:20px;height:20px;
                               font-size:12px;cursor:pointer;line-height:1;">×</button>
              </div>
              @endforeach
            </div>
          </div>
          @endif

          {{-- Agregar más imágenes --}}
          <div class="col-12">
            <label class="form-label" style="font-size:13px;">Agregar más imágenes</label>
            <input type="file" name="nuevas_imagenes[{{ $variante->id }}][]"
                   multiple accept="image/*" class="form-control form-control-sm imagen-input">
            <div class="preview-container d-flex gap-2 flex-wrap mt-2"></div>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    {{-- Nuevas variantes --}}
    <div class="table-card">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h6 class="fw-bold mb-0">Agregar nuevas variantes</h6>
        <button type="button" class="btn btn-dark btn-sm" id="agregar-variante">+ Agregar</button>
      </div>
      <div id="nuevas-variantes-container"></div>
    </div>

  </div>

  <div class="col-lg-4">
    <div class="table-card sticky-top" style="top:20px;">
      <h6 class="fw-bold mb-3">Acciones</h6>
      <button type="submit" class="btn btn-dark w-100 py-3 fw-bold mb-2">
        Guardar cambios ✓
      </button>
      <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary w-100 mb-2">
        Volver a lista
      </a>
      <a href="{{ route('productos.show', $producto->slug) }}"
         class="btn btn-outline-dark w-100" target="_blank">
        Ver en tienda →
      </a>
    </div>
  </div>

</div>
</form>

@push('scripts')
<script>
const CSRF = '{{ csrf_token() }}';
let idxNew = 0;

// Preview imágenes
document.addEventListener('change', function(e) {
  if (e.target.classList.contains('imagen-input')) {
    const preview = e.target.nextElementSibling;
    preview.innerHTML = '';
    Array.from(e.target.files).forEach(file => {
      const reader = new FileReader();
      reader.onload = ev => {
        const img = document.createElement('img');
        img.src = ev.target.result;
        img.style.cssText = 'width:70px;height:70px;object-fit:cover;border-radius:8px;border:1px solid #ddd;';
        preview.appendChild(img);
      };
      reader.readAsDataURL(file);
    });
  }
});

// Agregar nueva variante
document.getElementById('agregar-variante').addEventListener('click', function() {
  const container = document.getElementById('nuevas-variantes-container');
  const tallas = ['XS','S','M','L','XL','XXL','XXXL','Única'];
  const options = tallas.map(t => `<option value="${t}">${t}</option>`).join('');

  const div = document.createElement('div');
  div.className = 'variante-card mb-3';
  div.innerHTML = `
    <div class="d-flex justify-content-between mb-3">
      <span class="fw-semibold" style="font-size:14px;">Nueva variante</span>
      <button type="button" class="btn btn-outline-danger btn-sm" onclick="this.closest('.variante-card').remove()">× Eliminar</button>
    </div>
    <div class="row g-3">
      <div class="col-md-4">
        <select name="nuevas_variantes[${idxNew}][talla]" class="form-select form-select-sm">
          <option value="">Talla...</option>${options}
        </select>
      </div>
      <div class="col-md-4">
        <input type="text" name="nuevas_variantes[${idxNew}][color]"
               class="form-control form-control-sm" placeholder="Color">
      </div>
      <div class="col-md-4">
        <input type="number" name="nuevas_variantes[${idxNew}][stock]"
               min="0" value="0" class="form-control form-control-sm" placeholder="Stock">
      </div>
      <div class="col-12">
        <input type="file" name="imagenes_nuevas_variantes[${idxNew}][]"
               multiple accept="image/*" class="form-control form-control-sm imagen-input">
        <div class="preview-container d-flex gap-2 flex-wrap mt-2"></div>
      </div>
    </div>`;
  container.appendChild(div);
  idxNew++;
});

// Eliminar imagen
function eliminarImagen(id) {
  if (!confirm('¿Eliminar esta imagen?')) return;
  fetch(`/admin/imagenes/${id}`, {
    method: 'DELETE',
    headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
  }).then(r => r.json()).then(data => {
    if (data.success) document.getElementById(`img-${id}`).remove();
  });
}

// Eliminar variante
function eliminarVariante(id) {
  if (!confirm('¿Eliminar esta variante y sus imágenes?')) return;
  fetch(`/admin/variantes/${id}`, {
    method: 'DELETE',
    headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
  }).then(r => r.json()).then(data => {
    if (data.success) document.getElementById(`variante-card-${id}`).remove();
  });
}
</script>
@endpush
@endsection