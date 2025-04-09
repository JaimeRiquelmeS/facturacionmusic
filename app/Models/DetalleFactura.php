<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleFactura extends Model
{
    use HasFactory;

    protected $table = 'detalles_factura';

    protected $fillable = [
        'factura_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'impuesto',
        'subtotal',
    ];

    protected $casts = [
        'cantidad' => 'integer',
        'precio_unitario' => 'decimal:2',
        'impuesto' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Obtener la factura asociada con este detalle.
     */
    public function factura()
    {
        return $this->belongsTo(Factura::class);
    }

    /**
     * Obtener el producto asociado con este detalle.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
