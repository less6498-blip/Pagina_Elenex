@extends('admin.layout')
@section('title', 'Pedidos')
@section('page-title', 'Pedidos')

@section('content')
<div class="table-card">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h6 class="fw-bold mb-0">Todos los pedidos ({{ $pedidos->total() }})</h6>
  </div>

  {{-- Filtros --}}
  <form method="GET" class="row g-2 mb-4">
    <div class="col-md-4">
      <input type="text" name="buscar" value="{{ request('buscar') }}"
             placeholder="Código, email o nombre..." class="form-control form-control-sm">
    </div>
    <div class="col-md-2">
      <select name="estado_pago" class="form-select form-select-sm">
        <option value="">Todos los pagos</option>
        <option value="pagado"   {{ request('estado_pago') == 'pagado'   ? 'selected' : '' }}>Pagado</option>
        <option value="pendiente"{{ request('estado_pago') == 'pendiente'? 'selected' : '' }}>Pendiente</option>
        <option value="fallido"  {{ request('estado_pago') == 'fallido'  ? 'selected' : '' }}>Fallido</option>
      </select>
    </div>
    <div class="col-md-2">
      <select name="estado" class="form-select form-select-sm">
        <option value="">Todos los estados</option>
        <option value="confirmado"{{ request('estado') == 'confirmado'? 'selected':'' }}>Confirmado</option>
        <option value="enviado"   {{ request('estado') == 'enviado'   ? 'selected':'' }}>Enviado</option>
        <option value="entregado" {{ request('estado') == 'entregado' ? 'selected':'' }}>Entregado</option>
        <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected':'' }}>Cancelado</option>
      </select>
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn btn-dark btn-sm w-100">Filtrar</button>
    </div>
    <div class="col-md-2">
      <a href="{{ route('admin.pedidos.index') }}" class="btn btn-outline-secondary btn-sm w-100">Limpiar</a>
    </div>
  </form>

  <div class="table-responsive">
    <table class="table table-hover align-middle" style="font-size:13px;">
      <thead style="color:#888;font-size:12px;text-transform:uppercase;">
        <tr>
          <th>Código</th>
          <th>Cliente</th>
          <th>Productos</th>
          <th>Total</th>
          <th>Pago</th>
          <th>Estado envío</th>
          <th>Fecha</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($pedidos as $pedido)
        <tr>
          <td class="fw-bold" style="font-family:monospace;">{{ $pedido->codigo_orden }}</td>
          <td>
            <div class="fw-semibold">{{ $pedido->guest_nombre }}</div>
            <div style="color:#888;font-size:11px;">{{ $pedido->guest_email }}</div>
          </td>
          <td>
            <span style="background:#f0f0f0;padding:2px 8px;border-radius:20px;font-size:12px;">
              {{ $pedido->detalles->count() }} item(s)
            </span>
          </td>
          <td class="fw-bold">S/ {{ number_format($pedido->total, 2) }}</td>
          <td>
            @php
              $pagoColor = match($pedido->estado_pago) {
                'pagado'   => ['bg' => '#d4edda', 'color' => '#155724'],
                'fallido'  => ['bg' => '#f8d7da', 'color' => '#721c24'],
                default    => ['bg' => '#fff3cd', 'color' => '#856404'],
              };
            @endphp
            <span style="background:{{ $pagoColor['bg'] }};color:{{ $pagoColor['color'] }};
                         padding:3px 10px;border-radius:20px;font-size:12px;">
              {{ ucfirst($pedido->estado_pago) }}
            </span>
          </td>
          <td>
            <select class="form-select form-select-sm estado-select"
                    data-id="{{ $pedido->id }}"
                    style="font-size:12px;width:130px;">
              @foreach(['pendiente','confirmado','enviado','entregado','cancelado'] as $est)
                <option value="{{ $est }}" {{ $pedido->estado == $est ? 'selected' : '' }}>
                  {{ ucfirst($est) }}
                </option>
              @endforeach
            </select>
          </td>
          <td style="color:#888;">{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
          <td>
            <button class="btn btn-outline-dark btn-sm ver-detalle"
                    data-id="{{ $pedido->id }}"
                    data-bs-toggle="modal"
                    data-bs-target="#modalPedido"
                    data-pedido="{{ json_encode([
                        'codigo'     => $pedido->codigo_orden,
                        'nombre'     => $pedido->guest_nombre,
                        'email'      => $pedido->guest_email,
                        'telefono'   => $pedido->guest_telefono,
                        'direccion'  => $pedido->envio_direccion . ', ' . $pedido->envio_distrito . ', ' . $pedido->envio_provincia,
                        'subtotal'   => number_format($pedido->subtotal, 2),
                        'envio'      => number_format($pedido->costo_envio, 2),
                        'total'      => number_format($pedido->total, 2),
                        'items'      => $pedido->detalles->map(fn($d) => [
                            'nombre'   => $d->nombre_producto,
                            'variante' => $d->variante_detalle,
                            'cantidad' => $d->cantidad,
                            'precio'   => number_format($d->precio_unitario, 2),
                            'subtotal' => number_format($d->subtotal, 2),
                        ])
                    ]) }}">
              <i class="fas fa-eye"></i>
            </button>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8" class="text-center text-muted py-4">No hay pedidos</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $pedidos->withQueryString()->links() }}
