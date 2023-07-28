<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        //si el usuario no esta autenticado redirecciona al siguiente enlace 
        if (!$request->expectsJson()) {
            return route('route-login');
        }
    }

    /*
Nota esta funcione añade un header de manera automatica a todas las peticiones API
de esta forma ya no es necesario añadir un header donde la peticion  HTTP, en este caso ya no se necesita añadir en 
javascript
*/
    public function handle($request, Closure $next, ...$guards)
    {

        if ($request->is('api/*')) {
            if ($token = $request->cookie('cookie_auth_token')) {

                $request->headers->set('Authorization', 'Bearer ' . $token);
                $request->headers->set("Accept", "application/json");
            }
        }
        $this->authenticate($request, $guards);
        return $next($request);
    }
}
