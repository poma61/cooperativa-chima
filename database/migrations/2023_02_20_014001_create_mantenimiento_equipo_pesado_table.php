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
        Schema::create('mantenimiento_equipo_pesado', function (Blueprint $table) {
            $table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
            $table->id();
            $table->bigInteger('id_equipo_pesado')->unsigned();
            $table->string('num_reg');
            $table->date('fecha_de_ingreso');
            $table->longText('caracteristicas');
            $table->longText('desarrollo');
            $table->string('material_ocupado',620);
            $table->string('mantenimiento_preventivo',620);
            $table->string('mantenimiento_correctivo',620);
            $table->date('fecha_de_salida');
            $table->longText('observacion');
        

            $table->boolean('status');
            $table->timestamps();

            $table->foreign('id_equipo_pesado')->references('id')->on('equipo_pesado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mantenimiento_equipo_pesado');
    }
};
