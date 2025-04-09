@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Clientes</h1>
            <a href="{{ route('clientes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo Cliente
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>NIF</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($clientes as $cliente)
                                <tr>
                                    <td>{{ $cliente->id }}</td>
                                    <td>{{ $cliente->nombre }}</td>
                                    <td>{{ $cliente->email }}</td>
                                    <td>{{ $cliente->telefono }}</td>
                                    <td>{{ $cliente->nif }}</td>
                                    <td class="d-flex">
                                        <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-sm btn-info me-1">
                                            Ver
                                        </a>
                                        <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-warning me-1">
                                            Editar
                                        </a>
                                        <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" onsubmit="return confirm('¿Está seguro de eliminar este cliente?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No hay clientes registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $clientes->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
