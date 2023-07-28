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
        Schema::create('historial_de_socio', function (Blueprint $table) {
            $table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
            $table->id();
            $table->string('num_reg',50);
            $table->date('fecha');
            $table->longText('descripcion');
            $table->string('tipo_de_documento');
            $table->longBinary('archivo');
            $table->string('mime_type',100);
            $table->unsignedBigInteger('id_socio');
            $table->boolean('status'); 
            $table->timestamps();
            $table->foreign('id_socio')->references('id')->on('socios');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historial_de_socio');
    }
};
