<?php

namespace App\Http\Controllers;

use App\Models\HistoryDB;
use App\Models\RegistroComisionesInformes;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Protected\MyEncryption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ControllerRegistroComisionesInformes extends Controller
{

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = RegistroComisionesInformes::where('status', true)->orderBy('fecha_recibida', 'DESC')->get();
        return view('RegistroComisionesInformes', ['registro_comisiones_informes' => $data]);
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
            $num_registro = str_pad(RegistroComisionesInformes::count('num_reg') + 1, 5, '0', STR_PAD_LEFT);
            //registrar historial del registro
            $data = [
                'table' => 'registro_comisiones_informes',
                'descripcion' => 'registro de comisiones control de informes',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'store',
                'registro' => $num_registro,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $registro_comisiones_informes = new RegistroComisionesInformes($request->all());
            $registro_comisiones_informes->status = true;
            $blob = $request->file('archivo');
            $registro_comisiones_informes->archivo = $blob->openFile()->fread($blob->getSize());
            $registro_comisiones_informes->mime_type = $blob->getMimeType();
            $registro_comisiones_informes->id_usuario = Auth::user()->id;
            $registro_comisiones_informes->num_reg = $num_registro;
            $registro_comisiones_informes->save();

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
            $registro_comisiones_informes = RegistroComisionesInformes::where('status', true)->find(MyEncryption::decrypt($id));
            if ($registro_comisiones_informes == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $data = [
            'registro_comisiones_informes' => $registro_comisiones_informes,
            'action' => 'update',
        ];

        return view('FrmRegistroComisionesInformes', $data);
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
            $registro_comisiones_informes = RegistroComisionesInformes::where('status', true)->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($registro_comisiones_informes == null) {
                $validar['errors_db'] = true;
                $validar['errors_db_messages'] = 'registro de comisiones control de informes null';
                return response()->json($validar);
            }

            $data = [
                'table' => 'registro_comisiones_informes',
                'descripcion' => 'registro de comisiones control de informes',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'update',
                'registro' => $registro_comisiones_informes->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $registro_comisiones_informes->fill($request->all());

            $blob = $request->file('archivo');
            if ($blob != null) {
                $registro_comisiones_informes->archivo = $blob->openFile()->fread($blob->getSize());
                $registro_comisiones_informes->mime_type = $blob->getMimeType();
            }

            $registro_comisiones_informes->id_usuario = Auth::user()->id;
            $registro_comisiones_informes->update();
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
            $registro_comisiones_informes = RegistroComisionesInformes::where('status', true)->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($registro_comisiones_informes == null) {
                $respuesta = [
                    'errors_db' => true,
                    'errors_db_messages' => 'registro de comisiones control de informes null',
                ];
                return response()->json($respuesta);
            }

            $data = [
                'table' => 'registro_comisiones_informes',
                'descripcion' => 'registro de comisiones control de informes',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'destroy',
                'registro' => $registro_comisiones_informes->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $registro_comisiones_informes->status = false;
            $registro_comisiones_informes->save();

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

    public function viewFrm()
    {
        $registro_comisiones_informes = new RegistroComisionesInformes();
        $registro_comisiones_informes->id = 0;
        $registro_comisiones_informes->fecha_recibida = date('Y-m-d');
        $registro_comisiones_informes->fecha_de_la_comision = date('Y-m-d');
        $num_registro = RegistroComisionesInformes::count('num_reg') + 1;
        $data = [
            'registro_comisiones_informes' => $registro_comisiones_informes,
            'num_registro' => $num_registro,
            'action' => 'store',
        ];
        return view('FrmRegistroComisionesInformes', $data);
    }

    //imprimir
    public function imprimirRegistrosAll()
    {
        try {
            $registro_comisiones_informes = RegistroComisionesInformes::where('status', true)->orderBy('fecha_recibida', 'DESC')->get();

        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DESCONOCIDO']);
        }

        $pdf = Pdf::loadView('PDFAllRegistroComisionesInformes', ['registro_comisiones_informes' => $registro_comisiones_informes]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
        $pdf->setPaper('legal', 'landscape'); //ocicio

        $pdf->render();

        return view('ViewPDFAllRegistroComisionesInformes', ['registro_comisiones_informes' => $registro_comisiones_informes, 'pdf' => $pdf->output()]);
    }

    //imprimir
    public function pdfRegistrosAll()
    {
        try {
            $registro_comisiones_informes = RegistroComisionesInformes::where('status', true)->orderBy('fecha_recibida', 'DESC')->get();

        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DESCONOCIDO']);
        }

        $pdf = Pdf::loadView('PDFAllRegistroComisionesInformes', ['registro_comisiones_informes' => $registro_comisiones_informes]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta vertical
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio vertical
        $pdf->setPaper('legal', 'landscape'); //ocicio horizontal

        $pdf->render();

        return $pdf->download(date('d-m-Y') . '-registro_comisiones_informes.pdf');
    }

    //imprimir
    public function imprimirRegistrosId(Request $request)
    {
        try {
            $registro_comisiones_informes = RegistroComisionesInformes::where('status', true)
                ->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($registro_comisiones_informes == null) {
                $respuesta = [
                    'status_code' => 200,
                    'errors_db_messages' => 'Registro de comisiones informes null',
                ];
                return response()->json($respuesta);
            }

            $pdf = Pdf::loadView('PDFIdRegistroComisionesInformes', ['registro_comisiones_informes' => $registro_comisiones_informes]);
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
            $registro_comisiones_informes = RegistroComisionesInformes::where('status', true)->find(MyEncryption::decrypt($id));
            if ($registro_comisiones_informes == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $pdf = Pdf::loadView('PDFIdRegistroComisionesInformes', ['registro_comisiones_informes' => $registro_comisiones_informes]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
        $pdf->setPaper('(array(0, 0, 612.00, 792.00))', 'portrait'); //carta

        $pdf->render();
        return $pdf->download(date('d-m-Y') . '-' . $registro_comisiones_informes->num_reg . '-registro_comisiones_informes.pdf');
    }

    public function archivoRegistroId(Request $request)
    {
        try {
            $registro_comisiones_informes = RegistroComisionesInformes::where('status', true)
                ->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($registro_comisiones_informes == null) {
                $respuesta = [
                    'status_code' => 200,
                    'errors_db_messages' => 'registro de comisiones control de informes null',
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
        return response()->streamDownload(function () use ($registro_comisiones_informes) {
            echo $registro_comisiones_informes->archivo;
        }, 'nombre del archivo', [
            "Content-Type" => $registro_comisiones_informes->mime_type,
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
            'fecha_recibida' => 'required|date',
            'referencia' => 'required|string|max:600',
            'entregado_por' => 'required|string|max:300',
            'cargo' => 'required|string|max:300',
            'fecha_de_la_comision' => 'required|date',
            'descripcion' => 'required|string',
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
