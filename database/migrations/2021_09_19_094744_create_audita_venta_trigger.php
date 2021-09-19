<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditaVentaTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE OR REPLACE FUNCTION audita_venta_function() RETURNS TRIGGER
                AS $audita_venta_trigger$
                declare
                    tipo_operacion integer:=3;
                    tmp_cantidad integer:=0;
                    tmp_precio numeric(8,2):=0;
                    promedio numeric(8,2):=0;
                    custom_error varchar(50):="El stock es menor a la venta";
                    BEGIN
                        SELECT cantidad_total, precio_promedio INTO tmp_cantidad, tmp_precio FROM inventario where id = (SELECT MAX(id) from inventario WHERE producto_id = NEW.producto_id);

                            IF tmp_cantidad >= NEW.cantidad THEN
                                promedio := tmp_precio;

                                INSERT INTO inventario (producto_id,cantidad_total,precio_promedio,tipo_operacion_id,cantidad,precio,created_at,updated_at)
                                VALUES (NEW.producto_id, (tmp_cantidad - NEW.cantidad), promedio, tipo_operacion, NEW.cantidad, NEW.precio_unitario, now(), null);

                                UPDATE producto SET precio_promedio = promedio,  stock = (tmp_cantidad - NEW.cantidad) WHERE id = NEW.producto_id;
                            END IF;
                        RETURN NEW;
                    END;
            $audita_venta_trigger$
            Language plpgsql
        ');

        DB::unprepared('
            CREATE TRIGGER audita_venta_trigger
            AFTER INSERT ON detalle_venta FOR EACH ROW
            EXECUTE PROCEDURE audita_venta_function();
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared(' DROP TRIGGER audita_venta_trigger on detalle_venta');
        DB::unprepared('  DROP FUNCTION audita_venta_function');
    }
}
