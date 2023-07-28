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
        Schema::create('registro_correspondencias_recibidas', function (Blueprint $table) {
            $table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
            $table->id();
            $table->string('num_reg',50);
            $table->date('fecha');
            $table->string('pestana_carpeta');
            $table->string('referencia',600);
            $table->string('entregado_por');
            $table->string('recibido_por');
            $table->string('cuenta');
            $table->longText('descripcion_observacion');
            $table->date('fecha_de_respuesta');
            $table->longText('descripcion');
            $table->longBinary('archivo');
            $table->string('mime_type',100);
            $table->boolean('status');
            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')->references('id')->on('users');
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
        Schema::dropIfExists('registro_correspondencias_recibidas');
    }
};
