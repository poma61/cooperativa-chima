<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaltasSociosAsAcontecimientos extends Model
{
    use HasFactory;
    protected $table="faltas_socios_as_acontecimientos";

    protected $fillable=[
     'fecha',
     'acontecimiento',
     'id_socio',
     'sancion_grm',
     'sancion_bs',
     'observacion',
     'status',
     'id_usuario',
    ];

    
}
