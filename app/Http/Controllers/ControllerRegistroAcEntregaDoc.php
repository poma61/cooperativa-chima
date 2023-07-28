<?php

namespace App\Http\Controllers;


use App\Models\HistoryDB;
use App\Models\RegistroAcEntregaDoc;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Protected\MyEncryption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ControllerRegistroAcEntregaDoc extends Controller
{

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = RegistroAcEntregaDoc::where('status', true)->orderBy('fecha_emitida', 'DESC')->get();
        return view('RegistroAcEntregaDoc', ['registro_ac_entrega_doc' => $data]);
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
            $num_registro = str_pad(RegistroAcEntregaDoc::count('num_reg') + 1, 5, '0', STR_PAD_LEFT);
            //registrar historial del registro
            $data = [
                'table' => 'actas_entrega_documentacion',
                'descripcion' => 'Registro de Actas Entrega de Documentacion',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'store',
                'registro' => $num_registro,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $registro_ac_entrega_doc = new RegistroAcEntregaDoc($request->all());
            $registro_ac_entrega_doc->status = true;
            $blob = $request->file('archivo');
            $registro_ac_entrega_doc->archivo = $blob->openFile()->fread($blob->getSize());
            $registro_ac_entrega_doc->mime_type = $blob->getMimeType();
            $registro_ac_entrega_doc->id_usuario = Auth::user()->id;
            $registro_ac_entrega_doc->num_reg = $num_registro;
            $registro_ac_entrega_doc->save();
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
            $registro_ac_entrega_doc = RegistroAcEntregaDoc::where('status', true)->find(MyEncryption::decrypt($id));
            if ($registro_ac_entrega_doc == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $data = [
            'registro_ac_entrega_doc' => $registro_ac_entrega_doc,
            'action' => 'update',
        ];

        return view('FrmRegistroAcEntregaDoc',  $data);
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
            $registro_ac_entrega_doc = RegistroAcEntregaDoc::where('status', true)->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($registro_ac_entrega_doc == null) {
                $validar['errors_db'] = true;
                $validar['errors_db_messages'] = 'Registro de Actas Entrega documentacion null';
                return response()->json($validar);
            }

            $data = [
                'table' => 'actas_entrega_documentacion',
                'descripcion' => 'Registro de Actas Entrega de Documentacion',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'update',
                'registro' => $registro_ac_entrega_doc->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $registro_ac_entrega_doc->fill($request->all());

            $blob = $request->file('archivo');
            if ($blob != null) {
                $registro_ac_entrega_doc->archivo = $blob->openFile()->fread($blob->getSize());
                $registro_ac_entrega_doc->mime_type = $blob->getMimeType();
            }

            $registro_ac_entrega_doc->id_usuario = Auth::user()->id;
            $registro_ac_entrega_doc->update();
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
            $registro_ac_entrega_doc = RegistroAcEntregaDoc::where('status', true)->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($registro_ac_entrega_doc == null) {
                $respuesta = [
                    'errors_db' => true,
                    'errors_db_messages' => 'Registro de Actas Entrega documentacion null',
                ];
                return response()->json($respuesta);
            }

            $data = [
                'table' => 'actas_entrega_documentacion',
                'descripcion' => 'Registro de Actas Entrega de Documentacion',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'destroy',
                'registro' => $registro_ac_entrega_doc->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $registro_ac_entrega_doc->status = false;
            $registro_ac_entrega_doc->save();

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
        $registro_ac_entrega_doc = new RegistroAcEntregaDoc();
        $registro_ac_entrega_doc->id = 0;
        $registro_ac_entrega_doc->fecha_emitida = date('Y-m-d');

        $num_registro = RegistroAcEntregaDoc::count('num_reg') + 1;
        $data = [
            'registro_ac_entrega_doc' => $registro_ac_entrega_doc,
            'num_registro' => $num_registro,
            'action' => 'store',
        ];
        return view('FrmRegistroAcEntregaDoc', $data);
    }


    //imprimir
    public function imprimirRegistrosAll()
    {
        try {
            $registro_ac_entrega_doc = RegistroAcEntregaDoc::where('status', true)->orderBy('fecha_emitida', 'DESC')->get();
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DESCONOCIDO']);
        }

        $pdf = Pdf::loadView('PDFAllRegistroAcEntregaDoc', ['registro_ac_entrega_doc' => $registro_ac_entrega_doc]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
        $pdf->setPaper('legal', 'landscape'); //ocicio

        $pdf->render();

        return view('ViewPDFAllRegistroAcEntregaDoc', ['registro_ac_entrega_doc' => $registro_ac_entrega_doc, 'pdf' => $pdf->output()]);
    }

    //imprimir
    public function pdfRegistrosAll()
    {
        try {
            $registro_ac_entrega_doc = RegistroAcEntregaDoc::where('status', true)->orderBy('fecha_emitida', 'DESC')->get();
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DESCONOCIDO']);
        }

        $pdf = Pdf::loadView('PDFAllRegistroAcEntregaDoc', ['registro_ac_entrega_doc' => $registro_ac_entrega_doc]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta vertical
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio vertical
        $pdf->setPaper('legal', 'landscape'); //ocicio horizontal

        $pdf->render();

        return $pdf->download(date('d-m-Y') . '-ActasEntregaDoc.pdf');
    }

    //imprimir
    public function imprimirRegistrosId(Request $request)
    {
        try {
            $registro_ac_entrega_doc = RegistroAcEntregaDoc::where('status', true)
                ->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($registro_ac_entrega_doc == null) {
                $respuesta = [
                    'status_code' => 200,
                    'errors_db_messages' => 'Registro de Actas Entrega documentacion null',
                ];
                return response()->json($respuesta);
            }

            $pdf = Pdf::loadView('PDFIdRegistroAcEntregaDoc', ['registro_ac_entrega_doc' => $registro_ac_entrega_doc]);
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
            $registro_ac_entrega_doc = RegistroAcEntregaDoc::where('status', true)->find(MyEncryption::decrypt($id));
            if ($registro_ac_entrega_doc == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'ENCRYPT']);
        }

        $pdf = Pdf::loadView('PDFIdRegistroAcEntregaDoc', ['registro_ac_entrega_doc' => $registro_ac_entrega_doc]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta vertical
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio vertical
        $pdf->setPaper('(array(0, 0, 612.00, 792.00))', 'portrait'); //ocicio


        $pdf->render();

        return $pdf->download(date('d-m-Y') . '-' . $registro_ac_entrega_doc->num_reg . '-ActasEntregaDoc.pdf');
    }

    public function archivoRegistroId(Request $request)
    {
        try {
            $registro_ac_entrega_doc = RegistroAcEntregaDoc::where('status', true)
                ->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($registro_ac_entrega_doc == null) {
                $respuesta = [
                    'status_code' => 200,
                    'errors_db_messages' => 'Registro de Actas Entrega de Documentacion null',
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
        return response()->streamDownload(function () use ($registro_ac_entrega_doc) {
            echo $registro_ac_entrega_doc->archivo;
        }, 'archivo', [
            "Content-Type" => $registro_ac_entrega_doc->mime_type,
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
            'institucion_responsable' => 'required|string|max:300',
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