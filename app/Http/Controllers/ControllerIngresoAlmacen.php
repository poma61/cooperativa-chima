<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IngresoAlmacen;
use App\Models\HistoryDB;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ControllerIngresoAlmacen extends Controller
{

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = IngresoAlmacen::where('status', true)->orderBy('id', 'DESC')->get();
        return view('IngresoAlmacen', ['ingreso_almacen' => $data]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validacion = $this->validateRequest($request);

        if ($validacion['errors_campos'] == true) {
            return response()->json($validacion);
        }

        try {
            $num_registro = str_pad(IngresoAlmacen::count('num_reg') + 1, 5, '0', STR_PAD_LEFT);
            //registrar historial del registro
            $data = [
                'table' => 'ingreso_almacen',
                'descripcion' => 'ingreso almacen',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'store',
                'registro' => $num_registro,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $ingreso_almacen = new IngresoAlmacen($request->all());
            $ingreso_almacen->status = true;
            $ingreso_almacen->id_usuario = Auth::user()->id;
            $ingreso_almacen->num_reg = $num_registro;
            $ingreso_almacen->save();
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
            $ingreso_almacen = IngresoAlmacen::where('status', true)->find(Crypt::decrypt($id));
            if ($ingreso_almacen == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $data = [
            'ingreso_almacen' => $ingreso_almacen,
            'action' => 'update',
        ];

        return view('FrmIngresoAlmacen',  $data);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validar = $this->validateRequest($request);
        if ($validar['errors_campos'] == true) {
            return response()->json($validar);
        }

        try {
            $ingreso_almacen = IngresoAlmacen::where('status', true)->find(Crypt::decrypt($request->input('id-reg')));

            if ($ingreso_almacen == null) {
                $validar['errors_db'] = true;
                $validar['errors_db_messages'] = 'ingreso almacen null';
                return response()->json($validar);
            }

            $data = [
                'table' => 'ingreso_almacen',
                'descripcion' => 'ingreso almacen',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'update',
                'registro' => $ingreso_almacen->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $ingreso_almacen->fill($request->all());
            $ingreso_almacen->id_usuario = Auth::user()->id;
            $ingreso_almacen->update();

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
            $ingreso_almacen = IngresoAlmacen::where('status', true)->find(Crypt::decrypt($request->input('id-reg')));

            if ($ingreso_almacen == null) {
                $respuesta = [
                    'errors_db' => true,
                    'errors_db_messages' => 'ingreso alamacen null',
                ];
                return response()->json($respuesta);
            }

            $data = [
                'table' => 'ingreso_almacen',
                'descripcion' => 'ingreso almacen',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'destroy',
                'registro' => $ingreso_almacen->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $ingreso_almacen->status = false;
            $ingreso_almacen->save();

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
        $ingreso_almacen = new IngresoAlmacen();
        $ingreso_almacen->id = 0;
        $ingreso_almacen->costo_unitario=0.00;
        $ingreso_almacen->divisa_costo_unitario="Bs.";
        $ingreso_almacen->total=0.00;
        $ingreso_almacen->divisa_total="Bs.";

        $num_registro = IngresoAlmacen::count('num_reg') + 1;
        $data = [
            'ingreso_almacen' => $ingreso_almacen,
            'num_registro' => $num_registro,
            'action' => 'store',
        ];
        return view('FrmIngresoAlmacen', $data);
    }

    //imprimir
    public function imprimirRegistrosAll()
    {
        try {
            $ingreso_almacen = IngresoAlmacen::where('status', true)->orderBy('id', 'DESC')->get();
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DESCONOCIDO']);
        }

        $pdf = Pdf::loadView('PDFIngresoAlmacen', ['ingreso_almacen' => $ingreso_almacen]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
        $pdf->setPaper('legal', 'landscape'); //ocicio

        $pdf->render();

        return view('ViewPDFIngresoAlmacen', ['ingreso_almacen' => $ingreso_almacen, 'pdf' => $pdf->output()]);
    }

    //imprimir
    public function pdfRegistrosAll()
    {
        try {
            $ingreso_almacen = IngresoAlmacen::where('status', true)->orderBy('id', 'DESC')->get();
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DESCONOCIDO']);
        }

        $pdf = Pdf::loadView('PDFIngresoAlmacen', ['ingreso_almacen' => $ingreso_almacen]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta vertical
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio vertical
        $pdf->setPaper('legal', 'landscape'); //ocicio horizontal

        $pdf->render();

        return $pdf->download(date('d-m-Y') . '-ingreso_almacen.pdf');
    }


    public function validateRequest(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                "n_de_documento" => "required|numeric",
                "cantidad" => "required|numeric",
                "um" => "required|string|max:400",
                "costo_unitario" => "required|numeric",
                "divisa_costo_unitario" => "required|string|max:180",
                "total" => "required|numeric",
                "divisa_total" => "required|string|max:180",
                "descripcion" => "required|string",
                "codigo" => "required|string|max:400",
                "marca" => "required|string|max:400",
                "proveedor" => "required|string|max:400",
                "entregado_por" => "required|string|max:400",
            ],
            [
                "n_de_documento.required" => "El campo N° de documento es obligatorio.",
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
