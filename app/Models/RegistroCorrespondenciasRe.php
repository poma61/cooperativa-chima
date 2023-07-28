<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroCorrespondenciasRe extends Model
{
    
    use HasFactory;
    protected $table="registro_correspondencias_recibidas";
    protected $fillable=[
     'num_reg',
     'fecha',
     'pestana_carpeta',
     'referencia',
     'entregado_por',
     'recibido_por',
     'cuenta',
     'descripcion_observacion',
     'fecha_de_respuesta',
     'descripcion',
     'archivo',
     'mime_type',
     'status',
     'id_usuario',
    ];
}
