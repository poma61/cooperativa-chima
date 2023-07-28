<?php

namespace App\Http\Controllers;

use App\Models\HistoryDB;
use Illuminate\Http\Request;
use App\Models\Socios;
use Exception;
use Illuminate\Protected\MyEncryption; //esta clase  yo lo adicione 
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ControllerSocios extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $socios = Socios::where('status', true)->orderBy('id', 'DESC')->get();
        return view('Socios', ['socios' => $socios]);
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
            $num_item = str_pad(Socios::count('num_item') + 1, 5, '0', STR_PAD_LEFT);
            //registrar historial del registro
            $data = [
                'table' => 'socios',
                'descripcion'=>'socios',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'store',
                'registro' => $num_item,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $socios = new Socios($request->all());
            $socios->status = true;
            $blob = $request->file('imagen');
            $socios->imagen = $blob->openFile()->fread($blob->getSize());
            $socios->id_usuario = MyEncryption::decrypt($request->input('id_usuario'));
            $socios->num_item = $num_item;
            $socios->save();
        } catch (Exception $ex) {
            $validacion['errors_db'] = true;
            $validacion['errors_db_messages'] = $ex;

            $history_db->update(['status_register' => 'falied']);
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
            $socios = Socios::where('status', true)->find(MyEncryption::decrypt($id));
            if ($socios == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }
     
        return view('FrmSocios', ['socios' => $socios, 'action' => 'update']);
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
            $socios = Socios::where('status', true)->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($socios == null) {
                $validar['errors_db'] = true;
                $validar['errors_db_messages'] = 'Error socios null';
                return response()->json($validar);
            }

            //registrar history de la base de datos
            $data = [
                'table' => 'socios',
                'descripcion'=>'socios',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'update',
                'registro' => $socios->num_item,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            /*********/
            $socios->estado_del_asociado = $request->input('estado_del_asociado');
            $blob = $request->file('imagen');
            //si el usuario subio un nueva nueva imagen entones siginifica que el campo
            //imagen NO estara vacio y lo subimos al modelo
            if ($blob != null) {
                $socios->imagen = $blob->openFile()->fread($blob->getSize());
            }
            $socios->nombres = $request->input('nombres');
            $socios->apellidos = $request->input('apellidos');
            $socios->ci = $request->input('ci');
            $socios->ci_valido = $request->input('ci_valido');
            $socios->fecha_de_nacimiento = $request->input('fecha_de_nacimiento');
            $socios->lugar_de_nacimiento = $request->input('lugar_de_nacimiento');
            $socios->estado_civil = $request->input('estado_civil');
            $socios->sexo = $request->input('sexo');
            $socios->celular = $request->input('celular');

            $socios->punta_de_trabajo = $request->input('punta_de_trabajo');
            $socios->grupo = $request->input('grupo');
            $socios->fecha_de_transferencia = $request->input('fecha_de_transferencia');
            $socios->susecion_de_derecho = $request->input('susecion_de_derecho');
            $socios->transfiriente_cc = $request->input('transfiriente_cc');
            $socios->parentesco = $request->input('parentesco');
            $socios->observacion = $request->input('observacion');

            $socios->id_usuario = MyEncryption::decrypt($request->input('id_usuario'));

            $socios->update();
        } catch (Exception $ex) {
            $validar['errors_db'] = true;
            $validar['errors_db_messages'] = $ex;

            $history_db->update(['status_register' => 'falied']);
        }

        return response()->json($validar);
    }

    /**
     * @param  \Illuminate\Http\Request  
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //si el usuario modifica el id dentro de las etiquetas html y coloca otros valores entonces
        //esto podria causar un error al desencriptar el id o caso contrario no se encuentre el registro
        //en la base de datos, entonces devolvemos un ERROR
        try {
            $socios = Socios::where('status', true)->find(MyEncryption::decrypt($request->input('id')));
            if ($socios == null) {

                return response()->json(['errors_db' => true,'errors_db_messages' => 'socios null']);
            }

            //registrar history de la base de datos
            $data = [
                'table' => 'socios',
                'descripcion'=>'socios',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'destroy',
                'registro' => $socios->num_item,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $socios->status = false;
            $socios->save();

            $respuesta = [
                'errors_db' => false,
            ];

        } catch (Exception $ex) {

            $respuesta = [
                'errors_db' => true,
                'errors_db_messages'=>$ex,
            ];

            $history_db->update(['status_register'=>'failed']);

        }

        return response()->json($respuesta);
    } //destroy


    public function viewFrm()
    {
        $socios = new Socios();
        $socios->id = 0;
        $cantidad_registros = Socios::count('num_item') + 1; // cantidad de registros
        $socios->ci_valido = date('Y-m-d');
        $socios->fecha_de_nacimiento = '1990-01-01';
        $socios->fecha_de_transferencia = date('Y-m-d');

        return view('FrmSocios', ['socios' => $socios, 'action' => 'store', 'num_registro' => $cantidad_registros]);
    }

    public function viewPerfil($id)
    {

        try {
            //si el usuario modifica la url del metodo get y coloca otros valores entonces
            //retornanos una pagina de not found
            //error NULL =>no hay registro
            $socios = Socios::where('status', true)->find(MyEncryption::decrypt($id));

            if ($socios == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            //si el usuario modifica la url del metodo get y coloca otros valores entonces
            //y por causa de esto hay un error al desenceiptar el dato igual 
            //retornanos una pagina de not found
            //error DECRYPT=>error al desencriptar
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        return view('PerfilSocios', ['socios' => $socios]);
    }

    public function imprimir($id)
    {
        try {
            $socios = Socios::where('status', true)->find(MyEncryption::decrypt($id));
            if ($socios == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $pdf = Pdf::loadView('PDFPerfilSocios', ['socios' => $socios]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
        $pdf->setPaper('legal', 'portrait'); //ocicio

        $pdf->render();

        return view('ViewPDFPerfilSocios', ['socios' => $socios, 'pdf' => $pdf->output()]);
    }

    public function pdf($id)
    {
        try {
            $socios = Socios::where('status', true)->find(MyEncryption::decrypt($id));
            if ($socios == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }


        $pdf = Pdf::loadView('PDFPerfilSocios', ['socios' => $socios]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
        $pdf->setPaper('legal', 'portrait'); //ocicio

        $pdf->render();
        return $pdf->download(date('d-m-Y') . '-' . $socios->nombres . '.pdf');
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
            'estado_del_asociado' => 'required|string|max:300',
            'imagen' =>  $image_validate,
            'nombres' => 'required|string|max:300',
            'apellidos' => 'required|string|max:300',
            'ci' => 'required|string|max:100',
            'ci_valido' => 'required|date',
            'fecha_de_nacimiento' => 'required|date',
            'lugar_de_nacimiento' => 'required|string|max:300',
            'estado_civil' => 'required|string|max:300',
            'sexo' => 'required|string|max:100',
            'celular' => 'required|numeric',

            'punta_de_trabajo' => 'required|string|max:300',
            'grupo' =>  'required|string|max:300',
            'fecha_de_transferencia' => 'required|date',
            'susecion_de_derecho' => 'required|string|max:300',
            'transfiriente_cc' => 'required|string|max:300',
            'parentesco' => 'required|string|max:300',
            'observacion' => 'required|string',
            'id_usuario' => 'required'
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
}//class
