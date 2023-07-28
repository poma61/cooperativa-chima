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
        Schema::create('faltas_socios_as_acontecimientos', function (Blueprint $table) {
            $table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
            $table->id();
            $table->date('fecha');
            $table->string('acontecimiento',720);
            $table->bigInteger('id_socio')->unsigned();
            $table->double('sancion_grm',20,2);
            $table->double('sancion_bs',20,2);
            $table->longText('observacion');
            $table->bigInteger('id_usuario')->unsigned();
            $table->boolean('status');
            $table->timestamps();
             
            $table->foreign('id_socio')->references('id')->on('socios');
            $table->foreign('id_usuario')->references('id')->on('users');
            
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faltas_socios_as_acontecimientos');
    }
};
