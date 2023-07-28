<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroMemorandums extends Model
{
    use HasFactory;
    protected $table="registro_memorandums";


    protected $fillable=[
        'num_reg',
        'fecha_emitida' ,
        'referencia' ,
        'entregado_a' ,
        'cargo' ,
        'sancion_gr',
        'sancion_bs',
        'descripcion' ,
        'fecha_recibida',
        'observacion' ,
        'archivo' ,
        'mime_type',
        'status',
        'id_usuario',
    ];

    
}
