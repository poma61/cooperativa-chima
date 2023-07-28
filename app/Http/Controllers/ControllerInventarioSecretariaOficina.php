<?php

namespace App\Http\Controllers;

use App\Models\HistoryDB;
use App\Models\InventarioSecretariaOficina;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Protected\MyEncryption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ControllerInventarioSecretariaOficina extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = InventarioSecretariaOficina::where('status', true)->orderBy('id', 'DESC')->get();
        return view('InventarioSecretariaOficina', ['inventario_secretaria_of' => $data]);
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
            $num_registro = str_pad(InventarioSecretariaOficina::count('num_reg') + 1, 5, '0', STR_PAD_LEFT);
            //registrar historial del registro
            $data = [
                'table' => 'inventario_secretaria_oficina',
                'descripcion' => 'Inventario Secretaria Oficina',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'store',
                'registro' => $num_registro,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $inventario_secretaria_of = new InventarioSecretariaOficina($request->all());
            $inventario_secretaria_of->status = true;
            $blob = $request->file('archivo');
            $inventario_secretaria_of->archivo = $blob->openFile()->fread($blob->getSize());
            $inventario_secretaria_of->mime_type = $blob->getMimeType();
            $inventario_secretaria_of->id_usuario = Auth::user()->id;
            $inventario_secretaria_of->num_reg = $num_registro;
            $inventario_secretaria_of->save();
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
            $inventario_secretaria_of = InventarioSecretariaOficina::where('status', true)->find(MyEncryption::decrypt($id));
            if ($inventario_secretaria_of == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $data = [
            'inventario_secretaria_of' => $inventario_secretaria_of,
            'action' => 'update',
        ];

        return view('FrmInventarioSecretariaOficina',  $data);
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
            $inventario_secretaria_of = InventarioSecretariaOficina::where('status', true)->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($inventario_secretaria_of == null) {
                $validar['errors_db'] = true;
                $validar['errors_db_messages'] = 'Inventario Secretaria Oficina null';
                return response()->json($validar);
            }

            $data = [
                'table' => 'inventario_secretaria_oficina',
                'descripcion' => 'Inventario Secretaria Oficina',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'update',
                'registro' => $inventario_secretaria_of->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $inventario_secretaria_of->fill($request->all());

            $blob = $request->file('archivo');
            if ($blob != null) {
                $inventario_secretaria_of->archivo = $blob->openFile()->fread($blob->getSize());
                $inventario_secretaria_of->mime_type = $blob->getMimeType();
            }

            $inventario_secretaria_of->id_usuario = Auth::user()->id;
            $inventario_secretaria_of->update();
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
            $inventario_secretaria_of = InventarioSecretariaOficina::where('status', true)->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($inventario_secretaria_of == null) {
                $respuesta = [
                    'errors_db' => true,
                    'errors_db_messages' => 'Inventario Secretaria Oficina null',
                ];
                return response()->json($respuesta);
            }

            $data = [
                'table' => 'inventario_secretaria_oficina',
                'descripcion' => 'Inventario Secretaria Oficina',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'destroy',
                'registro' => $inventario_secretaria_of->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $inventario_secretaria_of->status = false;
            $inventario_secretaria_of->save();

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
        $inventario_secretaria_of = new InventarioSecretariaOficina();
        $inventario_secretaria_of->id = 0;
        $inventario_secretaria_of->cantidad = 0;

        $num_registro = InventarioSecretariaOficina::count('num_reg') + 1;
        $data = [
            'inventario_secretaria_of' => $inventario_secretaria_of,
            'num_registro' => $num_registro,
            'action' => 'store',
        ];
        return view('FrmInventarioSecretariaOficina', $data);
    }


    //imprimir
    public function imprimirRegistrosAll()
    {
        try {
            $inventario_secretaria_of = InventarioSecretariaOficina::where('status', true)->orderBy('id', 'DESC')->get();
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DESCONOCIDO']);
        }

        $pdf = Pdf::loadView('PDFAllInventarioSecretariaOficina', ['inventario_secretaria_of' => $inventario_secretaria_of]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
        $pdf->setPaper('legal', 'landscape'); //ocicio

        $pdf->render();

        return view('ViewPDFAllInventarioSecretariaOficina', ['inventario_secretaria_of' => $inventario_secretaria_of, 'pdf' => $pdf->output()]);
    }

    //imprimir
    public function pdfRegistrosAll()
    {
        try {
            $inventario_secretaria_of = InventarioSecretariaOficina::where('status', true)->orderBy('id', 'DESC')->get();
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DESCONOCIDO']);
        }

        $pdf = Pdf::loadView('PDFAllInventarioSecretariaOficina', ['inventario_secretaria_of' => $inventario_secretaria_of]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta vertical
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio vertical
        $pdf->setPaper('legal', 'landscape'); //ocicio horizontal

        $pdf->render();

        return $pdf->download(date('d-m-Y') . '-inventario_secretaria_oficina.pdf');
    }

    //imprimir
    public function imprimirRegistrosId(Request $request)
    {
        try {
            $inventario_secretaria_of = InventarioSecretariaOficina::where('status', true)
                ->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($inventario_secretaria_of == null) {
                $respuesta = [
                    'status_code' => 200,
                    'errors_db_messages' => 'Inventario Secretaria Oficina null',
                ];
                return response()->json($respuesta);
            }

            $pdf = Pdf::loadView('PDFIdInventarioSecretariaOficina', ['inventario_secretaria_of' => $inventario_secretaria_of]);
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
            $inventario_secretaria_of = InventarioSecretariaOficina::where('status', true)->find(MyEncryption::decrypt($id));
            if ($inventario_secretaria_of == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'ENCRYPT']);
        }

        $pdf = Pdf::loadView('PDFIdInventarioSecretariaOficina', ['inventario_secretaria_of' => $inventario_secretaria_of]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta vertical
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio vertical
        $pdf->setPaper('(array(0, 0, 612.00, 792.00))', 'portrait'); //ocicio


        $pdf->render();

        return $pdf->download(date('d-m-Y') . '-' . $inventario_secretaria_of->num_reg . '-inventario_secretaria_oficina.pdf');
    }

    public function archivoRegistroId(Request $request)
    {
        try {
            $inventario_secretaria_of = InventarioSecretariaOficina::where('status', true)
                ->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($inventario_secretaria_of == null) {
                $respuesta = [
                    'status_code' => 200,
                    'errors_db_messages' => 'Inventario Secretaria Oficina null',
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
        return response()->streamDownload(function () use ($inventario_secretaria_of) {
            echo $inventario_secretaria_of->archivo;
        }, 'archivo', [
            "Content-Type" => $inventario_secretaria_of->mime_type,
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
            'estado' => 'required|string|max:300',
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
