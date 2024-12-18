<?php

namespace App\Http\Controllers;

use App\Models\HistoryDB;
use App\Models\PersonalEM;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ControllerPersonalEM extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = PersonalEM::where('status', true)->orderBy('id', 'DESC')->get();
        return view('PersonalEM', ['personal_em' => $data]);
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

            $num_empleado = str_pad(PersonalEM::count('num_empleado') + 1, 5, '0', STR_PAD_LEFT);
            $data = [
                'table' => 'personal_em',
                'descripcion' => 'personal empleado de mita',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'store',
                'registro' => $num_empleado,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $personal_em = new PersonalEM($request->all());
            $personal_em->status = true;
            $blob = $request->file('imagen');
            $personal_em->imagen = $blob->openFile()->fread($blob->getSize());
            $personal_em->id_usuario = Auth::user()->id;

            $personal_em->num_empleado = $num_empleado;
            $personal_em->save();
        } catch (Exception $ex) {
            $validacion['errors_db'] = true;
            $validacion['errors_db_messages'] = $ex;

            $history_db->update(['status_register' => 'failed']);
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
            $personal_em = PersonalEM::where('status', true)->find(Crypt::decrypt($id));
            if ($personal_em == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        return view('FrmPersonalEM', ['personal_em' =>  $personal_em, 'action' => 'update']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validar = $this->validateRequest($request, 'update');
        if ($validar['errors_campos'] == true) {
            return response()->json($validar);
        }

        try {
            $personal_em = PersonalEM::where('status', true)->find(Crypt::decrypt($request->input('id-reg')));

            if ($personal_em == null) {
                $validar['errors_db'] = true;
                $validar['errors_db_messages'] = 'personal mita null';
                return response()->json($validar);
            }

            $data = [
                'table' => 'personal_em',
                'descripcion' => 'personal empleado de mita',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'update',
                'registro' => $personal_em->num_empleado,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $personal_em->fill($request->all());

            $blob = $request->file('imagen');
            if ($blob != null) {
                $personal_em->imagen = $blob->openFile()->fread($blob->getSize());
            }
            $personal_em->id_usuario = Auth::user()->id;
            $personal_em->update();
        } catch (Exception $ex) {
            $validar['errors_db'] = true;
            $validar['errors_db_messages'] = $ex;

            $history_db->update(['status_register' => 'failed']);
        }

        return response()->json($validar);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //si el usuario modifica el id dentro de las etiquetas html y coloca otros valores entonces
        //esto podria causar un error al desencriptar el id o caso contrario no se encuentre el registro
        //en la base de datos, entonces devolvemos un ERROR
        try {
            $personal_em = PersonalEM::where('status', true)->find(Crypt::decrypt($request->input('id-reg')));

            if ($personal_em == null) {
                $respuesta = [
                    'errors_db' => true,
                    'errors_db_messages' => 'personal mita null',
                ];
                return response()->json($respuesta);
            }

            $data = [
                'table' => 'personal_em',
                'descripcion' => 'personal empleado de mita',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'destroy',
                'registro' => $personal_em->num_empleado,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $personal_em->status = false;
            $personal_em->save();

            $respuesta = [
                'errors_db' => false
            ];
        } catch (Exception $ex) {

            $respuesta = [
                'errors_db' => true,
                'errors_db_messages' => $ex,
            ];

            $history_db->update(['status_register' => 'failed']);
        }

        return response()->json($respuesta);
    }

    public function viewFrm()
    {

        $personal_em = new PersonalEM();
        $personal_em->id = 0;
        $personal_em->fecha_de_nacimiento = '1990-01-01';
        $personal_em->licencia_de_conducir_valido = date('Y-m-d');
        $personal_em->ci_valido = date('Y-m-d');
        $personal_em->fecha_de_ingreso = date('Y-m-d');
        $personal_em->divisa = 'Bs.';

        $cantidad_registros = PersonalEM::count('num_empleado') + 1;

        return view('FrmPersonalEM', ['personal_em' => $personal_em, 'action' => 'store', 'num_registro' => $cantidad_registros]);
    }

    public function viewPerfil($id)
    {

        try {
            $personal_em = PersonalEM::where('status', true)->find(Crypt::decrypt($id));

            if ($personal_em == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        return view('PerfilPersonalEM', ['personal_em' => $personal_em]);
    }

    //imprimir
    public function imprimir($id)
    {
        try {
            $personal_em = PersonalEM::where('status', true)->find(Crypt::decrypt($id));
            if ($personal_em == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $pdf = Pdf::loadView('PDFPerfilPersonalEM', ['personal_em' => $personal_em]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
        $pdf->setPaper('legal', 'portrait'); //ocicio

        $pdf->render();

        return view('ViewPDFPerfilPersonalEM', ['personal_em' => $personal_em, 'pdf' => $pdf->output()]);
    }
    //pdf
    public function pdf($id)
    {
        try {
            $personal_em = PersonalEM::where('status', true)->find(Crypt::decrypt($id));
            if ($personal_em == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $pdf = Pdf::loadView('PDFPerfilPersonalEM', ['personal_em' => $personal_em]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
        $pdf->setPaper('legal', 'portrait'); //ocicio

        $pdf->render();

        return $pdf->download(date('d-m-Y') . '-' . $personal_em->nombres . '.pdf');
    }

    public function validateRequest(Request $request, $type)
    {

        switch ($type) {
            case 'store':
                $image_validate = "required|image|mimes:jpg,png";
                break;
            case 'update':
                $image_validate = "image|mimes:jpg,png";
                break;
            default:
                $image_validate = "";
                break;
        }

        $validator = Validator::make($request->all(), [
            'estado_del_empleado' => 'required|string|max:300',
            'imagen' => $image_validate,
            'nombres' => 'required|string|max:300',
            'apellidos' => 'required|string|max:300',
            'ci' => 'required|string|max:100',
            'ci_valido' => 'required|date',
            'fecha_de_nacimiento' => 'required|date',
            'lugar_de_nacimiento' => 'required|string|max:300',
            'profesion_ocupacion' => 'required|string|max:300',
            'estado_civil' => 'required|string|max:300',
            'sexo' => 'required|string|max:50',
            'licencia_de_conducir' => 'required|string|max:300',
            'licencia_de_conducir_valido' => 'required|date',
            'celular' => 'required|numeric',
            'lugar_de_trabajo' => 'required|string|max:300',
            'fecha_de_ingreso' => 'required|date',
            'cargo_a_desarrollar' => 'required|string|max:300',
            'haber_basico' => 'required|numeric',
            'divisa' => 'required|string|max:100',
            'ultima_vacacion' => 'required|string|max:300',
            //fecha de retiro puede ser nulo
            'estado_de_retiro' => 'required|string|max:300',
            'observacion' => 'required|string',
        ]);



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
