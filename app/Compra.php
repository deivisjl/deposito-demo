<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compra';

    protected $fillable = [
        'id',
        'proveedor_id',
        'tipo_pago_id',
        'no_comprobante',
        'monto',
        'anulada',
        'usuario_id',
        'fecha_comprobante'
    ];

    public function detalle_compra()
    {
        return $this->hasMany(DetalleCompra::class);
    }

    public function tipo_pago()
    {
        return $this->belongsTo(TipoPago::class);
    }
}
