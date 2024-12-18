<?php

namespace App\Http\Controllers;

use App\Models\HistorialPersonalEM;
use App\Models\HistoryDB;
use App\Models\PersonalEM;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ControllerHistorialPersonalEM extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        try {
            $personal_em = PersonalEM::where('status', true)->find(Crypt::decrypt($id));
            if ($personal_em == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }

            $historial_personal_em = HistorialPersonalEM::select('id','num_reg', 'fecha', 'estado')
                ->where('status', true)
                ->where('id_personal_em', $personal_em->id)
                ->orderBy('fecha', 'DESC')->get();

        } catch (Exception $ex) {

 
                return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
            
        }


        return view('HistorialPersonalEM', ['personal_em' => $personal_em, 'historial_personal_em' => $historial_personal_em]);
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

            $id_personal_em = Crypt::decrypt($request->input('id-personal-em'));
            $verificar_registro = PersonalEM::select('id')->where('id', $id_personal_em)->where('status', true)->first();
            if ($verificar_registro == null) {
                $validacion['errors_db'] = true;
                $validacion['errors_db_messages'] = 'personal mita null';
                return response()->json($validacion);
            }

            $num = HistorialPersonalEM::where('id_personal_em', $id_personal_em)->count('num_reg') + 1;
            $num_reg = str_pad($num, 5, '0', STR_PAD_LEFT);

            $data = [
                'table' => 'historial_personal_em',
                'descripcion' => 'historial personal empleado de mita',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'store',
                'registro' => $num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $historial_personal_em = new HistorialPersonalEM($request->all());
            $historial_personal_em->status = true;
            $blob_file = $request->file('archivo');
            $historial_personal_em->archivo = $blob_file->openFile()->fread($blob_file->getSize());
            $historial_personal_em->mime_type = $blob_file->getMimeType();
            $historial_personal_em->id_personal_em = $id_personal_em;

            $historial_personal_em->num_reg = $num_reg;
            $historial_personal_em->save();
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
            $historial_personal_em = HistorialPersonalEM::where('status',true)->find(Crypt::decrypt($id));
            $personal_em = PersonalEM::where('status',true)->find($historial_personal_em->id_personal_em);

            if ($personal_em == null || $historial_personal_em == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }
       
        return view('FrmHistorialPersonalEM', ['historial_personal_em' => $historial_personal_em, 'personal_em' => $personal_em, 'action' => 'update']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Responsepersonal_em
     */
    public function update(Request $request)
    {
        $validar = $this->validateRequest($request, 'update');
        if ($validar['errors_campos'] == true) {
            return response()->json($validar);
        }

        try {
            $historial_personal_em = HistorialPersonalEM::where('status', true)->find(Crypt::decrypt($request->input('id-reg')));

            if ($historial_personal_em == null) {
                $validar['errors_db'] = true;
                $validar['errors_db_messages'] = 'historial personal mita null';
                return response()->json($validar);
            }

            $data = [
                'table' => 'historial_personal_em',
                'descripcion' => 'historial personal empleado de mita',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'update',
                'registro' => $historial_personal_em->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();


            $historial_personal_em->fill($request->all());
            $blob = $request->file('archivo');
            //si el usuario subio un nueva nueva imagen entones siginifica que el campo
            //imagen NO estara vacio y lo subimos al modelo
            if ($blob != null) {
                $historial_personal_em->archivo = $blob->openFile()->fread($blob->getSize());
                $historial_personal_em->mime_type = $blob->getMimeType();
            }
            $historial_personal_em->update();
            
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
            $historial_personal_em = HistorialPersonalEM::where('status', true)->find(Crypt::decrypt($request->input('id-reg')));

            if ($historial_personal_em == null) {
                $respuesta = [
                    'errors_db' => true,
                    'errors_db_messages' => 'historial personal mita null',
                ];

                return response()->json($respuesta);
            }

            $data = [
                'table' => 'historial_personal_em',
                'descripcion' => 'historial personal empleado de mita',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'destroy',
                'registro' => $historial_personal_em->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();


            $historial_personal_em->status = false;
            $historial_personal_em->save();

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
        $historial_personal_em = new HistorialPersonalEM();
        $historial_personal_em->id = 0;
        $historial_personal_em->fecha = date('Y-m-d');

        try {
            $personal_em = PersonalEM::where('status', true)->find(Crypt::decrypt($id));

            if ($personal_em == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }

        } catch (Exception) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }
        $cantidad_registros = HistorialPersonalEM::where('id_personal_em', $personal_em->id)->count('num_reg') + 1;

        return view('FrmHistorialPersonalEM', ['historial_personal_em' => $historial_personal_em, 'num_registro' => $cantidad_registros, 'personal_em' => $personal_em, 'action' => 'store']);
    }

    public function viewVerHistorial($id)
    {
        try {
            $historial_personal_em_personal_em = HistorialPersonalEM::join('personal_em', 'personal_em.id', '=', 'historial_personal_em.id_personal_em')
                ->select(
                    'personal_em.nombres',
                    'personal_em.apellidos',
                    'personal_em.ci',
                    'personal_em.lugar_de_trabajo',
                    'personal_em.cargo_a_desarrollar',
                    'personal_em.num_empleado',
                    'personal_em.fecha_de_ingreso',
                    'historial_personal_em.id as id_historial_personal_em',
                    'historial_personal_em.*'
                )
                ->where('historial_personal_em.id', Crypt::decrypt($id))
                ->where('personal_em.status', true)
                ->where('historial_personal_em.status', true)
                ->first();

            if ($historial_personal_em_personal_em == null) {

                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }

        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        return view('VerHistorialPersonalEM', ['historial_personal_em_personal_em' => $historial_personal_em_personal_em]);
    }

    //pdf
    public function pdfRegistros($id)
    {
        try {

            $personal_em = PersonalEM::where('status',true)->find(Crypt::decrypt($id));

                      
            if ($personal_em == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
            
            
            $historial_personal_em = HistorialPersonalEM::where('id_personal_em', Crypt::decrypt($id))->where('status',true)->orderBy('fecha','DESC')->get();

        } catch (Exception $ex) {
         return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $pdf_render = Pdf::loadView('PDFHistorialPersonalEM', ['historial_personal_em' => $historial_personal_em, 'personal_em' => $personal_em]);
        $pdf_render->setPaper('legal', 'portrait');
        $pdf_render->render();

        $pdf = $pdf_render->download(date('d-m-Y') . '-historial-' . $personal_em->nombres . '.pdf');
        return   $pdf;
    }

    //imprimir
    public function imprimirRegistros($id)
    {
        try {
            $personal_em = PersonalEM::where('status',true)->find(Crypt::decrypt($id));

            if ($personal_em == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }

            $historial_personal_em = HistorialPersonalEM::where('id_personal_em', Crypt::decrypt($id))->where('status',true)->orderBy('fecha','DESC')->get();
           
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $pdf_render = Pdf::loadView('PDFHistorialPersonalEM', ['historial_personal_em' => $historial_personal_em, 'personal_em' => $personal_em]);
        $pdf_render->setPaper('legal', 'portrait');
        $pdf_render->render();

        $pdf = $pdf_render->output();
        return view('ViewPDFHistorialPersonalEM', ['pdf' => $pdf,'personal_em'=>$personal_em]);
    }

     //pdf historial de antecedentes solo de 1 registro 
     public function pdfRegistroId($id)
     {
        try {

            $historial_personal_em_personal_em = HistorialPersonalEM::join('personal_em', 'personal_em.id', '=', 'historial_personal_em.id_personal_em')
                ->select(
                    'personal_em.nombres',
                    'personal_em.apellidos',
                    'personal_em.ci',
                    'personal_em.lugar_de_trabajo',
                    'personal_em.cargo_a_desarrollar',
                    'personal_em.num_empleado',
                    'personal_em.fecha_de_ingreso',
                    'historial_personal_em.id as id_historial_personal_em',
                    'historial_personal_em.*'
                )
                ->where('historial_personal_em.id', Crypt::decrypt($id))
                ->where('personal_em.status', true)
                ->where('historial_personal_em.status', true)
                ->first();

            if ($historial_personal_em_personal_em== null) {

                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $pdf_render = Pdf::loadView('PDFVerHistorialPersonalEM', ['historial_personal_em_personal_em' => $historial_personal_em_personal_em]);
         $pdf_render->setPaper('legal', 'portrait');
         $pdf_render->render();
 
         $pdf = $pdf_render->download(date('d-m-Y').'--'.$historial_personal_em_personal_em->num_reg.'--'.$historial_personal_em_personal_em->nombres.'.pdf');
         return   $pdf;
     }
 
          //pdf historial de antecedentes solo de 1 registro 
     public function imprimirRegistroId($id)
     {
        try {

            $historial_personal_em_personal_em = HistorialPersonalEM::join('personal_em', 'personal_em.id', '=', 'historial_personal_em.id_personal_em')
                ->select(
                    'personal_em.nombres',
                    'personal_em.apellidos',
                    'personal_em.ci',
                    'personal_em.lugar_de_trabajo',
                    'personal_em.cargo_a_desarrollar',
                    'personal_em.num_empleado',
                    'personal_em.fecha_de_ingreso',
                    'historial_personal_em.id as id_historial_personal_em',
                    'historial_personal_em.*'
                )
                ->where('historial_personal_em.id', Crypt::decrypt($id))
                ->where('personal_em.status', true)
                ->where('historial_personal_em.status', true)
                ->first();

            if ($historial_personal_em_personal_em== null) {

                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

         $pdf_render = Pdf::loadView('PDFVerHistorialPersonalEM', ['historial_personal_em_personal_em' => $historial_personal_em_personal_em]);
         $pdf_render->setPaper('legal', 'portrait');
         $pdf_render->render();
         $pdf = $pdf_render->output();

         return view('ViewPDFVerHistorialPersonalEM', ['historial_personal_em_personal_em' => $historial_personal_em_personal_em,'pdf'=>$pdf]);
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
                'status_code'=>200,
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
