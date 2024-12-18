<?php

namespace App\Http\Controllers;

use App\Models\MantenimientoEquipoPesado;
use App\Models\HistoryDB;
use App\Models\EquipoPesado;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ControllerMantenimientoEquipoPesado extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        try {
            $equipo_pesado = EquipoPesado::select(
                'id',
                'nombre_comun_del_equipo',
                'ano_de_compra',
                'fabricante',
                'estado_del_equipo_al_momento_de_alta',
                'ano_de_fabricacion',
                'ano_de_alta_planta',
                'numero_de_serie'
            )->where('status', true)->find(Crypt::decrypt($id));

            if ($equipo_pesado == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }

            $mantenimiento_equipo_pesado = MantenimientoEquipoPesado::where('status', true)->where('id_equipo_pesado', $equipo_pesado->id)->orderBy('id', 'DESC')->get();
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }


        return view('MantenimientoEquipoPesado', ['equipo_pesado' => $equipo_pesado, 'mantenimiento_equipo_pesado' => $mantenimiento_equipo_pesado]);
    }

    /**
     * Store a newly created resource in storage.
     *
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

            $id_equipo_pesado = Crypt::decrypt($request->input('id-equipo-pesado'));
            $verificar_registro = EquipoPesado::select('id')->where('id', $id_equipo_pesado)->where('status', true)->first();
            if ($verificar_registro == null) {
                $validacion['errors_db'] = true;
                $validacion['errors_db_messages'] = 'equipo pesado null';
                return response()->json($validacion);
            }

            $num = MantenimientoEquipoPesado::where('id_equipo_pesado', $id_equipo_pesado)->count('num_reg') + 1;
            $num_reg = str_pad($num, 5, '0', STR_PAD_LEFT);

            $data = [
                'table' => 'mantenimiento_equipo_pesado',
                'descripcion' => 'mantenimiento-reparacion equipo pesado',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'store',
                'registro' => $num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();

            $mantenimiento_equipo_pesado = new MantenimientoEquipoPesado($request->all());
            $mantenimiento_equipo_pesado->status = true;
            $mantenimiento_equipo_pesado->id_equipo_pesado = $id_equipo_pesado;
            $mantenimiento_equipo_pesado->num_reg = $num_reg;
            $mantenimiento_equipo_pesado->save();
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
            $mantenimiento_equipo_pesado = MantenimientoEquipoPesado::where('status', true)->find(Crypt::decrypt($id));
            $equipo_pesado = EquipoPesado::select(
                'id',
                'nombre_comun_del_equipo',
                'ano_de_compra',
                'fabricante',
                'estado_del_equipo_al_momento_de_alta',
                'ano_de_fabricacion',
                'ano_de_alta_planta',
                'numero_de_serie'
            )->where('status', true)->find($mantenimiento_equipo_pesado->id_equipo_pesado);

            if ($equipo_pesado == null || $mantenimiento_equipo_pesado == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        return view('FrmMantenimientoEquipoPesado', ['mantenimiento_equipo_pesado' => $mantenimiento_equipo_pesado, 'equipo_pesado' => $equipo_pesado, 'action' => 'update']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Responseequipo_pesado
     */
    public function update(Request $request)
    {
        $validar = $this->validateRequest($request);
        if ($validar['errors_campos'] == true) {
            return response()->json($validar);
        }

        try {
            $mantenimiento_equipo_pesado = MantenimientoEquipoPesado::where('status', true)->find(Crypt::decrypt($request->input('id-reg')));

            if ($mantenimiento_equipo_pesado == null) {
                $validar['errors_db'] = true;
                $validar['errors_db_messages'] = 'historial personal mita null';
                return response()->json($validar);
            }

            $data = [
                'table' => 'mantenimiento_equipo_pesado',
                'descripcion' => 'mantenimiento-reparacion equipo pesado',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'update',
                'registro' => $mantenimiento_equipo_pesado->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();


            $mantenimiento_equipo_pesado->fill($request->all());
            $blob = $request->file('archivo');
            //si el usuario subio un nueva nueva imagen entones siginifica que el campo
            //imagen NO estara vacio y lo subimos al modelo
            if ($blob != null) {
                $mantenimiento_equipo_pesado->archivo = $blob->openFile()->fread($blob->getSize());
                $mantenimiento_equipo_pesado->mime_type = $blob->getMimeType();
            }
            $mantenimiento_equipo_pesado->update();
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
            $mantenimiento_equipo_pesado = MantenimientoEquipoPesado::where('status', true)->find(Crypt::decrypt($request->input('id-reg')));

            if ($mantenimiento_equipo_pesado == null) {
                $respuesta = [
                    'errors_db' => true,
                    'errors_db_messages' => 'mantenimiento equipo pesado null',
                ];

                return response()->json($respuesta);
            }

            $data = [
                'table' => 'mantenimiento_equipo_pesado',
                'descripcion' => 'mantenimiento equipo pesado',
                'id_usuario' => Auth::user()->id,
                'type_query' => 'destroy',
                'registro' => $mantenimiento_equipo_pesado->num_reg,
                'status_register' => 'sucess',
            ];
            $history_db = new HistoryDB($data);
            $history_db->save();


            $mantenimiento_equipo_pesado->status = false;
            $mantenimiento_equipo_pesado->save();

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
        $mantenimiento_equipo_pesado = new MantenimientoEquipoPesado();
        $mantenimiento_equipo_pesado->id = 0;
        $mantenimiento_equipo_pesado->fecha_de_ingreso = date('Y-m-d');
        $mantenimiento_equipo_pesado->fecha_de_salida = date('Y-m-d');

        try {
            $equipo_pesado = EquipoPesado::where('status', true)->find(Crypt::decrypt($id));

            if ($equipo_pesado == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }
        $cantidad_registros = MantenimientoEquipoPesado::where('id_equipo_pesado', $equipo_pesado->id)->count('num_reg') + 1;

        return view('FrmMantenimientoEquipoPesado', ['mantenimiento_equipo_pesado' => $mantenimiento_equipo_pesado, 'num_registro' => $cantidad_registros, 'equipo_pesado' => $equipo_pesado, 'action' => 'store']);
    }

    public function verRegistro($id)
    {
        try {
            $mantenimiento_equipo_pesado_equipo_pesado = MantenimientoEquipoPesado::join('equipo_pesado', 'equipo_pesado.id', '=', 'mantenimiento_equipo_pesado.id_equipo_pesado')
                ->select(
                    'equipo_pesado.nombre_comun_del_equipo',
                    'equipo_pesado.fabricante',
                    'equipo_pesado.ano_de_fabricacion',
                    'equipo_pesado.ano_de_compra',
                    'equipo_pesado.estado_del_equipo_al_momento_de_alta',
                    'equipo_pesado.ano_de_alta_planta',
                    'equipo_pesado.numero_de_serie',
                    'mantenimiento_equipo_pesado.*'
                )
                ->where('mantenimiento_equipo_pesado.id', Crypt::decrypt($id))
                ->where('equipo_pesado.status', true)
                ->where('mantenimiento_equipo_pesado.status', true)
                ->first();

            if ($mantenimiento_equipo_pesado_equipo_pesado == null) {

                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }
        } catch (Exception $ex) {

            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        return view('VerMantenimientoEquipoPesado', ['mantenimiento_equipo_pesado_equipo_pesado' => $mantenimiento_equipo_pesado_equipo_pesado]);
    }

    //pdf
    public function pdfRegistros($id)
    {
        try {

            $equipo_pesado = EquipoPesado::select(
                'id',
                'nombre_comun_del_equipo',
                'ano_de_compra',
                'fabricante',
                'estado_del_equipo_al_momento_de_alta',
                'ano_de_fabricacion',
                'ano_de_alta_planta',
                'numero_de_serie'
            )->where('status', true)->find(Crypt::decrypt($id));

            if ($equipo_pesado == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }


            $mantenimiento_equipo_pesado = MantenimientoEquipoPesado::where('id_equipo_pesado', Crypt::decrypt($id))->where('status', true)->orderBy('id', 'DESC')->get();
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $pdf_render = Pdf::loadView('PDFMantenimientoEquipoPesado', ['mantenimiento_equipo_pesado' => $mantenimiento_equipo_pesado, 'equipo_pesado' => $equipo_pesado]);
        $pdf_render->setPaper('legal', 'landscape');
        $pdf_render->render();


        $pdf = $pdf_render->download(date('d-m-Y') . '-mantenimiento_equipo_pesado-' . $equipo_pesado->nombre_comun_del_equipo . '.pdf');
        return   $pdf;
    }

    //imprimir
    public function imprimirRegistros($id)
    {
        try {
            $equipo_pesado = EquipoPesado::select(
                'id',
                'nombre_comun_del_equipo',
                'ano_de_compra',
                'fabricante',
                'estado_del_equipo_al_momento_de_alta',
                'ano_de_fabricacion',
                'ano_de_alta_planta',
                'numero_de_serie'
            )->where('status', true)->find(Crypt::decrypt($id));

            if ($equipo_pesado == null) {
                return view('PageNotFound', ['tipo_error' => 'NULL']);
            }

            $mantenimiento_equipo_pesado = MantenimientoEquipoPesado::where('id_equipo_pesado', Crypt::decrypt($id))->where('status', true)->orderBy('id', 'DESC')->get();
        } catch (Exception $ex) {
            return view('PageNotFound', ['tipo_error' => 'DECRYPT']);
        }

        $pdf_render = Pdf::loadView('PDFMantenimientoEquipoPesado', ['mantenimiento_equipo_pesado' => $mantenimiento_equipo_pesado, 'equipo_pesado' => $equipo_pesado]);
        $pdf_render->setPaper('legal', 'landscape');
        $pdf_render->render();

        $pdf = $pdf_render->output();


        return view('ViewPDFMantenimientoEquipoPesado', ['pdf' => $pdf, 'equipo_pesado' => $equipo_pesado]);
    }



    //validador
    public function validateRequest(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'fecha_de_ingreso' => 'required|date',
            'caracteristicas' => 'required|string',
            'desarrollo' => 'required|string',
            'material_ocupado' => 'required|string|max:600',
            'mantenimiento_preventivo' => 'required|string|max:600',
            'mantenimiento_correctivo' => 'required|string|max:600',
            'fecha_de_salida' => 'required|date',
            'observacion' => 'required|string',
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
