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
        Schema::create('ingreso_almacen', function (Blueprint $table) {
            $table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
            $table->id();
            $table->string('num_reg',50);
            $table->bigInteger('n_de_documento');
            $table->bigInteger('cantidad');
            $table->string('um');
            $table->double('costo_unitario',20,2);
            $table->string('divisa_costo_unitario',200);
            $table->double('total',20,2);//total del costo unitario
            $table->string('divisa_total',200);
            $table->longText('descripcion');
            $table->string('codigo');
            $table->string('marca');
            $table->string('proveedor');
            $table->string('entregado_por');


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
        Schema::dropIfExists('ingreso_almacen');
    }
};
