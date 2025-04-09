<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PDFController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Clientes
Route::resource('clientes', ClienteController::class);

// Productos
Route::resource('productos', ProductoController::class);

// Facturas
Route::resource('facturas', FacturaController::class);
Route::get('facturas/{factura}/pdf', [PDFController::class, 'generarFacturaPDF'])->name('facturas.pdf');

// Ruta de prueba para PDF sin dependencias
Route::get('/pdf-test', function() {
    $dompdf = new \Dompdf\Dompdf();
    $html = '<h1>Prueba de PDF</h1><p>Esta es una prueba de generación de PDF sin usar el provider.</p>';
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    return response($dompdf->output(), 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="test.pdf"'
    ]);
});