</div>

{{-- Modal detalle pedido --}}
<div class="modal fade" id="modalPedido" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius:16px;">
      <div class="modal-header border-0 pb-0">
        <h6 class="modal-title fw-bold" id="modalCodigo"></h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <div style="background:#f8f9fa;border-radius:10px;padding:16px;">
              <div style="font-size:12px;color:#888;margin-bottom:8px;">DATOS DEL CLIENTE</div>
              <div id="modalNombre" class="fw-semibold"></div>
              <div id="modalEmail" style="font-size:13px;color:#888;"></div>
              <div id="modalTelefono" style="font-size:13px;color:#888;"></div>
            </div>
          </div>
          <div class="col-md-6">
            <div style="background:#f8f9fa;border-radius:10px;padding:16px;">
              <div style="font-size:12px;color:#888;margin-bottom:8px;">DIRECCIÓN DE ENVÍO</div>
              <div id="modalDireccion" style="font-size:13px;"></div>
            </div>
          </div>
        </div>

        <div id="modalItems" style="margin-bottom:16px;"></div>

        <div style="border-top:1px solid #f0f0f0;padding-top:12px;">
          <div class="d-flex justify-content-between" style="font-size:13px;color:#888;">
            <span>Subtotal</span><span id="modalSubtotal"></span>
          </div>
          <div class="d-flex justify-content-between" style="font-size:13px;color:#888;">
            <span>Envío</span><span id="modalEnvio"></span>
          </div>
          <div class="d-flex justify-content-between fw-bold mt-2">
            <span>Total</span><span id="modalTotal"></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
const CSRF = '{{ csrf_token() }}';

// Cambiar estado del pedido
document.querySelectorAll('.estado-select').forEach(select => {
    select.addEventListener('change', function() {
        const id     = this.dataset.id;
        const estado = this.value;

        fetch(`/admin/pedidos/${id}/estado`, {
            method:  'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept':       'application/json',
            },
            body: JSON.stringify({ estado })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                // Flash visual
                select.style.background = '#d4edda';
                setTimeout(() => select.style.background = '', 1500);
            }
        });
    });
});

// Modal detalle
document.querySelectorAll('.ver-detalle').forEach(btn => {
    btn.addEventListener('click', function() {
        const p = JSON.parse(this.dataset.pedido);

        document.getElementById('modalCodigo').textContent    = 'Pedido ' + p.codigo;
        document.getElementById('modalNombre').textContent    = p.nombre;
        document.getElementById('modalEmail').textContent     = p.email;
        document.getElementById('modalTelefono').textContent  = p.telefono || '';
        document.getElementById('modalDireccion').textContent = p.direccion;
        document.getElementById('modalSubtotal').textContent  = 'S/ ' + p.subtotal;
        document.getElementById('modalEnvio').textContent     = 'S/ ' + p.envio;
        document.getElementById('modalTotal').textContent     = 'S/ ' + p.total;

        const itemsHtml = p.items.map(i => `
            <div class="d-flex justify-content-between align-items-center py-2"
                 style="border-bottom:1px solid #f5f5f5;font-size:13px;">
                <div>
                    <div class="fw-semibold">${i.nombre}</div>
                    ${i.variante ? `<div style="color:#888;font-size:12px;">${i.variante}</div>` : ''}
                    <div style="color:#888;font-size:12px;">${i.cantidad} × S/ ${i.precio}</div>
                </div>
                <div class="fw-bold">S/ ${i.subtotal}</div>
            </div>
        `).join('');

        document.getElementById('modalItems').innerHTML = itemsHtml;
    });
});
</script>

@endsection