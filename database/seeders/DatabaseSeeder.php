<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::create([
            'nombres' => 'Super Sistema',
            'apellidos' => 'sistema sistema',
            'usuario' => 'system',
            'status'=>true,
            'password'=>'$2y$10$jjDb4siaEWs3Iw.sFqFwquRENoM/Lsi.IK6WL5L9fXF/x1GXKPfFq',//1234
         ]);
         \App\Models\Role::create([
            'id_user' => 1,
            'rol'=>'system',
         ]);



    }
}
