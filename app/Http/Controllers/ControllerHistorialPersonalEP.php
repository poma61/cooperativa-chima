<?php

namespace App\Http\Controllers;

use App\Models\HistorialPersonalEP;
use App\Models\HistoryDB;
use App\Models\PersonalEP;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ControllerHistorialPersonalEP extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        try {
            $personal_ep = PersonalEP::where('status', true)->find(Crypt::decrypt($id));
            if ($personal_ep == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }

            $historial_personal_ep = HistorialPersonalEP::select('id', 'num_reg', 'fecha', 'estado')
                ->where('status', true)
                ->where('id_personal_ep', $personal_ep->id)
                ->orderBy('fecha', 'DESC')->get();
        } catch (Exception $ex) {
            if ($personal_ep == null) {
                return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
            }
        }


        return view('HistorialPersonalEP', ['personal_ep' => $personal_ep, 'historial_personal_ep' => $historial_personal_ep]);
    }

    /**
     * Store a newly created resource in storage.
     *
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

            $id_personal_ep = Crypt::decrypt($request->input('id-personal-ep'));
            $verificar_registro = PersonalEP::select('id')->where('id', $id_personal_ep)->where('status', true)->first();
            if ($verificar_registro == null) {
                $validacion['errors_db'] = true;
                $validacion['errors_db_messages'] = 'personal planta null';
                return response()->json($validacion);
            }

            $num = HistorialPersonalEP::where('id_personal_ep', $id_personal_ep)->count('num_reg') + 1;
            $num_reg = str_pad($num, 5, '0', STR_PAD_LEFT);

            $data = [
                'table' => 'historial_personal_ep',
                'descripcion' => 'historial personal empleado de planta',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'store',
                'registro' => $num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $historial_personal_ep = new HistorialPersonalEP($request->all());
            $historial_personal_ep->status = true;
            $blob_file = $request->file('archivo');
            $historial_personal_ep->archivo = $blob_file->openFile()->fread($blob_file->getSize());
            $historial_personal_ep->mime_type = $blob_file->getMimeType();
            $historial_personal_ep->id_personal_ep = $id_personal_ep;

            $historial_personal_ep->num_reg = $num_reg;
            $historial_personal_ep->save();

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
            $historial_personal_ep = HistorialPersonalEP::where('status', true)->find(Crypt::decrypt($id));
            $personal_ep = PersonalEP::where('status', true)->find($historial_personal_ep->id_personal_ep);

            if ($personal_ep == null || $historial_personal_ep == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        return view('FrmHistorialPersonalEP', ['historial_personal_ep' => $historial_personal_ep, 'personal_ep' => $personal_ep, 'action' => 'update']);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Responsepersonal_ep
     */
    public function update(Request $request)
    {
        $validar = $this->validateRequest($request, 'update');
        if ($validar['errors_campos'] == true) {
            return response()->json($validar);
        }

        try {
            $historial_personal_ep = HistorialPersonalEP::where('status', true)->find(Crypt::decrypt($request->input('id-reg')));

            if ($historial_personal_ep == null) {
                $validar['errors_db'] = true;
                $validar['errors_db_messages'] = 'historial personal planta null';
                return response()->json($validar);
            }

            $data = [
                'table' => 'historial_personal_ep',
                'descripcion' => 'historial personal empleado de planta',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'update',
                'registro' => $historial_personal_ep->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();


            $historial_personal_ep->fill($request->all());
            $blob = $request->file('archivo');
            //si el usuario subio un nueva nueva imagen entones siginifica que el campo
            //imagen NO estara vacio y lo subimos al modelo
            if ($blob != null) {
                $historial_personal_ep->archivo = $blob->openFile()->fread($blob->getSize());
                $historial_personal_ep->mime_type = $blob->getMimeType();
            }
            $historial_personal_ep->update();
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
        try {
            $historial_personal_ep = HistorialPersonalEP::where('status', true)->find(Crypt::decrypt($request->input('id')));

            if ($historial_personal_ep == null) {
                $respuesta = [
                    'errors_db' => true,
                    'errors_db_messages' => 'historial personal planta null',
                ];

                return response()->json($respuesta);
            }

            $data = [
                'table' => 'historial_personal_ep',
                'descripcion' => 'historial personal empleado de planta',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'destroy',
                'registro' => $historial_personal_ep->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();


            $historial_personal_ep->status = false;
            $historial_personal_ep->save();

            $respuesta = [
                'errors_db' => false
            ];
        } catch (Exception $ex) {

            $respuesta = [
                'errors_db' => true,
                'errors_db_messages' => $ex
            ];
            $history_db->update(['status_register' => 'failed']);
        }
        return response()->json($respuesta);
    }

    public function viewFrm($id)
    {
        $historial_personal_ep = new HistorialPersonalEP();
        $historial_personal_ep->id = 0;
        $historial_personal_ep->fecha = date('Y-m-d');

        try {
            $personal_ep = PersonalEP::where('status', true)->find(Crypt::decrypt($id));
            if ($personal_ep == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }
        $cantidad_registros = HistorialPersonalEP::where('status', true)->where('id_personal_ep', $personal_ep->id)->count('num_reg') + 1;

        return view('FrmHistorialPersonalEP', ['historial_personal_ep' => $historial_personal_ep, 'num_registro' => $cantidad_registros, 'personal_ep' => $personal_ep, 'action' => 'store']);
    }

    public function viewVerHistorial($id)
    {
        try {
            $historial_personal_ep_personal_ep = HistorialPersonalEP::join('personal_ep', 'personal_ep.id', '=', 'historial_personal_ep.id_personal_ep')
                ->select(
                    'personal_ep.nombres',
                    'personal_ep.apellidos',
                    'personal_ep.ci',
                    'personal_ep.lugar_de_trabajo',
                    'personal_ep.cargo_a_desarrollar',
                    'personal_ep.num_empleado',
                    'personal_ep.fecha_de_ingreso',
                    'historial_personal_ep.id as id_historial_personal_ep',
                    'historial_personal_ep.*'
                )
                ->where('historial_personal_ep.id', Crypt::decrypt($id))
                ->where('personal_ep.status', true)
                ->where('historial_personal_ep.status', true)
                ->first();

            if ($historial_personal_ep_personal_ep == null) {

                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        return view('VerHistorialPersonalEP', ['historial_personal_ep_personal_ep' => $historial_personal_ep_personal_ep]);
    }

    //pdf
    public function pdfRegistros($id)
    {
        try {

            $personal_ep = PersonalEP::where('status', true)->find(Crypt::decrypt($id));
            $historial_personal_ep = HistorialPersonalEP::where('id_personal_ep', Crypt::decrypt($id))->where('status', true)->orderBy('fecha', 'DESC')->get();
            if ($personal_ep == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $pdf_render = Pdf::loadView('PDFHistorialPersonalEP', ['historial_personal_ep' => $historial_personal_ep, 'personal_ep' => $personal_ep]);
        $pdf_render->setPaper('legal', 'portrait');
        $pdf_render->render();

        $pdf = $pdf_render->download(date('Y-m-d') . '-historial de antecedentes-' . $personal_ep->nombres . '.pdf');
        return   $pdf;
    }

    //imprimir
    public function imprimirRegistros($id)
    {
        try {
            $personal_ep = PersonalEP::where('status', true)->find(Crypt::decrypt($id));
            $historial_personal_ep = HistorialPersonalEP::where('id_personal_ep', Crypt::decrypt($id))->where('status', true)->orderBy('fecha', 'DESC')->get();
            if ($personal_ep == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $pdf_render = Pdf::loadView('PDFHistorialPersonalEP', ['historial_personal_ep' => $historial_personal_ep, 'personal_ep' => $personal_ep]);
        $pdf_render->setPaper('legal', 'portrait');
        $pdf_render->render();

        $pdf = $pdf_render->output();
        return view('ViewPDFHistorialPersonalEP', ['pdf' => $pdf, 'personal_ep' => $personal_ep]);
    }

    //pdf historial de antecedentes solo de 1 registro 
    public function pdfRegistroId($id)
    {
        try {

            $historial_personal_ep_personal_ep = HistorialPersonalEP::join('personal_ep', 'personal_ep.id', '=', 'historial_personal_ep.id_personal_ep')
                ->select(
                    'personal_ep.nombres',
                    'personal_ep.apellidos',
                    'personal_ep.ci',
                    'personal_ep.lugar_de_trabajo',
                    'personal_ep.cargo_a_desarrollar',
                    'personal_ep.num_empleado',
                    'personal_ep.fecha_de_ingreso',
                    'historial_personal_ep.id as id_historial_personal_ep',
                    'historial_personal_ep.*'
                )
                ->where('historial_personal_ep.id', Crypt::decrypt($id))
                ->where('personal_ep.status', true)
                ->where('historial_personal_ep.status', true)
                ->first();

            if ($historial_personal_ep_personal_ep == null) {

                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $pdf_render = Pdf::loadView('PDFVerHistorialPersonalEP', ['historial_personal_ep_personal_ep' => $historial_personal_ep_personal_ep]);
        $pdf_render->setPaper('legal', 'portrait');
        $pdf_render->render();

        $pdf = $pdf_render->download(date('Y-m-d') . '--' . $historial_personal_ep_personal_ep->num_reg . '--' . $historial_personal_ep_personal_ep->nombres . '.pdf');
        return   $pdf;
    }

    //pdf historial de antecedentes solo de 1 registro 
    public function imprimirRegistroId($id)
    {
        try {

            $historial_personal_ep_personal_ep = HistorialPersonalEP::join('personal_ep', 'personal_ep.id', '=', 'historial_personal_ep.id_personal_ep')
                ->select(
                    'personal_ep.nombres',
                    'personal_ep.apellidos',
                    'personal_ep.ci',
                    'personal_ep.lugar_de_trabajo',
                    'personal_ep.cargo_a_desarrollar',
                    'personal_ep.num_empleado',
                    'personal_ep.fecha_de_ingreso',
                    'historial_personal_ep.id as id_historial_personal_ep',
                    'historial_personal_ep.*'
                )
                ->where('historial_personal_ep.id', Crypt::decrypt($id))
                ->where('personal_ep.status', true)
                ->where('historial_personal_ep.status', true)
                ->first();

            if ($historial_personal_ep_personal_ep == null) {

                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $pdf_render = Pdf::loadView('PDFVerHistorialPersonalEP', ['historial_personal_ep_personal_ep' => $historial_personal_ep_personal_ep]);
        $pdf_render->setPaper('legal', 'portrait');
        $pdf_render->render();
        $pdf = $pdf_render->output();

        return view('ViewPDFVerHistorialPersonalEP', ['historial_personal_ep_personal_ep' => $historial_personal_ep_personal_ep, 'pdf' => $pdf]);
    }



    //validador
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
            'estado' => 'required|string|max:300',
            'mes' => 'required|string|max:300',
            'dias' => 'required|string|max:300',
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
