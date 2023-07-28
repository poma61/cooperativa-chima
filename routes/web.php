<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerLogin;
use App\Http\Controllers\ControllerSocios;
use App\Http\Controllers\ControllerRegistroCorrespondenciasEmi;
use App\Http\Controllers\ControllerRegistroCorrespondenciasRe;
use App\Http\Controllers\ControllerRegistroDeActas;
use App\Http\Controllers\ControllerHistorialSocios;
use App\Http\Controllers\ControllerRegistroMemorandums;
use App\Http\Controllers\ControllerCooperativa;
use App\Http\Controllers\ControllerDocumentacionPdteCsjoAdmin;
use App\Http\Controllers\ControllerEquipoPesado;
use App\Http\Controllers\ControllerFaltasSociosAsAcontecimientos;
use App\Http\Controllers\ControllerHistorialPersonalEM;
use App\Http\Controllers\ControllerHistorialPersonalEP;
use App\Http\Controllers\ControllerIngresoAlmacen;
use App\Http\Controllers\ControllerInventarioDocStrioGeneral;
use App\Http\Controllers\ControllerInventarioSecretariaOficina;
use App\Http\Controllers\ControllerMantenimientoEquipoPesado;
use App\Http\Controllers\ControllerPersonalEM;
use App\Http\Controllers\ControllerPersonalEP;
use App\Http\Controllers\ControllerRegistroAcAsExtraOrdinarias;
use App\Http\Controllers\ControllerRegistroAcAsOrdinarias;
use App\Http\Controllers\ControllerRegistroAcAsOrganicas;
use App\Http\Controllers\ControllerRegistroAcEntregaDoc;
use App\Http\Controllers\ControllerRegistroAcLibroDeAlzas;
use App\Http\Controllers\ControllerRegistroAcReuniones;
use App\Http\Controllers\ControllerRegistroAcTribunalDeHonor;
use App\Http\Controllers\ControllerRegistroComisionesInformes;
use App\Http\Controllers\ControllerSalidaAlmacen;
use App\Http\Controllers\ControllerUsuarios;
use Illuminate\Support\Facades\Auth;

//middleware('guest') si el usuario esta autenticado no permite que el usuario acceda a la vista login
//entonces esto redirige a la vista principal donde se configura en la siguiente ruta del archivo php
//app/Providers/RouteServiceProvider.php

Route::get('/', [ControllerLogin::class, 'index'])->name('route-login')->middleware('guest');
Route::post('/logueo', [ControllerLogin::class, 'verificarUsuario'])->name('route-logueo');


