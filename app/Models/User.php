<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nombres',
        'apellidos',
        'usuario',
        'password',
        'foto',
        'rol',
        'status',
    ];

    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
    ];


    //para unir dos tablas en este caso unos a muchos
    //hace un join
    public function onHasRoles()
    {
        return $this->hasMany(Role::class, 'id_user');
    }


    // public function hasRoles($role)
    // {
    //     return $this->roles()->where('rol', $role)->exists();
    // }


}
