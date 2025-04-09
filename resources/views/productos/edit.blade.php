@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Editar Producto: {{ $producto->nombre }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('productos.update', $producto) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Nombre <span class="text-danger">*</span></label>
                                        <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $producto->nombre) }}" required>
                                        @error('nombre')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="codigo">Código</label>
                                        <input type="text" name="codigo" id="codigo" class="form-control @error('codigo') is-invalid @enderror" value="{{ old('codigo', $producto->codigo) }}">
                                        @error('codigo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="precio">Precio <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">€</span>
                                            <input type="number" name="precio" id="precio" class="form-control @error('precio') is-invalid @enderror" step="0.01" min="0" value="{{ old('precio', $producto->precio) }}" required>
                                            @error('precio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="stock">Stock <span class="text-danger">*</span></label>
                                        <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror" min="0" value="{{ old('stock', $producto->stock) }}" required>
                                        @error('stock')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion">Descripción</label>
                                        <textarea name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" rows="3">{{ old('descripcion', $producto->descripcion) }}</textarea>
                                        @error('descripcion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                                    Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Actualizar Producto
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
