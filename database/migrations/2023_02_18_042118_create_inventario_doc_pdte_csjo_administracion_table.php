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
        Schema::create('inventario_doc_pdte_csjo_administracion', function (Blueprint $table) {
            $table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
            $table->id();
            $table->string('num_reg',50);
            $table->string('detalle',620);
            $table->bigInteger('cantidad');
            $table->string('rubro');
            $table->longText('observacion');
            $table->longBinary('archivo');
            $table->string('mime_type',100);
            $table->bigInteger('id_usuario')->unsigned();
            $table->boolean('status');
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
        Schema::dropIfExists('inventario_doc_pdte_csjo_administracion');
    }
};
