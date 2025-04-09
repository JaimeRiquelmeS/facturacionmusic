@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Detalles del Producto</h4>
                        <div>
                            <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning btn-sm">
                                Editar
                            </a>
                            <a href="{{ route('productos.index') }}" class="btn btn-secondary btn-sm">
                                Volver
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Nombre:</strong> {{ $producto->nombre }}</p>
                                <p><strong>Código:</strong> {{ $producto->codigo ?: 'No disponible' }}</p>
                                <p><strong>Precio:</strong> €{{ number_format($producto->precio, 2) }}</p>
                            </div>
                            <div class="col-md-6">
                                <p>
                                    <strong>Stock:</strong>
                                    @if($producto->stock < 10)
                                        <span class="badge bg-danger">{{ $producto->stock }}</span>
                                    @elseif($producto->stock < 20)
                                        <span class="badge bg-warning">{{ $producto->stock }}</span>
                                    @else
                                        <span class="badge bg-success">{{ $producto->stock }}</span>
                                    @endif
                                </p>
                                <p><strong>Fecha Registro:</strong> {{ $producto->created_at->format('d/m/Y H:i') }}</p>
                                <p><strong>Última Actualización:</strong> {{ $producto->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        @if($producto->descripcion)
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h5>Descripción</h5>
                                    <p>{{ $producto->descripcion }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Historial de Ventas (opcional) -->
                @if($producto->detallesFactura->count() > 0)
                    <div class="card mt-4">
                        <div class="card-header">
                            <h4>Historial de Ventas</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Factura</th>
                                            <th>Fecha</th>
                                            <th>Cliente</th>
                                            <th>Cantidad</th>
                                            <th>Precio</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($producto->detallesFactura as $detalle)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('facturas.show', $detalle->factura) }}">
                                                        {{ $detalle->factura->numero }}
                                                    </a>
                                                </td>
                                                <td>{{ $detalle->factura->fecha->format('d/m/Y') }}</td>
                                                <td>{{ $detalle->factura->cliente->nombre }}</td>
                                                <td>{{ $detalle->cantidad }}</td>
                                                <td>€{{ number_format($detalle->precio_unitario, 2) }}</td>
                                                <td>€{{ number_format($detalle->subtotal, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info mt-4">
                        Este producto no ha sido vendido aún.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
