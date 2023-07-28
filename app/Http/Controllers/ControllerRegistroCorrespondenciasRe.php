<?php

namespace App\Http\Controllers;

use App\Models\HistoryDB;
use Illuminate\Http\Request;
use App\Models\RegistroCorrespondenciasRe;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Protected\MyEncryption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Psy\VersionUpdater\Downloader;

class ControllerRegistroCorrespondenciasRe extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = RegistroCorrespondenciasRe::where('status', true)->orderBy('fecha','DESC')->get();
        return view('RegistroCorrespondenciasRe', ['registro_correspondencias_re' => $data]);
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
            $num_registro = str_pad(RegistroCorrespondenciasRe::count('num_reg') + 1, 5, '0', STR_PAD_LEFT);
            //registrar historial del registro
            $data = [
                'table' => 'registro_correspondencias_recibidas',
                'descripcion'=>'registro de correspondencias recibidas',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'store',
                'registro' => $num_registro,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $registro_correspondencias_re = new RegistroCorrespondenciasRe($request->all());
            $registro_correspondencias_re->status = true;
            $blob = $request->file('archivo');
            $registro_correspondencias_re->archivo = $blob->openFile()->fread($blob->getSize());
            $registro_correspondencias_re->mime_type = $blob->getMimeType();
            $registro_correspondencias_re->id_usuario = Auth::user()->id;
            $registro_correspondencias_re->num_reg = $num_registro;
            $registro_correspondencias_re->save();
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
            $registro_correspondencias_re = RegistroCorrespondenciasRe::where('status', true)->find(MyEncryption::decrypt($id));
            if ($registro_correspondencias_re == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $data = [
            'registro_correspondencias_re' => $registro_correspondencias_re,
            'action' => 'update',
        ];

        return view('FrmRegistroCorrespondenciasRe',  $data);
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
            $registro_correspondencias_re = RegistroCorrespondenciasRe::where('status', true)->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($registro_correspondencias_re == null) {
                $validar['errors_db'] = true;
                $validar['errors_db_messages'] = 'registro de correspondencias recibidas null';
                return response()->json($validar);
            }

            $data = [
                'table' => 'registro_correspondencias_recibidas',
                'descripcion'=>'registro de correspondencias recibidas',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'update',
                'registro' => $registro_correspondencias_re->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $registro_correspondencias_re->fill($request->all());

            $blob = $request->file('archivo');
            if ($blob != null) {
                $registro_correspondencias_re->archivo = $blob->openFile()->fread($blob->getSize());
                $registro_correspondencias_re->mime_type = $blob->getMimeType();
            }
          
            $registro_correspondencias_re->id_usuario = Auth::user()->id;
            $registro_correspondencias_re->update();
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
            $registro_correspondencias_re = RegistroCorrespondenciasRe::where('status', true)->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($registro_correspondencias_re == null) {
                $respuesta = [
                    'errors_db' => true,
                    'errors_db_messages' => 'registro de correspondencias recibidas null',
                ];
                return response()->json($respuesta);
            }

            $data = [
                'table' => 'registro_correspondencias_recibidas',
                'descripcion'=>'registro de correspondencias recibidas',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'destroy',
                'registro' => $registro_correspondencias_re->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $registro_correspondencias_re->status = false;
            $registro_correspondencias_re->save();

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
        $registro_correspondencias_re = new RegistroCorrespondenciasRe();
        $registro_correspondencias_re->id = 0;
        $registro_correspondencias_re->fecha = date('Y-m-d');
        $registro_correspondencias_re->fecha_de_respuesta = date('Y-m-d');
        $num_registro = RegistroCorrespondenciasRe::count('num_reg') + 1;
        $data = [
            'registro_correspondencias_re' => $registro_correspondencias_re,
            'num_registro' => $num_registro,
            'action' => 'store',
        ];
        return view('FrmRegistroCorrespondenciasRe', $data);
    }

    public function verRegistro($id){
        try {
            $registro_correspondencias_re = RegistroCorrespondenciasRe::where('status', true)->find(MyEncryption::decrypt($id));
            if ($registro_correspondencias_re == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        return view('VerRegistroCorrespondenciasRe', ['registro_correspondencias_re' => $registro_correspondencias_re]);

    }


  //imprimir
  public function imprimirRegistrosAll()
  {
      try {
          $registro_correspondencias_re = RegistroCorrespondenciasRe::where('status', true)->orderBy('fecha','DESC')->get();
         
      } catch (Exception $ex) {

          return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
      }

      $pdf = Pdf::loadView('PDFRegistroCorrespondenciasRe', ['registro_correspondencias_re' => $registro_correspondencias_re]);
       //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
      $pdf->setPaper('legal', 'landscape'); //ocicio

      $pdf->render();

      return view('ViewPDFRegistroCorrespondenciasRe', ['registro_correspondencias_re' => $registro_correspondencias_re, 'pdf' => $pdf->output()]);
  }

   //imprimir
   public function pdfRegistrosAll()
   {
       try {
           $registro_correspondencias_re = RegistroCorrespondenciasRe::where('status', true)->orderBy('fecha','DESC')->get();
         
       } catch (Exception $ex) {
 
           return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
       }
 
       $pdf = Pdf::loadView('PDFRegistroCorrespondenciasRe', ['registro_correspondencias_re' => $registro_correspondencias_re]);
        //tamaño carta array(0, 0, 612.00, 792.00)
         //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'
 
         // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta vertical
         //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio vertical
       $pdf->setPaper('legal', 'landscape'); //ocicio horizontal
 
       $pdf->render();
 
       return $pdf->download(date('d-m-Y').'-CorrespondenciasRecibidas.pdf');
   }
 
   //imprimir
   public function imprimirRegistrosId($id)
   {


       try {
           $registro_correspondencias_re = RegistroCorrespondenciasRe::where('status', true)->find(MyEncryption::decrypt($id));
           if ($registro_correspondencias_re == null) {
               return view('PageNotFound', ['tipo_error' => 'NULL']);
           }
       } catch (Exception $ex) {
 
           return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
       }
 
       $pdf = Pdf::loadView('PDFVerRegistroCorrespondenciasRe', ['registro_correspondencias_re' => $registro_correspondencias_re]);
        //tamaño carta array(0, 0, 612.00, 792.00)
         //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'
 
         // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
         //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
       $pdf->setPaper('(array(0, 0, 612.00, 792.00))', 'portrait'); //carta
 
       $pdf->render();
 
       return view('ViewPDFVerRegistroCorrespondenciasRe', ['registro_correspondencias_re' => $registro_correspondencias_re, 'pdf' => $pdf->output()]);
   }

     //imprimir
     public function pdfRegistrosId($id)
     {
  
        try {
            $registro_correspondencias_re = RegistroCorrespondenciasRe::where('status', true)->find(MyEncryption::decrypt($id));
            if ($registro_correspondencias_re == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
  
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }
  
        $pdf = Pdf::loadView('PDFVerRegistroCorrespondenciasRe', ['registro_correspondencias_re' => $registro_correspondencias_re]);
         //tamaño carta array(0, 0, 612.00, 792.00)
          //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'
  
          // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
          //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
        $pdf->setPaper('(array(0, 0, 612.00, 792.00))', 'portrait'); //carta
  
        $pdf->render();
       return $pdf->download(date('d-m-Y').'-'.$registro_correspondencias_re->num_reg.'-Correspondencia-recibida.pdf');
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
            'fecha' => 'required|date',
            'pestana_carpeta' => 'required|string|max:300',
            'referencia' => 'required|string|max:550',
            'entregado_por' => 'required|string|max:300',
            'recibido_por' => 'required|string|max:300',
            'cuenta' => 'required|string|max:300',
            'descripcion_observacion' => 'required|string',
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
