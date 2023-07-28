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
        Schema::create('personal_ep', function (Blueprint $table) {
            $table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
            $table->id();
            $table->string('num_empleado', 50);
            $table->string('estado_del_empleado');
            $table->longBinary('imagen');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('ci')->unique();
            $table->date('ci_valido');
            $table->date('fecha_de_nacimiento');
            $table->string('lugar_de_nacimiento');
            $table->string('profesion_ocupacion');
            $table->string('estado_civil');
            $table->string('sexo', 50);
            $table->string('licencia_de_conducir');
            $table->date('licencia_de_conducir_valido');
            $table->string('celular',50);
            $table->string('lugar_de_trabajo');
            $table->date('fecha_de_ingreso');
            $table->string('cargo_a_desarrollar');
            $table->double('sueldo_asignado', 20, 2);
            $table->string('divisa',100);
            $table->string('ultima_vacacion');
            $table->date('fecha_de_retiro')->nullable();
            $table->string('estado_de_retiro');
            $table->longText('observacion');
            $table->unsignedBigInteger('id_usuario');
            $table->boolean('status');
            $table->timestamps();
            $table->foreign('id_usuario')->references('id')->on('users');
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_ep');
    }
};
