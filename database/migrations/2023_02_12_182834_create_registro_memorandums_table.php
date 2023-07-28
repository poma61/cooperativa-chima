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
        Schema::create('registro_memorandums', function (Blueprint $table) {
            $table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
            $table->id();
            $table->string('num_reg',50);
            $table->date('fecha_emitida');
            $table->string('referencia',600);
            $table->string('entregado_a');
            $table->string('cargo');
            $table->double('sancion_gr',20,2);
            $table->double('sancion_bs',20,2);
            $table->longText('descripcion');
            $table->date('fecha_recibida');
            $table->longText('observacion');
            $table->longBinary('archivo');
            $table->string('mime_type',100);
            $table->boolean('status');
            $table->unsignedBigInteger('id_usuario');
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
        Schema::dropIfExists('registro_memorandums');
    }
};
