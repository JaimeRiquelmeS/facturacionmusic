<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Mostrar una lista de los clientes.
     */
    public function index()
    {
        $clientes = Cliente::latest()->paginate(10);
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Mostrar el formulario para crear un nuevo cliente.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Almacenar un nuevo cliente en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
            'nif' => 'nullable|string|max:20',
        ]);

        Cliente::create($request->all());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente creado con éxito.');
    }

    /**
     * Mostrar el cliente especificado.
     */
    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Mostrar el formulario para editar el cliente especificado.
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Actualizar el cliente especificado en la base de datos.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
            'nif' => 'nullable|string|max:20',
        ]);

        $cliente->update($request->all());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado con éxito.');
    }

    /**
     * Eliminar el cliente especificado de la base de datos.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado con éxito.');
    }
}
