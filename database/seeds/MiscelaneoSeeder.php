<?php

use App\Cliente;
use App\Producto;
use App\Proveedor;
use Illuminate\Database\Seeder;

class MiscelaneoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Proveedor::create([
            'nombre' => 'Hely Solares',
            'nit' => '9053066-7',
            'telefono'=> 41118716,
            'direccion' =>'Barrio Champote, Chiquimulilla, Santa Rosa',
        ]);

        Producto::create([
            'nombre' => 'Ajonjolí',
            'categoria_id' => 1,
            'stock_minimo' => 1,
            'stock_maximo' => 100,
            'porcentaje_ganancia' =>10,
            'stock' => 0,
            'precio_promedio' =>0
        ]);

        Producto::create([
            'nombre' => 'Arroz',
            'categoria_id' => 1,
            'stock_minimo' => 1,
            'stock_maximo' => 100,
            'porcentaje_ganancia' =>10,
            'stock' => 0,
            'precio_promedio' =>0
        ]);

        Producto::create([
            'nombre' => 'Frijol',
            'categoria_id' => 1,
            'stock_minimo' => 1,
            'stock_maximo' => 100,
            'porcentaje_ganancia' =>10,
            'stock' => 0,
            'precio_promedio' =>0
        ]);

        Producto::create([
            'nombre' => 'Maicillo',
            'categoria_id' => 1,
            'stock_minimo' => 1,
            'stock_maximo' => 100,
            'porcentaje_ganancia' =>10,
            'stock' => 0,
            'precio_promedio' =>0
        ]);

        Producto::create([
            'nombre' => 'Maíz',
            'categoria_id' => 1,
            'stock_minimo' => 1,
            'stock_maximo' => 100,
            'porcentaje_ganancia' =>10,
            'stock' => 0,
            'precio_promedio' =>0
        ]);

        Producto::create([
            'nombre' => 'Cat Chow',
            'categoria_id' => 2,
            'stock_minimo' => 5,
            'stock_maximo' => 20,
            'porcentaje_ganancia' =>20,
            'stock' => 0,
            'precio_promedio' =>0
        ]);

        Producto::create([
            'nombre' => 'Desarrollina Cerdos',
            'categoria_id' => 2,
            'stock_minimo' => 5,
            'stock_maximo' => 20,
            'porcentaje_ganancia' =>20,
            'stock' => 0,
            'precio_promedio' =>0
        ]);

        Producto::create([
            'nombre' => 'Dog Chow',
            'categoria_id' => 2,
            'stock_minimo' => 5,
            'stock_maximo' => 20,
            'porcentaje_ganancia' =>20,
            'stock' => 0,
            'precio_promedio' =>0
        ]);

        Producto::create([
            'nombre' => 'Master Pollito',
            'categoria_id' => 2,
            'stock_minimo' => 5,
            'stock_maximo' => 20,
            'porcentaje_ganancia' =>20,
            'stock' => 0,
            'precio_promedio' =>0
        ]);

        Producto::create([
            'nombre' => 'Pollo Engorde',
            'categoria_id' => 2,
            'stock_minimo' => 5,
            'stock_maximo' => 20,
            'porcentaje_ganancia' =>20,
            'stock' => 0,
            'precio_promedio' =>0
        ]);

        Cliente::create([
            'nombres'=>'Consumidor',
            'apellidos'=> 'Final',
            'nit'=>'C/F',
            'direccion'=>'Ciudad'
        ]);
    }
}
