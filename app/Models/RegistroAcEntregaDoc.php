<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroAcEntregaDoc extends Model
{
    use HasFactory;


    protected $table = 'actas_entrega_documentacion';
    protected $fillable = [
        'num_reg',
        'fecha_emitida',
        'referencia',
        'descripcion',
        'institucion_responsable',
        'observacion',
        'archivo',
        'mime_type',
        'status',
        'id_usuario',
    ];

}
