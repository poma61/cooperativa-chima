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
        Schema::create('salida_almacen', function (Blueprint $table) {

            $table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
            $table->id();
            $table->string('num_reg', 50);
            $table->bigInteger('cantidad');
            $table->string('um'); 
            $table->string('codigo');
            $table->string('nombre_del_articulo');
            $table->string('referencia', 620);
            $table->string('destino_sector');
            $table->string('entregado_por');
            $table->string('autorizado_por');
            $table->string('interesado');
            $table->longBinary('firma'); //firma en formato imagen
            $table->string('mime_type_firma');

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
        Schema::dropIfExists('salida_almacen');
    }
};
