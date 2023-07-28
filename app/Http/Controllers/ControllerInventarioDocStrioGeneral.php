<?php

namespace App\Http\Controllers;

use App\Models\HistoryDB;
use App\Models\InventarioDocStrioGeneral;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Protected\MyEncryption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ControllerInventarioDocStrioGeneral extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = InventarioDocStrioGeneral::where('status', true)->orderBy('id', 'DESC')->get();
        return view('InventarioDocStrioGeneral', ['inventario_doc_strio_general' => $data]);
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
            $num_registro = str_pad(InventarioDocStrioGeneral::count('num_reg') + 1, 5, '0', STR_PAD_LEFT);
            //registrar historial del registro
            $data = [
                'table' => 'inventario_doc_strio_general',
                'descripcion' => 'Inventario de documentacion - Strio. General',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'store',
                'registro' => $num_registro,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $inventario_doc_strio_general = new InventarioDocStrioGeneral($request->all());
            $inventario_doc_strio_general->status = true;
            $blob = $request->file('archivo');
            $inventario_doc_strio_general->archivo = $blob->openFile()->fread($blob->getSize());
            $inventario_doc_strio_general->mime_type = $blob->getMimeType();
            $inventario_doc_strio_general->id_usuario = Auth::user()->id;
            $inventario_doc_strio_general->num_reg = $num_registro;
            $inventario_doc_strio_general->save();
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
            $inventario_doc_strio_general = InventarioDocStrioGeneral::where('status', true)->find(MyEncryption::decrypt($id));
            if ($inventario_doc_strio_general == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $data = [
            'inventario_doc_strio_general' => $inventario_doc_strio_general,
            'action' => 'update',
        ];

        return view('FrmInventarioDocStrioGeneral',  $data);
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
            $inventario_doc_strio_general = InventarioDocStrioGeneral::where('status', true)->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($inventario_doc_strio_general == null) {
                $validar['errors_db'] = true;
                $validar['errors_db_messages'] = 'Inventario de documentacion - Strio. General null';
                return response()->json($validar);
            }

            $data = [
                'table' => 'inventario_doc_strio_general',
                'descripcion' => 'Inventario de documentacion - Strio. General',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'update',
                'registro' => $inventario_doc_strio_general->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $inventario_doc_strio_general->fill($request->all());

            $blob = $request->file('archivo');
            if ($blob != null) {
                $inventario_doc_strio_general->archivo = $blob->openFile()->fread($blob->getSize());
                $inventario_doc_strio_general->mime_type = $blob->getMimeType();
            }

            $inventario_doc_strio_general->id_usuario = Auth::user()->id;
            $inventario_doc_strio_general->update();
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
            $inventario_doc_strio_general = InventarioDocStrioGeneral::where('status', true)->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($inventario_doc_strio_general == null) {
                $respuesta = [
                    'errors_db' => true,
                    'errors_db_messages' => 'Inventario de documentacion - Strio. General null',
                ];
                return response()->json($respuesta);
            }

            $data = [
                'table' => 'inventario_doc_strio_general',
                'descripcion' => 'Inventario de documentacion - Strio. General',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'destroy',
                'registro' => $inventario_doc_strio_general->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $inventario_doc_strio_general->status = false;
            $inventario_doc_strio_general->save();

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
        $inventario_doc_strio_general = new InventarioDocStrioGeneral();
        $inventario_doc_strio_general->id = 0;
        $inventario_doc_strio_general->cantidad = 0;

        $num_registro = InventarioDocStrioGeneral::count('num_reg') + 1;
        $data = [
            'inventario_doc_strio_general' => $inventario_doc_strio_general,
            'num_registro' => $num_registro,
            'action' => 'store',
        ];
        return view('FrmInventarioDocStrioGeneral', $data);
    }


    //imprimir
    public function imprimirRegistrosAll()
    {
        try {
            $inventario_doc_strio_general = InventarioDocStrioGeneral::where('status', true)->orderBy('id', 'DESC')->get();
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DESCONOCIDO']);
        }

        $pdf = Pdf::loadView('PDFAllInventarioDocStrioGeneral', ['inventario_doc_strio_general' => $inventario_doc_strio_general]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
        $pdf->setPaper('legal', 'landscape'); //ocicio

        $pdf->render();

        return view('ViewPDFAllInventarioDocStrioGeneral', ['inventario_doc_strio_general' => $inventario_doc_strio_general, 'pdf' => $pdf->output()]);
    }

    //imprimir
    public function pdfRegistrosAll()
    {
        try {
            $inventario_doc_strio_general = InventarioDocStrioGeneral::where('status', true)->orderBy('id', 'DESC')->get();
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DESCONOCIDO']);
        }

        $pdf = Pdf::loadView('PDFAllInventarioDocStrioGeneral', ['inventario_doc_strio_general' => $inventario_doc_strio_general]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta vertical
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio vertical
        $pdf->setPaper('legal', 'landscape'); //ocicio horizontal

        $pdf->render();

        return $pdf->download(date('d-m-Y') . '-inventario_doc_strio_general.pdf');
    }

    //imprimir
    public function imprimirRegistrosId(Request $request)
    {
        try {
            $inventario_doc_strio_general = InventarioDocStrioGeneral::where('status', true)
                ->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($inventario_doc_strio_general == null) {
                $respuesta = [
                    'status_code' => 200,
                    'errors_db_messages' => 'Inventario de documentacion - Strio. General null',
                ];
                return response()->json($respuesta);
            }

            $pdf = Pdf::loadView('PDFIdInventarioDocStrioGeneral', ['inventario_doc_strio_general' => $inventario_doc_strio_general]);
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
            $inventario_doc_strio_general = InventarioDocStrioGeneral::where('status', true)->find(MyEncryption::decrypt($id));
            if ($inventario_doc_strio_general == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'ENCRYPT']);
        }

        $pdf = Pdf::loadView('PDFIdInventarioDocStrioGeneral', ['inventario_doc_strio_general' => $inventario_doc_strio_general]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta vertical
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio vertical
        $pdf->setPaper('(array(0, 0, 612.00, 792.00))', 'portrait'); //ocicio


        $pdf->render();

        return $pdf->download(date('d-m-Y') . '-' . $inventario_doc_strio_general->num_reg . '-inventario_doc_strio_general.pdf');
    }

    public function archivoRegistroId(Request $request)
    {
        try {
            $inventario_doc_strio_general = InventarioDocStrioGeneral::where('status', true)
                ->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($inventario_doc_strio_general == null) {
                $respuesta = [
                    'status_code' => 200,
                    'errors_db_messages' => 'Inventario de documentacion - Strio. General null',
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
        return response()->streamDownload(function () use ($inventario_doc_strio_general) {
            echo $inventario_doc_strio_general->archivo;
        }, 'archivo', [
            "Content-Type" => $inventario_doc_strio_general->mime_type,
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
            'detalle' => 'required|string|max:600',
            'cantidad' => 'required|numeric|min:0|max:999999999999999999',
            'rubro' => 'required|string|max:300',
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

