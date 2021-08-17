<?php

use App\Categoria;
use App\Comprobante;
use App\TipoOperacion;
use App\TipoPago;
use Illuminate\Database\Seeder;

class TipoOperacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoOperacion::create([
            'id' => TipoOperacion::REGISTRO,
            'nombre' => 'Registro'
        ]);

        TipoOperacion::create([
            'id' => TipoOperacion::COMPRA,
            'nombre' => 'Compra'
        ]);

        TipoOperacion::create([
            'id' => TipoOperacion::VENTA,
            'nombre' => 'Venta'
        ]);

        TipoOperacion::create([
            'id' => TipoOperacion::DEVOLUCION_COMPRA,
            'nombre' => 'Devolución compra'
        ]);

        TipoOperacion::create([
            'id' => TipoOperacion::DEVOLUCION_VENTA,
            'nombre' => 'Devolución venta'
        ]);

        Categoria::create([
            'nombre' => 'Granos básicos'
        ]);

        Categoria::create([
            'nombre' => 'Concentrados'
        ]);

        Comprobante::create([
            'nombre' => 'Ticket',
            'serie' => 'T01',
            'cantidad_numeros' => 5
        ]);

        Comprobante::create([
            'nombre' => 'Factura',
            'serie' => 'F01',
            'cantidad_numeros' => 5
        ]);

        TipoPago::create([
            'nombre'=> 'Efectivo'
        ]);

        TipoPago::create([
            'nombre'=>'Tarjeta de débito'
        ]);

        TipoPago::create([
            'nombre'=>'Tarjeta de crédito'
        ]);


    }
}
