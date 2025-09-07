
@extends('layouts.admin')


@section('content')
  <div class="container-fluid py-4">
    <div class="row">
      <!-- Tarjetas de Resumen -->
      <div class="col-md-3 mb-3">
        <div class="card shadow-sm text-center">
          <div class="card-body">
            <h6 class="text-muted">Ventas Hoy</h6>
            <h4 class="fw-bold text-primary">S/ {{ number_format($ventasHoy, 2) }}</h4>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="card shadow-sm text-center">
          <div class="card-body">
            <h6 class="text-muted">Clientes Nuevos</h6>
            <h4 class="fw-bold text-success">{{ $clientesNuevos }}</h4>
          </div>
        </div>
      </div>

      <div class="col-md-3 mb-3">
        <div class="card shadow-sm text-center">
          <div class="card-body">
            <h6 class="text-muted">Stock mínimo</h6>
            <h4 class="fw-bold text-warning">{{ $productosCriticos }}</h4>
          </div>
        </div>
      </div>

      <div class="col-md-3 mb-3">
        <div class="card shadow-sm text-center">
          <div class="card-body">
            <h6 class="text-muted">Productos vendidos hoy</h6>
            <h4 class="fw-bold text-success">{{ $ventasHoy }}</h4>
          </div>
        </div>
      </div>

    </div>

    <!-- Gráficos -->
    <div class="row">
      <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white">Ventas por Mes</div>
          <div class="card-body">
            <canvas id="ventasMes"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
          <div class="card-header bg-success text-white">Top Productos</div>
          <div class="card-body">
            <canvas id="topProductos"></canvas>
          </div>
        </div>
      </div>
    </div>


  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // Ventas por mes
    new Chart(document.getElementById('ventasMes'), {
      type: 'line',
      data: {
        labels: {!! json_encode(array_keys($ventasMes->toArray())) !!},
        datasets: [{
          label: 'Ventas (S/)',
          data: {!! json_encode(array_values($ventasMes->toArray())) !!},
          borderColor: '#0d6efd',
          backgroundColor: 'rgba(13,110,253,0.3)',
          fill: true
        }]
      }
    });

    // Top productos
    new Chart(document.getElementById('topProductos'), {
      type: 'bar',
      data: {
        labels: {!! json_encode(array_keys($topProductos->toArray())) !!},
        datasets: [{
          label: 'Unidades Vendidas',
          data: {!! json_encode(array_values($topProductos->toArray())) !!},
          backgroundColor: '#198754'
        }]
      },
      options: {
        indexAxis: 'y', // <- Esto lo hace horizontal
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          },
          tooltip: {
            enabled: true
          }
        },
        scales: {
          x: {
            beginAtZero: true
          }
        }
      }
    });

    
  </script>
@endsection