<?php

namespace App\Http\Controllers;

use App\Models\FaltasSociosAsAcontecimientos;
use App\Models\HistoryDB;
use App\Models\Socios;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ControllerFaltasSociosAsAcontecimientos extends Controller
{

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = FaltasSociosAsAcontecimientos::join('socios', 'socios.id', '=', 'faltas_socios_as_acontecimientos.id_socio')
            ->select(
                'socios.nombres',
                'socios.apellidos',
                'faltas_socios_as_acontecimientos.*'
            )
            ->where('socios.status', true)
            ->where('faltas_socios_as_acontecimientos.status', true)
            ->orderBy('id','DESC')
            ->get();

       
        return view('FaltasSociosAsAcontecimientos', ['faltas_socios_as_acontecimientos' => $data]);
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

            $faltas_socios_as_acontecimientos = new FaltasSociosAsAcontecimientos($request->all());
            $faltas_socios_as_acontecimientos->status = true;
            $faltas_socios_as_acontecimientos->id_usuario = Auth::user()->id;
            $faltas_socios_as_acontecimientos->id_socio = Crypt::decrypt($request->input('id_socio'));
            $faltas_socios_as_acontecimientos->save();

            $data = [
                'table' => 'faltas_socios_as_acontecimientos',
                'descripcion' => 'faltas socios asambleas y acontecimientos',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'store',
                'registro' => $faltas_socios_as_acontecimientos->id,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

        } catch (Exception $ex) {

            $validacion['errors_db'] = true;
            $validacion['errors_db_messages'] = $ex;

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

            $faltas_socios_as_acontecimientos = FaltasSociosAsAcontecimientos::join('socios', 'socios.id', '=', 'faltas_socios_as_acontecimientos.id_socio')
            ->select(
                'socios.nombres',
                'socios.apellidos',
                'faltas_socios_as_acontecimientos.*'
            )
            ->where('socios.status', true)
            ->where('faltas_socios_as_acontecimientos.id', Crypt::decrypt($id))
            ->where('faltas_socios_as_acontecimientos.status', true)
            ->first();


            if ($faltas_socios_as_acontecimientos == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }

          $id_socio=Crypt::encrypt($faltas_socios_as_acontecimientos->id_socio);
          $faltas_socios_as_acontecimientos->id_socio=$id_socio;

            $data = [
                'faltas_socios_as_acontecimientos' => $faltas_socios_as_acontecimientos,
                'action' => 'update',
            ];


        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

      

        return view('FrmFaltasSociosAsAcontecimientos', $data);
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
            $faltas_socios_as_acontecimientos = FaltasSociosAsAcontecimientos::where('status', true)->find(Crypt::decrypt($request->input('id-reg')));

            if ($faltas_socios_as_acontecimientos == null) {
                $validar['errors_db'] = true;
                $validar['errors_db_messages'] = 'faltas socios asambleas y acontecimientos null';
                return response()->json($validar);
            }

            $faltas_socios_as_acontecimientos->fill($request->all());

            $faltas_socios_as_acontecimientos->id_usuario = Auth::user()->id;
            $faltas_socios_as_acontecimientos->id_socio = Crypt::decrypt($request->input('id_socio'));
            $faltas_socios_as_acontecimientos->update();

            $data = [
                'table' => 'faltas_socios_as_acontecimientos',
                'descripcion' => 'faltas socios asambleas y acontecimientos',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'update',
                'registro' => $faltas_socios_as_acontecimientos->id,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

        } catch (Exception $ex) {
            $validar['errors_db'] = true;
            $validar['errors_db_messages'] = $ex;
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
            $faltas_socios_as_acontecimientos = FaltasSociosAsAcontecimientos::where('status', true)->find(Crypt::decrypt($request->input('id-reg')));

            if ($faltas_socios_as_acontecimientos == null) {
                $respuesta = [
                    'errors_db' => true,
                    'errors_db_messages' => 'faltas socios asambleas y acontecimientos null',
                ];
                return response()->json($respuesta);
            }

            $faltas_socios_as_acontecimientos->status = false;
            $faltas_socios_as_acontecimientos->save();

            $data = [
                'table' => 'faltas_socios_as_acontecimientos',
                'descripcion' => 'faltas socios asambleas y acontecimientos',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'destroy',
                'registro' => $faltas_socios_as_acontecimientos->id,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $respuesta = [
                'errors_db' => false,
            ];
        } catch (Exception $ex) {

            $respuesta = [
                'errors_db' => true,
                'errors_db_messages' => $ex,
            ];

        }

        return response()->json($respuesta);
    }

    public function viewFrm()
    {
        $faltas_socios_as_acontecimientos = new FaltasSociosAsAcontecimientos();
        $faltas_socios_as_acontecimientos->id = 0;
        $faltas_socios_as_acontecimientos->sancion_grm = 0.00;
        $faltas_socios_as_acontecimientos->sancion_bs = 0.00;
        $faltas_socios_as_acontecimientos->fecha = date('Y-m-d');

        $data = [
            'faltas_socios_as_acontecimientos' => $faltas_socios_as_acontecimientos,
            'action' => 'store',
        ];
        return view('FrmFaltasSociosAsAcontecimientos', $data);
    }

    //imprimir
    public function imprimirRegistrosAll()
    {
        try {
            $faltas_socios_as_acontecimientos = FaltasSociosAsAcontecimientos::join('socios', 'socios.id', '=', 'faltas_socios_as_acontecimientos.id_socio')
                ->select(
                    'socios.nombres',
                    'socios.apellidos',
                    'faltas_socios_as_acontecimientos.*'
                )
                ->where('socios.status', true)
                ->where('faltas_socios_as_acontecimientos.status', true)
                ->get();

        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DESCONOCIDO']);
        }

        $pdf = Pdf::loadView('PDFAllFaltasSociosAsAcontecimientos', ['faltas_socios_as_acontecimientos' => $faltas_socios_as_acontecimientos]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
        $pdf->setPaper('legal', 'landscape'); //ocicio

        $pdf->render();

        return view('ViewPDFAllFaltasSociosAsAcontecimientos', ['faltas_socios_as_acontecimientos' => $faltas_socios_as_acontecimientos, 'pdf' => $pdf->output()]);
    }

    //imprimir
    public function pdfRegistrosAll()
    {
        try {
            $faltas_socios_as_acontecimientos = FaltasSociosAsAcontecimientos::join('socios', 'socios.id', '=', 'faltas_socios_as_acontecimientos.id_socio')
                ->select(
                    'socios.nombres',
                    'socios.apellidos',
                    'faltas_socios_as_acontecimientos.*'
                )
                ->where('socios.status', true)
                ->where('faltas_socios_as_acontecimientos.status', true)
                ->get();

        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DESCONOCIDO']);
        }

        $pdf = Pdf::loadView('PDFAllFaltasSociosAsAcontecimientos', ['faltas_socios_as_acontecimientos' => $faltas_socios_as_acontecimientos]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta vertical
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio vertical
        $pdf->setPaper('legal', 'landscape'); //ocicio horizontal

        $pdf->render();

        return $pdf->download(date('d-m-Y') . '-faltas_socios_as_acontecimientos.pdf');
    }

    //imprimir
    public function imprimirRegistrosId(Request $request)
    {
        try {

            $faltas_socios_as_acontecimientos = FaltasSociosAsAcontecimientos::join('socios', 'socios.id', '=', 'faltas_socios_as_acontecimientos.id_socio')
                ->select(
                    'socios.nombres',
                    'socios.apellidos',
                    'faltas_socios_as_acontecimientos.*'
                )
                ->where('socios.status', true)
                ->where('faltas_socios_as_acontecimientos.id', Crypt::decrypt($request->input('id-reg')))
                ->where('faltas_socios_as_acontecimientos.status', true)
                ->first();

            if ($faltas_socios_as_acontecimientos == null) {
                $respuesta = [
                    'status_code' => 200,
                    'errors_db_messages' => 'Registro de comisiones informes null',
                ];
                return response()->json($respuesta);
            }

            $pdf = Pdf::loadView('PDFIdFaltasSociosAsAcontecimientos', ['faltas_socios_as_acontecimientos' => $faltas_socios_as_acontecimientos]);
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

            $faltas_socios_as_acontecimientos = FaltasSociosAsAcontecimientos::join('socios', 'socios.id', '=', 'faltas_socios_as_acontecimientos.id_socio')
                ->select(
                    'socios.nombres',
                    'socios.apellidos',
                    'faltas_socios_as_acontecimientos.*'
                )
                ->where('socios.status', true)
                ->where('faltas_socios_as_acontecimientos.id', Crypt::decrypt($id))
                ->where('faltas_socios_as_acontecimientos.status', true)
                ->first();

            if ($faltas_socios_as_acontecimientos == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $pdf = Pdf::loadView('PDFIdFaltasSociosAsAcontecimientos', ['faltas_socios_as_acontecimientos' => $faltas_socios_as_acontecimientos]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
        $pdf->setPaper('(array(0, 0, 612.00, 792.00))', 'portrait'); //carta

        $pdf->render();
        return $pdf->download(date('d-m-Y') . '-' . $faltas_socios_as_acontecimientos->id . '-faltas_socios_as_acontecimientos.pdf');
    }


    //buscar registro
    public function buscarSocio(Request $request)
    {

        $txt = $request->input('txt-buscar');
        $socios = Socios::select('id', 'nombres', 'apellidos')
            ->whereRaw("concat_ws(' ',nombres, apellidos) like '%$txt%' or ci='$txt' ")
            ->get();

        foreach($socios as $row){
            $id =$row->id;         
            $row->id_socio = Crypt::encrypt($id) ;
            $row->id=null;
        }   
        
        return response()->json($socios);

    }

    public function validateRequest(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date',
            'acontecimiento' => 'required|string|max:700',
            'id_socio' => 'required|string',
            'sancion_grm' => 'required|numeric|max:999999999999999',
            'sancion_bs' => 'required|numeric|max:999999999999999',
            'observacion' => 'required|string',
        ],['id_socio.required'=>'El campo nombre es obligatorio']);

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
