<?php

namespace App\Http\Controllers;

use App\Models\HistoryDB;
use App\Models\DocumentacionPdteCsjoAdmin;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ControllerDocumentacionPdteCsjoAdmin extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       

        $data = DocumentacionPdteCsjoAdmin::where('status', true)->orderBy('id', 'DESC')->get();
        return view('DocumentacionPdteCsjoAdmin', ['doc_pdte_csjo_admin' => $data]);
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
            $num_registro = str_pad(DocumentacionPdteCsjoAdmin::count('num_reg') + 1, 5, '0', STR_PAD_LEFT);
            //registrar historial del registro
            $data = [
                'table' => 'doc_pdte_csjo_administracion',
                'descripcion' => 'Inventario de Documentacion - Pdte Csjo Administracion',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'store',
                'registro' => $num_registro,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $doc_pdte_csjo_admin = new DocumentacionPdteCsjoAdmin($request->all());
            $doc_pdte_csjo_admin->status = true;
            $blob = $request->file('archivo');
            $doc_pdte_csjo_admin->archivo = $blob->openFile()->fread($blob->getSize());
            $doc_pdte_csjo_admin->mime_type = $blob->getMimeType();
            $doc_pdte_csjo_admin->id_usuario = Auth::user()->id;
            $doc_pdte_csjo_admin->num_reg = $num_registro;
            $doc_pdte_csjo_admin->save();
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
            $doc_pdte_csjo_admin = DocumentacionPdteCsjoAdmin::where('status', true)->find(Crypt::decrypt($id));
            if ($doc_pdte_csjo_admin == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $data = [
            'doc_pdte_csjo_admin' => $doc_pdte_csjo_admin,
            'action' => 'update',
        ];

        return view('FrmDocumentacionPdteCsjoAdmin',  $data);
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
            $doc_pdte_csjo_admin = DocumentacionPdteCsjoAdmin::where('status', true)->find(Crypt::decrypt($request->input('id-reg')));

            if ($doc_pdte_csjo_admin == null) {
                $validar['errors_db'] = true;
                $validar['errors_db_messages'] = 'Inventario de Documentacion - Pdte Csjo Administracion null';
                return response()->json($validar);
            }

            $data = [
                'table' => 'doc_pdte_csjo_administracion',
                'descripcion' => 'Inventario  de Documentacion - Pdte Csjo Administracion',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'update',
                'registro' => $doc_pdte_csjo_admin->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $doc_pdte_csjo_admin->fill($request->all());

            $blob = $request->file('archivo');
            if ($blob != null) {
                $doc_pdte_csjo_admin->archivo = $blob->openFile()->fread($blob->getSize());
                $doc_pdte_csjo_admin->mime_type = $blob->getMimeType();
            }

            $doc_pdte_csjo_admin->id_usuario = Auth::user()->id;
            $doc_pdte_csjo_admin->update();
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
            $doc_pdte_csjo_admin = DocumentacionPdteCsjoAdmin::where('status', true)->find(Crypt::decrypt($request->input('id-reg')));

            if ($doc_pdte_csjo_admin == null) {
                $respuesta = [
                    'errors_db' => true,
                    'errors_db_messages' => 'Inventario de Documentacion - Pdte Csjo Administracion null',
                ];
                return response()->json($respuesta);
            }

            $data = [
                'table' => 'doc_pdte_csjo_administracion',
                'descripcion' => 'Inventario de Documentacion - Pdte Csjo Administracion',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'destroy',
                'registro' => $doc_pdte_csjo_admin->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $doc_pdte_csjo_admin->status = false;
            $doc_pdte_csjo_admin->save();

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


 


        $doc_pdte_csjo_admin = new DocumentacionPdteCsjoAdmin();
        $doc_pdte_csjo_admin->id = 0;
        $doc_pdte_csjo_admin->cantidad = 0;

        $num_registro = DocumentacionPdteCsjoAdmin::count('num_reg') + 1;
        $data = [
            'doc_pdte_csjo_admin' => $doc_pdte_csjo_admin,
            'num_registro' => $num_registro,
            'action' => 'store',
        ];
        return view('FrmDocumentacionPdteCsjoAdmin', $data);
    }


    //imprimir
    public function imprimirRegistrosAll()
    {
        try {
            $doc_pdte_csjo_admin = DocumentacionPdteCsjoAdmin::where('status', true)->orderBy('id', 'DESC')->get();
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DESCONOCIDO']);
        }

        $pdf = Pdf::loadView('PDFAllDocumentacionPdteCsjoAdmin', ['doc_pdte_csjo_admin' => $doc_pdte_csjo_admin]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
        $pdf->setPaper('legal', 'landscape'); //ocicio

        $pdf->render();

        return view('ViewPDFAllDocumentacionPdteCsjoAdmin', ['doc_pdte_csjo_admin' => $doc_pdte_csjo_admin, 'pdf' => $pdf->output()]);
    }

    //imprimir
    public function pdfRegistrosAll()
    {
        try {
            $doc_pdte_csjo_admin = DocumentacionPdteCsjoAdmin::where('status', true)->orderBy('id', 'DESC')->get();
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DESCONOCIDO']);
        }

        $pdf = Pdf::loadView('PDFAllDocumentacionPdteCsjoAdmin', ['doc_pdte_csjo_admin' => $doc_pdte_csjo_admin]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta vertical
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio vertical
        $pdf->setPaper('legal', 'landscape'); //ocicio horizontal

        $pdf->render();

        return $pdf->download(date('d-m-Y') . '-DocPdteCsjoAdmin.pdf');
    }

    //imprimir
    public function imprimirRegistrosId(Request $request)
    {
        try {
            $doc_pdte_csjo_admin = DocumentacionPdteCsjoAdmin::where('status', true)
                ->find(Crypt::decrypt($request->input('id-reg')));

            if ($doc_pdte_csjo_admin == null) {
                $respuesta = [
                    'status_code' => 200,
                    'errors_db_messages' => 'Inventario de Documentacion Pdte Csjo Administracion null',
                ];
                return response()->json($respuesta);
            }

            $pdf = Pdf::loadView('PDFIdDocumentacionPdteCsjoAdmin', ['doc_pdte_csjo_admin' => $doc_pdte_csjo_admin]);
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
            $doc_pdte_csjo_admin = DocumentacionPdteCsjoAdmin::where('status', true)->find(Crypt::decrypt($id));
            if ($doc_pdte_csjo_admin == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'ENCRYPT']);
        }

        $pdf = Pdf::loadView('PDFIdDocumentacionPdteCsjoAdmin', ['doc_pdte_csjo_admin' => $doc_pdte_csjo_admin]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta vertical
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio vertical
        $pdf->setPaper('(array(0, 0, 612.00, 792.00))', 'portrait'); //ocicio


        $pdf->render();

        return $pdf->download(date('d-m-Y') . '-' . $doc_pdte_csjo_admin->num_reg . '-DocPdteCsjoAdmin.pdf');
    }

    public function archivoRegistroId(Request $request)
    {
        try {
            $doc_pdte_csjo_admin = DocumentacionPdteCsjoAdmin::where('status', true)
                ->find(Crypt::decrypt($request->input('id-reg')));

            if ($doc_pdte_csjo_admin == null) {
                $respuesta = [
                    'status_code' => 200,
                    'errors_db_messages' => 'Inventario de Documentacion Pdte Csjo Administracion null',
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
        return response()->streamDownload(function () use ($doc_pdte_csjo_admin) {
            echo $doc_pdte_csjo_admin->archivo;
        }, 'archivo', [
            "Content-Type" => $doc_pdte_csjo_admin->mime_type,
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
