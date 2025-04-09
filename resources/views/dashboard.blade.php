@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">
            <i class="fas fa-guitar me-2"></i>Dashboard Musical
            <small class="text-muted fs-6">El ritmo de tu negocio</small>
        </h1>

        <!-- Tarjetas de resumen -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-3x mb-3 text-primary"></i>
                        <h5 class="card-title">Clientes</h5>
                        <h2 class="card-text">{{ $totalClientes }}</h2>
                        <p class="text-muted">Tus fans</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-guitar fa-3x mb-3 text-success"></i>
                        <h5 class="card-title">Productos</h5>
                        <h2 class="card-text">{{ $totalProductos }}</h2>
                        <p class="text-muted">Tus instrumentos</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-file-invoice fa-3x mb-3 text-info"></i>
                        <h5 class="card-title">Facturas</h5>
                        <h2 class="card-text">{{ $totalFacturas }}</h2>
                        <p class="text-muted">Tu repertorio</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-euro-sign fa-3x mb-3 text-warning"></i>
                        <h5 class="card-title">Ingresos</h5>
                        <h2 class="card-text">€{{ number_format($totalIngresos, 2) }}</h2>
                        <p class="text-muted">El ritmo de tu éxito</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-music me-2"></i>Estado de Facturas</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="p-3 rounded mb-3" style="background-color: rgba(255, 193, 7, 0.1);">
                                    <i class="fas fa-hourglass-half fa-2x text-warning mb-2"></i>
                                    <h5>Pendientes</h5>
                                    <h3 class="text-warning">{{ $facturasPendientes }}</h3>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 rounded mb-3" style="background-color: rgba(40, 167, 69, 0.1);">
                                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                                    <h5>Pagadas</h5>
                                    <h3 class="text-success">{{ $facturasPagadas }}</h3>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 rounded mb-3" style="background-color: rgba(220, 53, 69, 0.1);">
                                    <i class="fas fa-times-circle fa-2x text-danger mb-2"></i>
                                    <h5>Canceladas</h5>
                                    <h3 class="text-danger">{{ $facturasCanceladas }}</h3>
                                </div>
                            </div>
                        </div>
                        <canvas id="estadoFacturasChart" class="mt-3"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Facturas por Mes ({{ date('Y') }})</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="facturasChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tablas -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-star me-2"></i>Productos Más Vendidos</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th class="text-end">Cantidad Vendida</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($productosPopulares as $producto)
                                    <tr>
                                        <td>
                                            <i class="fas fa-guitar me-2 text-primary"></i>
                                            {{ $producto->nombre }}
                                        </td>
                                        <td class="text-end fw-bold">{{ $producto->cantidad_vendida }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">No hay datos disponibles</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-crown me-2"></i>Clientes VIP</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th class="text-center">Facturas</th>
                                    <th class="text-end">Total Gastado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($clientesTop as $cliente)
                                    <tr>
                                        <td>
                                            <i class="fas fa-user-circle me-2 text-primary"></i>
                                            {{ $cliente->nombre }}
                                        </td>
                                        <td class="text-center">{{ $cliente->total_facturas }}</td>
                                        <td class="text-end fw-bold">€{{ number_format($cliente->total_gastado, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No hay datos disponibles</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Gráfico de facturas por mes
    var ctxFacturas = document.getElementById('facturasChart').getContext('2d');
    var facturasChart = new Chart(ctxFacturas, {
        type: 'bar',
        data: {
            labels: {!! json_encode($meses) !!},
            datasets: [{
                label: 'Facturas mensuales',
                data: {!! json_encode($totalFacturasPorMes) !!},
                backgroundColor: [
                    'rgba(106, 17, 203, 0.5)',
                    'rgba(90, 24, 194, 0.5)',
                    'rgba(74, 30, 184, 0.5)',
                    'rgba(59, 37, 175, 0.5)',
                    'rgba(43, 44, 166, 0.5)',
                    'rgba(28, 50, 157, 0.5)',
                    'rgba(12, 57, 147, 0.5)',
                    'rgba(0, 63, 138, 0.5)',
                    'rgba(0, 70, 129, 0.5)',
                    'rgba(0, 77, 120, 0.5)',
                    'rgba(0, 83, 110, 0.5)',
                    'rgba(0, 90, 101, 0.5)'
                ],
                borderColor: [
                    'rgba(106, 17, 203, 1)',
                    'rgba(90, 24, 194, 1)',
                    'rgba(74, 30, 184, 1)',
                    'rgba(59, 37, 175, 1)',
                    'rgba(43, 44, 166, 1)',
                    'rgba(28, 50, 157, 1)',
                    'rgba(12, 57, 147, 1)',
                    'rgba(0, 63, 138, 1)',
                    'rgba(0, 70, 129, 1)',
                    'rgba(0, 77, 120, 1)',
                    'rgba(0, 83, 110, 1)',
                    'rgba(0, 90, 101, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Gráfico de estado de facturas
    var ctxEstado = document.getElementById('estadoFacturasChart').getContext('2d');
    var estadoFacturasChart = new Chart(ctxEstado, {
        type: 'doughnut',
        data: {
            labels: ['Pendientes', 'Pagadas', 'Canceladas'],
            datasets: [{
                data: [{{ $facturasPendientes }}, {{ $facturasPagadas }}, {{ $facturasCanceladas }}],
                backgroundColor: [
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(220, 53, 69, 0.8)'
                ],
                borderColor: [
                    'rgba(255, 193, 7, 1)',
                    'rgba(40, 167, 69, 1)',
                    'rgba(220, 53, 69, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            },
            cutout: '70%'
        }
    });
</script>
@endpush