Route::group(['middleware' => ['auth']], function () {
   Route::get('/cooperativa', [ControllerCooperativa::class, 'index'])->name('route-cooperativa');
   Route::get('/cerrar-sesion', [ControllerLogin::class, 'cerrarSesionUser']);
});




Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerSocios::class)->group(function () {
      Route::get('/socios', 'index')->name('route-socios');
     
      Route::get('/perfil-de-socios/{parametro}', 'viewPerfil')->name('route-perfil-socios');
      Route::get('/pdf-perfil-socios/{parametro}', 'pdf')->name('route-pdf-perfil-socios');
      Route::get('/imprimir-perfil-socios/{parametro}', 'imprimir')->name('route-imprimir-perfil-socios');
   });
});
Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria']], function () {
   Route::controller(ControllerSocios::class)->group(function () {
      Route::get('/frm-socios-new', 'viewFrm')->name('route-frm-new-socios');
      Route::get('frm-show-socios/{parametro}', 'show')->name('route-frm-show-socios');
   });
});





Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerHistorialSocios::class)->group(function () {
      Route::get('/historial-socios/{parametro}', 'index')->name('route-historial-socios');
     
      Route::get('/ver-historial-socios/{parametro}', 'viewVerHistorial')->name('route-ver-historial-socios');
      Route::get('/pdf-historial-socios/{parametro}', 'pdfRegistros')->name('route-pdf-historial-socios');
      Route::get('/imprimir-historial-socios/{parametro}', 'imprimirRegistros')->name('route-imprimir-historial-socios');
      Route::get('/pdf-ver-historial-socios/{parametro}', 'pdfRegistroId')->name('route-pdf-ver-historial-socios');
      Route::get('/imprimir-ver-historial-socios/{parametro}', 'imprimirRegistroId')->name('route-imprimir-ver-historial-socios');
   });
});
Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria']], function () {
   Route::controller(ControllerHistorialSocios::class)->group(function () {
      Route::get('/frm-new-historial-socios/{parametro}', 'viewFrm')->name('route-frm-new-historial-socios');
      Route::get('/frm-show-historial-socios/{parametro}', 'show')->name('route-frm-show-historial-socios');
    
   });
});




Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerPersonalEP::class)->group(function () {
      Route::get('/personal-planta', 'index')->name('route-personal-planta');
     
      Route::get('/perfil-personal-planta/{parametro}', 'viewPerfil')->name('route-perfil-personal-planta');
      Route::get('/pdf-perfil-personal-planta/{parametro}', 'pdf')->name('route-pdf-perfil-personal-planta');
      Route::get('/imprimir-perfil-personal-planta/{parametro}', 'imprimir')->name('route-imprimir-perfil-personal-planta');
   });
});
Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria']], function () {
   Route::controller(ControllerPersonalEP::class)->group(function () {
      Route::get('/frm-new-personal-planta', 'viewFrm')->name('route-frm-new-personal-planta');
      Route::get('/frm-show-personal-planta/{parametro}', 'show')->name('route-frm-show-personal-planta');
   });
});





Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerHistorialPersonalEP::class)->group(function () {
      Route::get('/historial-personal-planta/{parametro}', 'index')->name('route-historial-personal-planta');
    
      Route::get('/ver-historial-personal-planta/{parametro}', 'viewVerHistorial')->name('route-ver-historial-personal-planta');
      Route::get('/pdf-historial-personal-planta/{parametro}', 'pdfRegistros')->name('route-pdf-historial-personal-planta');
      Route::get('/imprimir-historial-personal-planta/{parametro}', 'imprimirRegistros')->name('route-imprimir-historial-personal-planta');
      Route::get('/pdf-ver-historial-personal-planta/{parametro}', 'pdfRegistroId')->name('route-pdf-ver-historial-personal-planta');
      Route::get('/imprimir-ver-historial-personal-planta/{parametro}', 'imprimirRegistroId')->name('route-imprimir-ver-historial-personal-planta');
   });
});
Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria']], function () {
   Route::controller(ControllerHistorialPersonalEP::class)->group(function () {
      Route::get('/frm-new-historial-personal-planta/{parametro}', 'viewFrm')->name('route-frm-new-historial-personal-planta');
      Route::get('/frm-show-historial-personal-planta/{parametro}', 'show')->name('route-frm-show-historial-personal-planta');
    
   });
});




Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerPersonalEM::class)->group(function () {
      Route::get('/personal-mita', 'index')->name('route-personal-mita');
   
      Route::get('/perfil-personal-mita/{parametro}', 'viewPerfil')->name('route-perfil-personal-mita');
      Route::get('/pdf-perfil-personal-mita/{parametro}', 'pdf')->name('route-pdf-perfil-personal-mita');
      Route::get('/imprimir-perfil-personal-mita/{parametro}', 'imprimir')->name('route-imprimir-perfil-personal-mita');
   });
});
Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria']], function () {
   Route::controller(ControllerPersonalEM::class)->group(function () {
      Route::get('/frm-new-personal-mita', 'viewFrm')->name('route-frm-new-personal-mita');
      Route::get('/frm-show-personal-mita/{parametro}', 'show')->name('route-frm-show-personal-mita');

   });
});




Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerHistorialPersonalEM::class)->group(function () {
      Route::get('/historial-personal-mita/{parametro}', 'index')->name('route-historial-personal-mita');
     
      Route::get('/ver-historial-personal-mita/{parametro}', 'viewVerHistorial')->name('route-ver-historial-personal-mita');
      Route::get('/pdf-historial-personal-mita/{parametro}', 'pdfRegistros')->name('route-pdf-historial-personal-mita');
      Route::get('/imprimir-historial-personal-mita/{parametro}', 'imprimirRegistros')->name('route-imprimir-historial-personal-mita');
      Route::get('/pdf-ver-historial-personal-mita/{parametro}', 'pdfRegistroId')->name('route-pdf-ver-historial-personal-mita');
      Route::get('/imprimir-ver-historial-personal-mita/{parametro}', 'imprimirRegistroId')->name('route-imprimir-ver-historial-personal-mita');
   });
});
Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria']], function () {
   Route::controller(ControllerHistorialPersonalEM::class)->group(function () {
      Route::get('/frm-new-historial-personal-mita/{parametro}', 'viewFrm')->name('route-frm-new-historial-personal-mita');
      Route::get('/frm-show-historial-personal-mita/{parametro}', 'show')->name('route-frm-show-historial-personal-mita');
   });
});




Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerRegistroCorrespondenciasRe::class)->group(function () {
      Route::get('/registro-correspondencias-re', 'index')->name('route-registro-correspondencias-re');
     
      route::get('/ver-registro-correspondencias-re/{parametro}', 'verRegistro')->name('route-ver-registro-correspondencias-re');
      route::get('/pdf-ver-registro-correspondencias-re/{parametro}', 'pdfRegistrosId')->name('route-pdf-ver-registro-correspondencias-re');
      route::get('/imprimir-ver-registro-correspondencias-re/{parametro}', 'imprimirRegistrosId')->name('route-imprimir-ver-registro-correspondencias-re');
      route::get('/pdf-registro-correspondencias-re', 'pdfRegistrosAll')->name('route-pdf-registro-correspondencias-re');
      route::get('/imprimir-registro-correspondencias-re', 'imprimirRegistrosAll')->name('route-imprimir-registro-correspondencias-re');
   });
});
Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria']], function () {
   Route::controller(ControllerRegistroCorrespondenciasRe::class)->group(function () {
      route::get('/frm-new-registro-correspondencias-re', 'viewFrm')->name('route-frm-new-registro-correspondencias-re');
      route::get('/frm-show-registro-correspondencias-re/{parametro}', 'show')->name('route-frm-show-registro-correspondencias-re');
   });
});



Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerRegistroCorrespondenciasEmi::class)->group(function () {
      Route::get('/registro-correspondencias-emi', 'index')->name('route-registro-correspondencias-emi');
     
      route::get('/ver-registro-correspondencias-emi/{parametro}', 'verRegistro')->name('route-ver-registro-correspondencias-emi');
      route::get('/pdf-ver-registro-correspondencias-emi/{parametro}', 'pdfRegistrosId')->name('route-pdf-ver-registro-correspondencias-emi');
      route::get('/imprimir-ver-registro-correspondencias-emi/{parametro}', 'imprimirRegistrosId')->name('route-imprimir-ver-registro-correspondencias-emi');
      route::get('/pdf-registro-correspondencias-emi', 'pdfRegistrosAll')->name('route-pdf-registro-correspondencias-emi');
      route::get('/imprimir-registro-correspondencias-emi', 'imprimirRegistrosAll')->name('route-imprimir-registro-correspondencias-emi');
   });
});
Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria']], function () {
   Route::controller(ControllerRegistroCorrespondenciasEmi::class)->group(function () {
      Route::get('/frm-new-registro-correspondencias-emi', 'viewFrm')->name('route-frm-new-registro-correspondencias-emi');
      route::get('/frm-show-registro-correspondencias-emi/{parametro}', 'show')->name('route-frm-show-registro-correspondencias-emi');
   });
});




Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerRegistroMemorandums::class)->group(function () {
      Route::get('/registro-memorandums', 'index')->name('route-registro-memorandums');
    
      route::get('/ver-registro-memorandums/{parametro}', 'verRegistro')->name('route-ver-registro-memorandums');
      route::get('/pdf-ver-registro-memorandums/{parametro}', 'pdfRegistrosId')->name('route-pdf-ver-registro-memorandums');
      route::get('/imprimir-ver-registro-memorandums/{parametro}', 'imprimirRegistrosId')->name('route-imprimir-ver-registro-memorandums');
      route::get('/pdf-registro-memorandums', 'pdfRegistrosAll')->name('route-pdf-registro-memorandums');
      route::get('/imprimir-memorandums', 'imprimirRegistrosAll')->name('route-imprimir-registro-memorandums');
   });
});
Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria']], function () {
   Route::controller(ControllerRegistroMemorandums::class)->group(function () { 
      Route::get('/frm-new-registro-memorandums', 'viewFrm')->name('route-frm-new-registro-memorandums');
      route::get('/frm-show-registro-memorandums/{parametro}', 'show')->name('route-frm-show-registro-memorandums');
   });
});



Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerFaltasSociosAsAcontecimientos::class)->group(function () {
      Route::get('/faltas-socios-as-acontecimientos', 'index')->name('route-faltas-socios-as-acontecimientos');
      Route::get('/frm-new-faltas-socios-as-acontecimientos', 'viewFrm')->name('route-frm-new-faltas-socios-as-acontecimientos');

      Route::get('/pdf-id-faltas-socios-as-acontecimientos/{parametro}', 'pdfRegistrosId')->name('route-pdf-id-faltas-socios-as-acontecimientos');
      Route::get('/pdf-all-faltas-socios-as-acontecimientos', 'pdfRegistrosAll')->name('route-pdf-all-faltas-socios-as-acontecimientos');
      Route::get('/imprimir-all-faltas-socios-as-acontecimientos', 'imprimirRegistrosAll')->name('route-imprimir-all-faltas-socios-as-acontecimientos');
   });
});
Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria']], function () {
   Route::controller(ControllerFaltasSociosAsAcontecimientos::class)->group(function () {
      Route::get('/frm-show-faltas-socios-as-acontecimientos/{parametro}', 'show')->name('route-frm-show-faltas-socios-as-acontecimientos');
   });
});



Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerRegistroDeActas::class)->group(function () {
      Route::get('/registro-de-actas', 'index')->name('route-registro-de-actas');
   });
});




Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerRegistroAcAsOrdinarias::class)->group(function () {
      Route::get('/registro-ac-as-ordinarias', 'index')->name('route-registro-ac-as-ordinarias');
      Route::get('/frm-new-registro-ac-as-ordinarias', 'viewFrm')->name('route-frm-new-registro-ac-as-ordinarias');
     
      Route::get('/pdf-id-registro-ac-as-ordinarias/{parametro}', 'pdfRegistrosId')->name('route-pdf-id-registro-ac-as-ordinarias');
      Route::get('/pdf-all-registro-ac-as-ordinarias', 'pdfRegistrosAll')->name('route-pdf-all-registro-ac-as-ordinarias');
      Route::get('/imprimir-all-registro-ac-as-ordinarias', 'imprimirRegistrosAll')->name('route-imprimir-all-registro-ac-as-ordinarias');
   });
});
Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria']], function () {
   Route::controller(ControllerRegistroAcAsOrdinarias::class)->group(function () {
      Route::get('/frm-show-registro-ac-as-ordinarias/{parametro}', 'show')->name('route-frm-show-registro-ac-as-ordinarias');
   });
});




Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerRegistroAcAsExtraOrdinarias::class)->group(function () {
      Route::get('/registro-ac-as-extra-ordinarias', 'index')->name('route-registro-ac-as-extra-ordinarias');
      Route::get('/frm-new-registro-ac-as-extra-ordinarias', 'viewFrm')->name('route-frm-new-registro-ac-as-extra-ordinarias');

      Route::get('/pdf-id-registro-ac-as-extra-ordinarias/{parametro}', 'pdfRegistrosId')->name('route-pdf-id-registro-ac-as-extra-ordinarias');
      Route::get('/pdf-all-registro-ac-as-extra-ordinarias', 'pdfRegistrosAll')->name('route-pdf-all-registro-ac-as-extra-ordinarias');
      Route::get('/imprimir-all-registro-ac-as-extra-ordinarias', 'imprimirRegistrosAll')->name('route-imprimir-all-registro-ac-as-extra-ordinarias');
   });
});
Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria']], function () {
   Route::controller(ControllerRegistroAcAsExtraOrdinarias::class)->group(function () {
      Route::get('/frm-show-registro-ac-as-extra-ordinarias/{parametro}', 'show')->name('route-frm-show-registro-ac-as-extra-ordinarias');
   });
});



Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerRegistroAcAsOrganicas::class)->group(function () {
      Route::get('/registro-ac-as-organicas', 'index')->name('route-registro-ac-as-organicas');
      Route::get('/frm-new-registro-ac-as-organicas', 'viewFrm')->name('route-frm-new-registro-ac-as-organicas');

      Route::get('/pdf-id-registro-ac-as-organicas/{parametro}', 'pdfRegistrosId')->name('route-pdf-id-registro-ac-as-organicas');
      Route::get('/pdf-all-registro-ac-as-organicas', 'pdfRegistrosAll')->name('route-pdf-all-registro-ac-as-organicas');
      Route::get('/imprimir-all-registro-ac-as-organicas', 'imprimirRegistrosAll')->name('route-imprimir-all-registro-ac-as-organicas');
   });
});
Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria']], function () {
   Route::controller(ControllerRegistroAcAsOrganicas::class)->group(function () {
      Route::get('/frm-show-registro-ac-as-organicas/{parametro}', 'show')->name('route-frm-show-registro-ac-as-organicas');
   });
});



Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerRegistroAcTribunalDeHonor::class)->group(function () {
      Route::get('/registro-ac-tribunal-de-honor', 'index')->name('route-registro-ac-tribunal-de-honor');
      Route::get('/frm-new-registro-ac-tribunal-de-honor', 'viewFrm')->name('route-frm-new-registro-ac-tribunal-de-honor');
     
      Route::get('/pdf-id-registro-ac-tribunal-de-honor/{parametro}', 'pdfRegistrosId')->name('route-pdf-id-registro-ac-tribunal-de-honor');
      Route::get('/pdf-all-registro-ac-tribunal-de-honor', 'pdfRegistrosAll')->name('route-pdf-all-registro-ac-tribunal-de-honor');
      Route::get('/imprimir-all-registro-ac-tribunal-de-honor', 'imprimirRegistrosAll')->name('route-imprimir-all-registro-ac-tribunal-de-honor');
   });
});
Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria']], function () {
   Route::controller(ControllerRegistroAcTribunalDeHonor::class)->group(function () {
      Route::get('/frm-show-registro-ac-tribunal-de-honor/{parametro}', 'show')->name('route-frm-show-registro-ac-tribunal-de-honor');
   });
});




Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerRegistroAcReuniones::class)->group(function () {
      Route::get('/registro-ac-reuniones', 'index')->name('route-registro-ac-reuniones');
      Route::get('/frm-new-registro-ac-reuniones', 'viewFrm')->name('route-frm-new-registro-ac-reuniones');
     
      Route::get('/pdf-id-registro-ac-reuniones/{parametro}', 'pdfRegistrosId')->name('route-pdf-id-registro-ac-reuniones');
      Route::get('/pdf-all-registro-ac-reuniones', 'pdfRegistrosAll')->name('route-pdf-all-registro-ac-reuniones');
      Route::get('/imprimir-all-registro-ac-reuniones', 'imprimirRegistrosAll')->name('route-imprimir-all-registro-ac-reuniones');
   });
});
Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria']], function () {
   Route::controller(ControllerRegistroAcReuniones::class)->group(function () {
      Route::get('/frm-show-registro-ac-reuniones/{parametro}', 'show')->name('route-frm-show-registro-ac-reuniones');
   });
});




Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerRegistroAcEntregaDoc::class)->group(function () {
      Route::get('/registro-ac-entrega-doc', 'index')->name('route-registro-ac-entrega-doc');
      Route::get('/frm-new-registro-ac-entrega-doc', 'viewFrm')->name('route-frm-new-registro-ac-entrega-doc');
    
      Route::get('/pdf-id-registro-ac-entrega-doc/{parametro}', 'pdfRegistrosId')->name('route-pdf-id-registro-ac-entrega-doc');
      Route::get('/pdf-all-registro-ac-entrega-doc', 'pdfRegistrosAll')->name('route-pdf-all-registro-ac-entrega-doc');
      Route::get('/imprimir-all-registro-ac-entrega-doc', 'imprimirRegistrosAll')->name('route-imprimir-all-registro-ac-entrega-doc');
   });
});
Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria']], function () {
   Route::controller(ControllerRegistroAcEntregaDoc::class)->group(function () {
      Route::get('/frm-show-registro-ac-entrega-doc/{parametro}', 'show')->name('route-frm-show-registro-ac-entrega-doc');
   });
});



Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerRegistroAcLibroDeAlzas::class)->group(function () {
      Route::get('/registro-ac-libro-de-alzas', 'index')->name('route-registro-ac-libro-de-alzas');
      Route::get('/frm-new-registro-ac-libro-de-alzas', 'viewFrm')->name('route-frm-new-registro-ac-libro-de-alzas');

      Route::get('/pdf-id-registro-ac-libro-de-alzas/{parametro}', 'pdfRegistrosId')->name('route-pdf-id-registro-ac-libro-de-alzas');
      Route::get('/pdf-all-registro-ac-libro-de-alzas', 'pdfRegistrosAll')->name('route-pdf-all-registro-ac-libro-de-alzas');
      Route::get('/imprimir-all-registro-ac-libro-de-alzas', 'imprimirRegistrosAll')->name('route-imprimir-all-registro-ac-libro-de-alzas');
   });
});
Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria']], function () {
   Route::controller(ControllerRegistroAcLibroDeAlzas::class)->group(function () {
      Route::get('/frm-show-registro-ac-libro-de-alzas/{parametro}', 'show')->name('route-frm-show-registro-ac-libro-de-alzas');
   });
});




Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerDocumentacionPdteCsjoAdmin::class)->group(function () {
      Route::get('/documentacion-pdte-csjo-admin', 'index')->name('route-documentacion-pdte-csjo-admin');
      Route::get('/frm-new-documentacion-pdte-csjo-admin', 'viewFrm')->name('route-frm-new-documentacion-pdte-csjo-admin');
    
      Route::get('/pdf-id-documentacion-pdte-csjo-admin/{parametro}', 'pdfRegistrosId')->name('route-pdf-id-documentacion-pdte-csjo-admin');
      Route::get('/pdf-all-documentacion-pdte-csjo-admin', 'pdfRegistrosAll')->name('route-pdf-all-documentacion-pdte-csjo-admin');
      Route::get('/imprimir-all-documentacion-pdte-csjo-admin', 'imprimirRegistrosAll')->name('route-imprimir-all-documentacion-pdte-csjo-admin');
   });
});
Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria']], function () {
   Route::controller(ControllerDocumentacionPdteCsjoAdmin::class)->group(function () {
      Route::get('/frm-show-documentacion-pdte-csjo-admin/{parametro}', 'show')->name('route-frm-show-documentacion-pdte-csjo-admin');
   });
});




Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerInventarioSecretariaOficina::class)->group(function () {
      Route::get('/inventario-secretaria-oficina', 'index')->name('route-inventario-secretaria-oficina');
      Route::get('/frm-new-inventario-secretaria-oficina', 'viewFrm')->name('route-frm-new-inventario-secretaria-oficina');
     
      Route::get('/pdf-id-inventario-secretaria-oficina/{parametro}', 'pdfRegistrosId')->name('route-pdf-id-inventario-secretaria-oficina');
      Route::get('/pdf-all-inventario-secretaria-oficina', 'pdfRegistrosAll')->name('route-pdf-all-inventario-secretaria-oficina');
      Route::get('/imprimir-all-inventario-secretaria-oficina', 'imprimirRegistrosAll')->name('route-imprimir-all-inventario-secretaria-oficina');
   });
});
Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria']], function () {
   Route::controller(ControllerInventarioSecretariaOficina::class)->group(function () {
      Route::get('/frm-show-inventario-secretaria-oficina/{parametro}', 'show')->name('route-frm-show-inventario-secretaria-oficina');
   });
});





Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerInventarioDocStrioGeneral::class)->group(function () {
      Route::get('/inventario-doc-strio-general', 'index')->name('route-inventario-doc-strio-general');
      Route::get('/frm-new-inventario-doc-strio-general', 'viewFrm')->name('route-frm-new-inventario-doc-strio-general');
     
      Route::get('/pdf-id-inventario-doc-strio-general/{parametro}', 'pdfRegistrosId')->name('route-pdf-id-inventario-doc-strio-general');
      Route::get('/pdf-all-inventario-doc-strio-general', 'pdfRegistrosAll')->name('route-pdf-all-inventario-doc-strio-general');
      Route::get('/imprimir-all-inventario-doc-strio-general', 'imprimirRegistrosAll')->name('route-imprimir-all-inventario-doc-strio-general');
   });
});
Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria']], function () {
   Route::controller(ControllerInventarioDocStrioGeneral::class)->group(function () {
      Route::get('/frm-show-inventario-doc-strio-general/{parametro}', 'show')->name('route-frm-show-inventario-doc-strio-general');
   });
});




Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria,invitado']], function () {
   Route::controller(ControllerRegistroComisionesInformes::class)->group(function () {
      Route::get('/registro-comisiones-informes', 'index')->name('route-registro-comisiones-informes');
      Route::get('/frm-new-registro-comisiones-informes', 'viewFrm')->name('route-frm-new-registro-comisiones-informes');

      Route::get('/pdf-id-registro-comisiones-informes/{parametro}', 'pdfRegistrosId')->name('route-pdf-id-registro-comisiones-informes');
      Route::get('/pdf-all-registro-comisiones-informes', 'pdfRegistrosAll')->name('route-pdf-all-registro-comisiones-informes');
      Route::get('/imprimir-all-registro-comisiones-informes', 'imprimirRegistrosAll')->name('route-imprimir-all-registro-comisiones-informes');
   });
});
Route::group(['middleware' => ['auth','role.web:system,administrador,secretaria']], function () {
   Route::controller(ControllerRegistroComisionesInformes::class)->group(function () {
      Route::get('/frm-show-registro-comisiones-informes/{parametro}', 'show')->name('route-frm-show-registro-comisiones-informes');
   });
});



