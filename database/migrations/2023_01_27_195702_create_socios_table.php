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
        Schema::create('socios', function (Blueprint $table) {
            $table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
            $table->id();
            $table->string('num_item',50);
            $table->string('estado_del_asociado');
            $table->longBinary('imagen');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('ci')->unique();
            $table->date('ci_valido');
            $table->date('fecha_de_nacimiento');
            $table->string('lugar_de_nacimiento');
            $table->string('estado_civil');
            $table->string('sexo');
            $table->string('celular',50);
            $table->string('punta_de_trabajo');
            $table->string('grupo');
            $table->date('fecha_de_transferencia');
            $table->string('susecion_de_derecho');
            $table->string('transfiriente_cc');
            $table->string('parentesco');
            $table->longText('observacion');
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
        Schema::dropIfExists('socios');
    }
};
