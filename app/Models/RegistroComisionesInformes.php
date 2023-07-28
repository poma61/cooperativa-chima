<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroComisionesInformes extends Model
{
    use HasFactory;

    protected $table="registro_comisiones_informes";

    protected $fillable=[
        'num_reg',
        'fecha_recibida' ,
        'referencia' ,
        'entregado_por' ,
        'cargo' ,
        'fecha_de_la_comision',
        'descripcion' ,
        'archivo' ,
        'mime_type',
        'status',
        'id_usuario',
    ];
}
