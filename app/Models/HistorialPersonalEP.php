<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialPersonalEP extends Model
{
    use HasFactory;
    protected $table="historial_personal_ep";
    protected $fillable=[
       'fecha',
       'descripcion',
       'estado',
       'mes',
       'dias',
       'archivo',
       'id_personal_ep',
       'status',
    ];
}
