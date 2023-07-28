<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarioDocStrioGeneral extends Model
{
    use HasFactory;
    protected $table = 'inventario_doc_strio_general';
    protected $fillable = [
        'num_reg',
        'detalle',
        'cantidad',
        'rubro',
        'observacion',
        'archivo',
        'mime_type',
        'status',
        'id_usuario',
    ];

}
