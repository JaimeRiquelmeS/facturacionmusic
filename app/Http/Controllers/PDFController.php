<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Response;

class PDFController extends Controller
{
    /**
     * Generar PDF de una factura
     */
    public function generarFacturaPDF(Factura $factura)
    {
        $factura->load('cliente', 'detalles.producto');

        // Opciones de DomPDF
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->setIsRemoteEnabled(true);

        // Instanciar DomPDF
        $dompdf = new Dompdf($options);

        // Cargar la vista HTML
        $html = view('facturas.pdf', compact('factura'))->render();

        // Cargar contenido HTML en DomPDF
        $dompdf->loadHtml($html);

        // Establecer tamaño de papel y orientación
        $dompdf->setPaper('A4', 'portrait');

        // Renderizar PDF
        $dompdf->render();

        // Nombre del archivo
        $filename = 'factura-' . $factura->numero . '.pdf';

        // Descargar PDF
        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
