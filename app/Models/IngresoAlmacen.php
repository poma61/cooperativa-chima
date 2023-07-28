<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngresoAlmacen extends Model
{
    use HasFactory;
    protected $table = "ingreso_almacen";

    protected $fillable = [
        "num_reg",
        "n_de_documento",
        "cantidad",
        "um",
        "costo_unitario",
        "divisa_costo_unitario",
        "total",
        "divisa_total",
        "descripcion",
        "codigo",
        "marca",
        "proveedor",
        "entregado_por",
        "status",
        "id_usuario",
    ];
}
