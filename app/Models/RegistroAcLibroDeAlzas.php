<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroAcLibroDeAlzas extends Model
{
    use HasFactory;
    protected $table = 'actas_libro_de_alzas';
    protected $fillable = [
        'num_reg',
        'fecha_emitida',
        'referencia',
        'descripcion',
        'alza_de',
        'peso_oro_fisico',
        'simbolo',
        'archivo',
        'mime_type',
        'status',
        'id_usuario',
    ];
}
