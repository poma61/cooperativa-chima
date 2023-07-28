<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\SalidaAlmacen;
use App\Models\HistoryDB;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Protected\MyEncryption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ControllerSalidaAlmacen extends Controller
{

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = SalidaAlmacen::where('status', true)->orderBy('id', 'DESC')->get();
        return view('SalidaAlmacen', ['salida_almacen' => $data]);
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
            $num_registro = str_pad(SalidaAlmacen::count('num_reg') + 1, 5, '0', STR_PAD_LEFT);
            //registrar historial del registro
            $data = [
                'table' => 'salida_almacen',
                'descripcion' => 'salida almacen',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'store',
                'registro' => $num_registro,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $salida_almacen = new SalidaAlmacen($request->all());
            $salida_almacen->status = true;
            $salida_almacen->id_usuario = Auth::user()->id;
            $salida_almacen->num_reg = $num_registro;

            $blob_firma = $request->file('firma');
            $salida_almacen->firma = $blob_firma->openFile()->fread($blob_firma->getSize());
            $salida_almacen->mime_type_firma = $blob_firma->getMimeType();

            $salida_almacen->save();
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
            $salida_almacen = SalidaAlmacen::where('status', true)->find(MyEncryption::decrypt($id));
            if ($salida_almacen == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $data = [
            'salida_almacen' => $salida_almacen,
            'action' => 'update',
        ];

        return view('FrmSalidaAlmacen',  $data);
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
            $salida_almacen = SalidaAlmacen::where('status', true)->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($salida_almacen == null) {
                $validar['errors_db'] = true;
                $validar['errors_db_messages'] = 'salida almacen null';
                return response()->json($validar);
            }

            $data = [
                'table' => 'salida_almacen',
                'descripcion' => 'salida almacen',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'update',
                'registro' => $salida_almacen->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $salida_almacen->fill($request->all());
            $salida_almacen->id_usuario = Auth::user()->id;

            $blob_firma = $request->file('firma');

            if ($blob_firma != null) {
                $salida_almacen->firma = $blob_firma->openFile()->fread($blob_firma->getSize());
                $salida_almacen->mime_type_firma = $blob_firma->getMimeType();
            }

            $salida_almacen->update();
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
            $salida_almacen = SalidaAlmacen::where('status', true)->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($salida_almacen == null) {
                $respuesta = [
                    'errors_db' => true,
                    'errors_db_messages' => 'salida almacen null',
                ];
                return response()->json($respuesta);
            }

            $data = [
                'table' => 'salida_almacen',
                'descripcion' => 'salida almacen',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'destroy',
                'registro' => $salida_almacen->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $salida_almacen->status = false;
            $salida_almacen->save();

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
        $salida_almacen = new SalidaAlmacen();
        $salida_almacen->id = 0;

        $num_registro = SalidaAlmacen::count('num_reg') + 1;
        $data = [
            'salida_almacen' => $salida_almacen,
            'num_registro' => $num_registro,
            'action' => 'store',
        ];
        return view('FrmSalidaAlmacen', $data);
    }

    //imprimir
    public function imprimirRegistrosAll()
    {
        try {
            $salida_almacen = SalidaAlmacen::where('status', true)->orderBy('id', 'DESC')->get();
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DESCONOCIDO']);
        }

        $pdf = Pdf::loadView('PDFSalidaAlmacen', ['salida_almacen' => $salida_almacen]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
        $pdf->setPaper('legal', 'landscape'); //ocicio

        $pdf->render();

        return view('ViewPDFSalidaAlmacen', ['salida_almacen' => $salida_almacen, 'pdf' => $pdf->output()]);
    }

    //imprimir
    public function pdfRegistrosAll()
    {
        try {
            $salida_almacen = SalidaAlmacen::where('status', true)->orderBy('id', 'DESC')->get();
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DESCONOCIDO']);
        }

        $pdf = Pdf::loadView('PDFSalidaAlmacen', ['salida_almacen' => $salida_almacen]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta vertical
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio vertical
        $pdf->setPaper('legal', 'landscape'); //ocicio horizontal

        $pdf->render();

        return $pdf->download(date('d-m-Y') . '-salida_almacen.pdf');
    }


    public function validateRequest(Request $request, $type)
    {
        switch ($type) {
            case "store":
                $validate_file = "required|mimes:png,jpg";
                break;
            case "update":
                $validate_file = "image|mimes:png,jpg";

                break;
            default:
                $validate_file = "";
                break;
        }

        $validator = Validator::make(
            $request->all(),
            [
                'cantidad' => 'required|numeric',
                'um' => 'required|string|max:400',
                'codigo' => 'required|string|max:400',
                'nombre_del_articulo' => 'required|string|max:400',
                'referencia' => 'required|string|max:600',
                'destino_sector' => 'required|string|max:400',
                'entregado_por' => 'required|string|max:400',
                'autorizado_por' => 'required|string|max:400',
                'interesado' => 'required|string|max:400',
                'firma' => $validate_file,
            ],
            [
                "um.required" => "El campo U.M. es obligatorio.",
            ]
        );

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
