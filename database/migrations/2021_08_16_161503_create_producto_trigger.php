<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateProductoTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE OR REPLACE FUNCTION registro_producto_function() RETURNS TRIGGER
                AS $registro_producto_trigger$
                    BEGIN
                        INSERT INTO inventario (producto_id,cantidad_total,precio_promedio,tipo_operacion_id,cantidad,precio,created_at,updated_at)
                            VALUES (NEW.id, 0, 0, 1, 0, 0, now(), null);
                        RETURN NEW;
                    END;
            $registro_producto_trigger$
            Language plpgsql
        ');

        DB::unprepared('
            CREATE TRIGGER registro_producto_trigger
            AFTER INSERT ON producto FOR EACH ROW
            EXECUTE PROCEDURE registro_producto_function();
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared(' DROP TRIGGER registro_producto_trigger on producto');
        DB::unprepared('  DROP FUNCTION registro_producto_function');
    }
}
