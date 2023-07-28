<?php

use App\Http\Controllers\ControllerDocumentacionPdteCsjoAdmin;
use App\Http\Controllers\ControllerEquipoPesado;
use App\Http\Controllers\ControllerFaltasSociosAsAcontecimientos;
use App\Http\Controllers\ControllerHistorialSocios;
use App\Http\Controllers\ControllerPersonalEP;
use App\Http\Controllers\ControllerHistorialPersonalEP;
use App\Http\Controllers\ControllerHistorialPersonalEM;
use App\Http\Controllers\ControllerIngresoAlmacen;
use App\Http\Controllers\ControllerInventarioDocStrioGeneral;
use App\Http\Controllers\ControllerInventarioSecretariaOficina;
use App\Http\Controllers\ControllerMantenimientoEquipoPesado;
use App\Http\Controllers\ControllerPersonalEM;
use App\Http\Controllers\ControllerRegistroAcAsExtraOrdinarias;
use App\Http\Controllers\ControllerRegistroAcAsOrdinarias;
use App\Http\Controllers\ControllerRegistroAcAsOrganicas;
use App\Http\Controllers\ControllerRegistroAcEntregaDoc;
use App\Http\Controllers\ControllerRegistroAcLibroDeAlzas;
use App\Http\Controllers\ControllerRegistroAcReuniones;
use App\Http\Controllers\ControllerRegistroAcTribunalDeHonor;
use App\Http\Controllers\ControllerRegistroComisionesInformes;
use App\Http\Controllers\ControllerRegistroCorrespondenciasEmi;
use App\Http\Controllers\ControllerRegistroCorrespondenciasRe;
use App\Http\Controllers\ControllerRegistroMemorandums;
use App\Http\Controllers\ControllerSalidaAlmacen;
use App\Http\Controllers\ControllerSocios;
use App\Http\Controllers\ControllerUsuarios;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//return $request->user();

