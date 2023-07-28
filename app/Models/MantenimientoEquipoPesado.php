<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MantenimientoEquipoPesado extends Model
{
    use HasFactory;
    protected $table = "mantenimiento_equipo_pesado";

    protected $fillable = [
        'id_equipo_pesado',
        'num_reg',
        'fecha_de_ingreso',
        'caracteristicas',
        'desarrollo',
        'material_ocupado',
        'mantenimiento_preventivo',
        'mantenimiento_correctivo',
        'fecha_de_salida',
        'observacion',
        'status',
    
    ];
}
