<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cliente_id')->unsigned();
            $table->bigInteger('tipo_pago_id')->unsigned();
            $table->bigInteger('usuario_id')->unsigned();
            $table->bigInteger('comprobante_id')->unsigned();
            $table->string('no_factura')->unique();
            $table->bigInteger('correlativo')->unsigned();
            $table->date('fecha_factura')->default(Carbon::now()->format('Y-m-d'));
            $table->decimal('monto',7,2);
            $table->integer('anulada')->default(0);
            $table->foreign('cliente_id')->references('id')->on('cliente');
            $table->foreign('tipo_pago_id')->references('id')->on('tipo_pago');
            $table->foreign('comprobante_id')->references('id')->on('comprobante');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venta');
    }
}
