<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventario', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->bigInteger('producto_id')->unsigned();
            $table->integer('cantidad_total');
            $table->decimal('precio_promedio');
            $table->bigInteger('tipo_operacion_id')->unsigned()->nullable();
            $table->integer('cantidad');
            $table->decimal('precio');
            $table->foreign('producto_id')->references('id')->on('producto');
            $table->foreign('tipo_operacion_id')->references('id')->on('tipo_operacion');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE inventario ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventario');
    }
}
