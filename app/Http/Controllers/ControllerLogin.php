<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ControllerLogin extends Controller
{


    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Login');
    }

    public function verificarUsuario()
    {
        //Hash::make(1234) para encryptar contraseña

        // $user = User::with('hasRole')->where('usuario', request('usuario'))->where('status', true)->first();
        $user = User::where('usuario', request('usuario'))->where('status', true)->first();

        if ($user != null) {
            if (Hash::check(request('password'), $user->password)) {
                Auth::login($user);

                $token = $user->createToken($user->usuario)->plainTextToken;
                request()->session()->regenerate();
                session()->put('session_auth_token', $token);

                $cookie = cookie('cookie_auth_token', $token, 60 * 24);
                
                return redirect()->route('route-cooperativa')->withoutCookie($cookie);
            } else {
                throw ValidationException::withMessages([
                    'credenciales-incorrectos' => 'Usuario y/o contraseña incorrectos'
                ]);
                return redirect('/');
            }
        } else {

            throw ValidationException::withMessages([
                'credenciales-incorrectos' => 'Usuario y/o contraseña incorrectos'
            ]);

            return redirect('/');
        }
    } //verificar usuario

    public function cerrarSesionUser(Request $request)
    {

     $token=session('session_auth_token');
     $token_id=explode('|',$token);
     $request->user()->tokens()->where('id', $token_id)->delete();

     $cookie=Cookie::forget('cookie_auth_token');
     
     Auth::logout();
     session()->invalidate();
      session()->regenerateToken();

        return response()->json([
            'sucess'=>true
        ],200)->withCookie($cookie);
    }
}
