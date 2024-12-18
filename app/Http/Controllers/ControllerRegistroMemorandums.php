<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroMemorandums;
use App\Models\HistoryDB;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ControllerRegistroMemorandums extends Controller
{

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = RegistroMemorandums::where('status', true)->orderBy('fecha_emitida','DESC')->get();
        return view('RegistroMemorandums', ['registro_memorandums' => $data]);
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
            $num_registro = str_pad(RegistroMemorandums::count('num_reg') + 1, 5, '0', STR_PAD_LEFT);
            //registrar historial del registro
            $data = [
                'table' => 'registro_memorandums',
                'descripcion'=>'registro - memorandums',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'store',
                'registro' => $num_registro,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $registro_memorandums = new RegistroMemorandums($request->all());
            $registro_memorandums->status = true;
            $blob = $request->file('archivo');
            $registro_memorandums->archivo = $blob->openFile()->fread($blob->getSize());
            $registro_memorandums->mime_type = $blob->getMimeType();
            $registro_memorandums->id_usuario = Auth::user()->id;
            $registro_memorandums->num_reg = $num_registro;
            $registro_memorandums->save();

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
            $registro_memorandums = RegistroMemorandums::where('status', true)->find(Crypt::decrypt($id));
            if ($registro_memorandums == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $data = [
            'registro_memorandums' => $registro_memorandums,
            'action' => 'update',
        ];

        return view('FrmRegistroMemorandums',  $data);
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
            $registro_memorandums = RegistroMemorandums::where('status', true)->find(Crypt::decrypt($request->input('id-reg')));

            if ($registro_memorandums == null) {
                $validar['errors_db'] = true;
                $validar['errors_db_messages'] = 'registro - memorandums null';
                return response()->json($validar);
            }

            $data = [
                'table' => 'registro_memorandums',
                'descripcion'=>'registro - memorandums',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'update',
                'registro' => $registro_memorandums->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $registro_memorandums->fill($request->all());

            $blob = $request->file('archivo');
            if ($blob != null) {
                $registro_memorandums->archivo = $blob->openFile()->fread($blob->getSize());
                $registro_memorandums->mime_type = $blob->getMimeType();
            }
          
            $registro_memorandums->id_usuario = Auth::user()->id;
            $registro_memorandums->update();
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
            $registro_memorandums = RegistroMemorandums::where('status', true)->find(Crypt::decrypt($request->input('id-reg')));

            if ($registro_memorandums == null) {
                $respuesta = [
                    'errors_db' => true,
                    'errors_db_messages' => 'registro - memorandums null',
                ];
                return response()->json($respuesta);
            }

            $data = [
                'table' => 'registro_memorandums',
                'descripcion'=>'registro - memorandums',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'destroy',
                'registro' => $registro_memorandums->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $registro_memorandums->status = false;
            $registro_memorandums->save();

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
        $registro_memorandums = new RegistroMemorandums();
        $registro_memorandums->id = 0;
        $registro_memorandums->sancion_gr = 0.00;
        $registro_memorandums->sancion_bs = 0.00;
        $registro_memorandums->fecha_emitida = date('Y-m-d');
        $registro_memorandums->fecha_recibida = date('Y-m-d');

        $num_registro = RegistroMemorandums::count('num_reg') + 1;
        $data = [
            'registro_memorandums' => $registro_memorandums,
            'num_registro' => $num_registro,
            'action' => 'store',
        ];
        return view('FrmRegistroMemorandums', $data);
    }

    public function verRegistro($id){
        try {
            $registro_memorandums = RegistroMemorandums::where('status', true)->find(Crypt::decrypt($id));
            if ($registro_memorandums == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        return view('VerRegistroMemorandums', ['registro_memorandums' => $registro_memorandums]);

    }


  //imprimir
  public function imprimirRegistrosAll()
  {
      try {
          $registro_memorandums = RegistroMemorandums::where('status', true)->orderBy('fecha_emitida','DESC')->get();
         
      } catch (Exception $ex) {

          return view('PageNotFound', ['tipo_error' => 'DESCONOCIDO']);
      }

      $pdf = Pdf::loadView('PDFRegistroMemorandums', ['registro_memorandums' => $registro_memorandums]);
       //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
      $pdf->setPaper('legal', 'landscape'); //ocicio

      $pdf->render();

      return view('ViewPDFRegistroMemorandums', ['registro_memorandums' => $registro_memorandums, 'pdf' => $pdf->output()]);
  }

   //imprimir
   public function pdfRegistrosAll()
   {
       try {
           $registro_memorandums = RegistroMemorandums::where('status', true)->orderBy('fecha_emitida','DESC')->get();
         
       } catch (Exception $ex) {
 
           return view('PageNotFound', ['tipo_error' => 'DESCONOCIDO']);
       }
 
       $pdf = Pdf::loadView('PDFRegistroMemorandums', ['registro_memorandums' => $registro_memorandums]);
        //tamaño carta array(0, 0, 612.00, 792.00)
         //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'
 
         // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta vertical
         //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio vertical
       $pdf->setPaper('legal', 'landscape'); //ocicio horizontal
 
       $pdf->render();
 
       return $pdf->download(date('d-m-Y').'-memorandums.pdf');
   }
 
   //imprimir
   public function imprimirRegistrosId($id)
   {
       try {
           $registro_memorandums = RegistroMemorandums::where('status', true)->find(Crypt::decrypt($id));
           if ($registro_memorandums == null) {
               return view('PageNotFound', ['tipo_error' => 'NULL']);
           }
       } catch (Exception $ex) {
 
           return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
       }
 
       $pdf = Pdf::loadView('PDFVerRegistroMemorandums', ['registro_memorandums' => $registro_memorandums]);
        //tamaño carta array(0, 0, 612.00, 792.00)
         //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'
 
         // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
         //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
       $pdf->setPaper('(array(0, 0, 612.00, 792.00))', 'portrait'); //carta
 
       $pdf->render();
 
       return view('ViewPDFVerRegistroMemorandums', ['registro_memorandums' => $registro_memorandums, 'pdf' => $pdf->output()]);
   }

     //imprimir
     public function pdfRegistrosId($id)
     {
  
        try {
            $registro_memorandums = RegistroMemorandums::where('status', true)->find(Crypt::decrypt($id));
            if ($registro_memorandums == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
  
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }
  
        $pdf = Pdf::loadView('PDFVerRegistroMemorandums', ['registro_memorandums' => $registro_memorandums]);
         //tamaño carta array(0, 0, 612.00, 792.00)
          //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'
  
          // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
          //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
        $pdf->setPaper('(array(0, 0, 612.00, 792.00))', 'portrait'); //carta
  
        $pdf->render();
       return $pdf->download(date('d-m-Y').'-'.$registro_memorandums->num_reg.'-memorandums.pdf');
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
            'referencia' => 'required|string|max:600',
            'entregado_a' => 'required|string|max:300',
            'cargo' => 'required|string|max:300',
            'sancion_gr' => 'required|numeric|max:999999999999999',
            'sancion_bs' => 'required|numeric|max:999999999999999',
            'descripcion' => 'required|string',
            'fecha_recibida' => 'required|date',
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