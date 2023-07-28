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
        Schema::create('historial_personal_em', function (Blueprint $table) {
            $table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
            $table->id();
            $table->string('num_reg');
            $table->date('fecha');
            $table->longText('descripcion');
            $table->string('estado');
            $table->string('mes');
            $table->string('dias');
            $table->longBinary('archivo');
            $table->string('mime_type',100);
            $table->unsignedBigInteger('id_personal_em');
            $table->boolean('status');
            $table->timestamps();
            $table->foreign('id_personal_em')->references('id')->on('personal_em');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historial_personal_em');
    }
};
