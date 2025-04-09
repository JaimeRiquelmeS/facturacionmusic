<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura #{{ $factura->numero }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.4;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }
        .logo {
            max-height: 100px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }
        .invoice-info {
            margin-bottom: 30px;
        }
        .invoice-info table {
            width: 100%;
        }
        .invoice-info td {
            padding: 5px;
            vertical-align: top;
        }
        .client-section {
            margin-bottom: 30px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .text-right {
            text-align: right;
        }
        .totals {
            width: 40%;
            margin-left: auto;
        }
        .totals table {
            width: 100%;
        }
        .totals td {
            padding: 5px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .estado-pendiente {
            color: #ff9800;
            font-weight: bold;
        }
        .estado-pagada {
            color: #4caf50;
            font-weight: bold;
        }
        .estado-cancelada {
            color: #f44336;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <!-- <img src="{{ asset('img/logo.png') }}" class="logo" alt="Logo"> -->
            <div class="title">FACTURA</div>
        </div>

        <div class="invoice-info">
            <table>
                <tr>
                    <td><strong>Factura Nº:</strong></td>
                    <td>{{ $factura->numero }}</td>
                    <td><strong>Estado:</strong></td>
                    <td>
                        @if($factura->estado == 'pendiente')
                            <span class="estado-pendiente">PENDIENTE</span>
                        @elseif($factura->estado == 'pagada')
                            <span class="estado-pagada">PAGADA</span>
                        @else
                            <span class="estado-cancelada">CANCELADA</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><strong>Fecha:</strong></td>
                    <td>{{ $factura->fecha->format('d/m/Y') }}</td>
                    <td><strong>Fecha Vencimiento:</strong></td>
                    <td>{{ $factura->fecha_vencimiento ? $factura->fecha_vencimiento->format('d/m/Y') : 'N/A' }}</td>
                </tr>
            </table>
        </div>

        <div class="client-section">
            <h3>Datos del Cliente</h3>
            <table>
                <tr>
                    <td><strong>Nombre:</strong></td>
                    <td>{{ $factura->cliente->nombre }}</td>
                </tr>
                <tr>
                    <td><strong>NIF:</strong></td>
                    <td>{{ $factura->cliente->nif ?: 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>Dirección:</strong></td>
                    <td>{{ $factura->cliente->direccion ?: 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>Email:</strong></td>
                    <td>{{ $factura->cliente->email ?: 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>Teléfono:</strong></td>
                    <td>{{ $factura->cliente->telefono ?: 'N/A' }}</td>
                </tr>
            </table>
        </div>

        <h3>Detalle de la Factura</h3>
        <table class="table">
            <thead>
                <tr>
                    <th width="10%">Cantidad</th>
                    <th width="40%">Descripción</th>
                    <th width="15%">Precio Unit.</th>
                    <th width="10%">IVA (%)</th>
                    <th width="15%">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($factura->detalles as $detalle)
                <tr>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>{{ $detalle->producto->nombre }}</td>
                    <td class="text-right">€{{ number_format($detalle->precio_unitario, 2) }}</td>
                    <td class="text-right">{{ $detalle->impuesto }}%</td>
                    <td class="text-right">€{{ number_format($detalle->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <table>
                <tr>
                    <td><strong>Subtotal:</strong></td>
                    <td class="text-right">€{{ number_format($factura->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Impuestos:</strong></td>
                    <td class="text-right">€{{ number_format($factura->impuestos, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Total:</strong></td>
                    <td class="text-right"><strong>€{{ number_format($factura->total, 2) }}</strong></td>
                </tr>
            </table>
        </div>

        @if($factura->notas)
        <div class="notes">
            <h3>Notas</h3>
            <p>{{ $factura->notas }}</p>
        </div>
        @endif

        <div class="footer">
            <p>Gracias por su confianza. Esta factura es válida sin firma ni sello.</p>
            <p>Sistema de Facturación - Generado el {{ date('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
