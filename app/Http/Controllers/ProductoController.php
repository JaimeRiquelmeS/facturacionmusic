<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Mostrar una lista de los productos.
     */
    public function index()
    {
        $productos = Producto::latest()->paginate(10);
        return view('productos.index', compact('productos'));
    }

    /**
     * Mostrar el formulario para crear un nuevo producto.
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Almacenar un nuevo producto en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'codigo' => 'nullable|string|max:50|unique:productos',
        ]);

        Producto::create($request->all());

        return redirect()->route('productos.index')
            ->with('success', 'Producto creado con éxito.');
    }

    /**
     * Mostrar el producto especificado.
     */
    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto'));
    }

    /**
     * Mostrar el formulario para editar el producto especificado.
     */
    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    /**
     * Actualizar el producto especificado en la base de datos.
     */
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'codigo' => 'nullable|string|max:50|unique:productos,codigo,' . $producto->id,
        ]);

        $producto->update($request->all());

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado con éxito.');
    }

    /**
     * Eliminar el producto especificado de la base de datos.
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado con éxito.');
    }
}
