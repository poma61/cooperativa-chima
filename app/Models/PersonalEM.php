<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalEM extends Model
{
    use HasFactory;

    protected $table = "personal_em";
    protected $fillable = [
        'num_empleado',
        'estado_del_empleado',
        'imagen',
        'nombres',
        'apellidos',
        'ci',
        'ci_valido',
        'fecha_de_nacimiento',
        'lugar_de_nacimiento',
        'profesion_ocupacion',
        'estado_civil',
        'sexo',
        'licencia_de_conducir',
        'licencia_de_conducir_valido',
        'celular',
        'lugar_de_trabajo',
        'fecha_de_ingreso',
        'cargo_a_desarrollar',
        'haber_basico',
        'divisa',
        'ultima_vacacion',
        'fecha_de_retiro',
        'estado_de_retiro',
        'observacion',
        'id_usuario',
        'status',
    ];
}
