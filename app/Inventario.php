<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventario';

    protected $fillable = [
        'id',
        'producto_id',
        'cantidad_total',
        'precio_promedio',
        'tipo_operacion_id',
        'cantidad',
        'precio',
        'producto_id',
        'tipo_operacion_id',
    ];
}
