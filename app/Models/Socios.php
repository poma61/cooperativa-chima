<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Socios extends Model
{
    use HasFactory;
    
    protected $table = "socios";
    protected $fillable = [
        'num_item' ,
        'estado_del_asociado' ,
        'imagen' ,
        'nombres' ,
        'apellidos' ,
        'ci',
        'ci_valido' ,
        'fecha_de_nacimiento' ,
        'lugar_de_nacimiento' ,
        'estado_civil' ,
        'sexo'  ,
        'celular' ,

        'punta_de_trabajo' ,
        'grupo' ,
        'fecha_de_transferencia',
        'susecion_de_derecho' ,
        'transfiriente_cc',
        'parentesco' ,
        'observacion',
        'status',
        'id_usuario',
    ];
   
}
