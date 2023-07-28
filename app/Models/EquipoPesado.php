<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipoPesado extends Model
{
    use HasFactory;

    protected $table = "equipo_pesado";
    protected $fillable = [
        //datos generales
        'nombre_comun_del_equipo',
        'codigo_de_inventario_interno',
        //datos de origen
        'fabricante',
        'ano_vencimiento_de_garantia',
        'ano_de_fabricacion',
        'pais_de_origen',
        'modelo',
        'numero_de_serie',
        'ano_de_compra',
        //datos de uso en planta
        'ano_de_alta_planta',
        'estado_del_equipo_al_momento_de_alta',
        'horometro_al_inicio_operacion_planta',
        'linea_de_produccion_asignada',
        'ubicacion',
        //registro fotografico
        'archivo',
        'mime_type_archivo',
        //datos tecnico
        'potencia_und',
        'potencia_valor_nominal',
        'potencia_caracteristicas',

        'voltaje_und',
        'voltaje_valor_nominal',
        'voltaje_caracteristicas',

        'corriente_und',
        'corriente_valor_nominal',
        'corriente_caracteristicas',

        'capacidad_de_cucharon_und',
        'capacidad_de_cucharon_valor_nominal',
        'capacidad_de_cucharon_caracteristicas',

        'capacidad_de_diesel_und',
        'capacidad_de_diesel_valor_nominal',
        'capacidad_de_diesel_caracteristicas',

        'otros_und',
        'otros_valor_nominal',
        'otros_caracteristicas',

        //disponibilidad de informacion de soporte tecnico
        'manuales_impresos',
        'manuales_digitales',
        'mime_type_manuales_digitales',
        'otros_manuales',

        'planos_mecanicos_digitales', //este campo no especifica si es archivo
        'planos_electricos_digitales',
        'mime_type_planos_electricos_digitales',
        'otros_planos',

        'status',
        'id_usuario',

    ];
}
