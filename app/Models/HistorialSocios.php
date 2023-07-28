<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialSocios extends Model
{
    use HasFactory;
    protected $table = "historial_de_socio";
    protected $fillable = [
        'num_reg',
        'fecha',
        'descripcion',
        'tipo_de_documento',
        'archivo',
        'id_socio',
        'status',
    ];
}
