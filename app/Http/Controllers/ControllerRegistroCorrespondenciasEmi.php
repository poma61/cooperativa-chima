<?php

namespace App\Http\Controllers;

use App\Models\HistoryDB;
use Illuminate\Http\Request;
use App\Models\RegistroCorrespondenciasEmi;
use Barryvdh\DomPDF\Facade\Pdf;

use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ControllerRegistroCorrespondenciasEmi extends Controller
{

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = RegistroCorrespondenciasEmi::where('status', true)->orderBy('fecha_emitida','DESC')->get();
        return view('RegistroCorrespondenciasEmi', ['registro_correspondencias_emi' => $data]);
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
            $num_registro = str_pad(RegistroCorrespondenciasEmi::count('num_reg') + 1, 5, '0', STR_PAD_LEFT);
            //registrar historial del registro
            $data = [
                'table' => 'registro_correspondencias_emitidas',
                'descripcion'=>'registro de correspondencias emitidas',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'store',
                'registro' => $num_registro,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $registro_correspondencias_emi = new RegistroCorrespondenciasEmi($request->all());
            $registro_correspondencias_emi->status = true;
            $blob = $request->file('archivo');
            $registro_correspondencias_emi->archivo = $blob->openFile()->fread($blob->getSize());
            $registro_correspondencias_emi->mime_type = $blob->getMimeType();
            $registro_correspondencias_emi->id_usuario = Auth::user()->id;
            $registro_correspondencias_emi->num_reg = $num_registro;
            $registro_correspondencias_emi->save();
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
            $registro_correspondencias_emi = RegistroCorrespondenciasEmi::where('status', true)->find(Crypt::decrypt($id));
            if ($registro_correspondencias_emi == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $data = [
            'registro_correspondencias_emi' => $registro_correspondencias_emi,
            'action' => 'update',
        ];

        return view('FrmRegistroCorrespondenciasEmi',  $data);
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
            $registro_correspondencias_emi = RegistroCorrespondenciasEmi::where('status', true)->find(Crypt::decrypt($request->input('id-reg')));

            if ($registro_correspondencias_emi == null) {
                $validar['errors_db'] = true;
                $validar['errors_db_messages'] = 'registro de correspondencias emitidas null';
                return response()->json($validar);
            }

            $data = [
                'table' => 'registro_correspondencias_emitidas',
                'descripcion'=>'registro de correspondencias emitidas',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'update',
                'registro' => $registro_correspondencias_emi->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $registro_correspondencias_emi->fill($request->all());

            $blob = $request->file('archivo');
            if ($blob != null) {
                $registro_correspondencias_emi->archivo = $blob->openFile()->fread($blob->getSize());
                $registro_correspondencias_emi->mime_type = $blob->getMimeType();
            }
          
            $registro_correspondencias_emi->id_usuario = Auth::user()->id;
            $registro_correspondencias_emi->update();
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
            $registro_correspondencias_emi = RegistroCorrespondenciasEmi::where('status', true)->find(Crypt::decrypt($request->input('id-reg')));

            if ($registro_correspondencias_emi == null) {
                $respuesta = [
                    'errors_db' => true,
                    'errors_db_messages' => 'registro de correspondencias emitidas null',
                ];
                return response()->json($respuesta);
            }

            $data = [
                'table' => 'registro_correspondencias_emitidas',
                'descripcion'=>'registro de correspondencias emitidas',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'destroy',
                'registro' => $registro_correspondencias_emi->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $registro_correspondencias_emi->status = false;
            $registro_correspondencias_emi->save();

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
        $registro_correspondencias_emi = new RegistroCorrespondenciasEmi();
        $registro_correspondencias_emi->id = 0;
        $registro_correspondencias_emi->fecha_emitida = date('Y-m-d');
        $registro_correspondencias_emi->fecha_recibida = date('Y-m-d');
        $registro_correspondencias_emi->fecha_de_respuesta = date('Y-m-d');
        $num_registro = RegistroCorrespondenciasEmi::count('num_reg') + 1;
        $data = [
            'registro_correspondencias_emi' => $registro_correspondencias_emi,
            'num_registro' => $num_registro,
            'action' => 'store',
        ];
        return view('FrmRegistroCorrespondenciasEmi', $data);
    }

    public function verRegistro($id){
        try {
            $registro_correspondencias_emi = RegistroCorrespondenciasEmi::where('status', true)->find(Crypt::decrypt($id));
            if ($registro_correspondencias_emi == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        return view('VerRegistroCorrespondenciasEmi', ['registro_correspondencias_emi' => $registro_correspondencias_emi]);

    }


  //imprimir
  public function imprimirRegistrosAll()
  {
      try {
          $registro_correspondencias_emi = RegistroCorrespondenciasEmi::where('status', true)->orderBy('fecha_emitida','DESC')->get();
         
      } catch (Exception $ex) {

          return view('PageNotFound', ['tipo_error' => 'DESCONOCIDO']);
      }

      $pdf = Pdf::loadView('PDFRegistroCorrespondenciasEmi', ['registro_correspondencias_emi' => $registro_correspondencias_emi]);
       //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
      $pdf->setPaper('legal', 'landscape'); //ocicio

      $pdf->render();

      return view('ViewPDFRegistroCorrespondenciasEmi', ['registro_correspondencias_emi' => $registro_correspondencias_emi, 'pdf' => $pdf->output()]);
  }

   //imprimir
   public function pdfRegistrosAll()
   {
       try {
           $registro_correspondencias_emi = RegistroCorrespondenciasEmi::where('status', true)->orderBy('fecha_emitida','DESC')->get();
         
       } catch (Exception $ex) {
 
           return view('PageNotFound', ['tipo_error' => 'DESCONOCIDO']);
       }
 
       $pdf = Pdf::loadView('PDFRegistroCorrespondenciasEmi', ['registro_correspondencias_emi' => $registro_correspondencias_emi]);
        //tamaño carta array(0, 0, 612.00, 792.00)
         //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'
 
         // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta vertical
         //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio vertical
       $pdf->setPaper('legal', 'landscape'); //ocicio horizontal
 
       $pdf->render();
 
       return $pdf->download(date('d-m-Y').'-CorrespondenciasEmitidas.pdf');
   }
 
   //imprimir
   public function imprimirRegistrosId($id)
   {


       try {
           $registro_correspondencias_emi = RegistroCorrespondenciasEmi::where('status', true)->find(Crypt::decrypt($id));
           if ($registro_correspondencias_emi == null) {
               return view('PageNotFound', ['tipo_error' => 'NULL']);
           }
       } catch (Exception $ex) {
 
           return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
       }
 
       $pdf = Pdf::loadView('PDFVerRegistroCorrespondenciasEmi', ['registro_correspondencias_emi' => $registro_correspondencias_emi]);
        //tamaño carta array(0, 0, 612.00, 792.00)
         //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'
 
         // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
         //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
       $pdf->setPaper('(array(0, 0, 612.00, 792.00))', 'portrait'); //carta
 
       $pdf->render();
 
       return view('ViewPDFVerRegistroCorrespondenciasEmi', ['registro_correspondencias_emi' => $registro_correspondencias_emi, 'pdf' => $pdf->output()]);
   }

     //imprimir
     public function pdfRegistrosId($id)
     {
  
        try {
            $registro_correspondencias_emi = RegistroCorrespondenciasEmi::where('status', true)->find(Crypt::decrypt($id));
            if ($registro_correspondencias_emi == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
  
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }
  
        $pdf = Pdf::loadView('PDFVerRegistroCorrespondenciasEmi', ['registro_correspondencias_emi' => $registro_correspondencias_emi]);
         //tamaño carta array(0, 0, 612.00, 792.00)
          //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'
  
          // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
          //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
        $pdf->setPaper('(array(0, 0, 612.00, 792.00))', 'portrait'); //carta
  
        $pdf->render();
       return $pdf->download(date('d-m-Y').'-'.$registro_correspondencias_emi->num_reg.'-CorrespondenciaEmitida.pdf');
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
            'entregado_a' => 'required|string|max:300',
            'cargo' => 'required|string|max:300',
            'fecha_recibida' => 'required|date',
            'observacion' => 'required|string',
            'fecha_de_respuesta' => 'required|date',
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
