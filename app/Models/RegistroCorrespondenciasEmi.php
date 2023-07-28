<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroCorrespondenciasEmi extends Model
{
  
    use HasFactory;
    protected $table="registro_correspondencias_emitidas";

    protected $fillable=[
        'num_reg',
        'fecha_emitida' ,
        'referencia' ,
        'entregado_a' ,
        'cargo' ,
        'fecha_recibida',
        'observacion' ,
        'fecha_de_respuesta',
        'descripcion' ,
        'archivo' ,
        'mime_type',
        'status',
        'id_usuario',
    ];
}
