<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Factura;
use App\Models\Producto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Mostrar el dashboard con estadísticas.
     */
    public function index()
    {
        // Estadísticas generales
        $totalClientes = Cliente::count();
        $totalProductos = Producto::count();
        $totalFacturas = Factura::count();
        $facturasPendientes = Factura::where('estado', 'pendiente')->count();
        $facturasPagadas = Factura::where('estado', 'pagada')->count();
        $facturasCanceladas = Factura::where('estado', 'cancelada')->count();

        // Total de ingresos
        $totalIngresos = Factura::where('estado', 'pagada')->sum('total');

        // Productos con bajo stock (menos de 10 unidades)
        $productosBajoStock = Producto::where('stock', '<', 10)->count();

        // Facturas por mes para el gráfico
        $facturasPorMes = Factura::select(
            DB::raw("strftime('%m', fecha) as mes"),
            DB::raw("strftime('%Y', fecha) as anio"),
            DB::raw('COUNT(*) as total')
        )
        ->whereRaw("strftime('%Y', fecha) = ?", [Carbon::now()->year])
        ->groupBy('mes', 'anio')
        ->orderBy('anio')
        ->orderBy('mes')
        ->get();

        // Formateamos los datos para el gráfico
        $meses = [];
        $totalFacturasPorMes = [];

        foreach ($facturasPorMes as $factura) {
            $fecha = Carbon::createFromDate($factura->anio, (int)$factura->mes, 1);
            $meses[] = $fecha->translatedFormat('F');
            $totalFacturasPorMes[] = $factura->total;
        }

        // Top 5 productos más vendidos
        $productosPopulares = DB::table('detalles_factura')
            ->select('productos.nombre', DB::raw('SUM(detalles_factura.cantidad) as cantidad_vendida'))
            ->join('productos', 'detalles_factura.producto_id', '=', 'productos.id')
            ->groupBy('productos.nombre')
            ->orderBy('cantidad_vendida', 'desc')
            ->limit(5)
            ->get();

        // Top 5 clientes que más compran
        $clientesTop = DB::table('facturas')
            ->select('clientes.nombre', DB::raw('COUNT(facturas.id) as total_facturas'), DB::raw('SUM(facturas.total) as total_gastado'))
            ->join('clientes', 'facturas.cliente_id', '=', 'clientes.id')
            ->where('facturas.estado', 'pagada')
            ->groupBy('clientes.nombre')
            ->orderBy('total_gastado', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalClientes',
            'totalProductos',
            'totalFacturas',
            'facturasPendientes',
            'facturasPagadas',
            'facturasCanceladas',
            'totalIngresos',
            'productosBajoStock',
            'meses',
            'totalFacturasPorMes',
            'productosPopulares',
            'clientesTop'
        ));
    }
}
