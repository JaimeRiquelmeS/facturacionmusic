@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Detalles del Cliente</h4>
                        <div>
                            <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning btn-sm">
                                Editar
                            </a>
                            <a href="{{ route('clientes.index') }}" class="btn btn-secondary btn-sm">
                                Volver
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Nombre:</strong> {{ $cliente->nombre }}</p>
                                <p><strong>Email:</strong> {{ $cliente->email ?: 'No disponible' }}</p>
                                <p><strong>Teléfono:</strong> {{ $cliente->telefono ?: 'No disponible' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>NIF:</strong> {{ $cliente->nif ?: 'No disponible' }}</p>
                                <p><strong>Dirección:</strong> {{ $cliente->direccion ?: 'No disponible' }}</p>
                                <p><strong>Fecha Registro:</strong> {{ $cliente->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($cliente->facturas->count() > 0)
                    <div class="card mt-4">
                        <div class="card-header">
                            <h4>Facturas del Cliente</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Número</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                            <th>Total</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cliente->facturas as $factura)
                                            <tr>
                                                <td>{{ $factura->numero }}</td>
                                                <td>{{ $factura->fecha->format('d/m/Y') }}</td>
                                                <td>
                                                    @if($factura->estado == 'pendiente')
                                                        <span class="badge bg-warning">Pendiente</span>
                                                    @elseif($factura->estado == 'pagada')
                                                        <span class="badge bg-success">Pagada</span>
                                                    @else
                                                        <span class="badge bg-danger">Cancelada</span>
                                                    @endif
                                                </td>
                                                <td>€{{ number_format($factura->total, 2) }}</td>
                                                <td>
                                                    <a href="{{ route('facturas.show', $factura) }}" class="btn btn-sm btn-info">Ver</a>
                                                    <a href="{{ route('facturas.pdf', $factura) }}" class="btn btn-sm btn-secondary" target="_blank">PDF</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info mt-4">
                        Este cliente no tiene facturas registradas.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
