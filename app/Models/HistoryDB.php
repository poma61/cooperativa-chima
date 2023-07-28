<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryDB extends Model
{
    use HasFactory;

    protected $table = "history_db";
    protected $fillable = [
        'table',
        'descripcion',
        'id_usuario',
        'type_query',
        'registro',
        'status_register',
    ];
}
