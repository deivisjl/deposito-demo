<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoOperacion extends Model
{
    const COMPRA = '1';
    const VENTA = '2';
    const DEVOLUCION_COMPRA = '3';
    const DEVOLUCION_VENTA = '4';

    protected $table = 'tipo_operacion';

    protected $fillable = [
        'id','nombre'
    ];
}
