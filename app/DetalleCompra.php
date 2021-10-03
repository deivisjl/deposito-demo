<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    protected $table = 'detalle_compra';

    protected $fillable = [
        'id',
        'producto_id',
        'compra_id',
        'cantidad',
        'precio_unitario',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