//});
//Route::middleware('auth:api')->get('/user', function (Request $request) {
// return $request->user();
//});

Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria']], function () {
   Route::controller(ControllerSocios::class)->group(function () {
      Route::post('/store-socios', 'store');

      Route::post('/update-socios', 'update');
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador']], function () {
   Route::controller(ControllerSocios::class)->group(function () {
      Route::post('/destroy-socios', 'destroy');
   });
});



Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria']], function () {
   Route::controller(ControllerHistorialSocios::class)->group(function () {
      Route::post('/store-historial-socios', 'store');
 
      Route::post('/update-historial-socios', 'update');
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador']], function () {
   Route::controller(ControllerHistorialSocios::class)->group(function () {
      Route::post('/destroy-historial-socios', 'destroy');
   });
});



Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria']], function () {
   Route::controller(ControllerPersonalEP::class)->group(function () {
      Route::post('/store-personal-planta', 'store');

      Route::post('/update-personal-planta', 'update');
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador']], function () {
   Route::controller(ControllerPersonalEP::class)->group(function () {
      Route::post('/destroy-personal-planta', 'destroy');
   });
});



Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria']], function () {
   Route::controller(ControllerHistorialPersonalEP::class)->group(function () {
      Route::post('/store-historial-personal-planta', 'store');

      Route::post('/update-historial-personal-planta', 'update');
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador']], function () {
   Route::controller(ControllerHistorialPersonalEP::class)->group(function () {
      Route::post('/destroy-historial-personal-planta', 'destroy');
   });
});




Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria']], function () {
   Route::controller(ControllerPersonalEM::class)->group(function () {
      Route::post('/store-personal-mita', 'store');

      Route::post('/update-personal-mita', 'update');
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador']], function () {
   Route::controller(ControllerPersonalEM::class)->group(function () {
      Route::post('/destroy-personal-mita', 'store');
   });
});


Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria']], function () {
   Route::controller(ControllerHistorialPersonalEM::class)->group(function () {
      Route::post('/store-historial-personal-mita', 'store');

      Route::post('/update-historial-personal-mita', 'update');
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador']], function () {
   Route::controller(ControllerHistorialPersonalEM::class)->group(function () {
      Route::post('/destroy-historial-personal-mita', 'destroy');
   });
});




Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria']], function () {
   Route::controller(ControllerRegistroCorrespondenciasRe::class)->group(function () {
      Route::post('/store-registro-correspondencias-re', 'store');

      Route::post('/update-registro-correspondencias-re', 'update');
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador']], function () {
   Route::controller(ControllerRegistroCorrespondenciasRe::class)->group(function () {
      Route::post('/destroy-registro-correspondencias-re', 'destroy');
   });
});




Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria']], function () {
   Route::controller(ControllerRegistroCorrespondenciasEmi::class)->group(function () {
      Route::post('/store-registro-correspondencias-emi', 'store');

      Route::post('/update-registro-correspondencias-emi', 'update');
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador']], function () {
   Route::controller(ControllerRegistroCorrespondenciasEmi::class)->group(function () {
      Route::post('/destroy-registro-correspondencias-emi', 'destroy');
   });
});



Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria']], function () {
   Route::controller(ControllerRegistroMemorandums::class)->group(function () {
      Route::post('/store-registro-memorandums', 'store');

      Route::post('/update-registro-memorandums', 'update');
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador']], function () {
   Route::controller(ControllerRegistroMemorandums::class)->group(function () {
      Route::post('/destroy-registro-memorandums', 'destroy');
   });
});




Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria']], function () {
   Route::controller(ControllerFaltasSociosAsAcontecimientos::class)->group(function () {
      Route::post('/store-faltas-socios-as-acontecimientos', 'store');

      Route::post('/update-faltas-socios-as-acontecimientos', 'update');
    
      Route::post('/buscar-socio-faltas-socios-as-acontecimientos', 'buscarSocio');
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador']], function () {
   Route::controller(ControllerFaltasSociosAsAcontecimientos::class)->group(function () {
      Route::post('/destroy-faltas-socios-as-acontecimientos', 'destroy');
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerFaltasSociosAsAcontecimientos::class)->group(function () {
      Route::post('/imprimir-id-faltas-socios-as-acontecimientos', 'imprimirRegistrosId');
   });
});





Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria']], function () {
   Route::controller(ControllerRegistroAcAsOrdinarias::class)->group(function () {
      Route::post('/store-registro-ac-as-ordinarias', 'store');

      Route::post('/update-registro-ac-as-ordinarias', 'update');
   
   
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador']], function () {
   Route::controller(ControllerRegistroAcAsOrdinarias::class)->group(function () {
      Route::post('/destroy-registro-ac-as-ordinarias', 'destroy');
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerRegistroAcAsOrdinarias::class)->group(function () {
      Route::post('/archivo-registro-ac-as-ordinarias', 'apiResponseArchivo');
      Route::post('/imprimir-id-registro-ac-as-ordinarias', 'imprimirRegistrosId');
   });
});



Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria']], function () {
   Route::controller(ControllerRegistroAcAsExtraOrdinarias::class)->group(function () {
      Route::post('/store-registro-ac-as-extra-ordinarias', 'store');

      Route::post('/update-registro-ac-as-extra-ordinarias', 'update');
    
    
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador']], function () {
   Route::controller(ControllerRegistroAcAsExtraOrdinarias::class)->group(function () {
      Route::post('/destroy-registro-ac-as-extra-ordinarias', 'destroy');
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerRegistroAcAsExtraOrdinarias::class)->group(function () {
      Route::post('/imprimir-id-registro-ac-as-extra-ordinarias', 'imprimirRegistrosId');
      Route::post('/archivo-registro-ac-as-extra-ordinarias', 'apiResponseArchivo');
   });
});




Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria']], function () {
   Route::controller(ControllerRegistroAcAsOrganicas::class)->group(function () {
      Route::post('/store-registro-ac-as-organicas', 'store');

      Route::post('/update-registro-ac-as-organicas', 'update');
   

   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador']], function () {
   Route::controller(ControllerRegistroAcAsOrganicas::class)->group(function () {
      Route::post('/destroy-registro-ac-as-organicas', 'destroy');
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerRegistroAcAsOrganicas::class)->group(function () {
      Route::post('/imprimir-id-registro-ac-as-organicas', 'imprimirRegistrosId');
      Route::post('/archivo-registro-ac-as-organicas', 'apiResponseArchivo');
   });
});




Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria']], function () {
   Route::controller(ControllerRegistroAcTribunalDeHonor::class)->group(function () {
      Route::post('/store-registro-ac-tribunal-de-honor', 'store');

      Route::post('/update-registro-ac-tribunal-de-honor', 'update');
    

   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador']], function () {
   Route::controller(ControllerRegistroAcTribunalDeHonor::class)->group(function () {
      Route::post('/destroy-registro-ac-tribunal-de-honor', 'destroy');
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerRegistroAcTribunalDeHonor::class)->group(function () {
      Route::post('/imprimir-id-registro-ac-tribunal-de-honor', 'imprimirRegistrosId');
      Route::post('/archivo-registro-ac-tribunal-de-honor', 'apiResponseArchivo');
   });
});



Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria']], function () {
   Route::controller(ControllerRegistroAcReuniones::class)->group(function () {
      Route::post('/store-registro-ac-reuniones', 'store');

      Route::post('/update-registro-ac-reuniones', 'update');
  
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador']], function () {
   Route::controller(ControllerRegistroAcReuniones::class)->group(function () {
      Route::post('/destroy-registro-ac-reuniones', 'destroy');
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerRegistroAcReuniones::class)->group(function () {
      Route::post('/imprimir-id-registro-ac-reuniones', 'imprimirRegistrosId');
      Route::post('/archivo-registro-ac-reuniones', 'archivoRegistroId');
   });
});




Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria']], function () {
   Route::controller(ControllerRegistroAcEntregaDoc::class)->group(function () {
      Route::post('/store-registro-ac-entrega-doc', 'store');

      Route::post('/update-registro-ac-entrega-doc', 'update');
   
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador']], function () {
   Route::controller(ControllerRegistroAcEntregaDoc::class)->group(function () {
      Route::post('/destroy-registro-ac-entrega-doc', 'destroy');
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerRegistroAcEntregaDoc::class)->group(function () {
      Route::post('/imprimir-id-registro-ac-entrega-doc', 'imprimirRegistrosId');
      Route::post('/archivo-registro-ac-entrega-doc', 'archivoRegistroId');
   });
});



Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria']], function () {
   Route::controller(ControllerRegistroAcLibroDeAlzas::class)->group(function () {
      Route::post('/store-registro-ac-libro-de-alzas', 'store');

      Route::post('/update-registro-ac-libro-de-alzas', 'update');
     
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador']], function () {
   Route::controller(ControllerRegistroAcLibroDeAlzas::class)->group(function () {
      Route::post('/destroy-registro-ac-libro-de-alzas', 'destroy');
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerRegistroAcLibroDeAlzas::class)->group(function () {
      Route::post('/imprimir-id-registro-ac-libro-de-alzas', 'imprimirRegistrosId');
      Route::post('/archivo-registro-ac-libro-de-alzas', 'archivoRegistroId');
   });
});




Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria']], function () {
   Route::controller(ControllerDocumentacionPdteCsjoAdmin::class)->group(function () {
      Route::post('/store-documentacion-pdte-csjo-admin', 'store');

      Route::post('/update-documentacion-pdte-csjo-admin', 'update');
  
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador']], function () {
   Route::controller(ControllerDocumentacionPdteCsjoAdmin::class)->group(function () {
      Route::post('/destroy-documentacion-pdte-csjo-admin', 'destroy');
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerDocumentacionPdteCsjoAdmin::class)->group(function () {
      Route::post('/imprimir-id-documentacion-pdte-csjo-admin', 'imprimirRegistrosId');
      Route::post('/archivo-documentacion-pdte-csjo-admin', 'archivoRegistroId');
   });
});




Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria']], function () {
   Route::controller(ControllerInventarioSecretariaOficina::class)->group(function () {
      Route::post('/store-inventario-secretaria-oficina', 'store');

      Route::post('/update-inventario-secretaria-oficina', 'update');
   
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador']], function () {
   Route::controller(ControllerInventarioSecretariaOficina::class)->group(function () {
      Route::post('/destroy-inventario-secretaria-oficina', 'destroy');
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerInventarioSecretariaOficina::class)->group(function () {
      Route::post('/imprimir-id-inventario-secretaria-oficina', 'imprimirRegistrosId');
      Route::post('/archivo-inventario-secretaria-oficina', 'archivoRegistroId');
   
   });
});




Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria']], function () {
   Route::controller(ControllerInventarioDocStrioGeneral::class)->group(function () {
      Route::post('/store-inventario-doc-strio-general', 'store');
      Route::post('/update-inventario-doc-strio-general', 'update');
  
  
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador']], function () {
   Route::controller(ControllerInventarioDocStrioGeneral::class)->group(function () {
      Route::post('/destroy-inventario-doc-strio-general', 'destroy');
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerInventarioDocStrioGeneral::class)->group(function () {
      Route::post('/imprimir-id-inventario-doc-strio-general', 'imprimirRegistrosId');
      Route::post('/archivo-inventario-doc-strio-general', 'archivoRegistroId');
   });
});




Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria']], function () {
   Route::controller(ControllerRegistroComisionesInformes::class)->group(function () {
      Route::post('/store-registro-comisiones-informes', 'store');

      Route::post('/update-registro-comisiones-informes', 'update');
   
    
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador']], function () {
   Route::controller(ControllerRegistroComisionesInformes::class)->group(function () {
      Route::post('/destroy-registro-comisiones-informes', 'destroy');
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerRegistroComisionesInformes::class)->group(function () {
      Route::post('/imprimir-id-registro-comisiones-informes', 'imprimirRegistrosId');
      Route::post('/archivo-registro-comisiones-informes', 'archivoRegistroId');
   });
});

/*revisar todas las rutas que tienen "imprimir"*/


Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,jefe-de-maquina']], function () {
   Route::controller(ControllerEquipoPesado::class)->group(function () {
      Route::post('/store-equipo-pesado', 'store');
      Route::post('/update-equipo-pesado', 'update');
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador']], function () {
   Route::controller(ControllerEquipoPesado::class)->group(function () {
      Route::post('/destroy-equipo-pesado', 'destroy');
   });
});


Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,jefe-de-maquina']], function () {
   Route::controller(ControllerMantenimientoEquipoPesado::class)->group(function () {
      Route::post('/store-mantenimiento-equipo-pesado', 'store');

      Route::post('/update-mantenimiento-equipo-pesado', 'update');
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador']], function () {
   Route::controller(ControllerMantenimientoEquipoPesado::class)->group(function () {
      Route::post('/destroy-mantenimiento-equipo-pesado', 'destroy');
   });
});



Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,almacenes']], function () {
   Route::controller(ControllerIngresoAlmacen::class)->group(function () {
      Route::post('/store-ingreso-almacen', 'store');

      Route::post('/update-ingreso-almacen', 'update');
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador']], function () {
   Route::controller(ControllerIngresoAlmacen::class)->group(function () {
      Route::post('/destroy-ingreso-almacen', 'destroy');
   });
});




Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador,almacenes']], function () {
   Route::controller(ControllerSalidaAlmacen::class)->group(function () {
      Route::post('/store-salida-almacen', 'store');
      Route::post('/update-salida-almacen', 'update');
   });
});
Route::group(['middleware' => ['auth:sanctum', 'role.api:system,administrador']], function () {
   Route::controller(ControllerSalidaAlmacen::class)->group(function () {
      Route::post('/destroy-salida-almacen', 'destroy');
   });
});



Route::group(['middleware' => ['auth:sanctum','role.api:system,administrador']], function () {
   Route::controller(ControllerUsuarios::class)->group(function () {
      Route::post('/store-usuarios', 'store');
      Route::post('/destroy-usuarios', 'destroy');
      Route::post('/update-usuarios', 'update');
   });
});
Route::group(['middleware' => ['auth:sanctum']], function () {
   Route::controller(ControllerUsuarios::class)->group(function () {
      Route::post('/update-password-usuarios', 'updateModifyPassword');
   });
});




//=========================================================//
Route::get('/prueba', function (Request $request) {
   //return response()->json(['valor'=>1]);
   //   return response()->json(session('session_auth_token'));
   // return response()->json($request->user());
   return response()->json($request->cookie('cookie_auth_token'));
});
