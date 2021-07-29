<?php

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
        User::create([
            'nombres' => 'Hely',
            'apellidos' => 'Solares',
            'dpi' => '2563450560608',
            'telefono' => '45236541',
            'direccion' => 'Chiquimulilla',
            'email' => 'hely@gmail.com',
            'password' => bcrypt('12345'),
        ]);
    }
}
