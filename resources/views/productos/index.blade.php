@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fas fa-guitar me-2"></i>Mis Instrumentos y Productos</h1>
            <a href="{{ route('productos.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Nuevo Instrumento
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Código</th>
                                <th>Instrumento</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($productos as $producto)
                                <tr>
                                    <td>{{ $producto->id }}</td>
                                    <td><span class="badge bg-secondary">{{ $producto->codigo ?: 'N/A' }}</span></td>
                                    <td>
                                        @php
                                            $icon = 'music';
                                            $nombre = strtolower($producto->nombre);
                                            if (strpos($nombre, 'guitarra') !== false) {
                                                $icon = 'guitar';
                                            } elseif (strpos($nombre, 'piano') !== false) {
                                                $icon = 'piano-keyboard';
                                            } elseif (strpos($nombre, 'batería') !== false || strpos($nombre, 'bateria') !== false) {
                                                $icon = 'drum';
                                            } elseif (strpos($nombre, 'micrófono') !== false || strpos($nombre, 'microfono') !== false) {
                                                $icon = 'microphone';
                                            } elseif (strpos($nombre, 'bajo') !== false) {
                                                $icon = 'guitar';
                                            } elseif (strpos($nombre, 'saxo') !== false) {
                                                $icon = 'saxophone';
                                            } elseif (strpos($nombre, 'violín') !== false || strpos($nombre, 'violin') !== false) {
                                                $icon = 'violin';
                                            } elseif (strpos($nombre, 'trompeta') !== false) {
                                                $icon = 'trumpet';
                                            }
                                        @endphp
                                        <i class="fas fa-{{ $icon }} me-2 text-primary"></i>
                                        <strong>{{ $producto->nombre }}</strong>
                                    </td>
                                    <td><span class="fw-bold">€{{ number_format($producto->precio, 2) }}</span></td>
                                    <td>
                                        @if($producto->stock < 10)
                                            <span class="badge bg-danger">{{ $producto->stock }}</span>
                                        @elseif($producto->stock < 20)
                                            <span class="badge bg-warning">{{ $producto->stock }}</span>
                                        @else
                                            <span class="badge bg-success">{{ $producto->stock }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('productos.show', $producto) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('productos.edit', $producto) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('productos.destroy', $producto) }}" method="POST" onsubmit="return confirm('¿Está seguro de eliminar este instrumento?');" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="fas fa-guitar fa-3x mb-3 text-muted"></i>
                                        <p class="text-muted">No hay instrumentos registrados. ¡Vamos a añadir algunos!</p>
                                        <a href="{{ route('productos.create') }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus me-1"></i> Añadir Instrumento
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $productos->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
