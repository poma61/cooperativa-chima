<?php

namespace App\Http\Controllers;

use App\Models\EquipoPesado;
use App\Models\HistoryDB;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Protected\MyEncryption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ControllerEquipoPesado extends Controller
{

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data= EquipoPesado::select(
            'id',
            'nombre_comun_del_equipo',
            'codigo_de_inventario_interno',
            'fabricante',
        )->where('status', true)->orderBy('id', 'DESC')->get();

     
        return view('EquipoPesado', ['equipo_pesado' => $data]);
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

            $equipo_pesado = new EquipoPesado($request->all());

            $blob_archivo = $request->file('archivo');
            $equipo_pesado->archivo = $blob_archivo->openFile()->fread($blob_archivo->getSize());
            $equipo_pesado->mime_type_archivo = $blob_archivo->getMimeType();

            $blob_manuales_digitales = $request->file('manuales_digitales');
            $equipo_pesado->manuales_digitales = $blob_manuales_digitales->openFile()->fread($blob_manuales_digitales->getSize());
            $equipo_pesado->mime_type_manuales_digitales = $blob_manuales_digitales->getMimeType();

            $blob_planos_electricos_digitales = $request->file('planos_electricos_digitales');
            $equipo_pesado->planos_electricos_digitales = $blob_planos_electricos_digitales->openFile()->fread($blob_planos_electricos_digitales->getSize());
            $equipo_pesado->mime_type_planos_electricos_digitales = $blob_planos_electricos_digitales->getMimeType();

            $equipo_pesado->status = true;
            $equipo_pesado->id_usuario = Auth::user()->id;
            $equipo_pesado->save();

            $data = [
                'table' => 'equipo_pesado',
                'descripcion' => 'Equipo - Pesado',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'store',
                'registro' => $equipo_pesado->id,
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
            $equipo_pesado = EquipoPesado::where('status', true)->find(MyEncryption::decrypt($id));
            if ($equipo_pesado == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $data = [
            'equipo_pesado' => $equipo_pesado,
            'action' => 'update',
        ];

        return view('FrmEquipoPesado', $data);
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
            $equipo_pesado = EquipoPesado::where('status', true)->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($equipo_pesado == null) {
                $validar['errors_db'] = true;
                $validar['errors_db_messages'] = 'Equipo - Pesado null';
                return response()->json($validar);
            }

            $equipo_pesado->fill($request->all());

            $blob_archivo = $request->file('archivo');
            if ($blob_archivo != null) {
                $equipo_pesado->archivo = $blob_archivo->openFile()->fread($blob_archivo->getSize());
                $equipo_pesado->mime_type_archivo = $blob_archivo->getMimeType();
            }

            $blob_manuales_digitales = $request->file('manuales_digitales');
            if ($blob_manuales_digitales != null) {
                $equipo_pesado->manuales_digitales = $blob_manuales_digitales->openFile()->fread($blob_manuales_digitales->getSize());
                $equipo_pesado->mime_type_manuales_digitales = $blob_manuales_digitales->getMimeType();
            }

            $blob_planos_electricos_digitales = $request->file('planos_electricos_digitales');
            if ($blob_planos_electricos_digitales != null) {
                $equipo_pesado->planos_electricos_digitales = $blob_planos_electricos_digitales->openFile()->fread($blob_planos_electricos_digitales->getSize());
                $equipo_pesado->mime_type_planos_electricos_digitales = $blob_planos_electricos_digitales->getMimeType();
            }

            $equipo_pesado->id_usuario = Auth::user()->id;
            $equipo_pesado->update();

            $data = [
                'table' => 'equipo_pesado',
                'descripcion' => 'Equipo - Pesado',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'update',
                'registro' => $equipo_pesado->id,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

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
            $equipo_pesado = EquipoPesado::where('status', true)->find(MyEncryption::decrypt($request->input('id-reg')));

            if ($equipo_pesado == null) {
                $respuesta = [
                    'errors_db' => true,
                    'errors_db_messages' => 'Equipo - Pesado null',
                ];
                return response()->json($respuesta);
            }

            $data = [
                'table' => 'equipo_pesado',
                'descripcion' => 'Equipo - Pesado',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'destroy',
                'registro' => $equipo_pesado->id,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $equipo_pesado->status = false;
            $equipo_pesado->save();

            $respuesta = [
                'errors_db' => false,
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
        $equipo_pesado = new EquipoPesado();
        $equipo_pesado->id = 0;

        $data = [
            'equipo_pesado' => $equipo_pesado,
            'action' => 'store',
        ];
        return view('FrmEquipoPesado', $data);
    }

    public function verRegistro($id)
    {
        try {
            $equipo_pesado = EquipoPesado::where('status', true)->find(MyEncryption::decrypt($id));
            if ($equipo_pesado == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        return view('VerEquipoPesado', ['equipo_pesado' => $equipo_pesado]);

    }



    //imprimir
    public function imprimirRegistrosId($id)
    {
        try {
            $equipo_pesado = EquipoPesado::where('status', true)->find(MyEncryption::decrypt($id));
            if ($equipo_pesado == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $pdf = Pdf::loadView('PDFVerEquipoPesado', ['equipo_pesado' => $equipo_pesado]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
        $pdf->setPaper('legal', 'portrait'); //oficio

        $pdf->render();

        return view('ViewPDFVerEquipoPesado', ['equipo_pesado' => $equipo_pesado, 'pdf' => $pdf->output()]);
    }

    //imprimir
    public function pdfRegistrosId($id)
    {

        try {
            $equipo_pesado = EquipoPesado::where('status', true)->find(MyEncryption::decrypt($id));
            if ($equipo_pesado == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $pdf = Pdf::loadView('PDFVerEquipoPesado', ['equipo_pesado' => $equipo_pesado]);
        //tamaño carta array(0, 0, 612.00, 792.00)
        //tamaño oficio  array(0, 0, 612.00, 1008.00) o 'legal'

        // $pdf->setPaper((array(0, 0, 612.00, 792.00)),'portrait');//carta
        //$pdf->setPaper((array(0, 0, 612.00, 1008.00)),'portrait');//oficio
        $pdf->setPaper('legal', 'portrait'); //oficio

        $pdf->render();
        return $pdf->download(date('d-m-Y') . '-' . $equipo_pesado->nombre_comun_del_equipo . '-equipo_pesado.pdf');
    }

    public function validateRequest(Request $request, $type)
    {

        switch ($type) {
            case 'store':
                $archivo_validate = "required|mimes:jpg,png";
                $pdf_validate = "required|mimes:pdf";
                break;
            case 'update':
                $archivo_validate = "mimes:jpg,png";
                $pdf_validate = "mimes:pdf";
                break;
            default:
                $archivo_validate = "";
                $pdf_validate = "";
                break;
        }

        $validator = Validator::make($request->all(), [
            //datos generales
            'nombre_comun_del_equipo' => 'required|string',
            'codigo_de_inventario_interno' => 'required|string',
            //datos de origen
            'fabricante' => 'required|string',
            'ano_vencimiento_de_garantia' => 'required|numeric|max:9999',
            'ano_de_fabricacion' => 'required|numeric|max:9999',
            'pais_de_origen' => 'required|string|max:400',
            'modelo' => 'required|string|max:400',
            'numero_de_serie' => 'required|string|max:400',
            'ano_de_compra' => 'required|numeric|max:9999',
            //datos de uso en planta
            'ano_de_alta_planta' => 'required|numeric|max:9999',
            'estado_del_equipo_al_momento_de_alta' => 'required|string|max:400',
            'horometro_al_inicio_operacion_planta' => 'required|string|max:400',
            'linea_de_produccion_asignada' => 'required|string|max:400',
            'ubicacion' => 'required|string|max:400',
            //registro fotografico
            'archivo' => $archivo_validate,

            //datos tecnico
            'potencia_und' => 'required|string|max:400',
            'potencia_valor_nominal' => 'required|string|max:400',
            'potencia_caracteristicas' => 'required|string',

            'voltaje_und' => 'required|string|max:400',
            'voltaje_valor_nominal' => 'required|string|max:400',
            'voltaje_caracteristicas' => 'required|string',

            'corriente_und' => 'required|string|max:400',
            'corriente_valor_nominal' => 'required|string|max:400',
            'corriente_caracteristicas' => 'required|string',

            'capacidad_de_cucharon_und' => 'required|string|max:400',
            'capacidad_de_cucharon_valor_nominal' => 'required|string|max:400',
            'capacidad_de_cucharon_caracteristicas' => 'required|string',

            'capacidad_de_diesel_und' => 'required|string|max:400',
            'capacidad_de_diesel_valor_nominal' => 'required|string|max:400',
            'capacidad_de_diesel_caracteristicas' => 'required|string',

            'otros_und' => 'required|string|max:400',
            'otros_valor_nominal' => 'required|string|max:400',
            'otros_caracteristicas' => 'required|string',

            //disponibilidad de informacion de soporte tecnico
            'manuales_impresos' => 'required|string|max:400',
            'manuales_digitales' => $pdf_validate,
            'otros_manuales' => 'required|string',

            'planos_mecanicos_digitales' => 'required|string|max:400', //este campo no especifica si es archivo
            'planos_electricos_digitales' => $pdf_validate,
            'otros_planos' => 'required|string',
        ], [
            'ano_vencimiento_de_garantia.required' => 'El campo año vencimiento de garantia es obligatorio.',
            'ano_vencimiento_de_garantia.numeric' => 'El campo año vencimiento de garantia debe ser un numero.',

            'ano_de_fabricacion.required' => 'El campo año de fabricacion es obligatorio.',
            'ano_de_fabricacion.numeric' => 'El campo año de fabricacion debe ser un numero.',

            'ano_de_compra.required' => 'El campo año de compra es obligatorio.',
            'ano_de_compra.numeric' => 'El campo año de compra debe ser un numero.',

            'ano_de_alta_planta.required' => 'El campo año de alta planta es obligatorio.',
            'ano_de_alta_planta.numeric' => 'El campo año de alta planta debe ser un numero.',

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
