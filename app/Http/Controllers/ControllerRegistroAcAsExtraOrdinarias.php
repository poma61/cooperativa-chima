<?php

namespace App\Http\Controllers;

use App\Models\HistoryDB;
use App\Models\RegistroAcAsExtraOrdinarias;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Protected\MyEncryption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ControllerRegistroAcAsExtraOrdinarias extends Controller
{

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = RegistroAcAsExtraOrdinarias::where('status', true)->orderBy('fecha_emitida', 'DESC')->get();
        return view('RegistroAcAsExtraOrdinarias', ['registro_ac_as_extra_ordinarias' => $data]);
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
            $num_registro = str_pad(RegistroAcAsExtraOrdinarias::count('num_reg') + 1, 5, '0', STR_PAD_LEFT);
            //registrar historial del registro
            $data = [
                'table' => 'actas_asambleas_extra_ordinarias',
                'descripcion' => 'Registro de Actas de Asambleas Extra Ordinarias',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'store',
                'registro' => $num_registro,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $registro_ac_as_extra_ordinarias = new RegistroAcAsExtraOrdinarias($request->all());
            $registro_ac_as_extra_ordinarias->status = true;
            $blob = $request->file('archivo');
            $registro_ac_as_extra_ordinarias->archivo = $blob->openFile()->fread($blob->getSize());
            $registro_ac_as_extra_ordinarias->mime_type = $blob->getMimeType();
            $registro_ac_as_extra_ordinarias->id_usuario = Auth::user()->id;
            $registro_ac_as_extra_ordinarias->num_reg = $num_registro;
            $registro_ac_as_extra_ordinarias->save();
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
            $registro_ac_as_extra_ordinarias = RegistroAcAsExtraOrdinarias::where('status', true)->find(MyEncryption::decrypt($id));
            if ($registro_ac_as_extra_ordinarias == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $data = [
            'registro_ac_as_extra_ordinarias' => $registro_ac_as_extra_ordinarias,
            'action' => 'update',
        ];

        return view('FrmRegistroAcAsExtraOrdinarias',  $data);
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
            $registro_ac_as_extra_ordinarias = RegistroAcAsExtraOrdinarias::where('status', true)->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($registro_ac_as_extra_ordinarias == null) {
                $validar['errors_db'] = true;
                $validar['errors_db_messages'] = 'Registro de Actas de Asambleas Extra Ordinarias null';
                return response()->json($validar);
            }

            $data = [
                'table' => 'actas_asambleas_extra_ordinarias',
                'descripcion' => 'Registro de Actas de Asambleas Extra Ordinarias',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'update',
                'registro' => $registro_ac_as_extra_ordinarias->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $registro_ac_as_extra_ordinarias->fill($request->all());

            $blob = $request->file('archivo');
            if ($blob != null) {
                $registro_ac_as_extra_ordinarias->archivo = $blob->openFile()->fread($blob->getSize());
                $registro_ac_as_extra_ordinarias->mime_type = $blob->getMimeType();
            }

            $registro_ac_as_extra_ordinarias->id_usuario = Auth::user()->id;
            $registro_ac_as_extra_ordinarias->update();
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
            $registro_ac_as_extra_ordinarias = RegistroAcAsExtraOrdinarias::where('status', true)->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($registro_ac_as_extra_ordinarias == null) {
                $respuesta = [
                    'errors_db' => true,
                    'errors_db_messages' => 'Registro de Actas de Asambleas Extra Ordinarias null',
                ];
                return response()->json($respuesta);
            }

            $data = [
                'table' => 'actas_asambleas_extra_ordinarias',
                'descripcion' => 'Registro de Actas de Asambleas Extra Ordinarias',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'destroy',
                'registro' => $registro_ac_as_extra_ordinarias->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $registro_ac_as_extra_ordinarias->status = false;
            $registro_ac_as_extra_ordinarias->save();

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
        $registro_ac_as_extra_ordinarias = new RegistroAcAsExtraOrdinarias();
        $registro_ac_as_extra_ordinarias->id = 0;
        $registro_ac_as_extra_ordinarias->fecha_emitida = date('Y-m-d');

        $num_registro = RegistroAcAsExtraOrdinarias::count('num_reg') + 1;
        $data = [
            'registro_ac_as_extra_ordinarias' => $registro_ac_as_extra_ordinarias,
            'num_registro' => $num_registro,
            'action' => 'store',
        ];
        return view('FrmRegistroAcAsExtraOrdinarias', $data);
    }

    public function verRegistro($id)
    {
        try {
            $registro_ac_as_extra_ordinarias = RegistroAcAsExtraOrdinarias::where('status', true)->find(MyEncryption::decrypt($id));
            if ($registro_ac_as_extra_ordinarias == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        return view('VerRegistroAcAsExtraOrdinarias', ['registro_ac_as_extra_ordinarias' => $registro_ac_as_extra_ordinarias]);
    }


    //imprimir
    public function imprimirRegistrosAll()
    {
        try {
            $registro_ac_as_extra_ordinarias = RegistroAcAsExtraOrdinarias::where('status', true)->orderBy('fecha_emitida', 'DESC')->get();
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DESCONOCIDO']);
        }

        $pdf = Pdf::loadView('PDFAllRegistroAcAsExtraOrdinarias', ['registro_ac_as_extra_ordinarias' => $registro_ac_as_extra_ordinarias]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
        $pdf->setPaper('legal', 'landscape'); //ocicio

        $pdf->render();

        return view('ViewPDFAllRegistroAcAsExtraOrdinarias', ['registro_ac_as_extra_ordinarias' => $registro_ac_as_extra_ordinarias, 'pdf' => $pdf->output()]);
    }

    //imprimir
    public function pdfRegistrosAll()
    {
        try {
            $registro_ac_as_extra_ordinarias = RegistroAcAsExtraOrdinarias::where('status', true)->orderBy('fecha_emitida', 'DESC')->get();
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DESCONOCIDO']);
        }

        $pdf = Pdf::loadView('PDFAllRegistroAcAsExtraOrdinarias', ['registro_ac_as_extra_ordinarias' => $registro_ac_as_extra_ordinarias]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta vertical
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio vertical
        $pdf->setPaper('legal', 'landscape'); //ocicio horizontal

        $pdf->render();

        return $pdf->download(date('d-m-Y') . '-AsambleasExtraOrdinarias.pdf');
    }

    //imprimir
    public function imprimirRegistrosId(Request $request)
    {
        try {
            $registro_ac_as_extra_ordinarias = RegistroAcAsExtraOrdinarias::where('status', true)
                ->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($registro_ac_as_extra_ordinarias == null) {
                $respuesta = [
                    'status_code' => 200,
                    'errors_db_messages' => 'registro de actas de asambleas extra ordinarias null',
                ];
                return response()->json($respuesta);
            }

            $pdf = Pdf::loadView('PDFIdRegistroAcAsExtraOrdinarias', ['registro_ac_as_extra_ordinarias' => $registro_ac_as_extra_ordinarias]);
            //tamaño carta array(0, 0, 612.00, 792.00)
            //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'
    
            // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
            //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
            $pdf->setPaper('(array(0, 0, 612.00, 792.00))', 'portrait'); //ocicio
    
            $pdf->render();

        } catch (Exception $ex) {

            $respuesta = [
                'status_code' => 200,
                'errors_db_messages' => $ex,
            ];

            return response()->json($respuesta);
        }

        //de esta manera se devuelven solamente datos blob 
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'archivo', [
            "Content-Type" => "application/pdf",
        ]);

    }

    //imprimir
    public function pdfRegistrosId($id)
    {
        try {
            $registro_ac_as_extra_ordinarias = RegistroAcAsExtraOrdinarias::where('status', true)->find(MyEncryption::decrypt($id));
            if ($registro_ac_as_extra_ordinarias == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'ENCRYPT']);
        }

        $pdf = Pdf::loadView('PDFIdRegistroAcAsExtraOrdinarias', ['registro_ac_as_extra_ordinarias' => $registro_ac_as_extra_ordinarias]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta vertical
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio vertical
        $pdf->setPaper('(array(0, 0, 612.00, 792.00))', 'portrait'); //ocicio


        $pdf->render();

        return $pdf->download(date('d-m-Y') . '-' . $registro_ac_as_extra_ordinarias->num_reg . '-asamblea_extra_ordinaria.pdf');
    }

    public function apiResponseArchivo(Request $request)
    {
        try {
            $registro_ac_as_extra_ordinarias = RegistroAcAsExtraOrdinarias::where('status', true)
                ->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($registro_ac_as_extra_ordinarias == null) {
                $respuesta = [
                    'status_code' => 200,
                    'errors_db_messages' => 'registro de actas de asambleas extra ordinarias null',
                ];
                return response()->json($respuesta);
            }
        } catch (Exception $ex) {
            $respuesta = [
                'status_code' => 200,
                'errors_db_messages' => $ex,
            ];

            return response()->json($respuesta);
        }

        //de esta manera se devuelven solamente datos blob 
        return response()->streamDownload(function () use ($registro_ac_as_extra_ordinarias) {
            echo $registro_ac_as_extra_ordinarias->archivo;
        }, 'archivo', [
            "Content-Type" => $registro_ac_as_extra_ordinarias->mime_type,
        ]);
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
            'fecha_emitida' => 'required|date',
            'referencia' => 'required|string|max:580',
            'descripcion' => 'required|string',
            'institucion' => 'required|string|max:300',
            'observacion' => 'required|string',
            'archivo' => $archivo_validate,

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
