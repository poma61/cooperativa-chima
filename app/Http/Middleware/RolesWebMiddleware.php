<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolesWebMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {

        //el parametro ...$roles  recibe como parametro de entrada un array con los niveles de rol
        //y esto depedenra de las rutas
        //ejemplo

        // Route::group(['middleware' => ['auth:sanctum','role:administrador']], function () {
        //     Route::controller(ControllerUsuarios::class)->group(function () {
        //     });
        //  });

        // entonces al middlware enviamos "administrador" y si invocamos varias veces 'role'  entonces el 
        //middleware recibira un array y lo almacenara en '...$roles'


        if (in_array(Auth::user()->onHasRoles->first()->rol, $roles)) {
            return $next($request);
        }

        // foreach ($roles as $role) {
        //     if (Auth::user()->hasRoles($role)) {
        //         return $next($request);
        //     }
        // }
    
        return redirect('/acceso-no-autorizado');
      //  return view('AccesoNoAutorizado');

    }
}//class
