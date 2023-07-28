<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\HistoryDB;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Protected\MyEncryption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class ControllerUsuarios extends Controller
{

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = User::select('users.*', 'roles.*', 'users.id as users_id', 'roles.id as roles_id')
            ->join('roles', 'roles.id_user', '=', 'users.id')
            ->where('users.status', true)
            ->where('roles.rol', '<>', 'system')
            ->get();

        return view('User', ['user' => $data]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validacion = $this->validateRequest($request, 'store');

        if ($validacion['errors_campos'] == true) {
            return response()->json($validacion);
        }


        try {

            $roles = [
                'secretaria',
                'jefe-de-maquina',
                'almacenes',
                'administrador',
                'invitado',
            ];
            $role_validado_html = false;
            $roles_length = count($roles);
            for ($i = 0; $i < $roles_length; $i++) {
                if ($request->input('rol') == $roles[$i]) {
                    $role_validado_html = true;
                }
            }
            if ($role_validado_html == false) {
                $validacion['errors_db'] = true;

                return response()->json($validacion);
            }

            $user = new User($request->except('rol'));
            $user->status = true;
            $blob = $request->file('foto');
            $user->foto = $blob->openFile()->fread($blob->getSize());
            $user->password = Hash::make($request->input('password'));
            $user->save();

            $roles = new Role();
            $roles->rol = $request->input('rol');
            $roles->id_user = $user->id;
            $roles->save();

            $data = [
                'table' => 'user',
                'descripcion' => 'usuarios',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'store',
                'registro' => $user->id,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();
        } catch (Exception $ex) {

            $validacion['errors_db'] = true;
            $validacion['errors_db_messages'] = $ex;
        }

        return response()->json($validacion);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $user = User::select('users.*', 'roles.*', 'users.id as users_id', 'roles.id as roles_id')
                ->join('roles', 'roles.id_user', '=', 'users.id')
                ->where('users.status', true)
                ->where('roles.rol', '<>', 'system')
                ->find(MyEncryption::decrypt($id));


            if ($user == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }

            $data = [
                'user' => $user,
                'action' => 'update',
            ];
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }



        return view('FrmUser', $data);
    }


    public function showModifyPassword()
    {
        return view('SettingUser');
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validar = $this->validateRequest($request, 'update');
        if ($validar['errors_campos'] == true) {
            return response()->json($validar);
        }

        try {
            $user = User::where('users.status', true)->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($user == null) {
                $validar['errors_db'] = true;
                $validar['errors_db_messages'] = 'usuarios null';
                return response()->json($validar);
            }


            $roles = [
                'secretaria',
                'jefe-de-maquina',
                'almacenes',
                'administrador',
                'invitado',
            ];
            $role_validado_html = false;
            $roles_length = count($roles);
            for ($i = 0; $i < $roles_length; $i++) {
                if ($request->input('rol') == $roles[$i]) {
                    $role_validado_html = true;
                }
            }
            if ($role_validado_html == false) {
                $validar['errors_db'] = true;
                return response()->json($validar);
            }

            $user->fill($request->except('rol'));
            $blob = $request->file('foto');
            if ($blob != null) {
                $user->foto = $blob->openFile()->fread($blob->getSize());
            }

            $user->update();

            $roles = Role::where('id_user', $user->id)->first();
            $roles->rol = $request->input('rol');
            $roles->update();


            $data = [
                'table' => 'user',
                'descripcion' => 'usuarios',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'update',
                'registro' => $user->id,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();
        } catch (Exception $ex) {
            $validar['errors_db'] = true;
            $validar['errors_db_messages'] = $ex;
        }

        return response()->json($validar);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateModifyPassword(Request $request)
    {
        $user = User::where('users.status', true)->find(Auth::user()->id);

        if (Hash::check($request->input('password_old'), $user->password)) {

            $validar = $this->validateRequest($request, 'update-password');
            if ($validar['errors_campos'] == true) {
                return response()->json($validar);
            }

            $user->password = Hash::make($request->input('password_new'));
            $user->usuario = $request->input('usuario');
            $blob = $request->file('foto');
            if ($blob != null) {
                $user->foto = $blob->openFile()->fread($blob->getSize());
            }
            $user->update();

            return response()->json($validar);
        } else {
            $errores = [
                'errors_campos_messages' =>  ['password_old' => [0 => 'Contraseña Incorrecta']],
                'errors_campos' => true,
                'status_code' => 200,
                'errors_db' => false,
                'errors_db_messages' => null,
            ];

            return response()->json($errores);
        }
    } //update

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {


        //si el usuario modifica el id dentro de las etiquetas html y coloca otros valores entonces
        //esto podria causar un error al desencriptar el id o caso contrario no se encuentre el registro
        //en la base de datos, entonces devolvemos un ERROR
        try {
            $user = User::select('users.*', 'roles.*', 'users.id as users_id', 'roles.id as roles_id')
                ->join('roles', 'roles.id_user', '=', 'users.id')
                ->where('users.status', true)
                ->where('roles.rol', '<>', 'system')
                ->find($request->input('id-reg'));

            if ($user == null) {
                $respuesta = [
                    'errors_db' => true,
                    'errors_db_messages' => 'usuario null',
                ];
                return response()->json($respuesta);
            }

            $user->status = false;
            $user->save();

            $data = [
                'table' => 'user',
                'descripcion' => 'usuarios',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'destroy',
                'registro' => $user->id,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $respuesta = [
                'errors_db' => false,
            ];
        } catch (Exception $ex) {

            $respuesta = [
                'errors_db' => true,
                'errors_db_messages' => $ex,
            ];
        }

        return response()->json($respuesta);
    }

    public function viewFrm()
    {

        $user = new User();
        $user->id = 0;
        $data = [
            'user' => $user,
            'action' => 'store',
        ];
        return view('FrmUser', $data);
    }


    public function validateRequest(Request $request, $type)
    {

        switch ($type) {
            case 'store':

                $validator = Validator::make($request->all(), [
                    'nombres' => 'required|string|max:400',
                    'apellidos' => 'required|string|max:400',
                    'usuario' => "required|string|max:400|unique:users",
                    'password' => "required|string|min:8|max:400|confirmed",
                    'foto' => "required|mimes:jpg,png",
                    'rol' => 'required|string|max:400',
                ], [
                    'password.required' => 'El campo contraseña es obligatorio.',
                    'password.confirmed' => 'Las contraseñas no coinciden.',
                    'password.min' => 'La contraseña debe ser minimo de 8 caracteres.',
                    'usuario.unique' => 'El usuario ya se encuentra registrado en el sistema.',
                ]);
                break;

            case "update":
                $validator = Validator::make($request->all(), [
                    'nombres' => 'required|string|max:400',
                    'apellidos' => 'required|string|max:400',
                    'foto' => "mimes:jpg,png",
                    'rol' => 'required|string|max:400',
                ]);
                break;

            case "update-password":
                $validator = Validator::make($request->all(), [
                    'usuario' => [
                        'required',
                        'string',
                        'max:400',
                        Rule::unique('users')->ignore(Auth::user()->id)->ignore(Auth::user()->usuario, 'usuario'), //solo aplica 'unique' si el campo es un valor nuevo(valor que no esta en DB)
                    ],
                    'password_new' => "required|string|min:8|max:400|confirmed",
                    'foto' => "mimes:jpg,png",
                ], [
                    'password_new.required' => 'El campo contraseña es obligario.',
                    'password_new.min' => 'La contraseña debe ser minimo de 8 caracteres.',
                    'password_new.confirmed' => 'Las contraseñas no coinciden.',
                    'usuario.unique' => 'El usuario ya se encuentra registrado en el sistema.',
                ]);
                break;


            default:
                $validator = Validator::make($request->all(), [
                    'nombres' => 'required|string|max:400',
                    'apellidos' => 'required|string|max:400',
                    'usuario' => "required|string|max:400|unique:users",
                    'password' => "required|string|min:8|max:400|confirmed",
                    'foto' => "required|mimes:jpg,png",
                    'rol' => 'required|string|max:400',
                ], [
                    'password.required' => 'El campo contraseña es obligatorio.',
                    'password.min' => 'La contraseña debe ser minimo de 8 caracteres.',
                    'password.confirmed' => 'Las contraseñas no coinciden.',
                    'usuario.unique' => 'El usuario ya se encuentra registrado en el sistema.',
                ]);
                break;
        }


        if ($validator->fails()) {
            $errores = [
                'errors_campos_messages' => $validator->errors(),
                'errors_campos' => true,
                'status_code' => 200,
                'errors_db' => false,
                'errors_db_messages' => null,
            ];
        } else {
            $errores = [
                'errors_campos_messages' => null,
                'errors_campos' => false,
                'status_code' => 200,
                'errors_db' => false,
                'errors_db_messages' => null,
            ];
        }

        return $errores;
    }
}
