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
        Schema::create('registro_comisiones_informes', function (Blueprint $table) {
            $table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
            $table->id();
            $table->string('num_reg', 50);
            $table->date('fecha_recibida');
            $table->string('referencia', 620);
            $table->string('entregado_por');
            $table->string('cargo');
            $table->date('fecha_de_la_comision');
            $table->longText('descripcion');
            $table->longBinary('archivo');
            $table->string('mime_type', 100);
            $table->boolean('status');
            $table->BigInteger('id_usuario')->unsigned();
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
        Schema::dropIfExists('registro_comisiones_informes');
    }
};