/*me quede hasta aqui de roles en las rutas tengo que reviar este archivo cada ruta y ahcer prueba el sistema*/



Route::group(['middleware' => ['auth']], function () {
   Route::controller(ControllerEquipoPesado::class)->group(function () {
      Route::get('/equipo-pesado', 'index')->name('route-equipo-pesado');
      Route::get('/frm-new-equipo-pesado', 'viewFrm')->name('route-frm-new-equipo-pesado');
      route::get('/frm-show-equipo-pesado/{parametro}', 'show')->name('route-frm-show-equipo-pesado');
      route::get('/ver-equipo-pesado/{parametro}', 'verRegistro')->name('route-ver-equipo-pesado');
      route::get('/pdf-ver-equipo-pesado/{parametro}', 'pdfRegistrosId')->name('route-pdf-ver-equipo-pesado');
      route::get('/imprimir-ver-equipo-pesado/{parametro}', 'imprimirRegistrosId')->name('route-imprimir-ver-equipo-pesado');
   });
});



Route::group(['middleware' => ['auth']], function () {
   Route::controller(ControllerMantenimientoEquipoPesado::class)->group(function () {
      Route::get('/mantenimiento-equipo-pesado/{parametro}', 'index')->name('route-mantenimiento-equipo-pesado');
      Route::get('/frm-new-mantenimiento-equipo-pesado/{parametro}', 'viewFrm')->name('route-frm-new-mantenimiento-equipo-pesado');
      route::get('/frm-show-mantenimiento-equipo-pesado/{parametro}', 'show')->name('route-frm-show-mantenimiento-equipo-pesado');
      route::get('/ver-mantenimiento-equipo-pesado/{parametro}', 'verRegistro')->name('route-ver-mantenimiento-equipo-pesado');
      route::get('/pdf-mantenimiento-equipo-pesado/{parametro}', 'pdfRegistros')->name('route-pdf-mantenimiento-equipo-pesado');
      route::get('/imprimir-mantenimiento-equipo-pesado/{parametro}', 'imprimirRegistros')->name('route-imprimir-mantenimiento-equipo-pesado');
   });
});



