<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipo_pesado', function (Blueprint $table) {
            $table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
            $table->id();

            //datos generales
            $table->string('nombre_comun_del_equipo');
            $table->string('codigo_de_inventario_interno');
            //datos de origen
            $table->string('fabricante');
            $table->string('ano_vencimiento_de_garantia', 200);
            $table->string('ano_de_fabricacion', 200);
            $table->string('pais_de_origen');
            $table->string('modelo');
            $table->string('numero_de_serie');
            $table->string('ano_de_compra', 200);
            //datos de uso en planta
            $table->string('ano_de_alta_planta', 200);
            $table->string('estado_del_equipo_al_momento_de_alta');
            $table->string('horometro_al_inicio_operacion_planta');
            $table->string('linea_de_produccion_asignada');
            $table->string('ubicacion');
            //registro fotografico
            $table->longBinary('archivo');
            $table->string('mime_type_archivo', 100);
            //datos tecnico
            $table->string('potencia_und');
            $table->string('potencia_valor_nominal');
            $table->longText('potencia_caracteristicas');

            $table->string('voltaje_und');
            $table->string('voltaje_valor_nominal');
            $table->longText('voltaje_caracteristicas');

            $table->string('corriente_und');
            $table->string('corriente_valor_nominal');
            $table->longText('corriente_caracteristicas');

            $table->string('capacidad_de_cucharon_und');
            $table->string('capacidad_de_cucharon_valor_nominal');
            $table->longText('capacidad_de_cucharon_caracteristicas');

            $table->string('capacidad_de_diesel_und');
            $table->string('capacidad_de_diesel_valor_nominal');
            $table->longText('capacidad_de_diesel_caracteristicas');

            $table->string('otros_und');
            $table->string('otros_valor_nominal');
            $table->longText('otros_caracteristicas');

            //disponibilidad de informacion de soporte tecnico
            $table->string('manuales_impresos');
            $table->longBinary('manuales_digitales');
            $table->string('mime_type_manuales_digitales',100);
            $table->longText('otros_manuales');

            $table->string('planos_mecanicos_digitales'); //este campo no especifica si es archivo
            $table->longBinary('planos_electricos_digitales');
            $table->string('mime_type_planos_electricos_digitales',100);
            $table->longText('otros_planos');

          
            $table->boolean('status');
            $table->bigInteger('id_usuario')->unsigned();
            $table->timestamps();
            $table->foreign('id_usuario')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipo_pesado');
    }
};
