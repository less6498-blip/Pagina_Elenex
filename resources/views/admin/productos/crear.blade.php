@extends('admin.layout')
@section('title', 'Crear Producto')
@section('page-title', 'Agregar Producto')

@section('content')

{{-- FORMULARIO CREAR PRODUCTO --}}
<form action="{{ route('admin.productos.guardar') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row g-4">

  {{-- Columna izquierda --}}
  <div class="col-lg-8">

    {{-- Datos básicos --}}
    <div class="table-card mb-4">
      <h6 class="fw-bold mb-4">Información del producto</h6>
      <div class="row g-3">
        <div class="col-12">
          <label class="form-label fw-medium">Nombre *</label>
          <input type="text" name="nombre" class="form-control" placeholder="Ej: Polo Mojito Oversize" required>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-medium">Precio (S/) *</label>
          <input type="number" name="precio" step="0.01" min="0" class="form-control" placeholder="75.00" required>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-medium">Categoría *</label>
          <select name="categoria_id" class="form-select" required>
            <option value="">Seleccionar...</option>
            @foreach($categorias as $cat)
              <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-medium">Marca</label>
          <select name="marca_id" class="form-select">
            <option value="">Sin marca</option>
            @foreach($marcas as $marca)
              <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <div class="form-check form-switch mt-4">
            <input class="form-check-input" type="checkbox" name="activo" checked id="activo">
            <label class="form-check-label" for="activo">Activo</label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-check form-switch mt-4">
            <input class="form-check-input" type="checkbox" name="nuevo" id="nuevo">
            <label class="form-check-label" for="nuevo">New Arrival</label>
          </div>
        </div>
      </div>
    </div>

    {{-- Variantes --}}
    <div class="table-card">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h6 class="fw-bold mb-0">Variantes (Talla + Color + Stock + Imágenes)</h6>
        <button type="button" class="btn btn-dark btn-sm" id="agregar-variante">
          + Agregar variante
        </button>
      </div>
      <div id="variantes-container">
        <div class="variante-card" data-idx="0">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="fw-semibold" style="font-size:14px;">Variante #1</span>
            <button type="button" class="btn btn-outline-danger btn-sm eliminar-variante">× Eliminar</button>
          </div>
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label" style="font-size:13px;">Talla *</label>
              <select name="variantes[0][talla]" class="form-select form-select-sm" required>
                <option value="">Seleccionar...</option>
                @foreach(['XS','S','M','L','XL','XXL','XXXL','Única'] as $talla)
                  <option value="{{ $talla }}">{{ $talla }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label" style="font-size:13px;">Color *</label>
              <input type="text" name="variantes[0][color]" class="form-control form-control-sm"
                     placeholder="Ej: negro, blanco, azul" required>
            </div>
            <div class="col-md-4">
              <label class="form-label" style="font-size:13px;">Stock *</label>
              <input type="number" name="variantes[0][stock]" min="0" value="0"
                     class="form-control form-control-sm" required>
            </div>
            <div class="col-12">
              <label class="form-label" style="font-size:13px;">Imágenes</label>
              <input type="file" name="imagenes[0][]" multiple accept="image/*"
                     class="form-control form-control-sm imagen-input">
              <div class="preview-container d-flex gap-2 flex-wrap mt-2"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  {{-- Columna derecha --}}
  <div class="col-lg-4">
    <div class="table-card sticky-top" style="top:20px;">
      <h6 class="fw-bold mb-4">Resumen</h6>
      <p style="font-size:13px;color:#888;">Completa todos los campos requeridos y agrega al menos una variante con sus imágenes.</p>
      <hr>
      <button type="submit" class="btn btn-dark w-100 py-3 fw-bold">
        Guardar producto ✓
      </button>
      <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary w-100 mt-2">
        Cancelar
      </a>
    </div>
  </div>

</div>
</form>

{{-- ══════════════════════════════════════════════════════
     CARGA MASIVA — Formulario separado (fuera del form principal)
══════════════════════════════════════════════════════ --}}
<div class="row mt-4">
  <div class="col-lg-4 offset-lg-8">
    <div class="table-card">
      <h6 class="fw-bold mb-3">
        <i class="fas fa-file-excel me-2" style="color:#28a745;"></i>
        Carga masiva
      </h6>
      <p style="font-size:13px;color:#888;margin-bottom:16px;">
        Sube múltiples productos de una vez usando nuestra plantilla.
      </p>

      {{-- Descargar plantilla --}}
      <a href="{{ route('admin.productos.plantilla') }}"
         class="btn btn-outline-success w-100 mb-3"
         style="border-radius:10px;font-size:13px;font-weight:600;">
        <i class="fas fa-download me-2"></i>
        Descargar plantilla (.xlsx)
      </a>

      {{-- Subir archivo — form independiente --}}
      <form action="{{ route('admin.productos.importar') }}"
            method="POST"
            enctype="multipart/form-data">
        @csrf
        <div class="mb-2">
          <label style="font-size:13px;font-weight:500;margin-bottom:6px;display:block;">
            Subir archivo (.xlsx o .csv)
          </label>
          <input type="file" name="archivo" accept=".csv,.xlsx,.txt"
                 class="form-control form-control-sm" required>
        </div>
        <button type="submit" class="btn btn-success w-100 mt-2"
                style="border-radius:10px;font-size:13px;font-weight:600;">
          <i class="fas fa-upload me-2"></i>
          Importar productos
        </button>
      </form>

      <div class="mt-3 p-3 rounded-3" style="background:#f0fff4;border:1px solid #c6f6d5;">
        <p style="font-size:12px;color:#276749;margin:0;">
          <strong>Instrucciones:</strong><br>
          1. Descarga la plantilla .xlsx<br>
          2. Llena una fila por cada variante<br>
          3. Si un producto tiene 4 tallas, escribe 4 filas con el mismo nombre<br>
          4. Sube el archivo y se crearán automáticamente
        </p>
      </div>
    </div>
  </div>
</div>

<script>
let idx = 1;

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

document.getElementById('agregar-variante').addEventListener('click', function() {
  const container = document.getElementById('variantes-container');
  const tallas = ['XS','S','M','L','XL','XXL','XXXL','Única'];
  const options = tallas.map(t => `<option value="${t}">${t}</option>`).join('');
  const div = document.createElement('div');
  div.className = 'variante-card';
  div.dataset.idx = idx;
  div.innerHTML = `
    <div class="d-flex justify-content-between align-items-center mb-3">
      <span class="fw-semibold" style="font-size:14px;">Variante #${idx + 1}</span>
      <button type="button" class="btn btn-outline-danger btn-sm eliminar-variante">× Eliminar</button>
    </div>
    <div class="row g-3">
      <div class="col-md-4">
        <label class="form-label" style="font-size:13px;">Talla *</label>
        <select name="variantes[${idx}][talla]" class="form-select form-select-sm" required>
          <option value="">Seleccionar...</option>${options}
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label" style="font-size:13px;">Color *</label>
        <input type="text" name="variantes[${idx}][color]" class="form-control form-control-sm"
               placeholder="Ej: negro, blanco, azul" required>
      </div>
      <div class="col-md-4">
        <label class="form-label" style="font-size:13px;">Stock *</label>
        <input type="number" name="variantes[${idx}][stock]" min="0" value="0"
               class="form-control form-control-sm" required>
      </div>
      <div class="col-12">
        <label class="form-label" style="font-size:13px;">Imágenes</label>
        <input type="file" name="imagenes[${idx}][]" multiple accept="image/*"
               class="form-control form-control-sm imagen-input">
        <div class="preview-container d-flex gap-2 flex-wrap mt-2"></div>
      </div>
    </div>`;
  container.appendChild(div);
  idx++;
});

document.addEventListener('click', function(e) {
  if (e.target.classList.contains('eliminar-variante')) {
    const card = e.target.closest('.variante-card');
    if (document.querySelectorAll('.variante-card').length > 1) {
      card.remove();
    } else {
      alert('Debe haber al menos una variante.');
    }
  }
});
</script>

@endsection