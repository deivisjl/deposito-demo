<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
    protected $table = 'comprobante';

    protected $fillable = [
        'id',
        'nombre',
        'serie',
        'cantidad_numeros',
    ];
}
