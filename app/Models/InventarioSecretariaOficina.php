<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarioSecretariaOficina extends Model
{
    use HasFactory;

    protected $table = 'inventario_secretaria_oficina';
    protected $fillable = [
        'num_reg',
        'detalle',
        'cantidad',
        'estado',
        'observacion',
        'archivo',
        'mime_type',
        'status',
        'id_usuario',
    ];

}