Route::group(['middleware' => ['auth', 'role.web:system,administrador,almacenes,invitado']], function () {
   Route::controller(ControllerIngresoAlmacen::class)->group(function () {
      Route::get('/ingreso-almacen', 'index')->name('route-ingreso-almacen');
   });
});
Route::group(['middleware' => ['auth', 'role.web:system,administrador,almacenes']], function () {
   Route::controller(ControllerIngresoAlmacen::class)->group(function () {
      Route::get('/ingreso-almacen', 'index')->name('route-ingreso-almacen');
      Route::get('/frm-new-ingreso-almacen', 'viewFrm')->name('route-frm-new-ingreso-almacen');
      Route::get('/frm-show-ingreso-almacen/{parametro}', 'show')->name('route-frm-show-ingreso-almacen');
      route::get('/pdf-ingreso-almacen', 'pdfRegistrosAll')->name('route-pdf-ingreso-almacen');
      route::get('/imprimir-ingreso-almacen', 'imprimirRegistrosAll')->name('route-imprimir-ingreso-almacen');
   });
});



Route::group(['middleware' => ['auth', 'role.web:system,administrador,almacenes,invitado']], function () {
   Route::controller(ControllerSalidaAlmacen::class)->group(function () {
      Route::get('/salida-almacen', 'index')->name('route-salida-almacen');
   });
});
Route::group(['middleware' => ['auth', 'role.web:system,administrador,almacenes']], function () {
   Route::controller(ControllerSalidaAlmacen::class)->group(function () {
      Route::get('/frm-new-salida-almacen', 'viewFrm')->name('route-frm-new-salida-almacen');
      route::get('/frm-show-salida-almacen/{parametro}', 'show')->name('route-frm-show-salida-almacen');
      route::get('/pdf-salida-almacen', 'pdfRegistrosAll')->name('route-pdf-salida-almacen');
      route::get('/imprimir-salida-almacen', 'imprimirRegistrosAll')->name('route-imprimir-salida-almacen');
   });
});



Route::group(['middleware' => ['auth', 'role.web:system,administrador']], function () {
   Route::controller(ControllerUsuarios::class)->group(function () {
      Route::get('/usuarios', 'index')->name('route-usuarios');
      Route::get('/frm-new-usuarios', 'viewFrm')->name('route-frm-new-usuarios');
      route::get('/frm-show-usuarios/{parametro}', 'show')->name('route-frm-show-usuarios');
      route::get('/frm-show-password-usuarios', 'showModifyPassword')->name('route-frm-show-password-usuarios');
   });
});
Route::group(['middleware' => ['auth']], function () {
   Route::controller(ControllerUsuarios::class)->group(function () {
      route::get('/frm-show-password-usuarios', 'showModifyPassword')->name('route-frm-show-password-usuarios');
   });
});


Route::group(['middleware' => ['auth']], function () {
   Route::get('/acceso-no-autorizado', function () {
   
      return view('AccesoNoAutorizado');
   });
});

