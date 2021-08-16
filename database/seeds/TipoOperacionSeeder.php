<?php

use App\TipoOperacion;
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
    }
}
