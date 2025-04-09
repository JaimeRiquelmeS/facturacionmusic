<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'codigo',
    ];

    /**
     * Obtener los detalles de factura relacionados con este producto.
     */
    public function detallesFactura()
    {
        return $this->hasMany(DetalleFactura::class);
    }
}
