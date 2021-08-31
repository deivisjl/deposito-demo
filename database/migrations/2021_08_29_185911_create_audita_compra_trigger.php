<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditaCompraTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE OR REPLACE FUNCTION audita_compra_function() RETURNS TRIGGER
                AS $audita_compra_trigger$
                declare
                    tipo_operacion integer:=2;
                    tmp_cantidad integer:=0;
                    tmp_precio numeric(8,2):=0;
                    promedio numeric(8,2):=0;
                    BEGIN
                        SELECT cantidad_total, precio_promedio INTO tmp_cantidad, tmp_precio FROM inventario where id = (SELECT MAX(id) from inventario WHERE producto_id = NEW.producto_id);

                            IF tmp_precio > 0 AND tmp_cantidad > 0 THEN
                                promedio := ((tmp_cantidad * tmp_precio)+(NEW.cantidad * NEW.precio_unitario))/(tmp_cantidad + NEW.cantidad);

                                INSERT INTO inventario (producto_id,cantidad_total,precio_promedio,tipo_operacion_id,cantidad,precio,created_at,updated_at)
                                VALUES (NEW.producto_id, (tmp_cantidad + NEW.cantidad), promedio, tipo_operacion, NEW.cantidad, NEW.precio_unitario, now(), null);

                                UPDATE producto SET precio_promedio = promedio,  stock = (tmp_cantidad + NEW.cantidad) WHERE id = NEW.producto_id;
                            ELSE
                                INSERT INTO inventario (producto_id,cantidad_total,precio_promedio,tipo_operacion_id,cantidad,precio,created_at,updated_at)
                                VALUES (NEW.producto_id, NEW.cantidad, NEW.precio_unitario, tipo_operacion, NEW.cantidad, NEW.precio_unitario, now(), null);

                                UPDATE producto SET precio_promedio = NEW.precio_unitario, stock = NEW.cantidad  WHERE id = NEW.producto_id;
                            END IF;
                        RETURN NEW;
                    END;
            $audita_compra_trigger$
            Language plpgsql
        ');

        DB::unprepared('
            CREATE TRIGGER audita_compra_trigger
            AFTER INSERT ON detalle_compra FOR EACH ROW
            EXECUTE PROCEDURE audita_compra_function();
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared(' DROP TRIGGER audita_compra_trigger on detalle_compra');
        DB::unprepared('  DROP FUNCTION audita_compra_function');
    }
}
