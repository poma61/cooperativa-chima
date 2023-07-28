<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalidaAlmacen extends Model
{
    use HasFactory;
    protected $table = "salida_almacen";

    protected $fillable = [
        'num_reg',
        'cantidad',
        'um',
        'codigo',
        'nombre_del_articulo',
        'referencia',
        'destino_sector',
        'entregado_por',
        'autorizado_por',
        'interesado',
        'firma',
        'mime_type_firma',
        'status',
        'id_usuario',
    ];
}
