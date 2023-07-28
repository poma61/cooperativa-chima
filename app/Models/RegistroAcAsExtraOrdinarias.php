<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroAcAsExtraOrdinarias extends Model
{
    use HasFactory;
    protected $table = 'actas_asambleas_extra_ordinarias';
    protected $fillable = [
        'num_reg',
        'fecha_emitida',
        'referencia',
        'descripcion',
        'institucion',
        'observacion',
        'archivo',
        'mime_type',
        'status',
        'id_usuario',
    ];
    
}
