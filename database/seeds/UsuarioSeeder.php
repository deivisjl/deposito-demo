<?php

use App\Rol;
use App\User;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rol1 = Rol::create(['nombre'=>'Administrador']);
        $rol2 = Rol::create(['nombre'=>'Digitador']);

        User::create([
            'nombres' => 'Hely',
            'apellidos' => 'Solares',
            'dpi' => '2563450560608',
            'telefono' => '45236541',
            'direccion' => 'Chiquimulilla',
            'email' => 'hely@gmail.com',
            'password' => bcrypt('12345'),
            'rol_id'=> $rol1->id,
        ]);
    }
}
