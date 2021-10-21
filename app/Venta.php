<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'venta';

    protected $fillable = [
        'id','cliente_id','usuario_id','tipo_pago_id','comprobante_id','no_factura','correlativo','fecha_factura','monto','anulada',
    ];

    public function detalle_venta()
    {
        return $this->hasMany(DetalleVenta::class);
    }

    public function tipo_pago()
    {
        return $this->belongsTo(TipoPago::class);
    }

    public function comprobante()
    {
        return $this->belongsTo(Comprobante::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
