<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'numero',
        'fecha',
        'fecha_vencimiento',
        'subtotal',
        'impuestos',
        'total',
        'estado',
        'notas',
    ];

    protected $casts = [
        'fecha' => 'date',
        'fecha_vencimiento' => 'date',
        'subtotal' => 'decimal:2',
        'impuestos' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * Obtener el cliente asociado con la factura.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Obtener los detalles de la factura.
     */
    public function detalles()
    {
        return $this->hasMany(DetalleFactura::class);
    }
}
