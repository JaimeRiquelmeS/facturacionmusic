@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Facturas</h1>
            <a href="{{ route('facturas.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nueva Factura
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Número</th>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($facturas as $factura)
                                <tr>
                                    <td>{{ $factura->numero }}</td>
                                    <td>{{ $factura->cliente->nombre }}</td>
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
                                    <td class="d-flex">
                                        <a href="{{ route('facturas.show', $factura) }}" class="btn btn-sm btn-info me-1">
                                            Ver
                                        </a>
                                        <a href="{{ route('facturas.edit', $factura) }}" class="btn btn-sm btn-warning me-1">
                                            Editar
                                        </a>
                                        <a href="{{ route('facturas.pdf', $factura) }}" class="btn btn-sm btn-secondary me-1" target="_blank">
                                            PDF
                                        </a>
                                        <form action="{{ route('facturas.destroy', $factura) }}" method="POST" onsubmit="return confirm('¿Está seguro de eliminar esta factura?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No hay facturas registradas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $facturas->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
