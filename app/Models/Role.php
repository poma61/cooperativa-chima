<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    
    protected $table="roles";

    protected $fillable=[
        "rol",
        "id_user",
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

}
