<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoOperacion extends Model
{
    const REGISTRO = '1';
    const COMPRA = '2';
    const VENTA = '3';
    const DEVOLUCION_COMPRA = '4';
    const DEVOLUCION_VENTA = '5';

    protected $table = 'tipo_operacion';

    protected $fillable = [
        'id','nombre'
    ];
}
