<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistorialSocios;
use App\Models\HistoryDB;
use App\Models\Socios;
use Exception;
use Illuminate\Protected\MyEncryption;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ControllerHistorialSocios extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        try {
            $socios = Socios::find(MyEncryption::decrypt($id));
            $historial_socios = HistorialSocios::where('status', true)->where('id_socio', MyEncryption::decrypt($id))
                ->orderBy('fecha', 'DESC')
                ->get();

            if ($socios == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }
        return view("HistorialSocios", ['historial_socios' => $historial_socios, 'socios' => $socios]);
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
            $id_socio = MyEncryption::decrypt($request->input('id_socio'));

            $verificar_registro = Socios::select('id')->where('id', $id_socio)->where('status', true)->first();
            if ($verificar_registro == null) {
                $validacion['errors_db'] = true;
                $validacion['errors_db_messages'] = 'socios null';
                return response()->json($validacion);
            }

            $num = HistorialSocios::where('id_socio',$id_socio)->count('num_reg') + 1;
            $num_reg = str_pad($num, 5, '0', STR_PAD_LEFT);

            //registrar history de la base de datos
            $data = [
                'table' => 'historial_de_socio',
                'descripcion' => 'historial de socios',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'store',
                'registro' => $num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $historial_socios = new HistorialSocios($request->all());

            $historial_socios->status = true;
            $blob_file = $request->file('archivo');
            $historial_socios->archivo = $blob_file->openFile()->fread($blob_file->getSize());
            $historial_socios->id_socio = $id_socio;
            $historial_socios->mime_type = $blob_file->getMimeType();

            $historial_socios->num_reg = $num_reg;
            $historial_socios->save();
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
            $historial_socios = HistorialSocios::where('status', true)->find(MyEncryption::decrypt($id));
            $socios = Socios::find($historial_socios->id_socio);


            if ($socios == null || $historial_socios == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }
        //'cant_reg_db'=>null
        return view('FrmHistorialSocios', ['historial_socios' => $historial_socios, 'socios' => $socios, 'action' => 'update']);
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
            $historial_socios = HistorialSocios::where('status', true)->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($historial_socios == null) {
                $validar['errors_db'] = true;
                $validar['errors_db_messages'] = 'historial socios null';
                return response()->json($validar);
            }
            //registrar history de la base de datos
            $data = [
                'table' => 'historial_de_socio',
                'descripcion' => 'historial de socios',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'update',
                'registro' => $historial_socios->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();


            $historial_socios->fecha = $request->input('fecha');
            $historial_socios->descripcion = $request->input('descripcion');
            $historial_socios->tipo_de_documento = $request->input('tipo_de_documento');
            $blob = $request->file('archivo');
            //si el usuario subio un nueva nueva imagen entones siginifica que el campo
            //imagen NO estara vacio y lo subimos al modelo
            if ($blob != null) {
                $historial_socios->archivo = $blob->openFile()->fread($blob->getSize());
                $historial_socios->mime_type = $blob->getMimeType();
            }

            $historial_socios->update();
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
        try {
            $historial_socios = HistorialSocios::where('status', true)->find(MyEncryption::decrypt($request->input('id')));

            if ($historial_socios == null) {
                return response()->json(['errors_db' => true, 'errors_db_messages' => 'historial de socios null']);
            }

            //registrar history de la base de datos
            $data = [
                'table' => 'historial_de_socio',
                'descripcion' => 'historial de socios',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'destroy',
                'registro' => $historial_socios->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $historial_socios->status = false;
            $historial_socios->save();

            $respuesta = [
                'errors_db' => false,
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

    public function viewFrm($id)
    {
        $historial_socios = new HistorialSocios();
        $historial_socios->id = 0;
        $historial_socios->fecha = date('Y-m-d');

        try {
            $socios = Socios::where('status', true)->find(MyEncryption::decrypt($id));
            if ($socios == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
            $num_registro = HistorialSocios::where('id_socio', $socios->id)->count('num_reg');
            $num_registro =  $num_registro + 1;
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        return view('FrmHistorialSocios', ['historial_socios' => $historial_socios, 'num_registro' => $num_registro, 'socios' => $socios, 'action' => 'store']);
    }


    //pdf
    public function pdfRegistros($id)
    {
        try {

            $socios = Socios::where('status', true)->find(MyEncryption::decrypt($id));
            $historial_socios = HistorialSocios::where('id_socio', MyEncryption::decrypt($id))->where('status', true)->orderBy('fecha', 'DESC')->get();
            if ($socios == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $pdf_render = Pdf::loadView('PDFHistorialSocios', ['historial_socios' => $historial_socios, 'socios' => $socios]);
        $pdf_render->setPaper('legal', 'portrait');
        $pdf_render->render();

        $pdf = $pdf_render->download(date('Y-m-d') . '-historial de antecedentes-' . $socios->nombres . '.pdf');
        return   $pdf;
    }

    //imprimir
    public function imprimirRegistros($id)
    {

        try {
            $socios = Socios::where('status', true)->find(MyEncryption::decrypt($id));
            $historial_socios = HistorialSocios::where('id_socio', MyEncryption::decrypt($id))->where('status', true)->orderBy('fecha', 'DESC')->get();

            if ($socios == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }
        $pdf_render = Pdf::loadView('PDFHistorialSocios', ['historial_socios' => $historial_socios, 'socios' => $socios]);
        $pdf_render->setPaper('legal', 'portrait');
        $pdf_render->render();

        $pdf = $pdf_render->output();
        return view('ViewPDFHistorialSocios', ['pdf' => $pdf, 'socios' => $socios]);
    }

    //pdf historial de antecedentes solo de 1 registro 
    public function pdfRegistroId($id)
    {
        try {

            $historial_socios_socios = HistorialSocios::join('socios', 'socios.id', '=', 'historial_de_socio.id_socio')
                ->select(
                    'socios.nombres',
                    'socios.apellidos',
                    'socios.punta_de_trabajo',
                    'socios.ci',
                    'historial_de_socio.id as id_historial_socio',
                    'historial_de_socio.num_reg',
                    'historial_de_socio.fecha',
                    'historial_de_socio.id_socio',
                    'historial_de_socio.mime_type',
                    'historial_de_socio.descripcion',
                    'historial_de_socio.tipo_de_documento',
                    'historial_de_socio.archivo'
                )
                ->where('historial_de_socio.id', MyEncryption::decrypt($id))
                ->where('socios.status', true)
                ->where('historial_de_socio.status', true)
                ->first();

            if ($historial_socios_socios == null) {

                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $pdf_render = Pdf::loadView('PDFVerHistorialSocios', ['historial_socios_socios' => $historial_socios_socios]);
        $pdf_render->setPaper('legal', 'portrait');
        $pdf_render->render();

        $pdf = $pdf_render->download(date('Y-m-d') . '-' . $historial_socios_socios->num_reg . '-historial-' . $historial_socios_socios->nombres . '.pdf');
        return   $pdf;
    }

    //pdf historial de antecedentes solo de 1 registro 
    public function imprimirRegistroId($id)
    {
        try {

            $historial_socios_socios = HistorialSocios::join('socios', 'socios.id', '=', 'historial_de_socio.id_socio')
                ->select(
                    'socios.nombres',
                    'socios.apellidos',
                    'socios.punta_de_trabajo',
                    'socios.ci',
                    'historial_de_socio.id as id_historial_socio',
                    'historial_de_socio.num_reg',
                    'historial_de_socio.fecha',
                    'historial_de_socio.id_socio',
                    'historial_de_socio.mime_type',
                    'historial_de_socio.descripcion',
                    'historial_de_socio.tipo_de_documento',
                    'historial_de_socio.archivo'
                )
                ->where('historial_de_socio.id', MyEncryption::decrypt($id))
                ->where('socios.status', true)
                ->where('historial_de_socio.status', true)
                ->first();

            if ($historial_socios_socios == null) {

                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $pdf_render = Pdf::loadView('PDFVerHistorialSocios', ['historial_socios_socios' => $historial_socios_socios]);
        $pdf_render->setPaper('legal', 'portrait');
        $pdf_render->render();

        $pdf = $pdf_render->output();
        return view('ViewPDFVerHistorialSocios', ['historial_socios_socios' => $historial_socios_socios, 'pdf' => $pdf]);
    }

    public function viewVerHistorial($id)
    {
        try {
            $historial_socios_socios = HistorialSocios::join('socios', 'socios.id', '=', 'historial_de_socio.id_socio')
                ->select(
                    'socios.nombres',
                    'socios.apellidos',
                    'socios.punta_de_trabajo',
                    'socios.ci',
                    'historial_de_socio.id as id_historial_socio',
                    'historial_de_socio.num_reg',
                    'historial_de_socio.fecha',
                    'historial_de_socio.id_socio',
                    'historial_de_socio.mime_type',
                    'historial_de_socio.descripcion',
                    'historial_de_socio.tipo_de_documento',
                    'historial_de_socio.archivo'
                )
                ->where('historial_de_socio.id', MyEncryption::decrypt($id))
                ->where('socios.status', true)
                ->where('historial_de_socio.status', true)
                ->first();

            if ($historial_socios_socios == null) {

                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        return view('VerHistorialSocios', ['historial_socios_socios' => $historial_socios_socios]);
    }


    public function validateRequest(Request $request, $type)
    {

        switch ($type) {
            case 'store':
                $archivo_validate = "required|mimes:jpg,png,pdf";
                break;
            case 'update':
                $archivo_validate = "mimes:jpg,png,pdf";
                break;
            default:
                $archivo_validate = "";
                break;
        }

        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date',
            'descripcion' => 'required|string',
            'tipo_de_documento' => 'required|string|max:300',
            'archivo' =>  $archivo_validate,
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
