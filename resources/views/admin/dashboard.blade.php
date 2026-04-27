@extends('admin.layout')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Stats Productos --}}
<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="stat-card">
      <div style="font-size:12px;color:#888;text-transform:uppercase;letter-spacing:.5px;">Total Productos</div>
      <div style="font-size:28px;font-weight:700;margin-top:4px;">{{ $stats['total_productos'] }}</div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="stat-card">
      <div style="font-size:12px;color:#888;text-transform:uppercase;letter-spacing:.5px;">Productos Activos</div>
      <div style="font-size:28px;font-weight:700;color:#28a745;margin-top:4px;">{{ $stats['productos_activos'] }}</div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="stat-card">
      <div style="font-size:12px;color:#888;text-transform:uppercase;letter-spacing:.5px;">Total Variantes</div>
      <div style="font-size:28px;font-weight:700;margin-top:4px;">{{ $stats['total_variantes'] }}</div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="stat-card">
      <div style="font-size:12px;color:#888;text-transform:uppercase;letter-spacing:.5px;">Variantes Sin Stock</div>
      <a href="{{ route('admin.productos.index', ['stock' => 'sin_stock']) }}" style="text-decoration:none;">
        <div style="font-size:28px;font-weight:700;color:#dc3545;margin-top:4px;">{{ $stats['sin_stock'] }}</div>
        <div style="font-size:11px;color:#dc3545;margin-top:2px;">Ver →</div>
      </a>
    </div>
  </div>
</div>

{{-- Stats Pedidos --}}
<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="stat-card" style="border-left:4px solid #111;">
      <div style="font-size:12px;color:#888;text-transform:uppercase;letter-spacing:.5px;">Total Pedidos</div>
      <div style="font-size:28px;font-weight:700;margin-top:4px;">{{ $pedidoStats['total_pedidos'] }}</div>
      <a href="{{ route('admin.pedidos.index') }}" style="font-size:11px;color:#888;">Ver todos →</a>
    </div>
  </div>
  <div class="col-md-3">
    <div class="stat-card" style="border-left:4px solid #28a745;">
      <div style="font-size:12px;color:#888;text-transform:uppercase;letter-spacing:.5px;">Pedidos Pagados</div>
      <div style="font-size:28px;font-weight:700;color:#28a745;margin-top:4px;">{{ $pedidoStats['pedidos_pagados'] }}</div>
      <a href="{{ route('admin.pedidos.index', ['estado_pago' => 'pagado']) }}" style="font-size:11px;color:#28a745;">Ver →</a>
    </div>
  </div>
  <div class="col-md-3">
    <div class="stat-card" style="border-left:4px solid #ffc107;">
      <div style="font-size:12px;color:#888;text-transform:uppercase;letter-spacing:.5px;">Pedidos Pendientes</div>
      <div style="font-size:28px;font-weight:700;color:#ffc107;margin-top:4px;">{{ $pedidoStats['pedidos_pendientes'] }}</div>
      <a href="{{ route('admin.pedidos.index', ['estado_pago' => 'pendiente']) }}" style="font-size:11px;color:#ffc107;">Ver →</a>
    </div>
  </div>
  <div class="col-md-3">
    <div class="stat-card" style="border-left:4px solid #6f42c1;">
      <div style="font-size:12px;color:#888;text-transform:uppercase;letter-spacing:.5px;">Ingresos Totales</div>
      <div style="font-size:24px;font-weight:700;color:#6f42c1;margin-top:4px;">S/ {{ number_format($pedidoStats['ingresos_totales'], 2) }}</div>
      <div style="font-size:11px;color:#888;">Hoy: S/ {{ number_format($pedidoStats['ingresos_hoy'], 2) }}</div>
    </div>
  </div>
</div>

{{-- Gráfica de ventas --}}
<div class="row g-4 mb-4">
  <div class="col-lg-8">
    <div class="table-card">
      <h6 class="fw-bold mb-4">Ventas últimos 7 días</h6>
      <canvas id="ventasChart" height="100"></canvas>
    </div>
  </div>

  {{-- Últimos pedidos --}}
  <div class="col-lg-4">
    <div class="table-card" style="height:100%;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">Últimos pedidos</h6>
        <a href="{{ route('admin.pedidos.index') }}" style="font-size:12px;color:#888;">Ver todos →</a>
      </div>
      <div style="max-height:280px;overflow-y:auto;">
        @forelse($ultimosPedidos as $pedido)
        <div class="d-flex justify-content-between align-items-center py-2"
             style="border-bottom:1px solid #f5f5f5;font-size:13px;">
          <div>
            <div class="fw-semibold">{{ $pedido->codigo_orden }}</div>
            <div style="color:#888;font-size:12px;">{{ $pedido->guest_nombre }}</div>
          </div>
          <div class="text-end">
            <div class="fw-bold">S/ {{ number_format($pedido->total, 2) }}</div>
            <span style="font-size:11px;padding:2px 8px;border-radius:20px;
                         background:{{ $pedido->estado_pago === 'pagado' ? '#d4edda' : '#fff3cd' }};
                         color:{{ $pedido->estado_pago === 'pagado' ? '#155724' : '#856404' }};">
              {{ ucfirst($pedido->estado_pago) }}
            </span>
          </div>
        </div>
        @empty
        <p class="text-muted text-center py-3" style="font-size:13px;">Sin pedidos aún</p>
        @endforelse
      </div>
    </div>
  </div>
</div>

{{-- Tabla últimos productos --}}
<div class="table-card">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h6 class="fw-bold mb-0">Últimos productos agregados</h6>
    <a href="{{ route('admin.productos.crear') }}" class="btn btn-dark btn-sm">+ Agregar producto</a>
  </div>
  <table class="table table-hover" style="font-size:14px;">
    <thead style="font-size:12px;color:#888;text-transform:uppercase;">
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
        <td class="fw-semibold">{{ $p->nombre }}</td>
        <td style="color:#888;">{{ $p->categoria->nombre ?? '-' }}</td>
        <td>S/ {{ number_format($p->precio, 2) }}</td>
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

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const ventasData = @json($ventasSemana);

new Chart(document.getElementById('ventasChart'), {
    type: 'bar',
    data: {
        labels: ventasData.map(v => v.dia),
        datasets: [{
            label: 'Ventas (S/)',
            data: ventasData.map(v => v.total),
            backgroundColor: 'rgba(17,17,17,0.8)',
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => 'S/ ' + ctx.parsed.y.toFixed(2)
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: val => 'S/ ' + val
                }
            }
        }
    }
});
</script>

@endsection