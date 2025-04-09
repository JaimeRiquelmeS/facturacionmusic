<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Factura;
use App\Models\Producto;
use App\Models\DetalleFactura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class FacturaController extends Controller
{
    /**
     * Mostrar una lista de las facturas.
     */
    public function index()
    {
        $facturas = Factura::with('cliente')->latest()->paginate(10);
        return view('facturas.index', compact('facturas'));
    }

    /**
     * Mostrar el formulario para crear una nueva factura.
     */
    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        // Generar un número de factura único
        $ultimaFactura = Factura::latest()->first();
        $numero = $ultimaFactura ? 'F-' . str_pad((intval(substr($ultimaFactura->numero, 2)) + 1), 6, '0', STR_PAD_LEFT) : 'F-000001';

        return view('facturas.create', compact('clientes', 'productos', 'numero'));
    }

    /**
     * Almacenar una nueva factura en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'numero' => 'required|string|unique:facturas',
            'fecha' => 'required|date',
            'fecha_vencimiento' => 'nullable|date',
            'estado' => 'required|in:pendiente,pagada,cancelada',
            'notas' => 'nullable|string',
            'producto_id' => 'required|array',
            'producto_id.*' => 'exists:productos,id',
            'cantidad' => 'required|array',
            'cantidad.*' => 'integer|min:1',
            'precio_unitario' => 'required|array',
            'precio_unitario.*' => 'numeric|min:0',
            'impuesto' => 'required|array',
            'impuesto.*' => 'numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Calculamos los totales
            $subtotal = 0;
            $impuestos = 0;

            for ($i = 0; $i < count($request->producto_id); $i++) {
                $cantidad = $request->cantidad[$i];
                $precio = $request->precio_unitario[$i];
                $impuesto = $request->impuesto[$i];

                $lineaSubtotal = $cantidad * $precio;
                $lineaImpuesto = $lineaSubtotal * ($impuesto / 100);

                $subtotal += $lineaSubtotal;
                $impuestos += $lineaImpuesto;
            }

            $total = $subtotal + $impuestos;

            // Crear la factura
            $factura = Factura::create([
                'cliente_id' => $request->cliente_id,
                'numero' => $request->numero,
                'fecha' => $request->fecha,
                'fecha_vencimiento' => $request->fecha_vencimiento,
                'subtotal' => $subtotal,
                'impuestos' => $impuestos,
                'total' => $total,
                'estado' => $request->estado,
                'notas' => $request->notas,
            ]);

            // Crear los detalles de la factura
            for ($i = 0; $i < count($request->producto_id); $i++) {
                $cantidad = $request->cantidad[$i];
                $precio = $request->precio_unitario[$i];
                $impuesto = $request->impuesto[$i];
                $lineaSubtotal = $cantidad * $precio;

                DetalleFactura::create([
                    'factura_id' => $factura->id,
                    'producto_id' => $request->producto_id[$i],
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precio,
                    'impuesto' => $impuesto,
                    'subtotal' => $lineaSubtotal,
                ]);

                // Actualizar stock del producto
                $producto = Producto::find($request->producto_id[$i]);
                $producto->stock -= $cantidad;
                $producto->save();
            }

            DB::commit();

            return redirect()->route('facturas.index')
                ->with('success', 'Factura creada con éxito.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al crear la factura: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Mostrar la factura especificada.
     */
    public function show(Factura $factura)
    {
        $factura->load('cliente', 'detalles.producto');
        return view('facturas.show', compact('factura'));
    }

    /**
     * Mostrar el formulario para editar la factura especificada.
     */
    public function edit(Factura $factura)
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        $factura->load('detalles.producto');

        return view('facturas.edit', compact('factura', 'clientes', 'productos'));
    }

    /**
     * Actualizar la factura especificada en la base de datos.
     */
    public function update(Request $request, Factura $factura)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => 'required|date',
            'fecha_vencimiento' => 'nullable|date',
            'estado' => 'required|in:pendiente,pagada,cancelada',
            'notas' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Actualizar la factura
            $factura->update([
                'cliente_id' => $request->cliente_id,
                'fecha' => $request->fecha,
                'fecha_vencimiento' => $request->fecha_vencimiento,
                'estado' => $request->estado,
                'notas' => $request->notas,
            ]);

            DB::commit();

            return redirect()->route('facturas.index')
                ->with('success', 'Factura actualizada con éxito.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al actualizar la factura: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Eliminar la factura especificada de la base de datos.
     */
    public function destroy(Factura $factura)
    {
        try {
            DB::beginTransaction();

            // Devolver productos al stock
            foreach ($factura->detalles as $detalle) {
                $producto = $detalle->producto;
                $producto->stock += $detalle->cantidad;
                $producto->save();
            }

            $factura->delete();
            DB::commit();

            return redirect()->route('facturas.index')
                ->with('success', 'Factura eliminada con éxito.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al eliminar la factura: ' . $e->getMessage());
        }
    }

    /**
     * Generar PDF de la factura.
     */
    public function generarPdf(Factura $factura)
    {
        $factura->load('cliente', 'detalles.producto');

        $pdf = PDF::loadView('facturas.pdf', compact('factura'));

        return $pdf->download('factura-' . $factura->numero . '.pdf');
    }
}
