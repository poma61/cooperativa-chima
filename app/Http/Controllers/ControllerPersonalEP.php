<?php

namespace App\Http\Controllers;

use App\Models\HistoryDB;
use App\Models\PersonalEP;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ControllerPersonalEP extends Controller
{


    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = PersonalEP::where('status', true)->orderBy('id', 'DESC')->get();
        return view('PersonalEP', ['personal_ep' => $data]);
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

            $num_empleado = str_pad(PersonalEP::count('num_empleado') + 1, 5, '0', STR_PAD_LEFT);
            //registrar history de la base de datos
            $data = [
                'table' => 'personal_ep',
                'descripcion' => 'personal empleado de planta',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'store',
                'registro' => $num_empleado,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();


            $personal_ep = new PersonalEP($request->all());
            $personal_ep->status = true;
            $blob = $request->file('imagen');
            $personal_ep->imagen = $blob->openFile()->fread($blob->getSize());
            $personal_ep->id_usuario = Crypt::decrypt($request->input('id_usuario'));

            $personal_ep->num_empleado = $num_empleado;
            $personal_ep->save();
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
            $personal_ep = PersonalEP::where('status', true)->find(Crypt::decrypt($id));
            if ($personal_ep == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        return view('FrmPersonalEP', ['personal_ep' =>  $personal_ep, 'action' => 'update']);
    }

    /**
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
            $personal_ep = PersonalEP::where('status', true)->find(Crypt::decrypt($request->input('id-reg')));

            if ($personal_ep == null) {
                $validar['errors_db'] = true;
                $validar['errors_db_messages'] = 'personal planta null';
                return response()->json($validar);
            }

            $data = [
                'table' => 'personal_ep',
                'descripcion' => 'personal empleado de planta',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'update',
                'registro' => $personal_ep->num_empleado,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $personal_ep->fill($request->all());

            $blob = $request->file('imagen');
            if ($blob != null) {
                $personal_ep->imagen = $blob->openFile()->fread($blob->getSize());
            }
            $personal_ep->id_usuario = Crypt::decrypt($request->input('id_usuario'));
            $personal_ep->update();
        } catch (Exception $ex) {

            $validar['errors_db'] = true;
            $validar['errors_db_messages'] = $ex;

            $history_db->update(['status_register' => 'failed']);
        }

        return response()->json($validar);
    }

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
            $personal_ep = PersonalEP::where('status', true)->find(Crypt::decrypt($request->input('id-reg')));

            if ($personal_ep == null) {
                $respuesta = [
                    'errors_db' => true,
                    'errors_db_messages' => 'personal planta null',
                ];
                return response()->json($respuesta);
            }

            $data = [
                'table' => 'personal_ep',
                'descripcion' => 'personal empleado de planta',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'destroy',
                'registro' => $personal_ep->num_empleado,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();


            $personal_ep->status = false;
            $personal_ep->save();

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
        $personal_ep = new PersonalEP();
        $personal_ep->id = 0;
        $personal_ep->fecha_de_nacimiento = '1990-01-01';
        $personal_ep->licencia_de_conducir_valido = date('Y-m-d');
        $personal_ep->ci_valido = date('Y-m-d');
        $personal_ep->fecha_de_ingreso = date('Y-m-d');
        $personal_ep->divisa = 'Bs.';


        $cantidad_registros = PersonalEP::count('num_empleado') + 1;

        return view('FrmPersonalEP', ['personal_ep' => $personal_ep, 'action' => 'store', 'num_registro' => $cantidad_registros]);
    }

    public function viewPerfil($id)
    {

        try {
            $personal_ep = PersonalEP::where('status', true)->find(Crypt::decrypt($id));

            if ($personal_ep == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        return view('PerfilPersonalEP', ['personal_ep' => $personal_ep]);
    }

    //imprimir
    public function imprimir($id)
    {
        try {
            $personal_ep = PersonalEP::where('status', true)->find(Crypt::decrypt($id));
            if ($personal_ep == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $pdf = Pdf::loadView('PDFPerfilPersonalEP', ['personal_ep' => $personal_ep]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
        $pdf->setPaper('legal', 'portrait'); //ocicio

        $pdf->render();

        return view('ViewPDFPerfilPersonalEP', ['personal_ep' => $personal_ep, 'pdf' => $pdf->output()]);
    }
    //pdf
    public function pdf($id)
    {
        try {
            $personal_ep = PersonalEP::where('status', true)->find(Crypt::decrypt($id));
            if ($personal_ep == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }


        $pdf = Pdf::loadView('PDFPerfilPersonalEP', ['personal_ep' => $personal_ep]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
        $pdf->setPaper('legal', 'portrait'); //ocicio

        $pdf->render();
        return $pdf->download(date('d-m-Y') . '-' . $personal_ep->nombres . '.pdf');
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
            'sueldo_asignado' => 'required',
            'divisa' => 'required|string|max:100',
            'ultima_vacacion' => 'required|string|max:300',
            //fecha de retiro puede ser nulo
            'estado_de_retiro' => 'required|string|max:300',
            'observacion' => 'required|string',
            'id_usuario' => 'required',
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
