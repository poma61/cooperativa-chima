<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{asset('assets/css/normalize.css')}}" type="text/css" media="all">
    <link rel="stylesheet" href="{{asset('assets/css/pro-sideBar.css')}}?v={{config('constants.VERSION_CSS')}}"
        type="text/css" media="all">
    <link rel="stylesheet" href="{{asset('assets/iconos/css/material-design-iconic-font.min.css')}}" type="text/css"
        media="all">
    <link rel="stylesheet" href="{{asset('assets/css/sideBar.css')}}?v={{config('constants.VERSION_CSS')}}"
        type="text/css" media="all">
    <link rel="stylesheet" href="{{asset('assets/css/main200.css')}}?v={{config('constants.VERSION_CSS')}}"
        type="text/css" media="all">

    <link rel="icon" href="{{asset('assets/images/logo-minero-1.png')}}" type="image/x-icon">

    <title>Cooperativa Chima</title>
</head>

<body>

    <!-- menu => popup -->
    <div class="container-popup-hidden">
    </div>


    <div class="layout has-sidebar fixed-sidebar fixed-header">
        <!-- menu =>  components/layouts/menu.blade.php -->
        @include('components/layouts/menu')

        <div id="overlay" class="overlay"> </div>
        <div class="layout">

            @include('components/layouts/fixed_header')

            <!-- Contenido-->
            <main class="content">

                <div class="title-info-color-200">Registrar - Equipo Pesado</div>
                <div class="main-container">

                    <section class="container-menu-opciones-vertical">
                        <ul class="list-menu-opciones">
                            <!-- menu opciones de forma vertical -->
                            <x-menu_opciones.MenuOptionVerticalEquipoPesado />
                            @if($equipo_pesado->id!=0)
                            <li class="item-menu-opciones">
                                <a class="color-100"
                                    href="{{route('route-ver-equipo-pesado',MyEncryption::encrypt($equipo_pesado->id))}}">
                                    <i class="zmdi zmdi-file-text"></i><span> Registro</span></a>
                            </li>
                            @endif
                        </ul>
                    </section>

                    <!-- formulario-->
                    <div class="container-form">
                        <h3 class="title-form-control">Formulario | Equipo Pesado</h3>
                        <p>Los campos marcados con (*) son obligatorios</p>

                        <form class="mi-form-control" id="mi-form" enctype="multipart/form-data">
                            @if($equipo_pesado->id!=0)
                            <input type="hidden" name="id-reg" value="{{MyEncryption::encrypt($equipo_pesado->id)}}">
                            @endif
                            <p class="form-aviso-campos"><i class="zmdi zmdi-label"></i> DATOS GENERALES</p>

                            <div class="form-control-colum-2">
                                <div class="campo-form-control-2">
                                    <label for="">Nombre comun del equipo<span class="asterisco-label">*</span></label>
                                    <input type="text" name="nombre_comun_del_equipo"
                                        value="{{$equipo_pesado->nombre_comun_del_equipo}}">
                                    <p class="advertencia-error" id="error-nombre_comun_del_equipo"></p>
                                </div>
                                <div class="campo-form-control-2">
                                    <label for="">Codigo de inventario interno<span
                                            class="asterisco-label">*</span></label>
                                    <input type="text" name="codigo_de_inventario_interno"
                                        value="{{$equipo_pesado->codigo_de_inventario_interno}}">
                                    <p class="advertencia-error" id="error-codigo_de_inventario_interno"></p>
                                </div>
                            </div>
                            <p class="form-aviso-campos"><i class="zmdi zmdi-label"></i> DATOS DE ORIGEN</p>

                            <div class="form-control-colum-2">
                                <div class="campo-form-control-2">
                                    <label for="">Fabricante<span class="asterisco-label">*</span></label>
                                    <input type="text" name="fabricante" value="{{$equipo_pesado->fabricante}}">
                                    <p class="advertencia-error" id="error-fabricante"></p>
                                </div>

                                <div class="campo-form-control-2">
                                    <label for="">Año vencimiento de garantia<span
                                            class="asterisco-label">*</span></label>
                                    <input type="number" name="ano_vencimiento_de_garantia"
                                        value="{{$equipo_pesado->ano_vencimiento_de_garantia}}">
                                    <p class="advertencia-error" id="error-ano_vencimiento_de_garantia"></p>
                                </div>
                            </div>


                            <div class="form-control-colum-2">
                                <div class="campo-form-control-2">
                                    <label for="">Año de Fabricacion<span class="asterisco-label">*</span></label>
                                    <input type="number" name="ano_de_fabricacion"
                                        value="{{$equipo_pesado->ano_de_fabricacion}}">
                                    <p class="advertencia-error" id="error-ano_de_fabricacion"></p>
                                </div>

                                <div class="campo-form-control-2">
                                    <label for="">Pais de origen<span class="asterisco-label">*</span></label>
                                    <input type="text" name="pais_de_origen" value="{{$equipo_pesado->pais_de_origen}}"
                                        s>
                                    <p class="advertencia-error" id="error-pais_de_origen"></p>
                                </div>
                            </div>

                            <div class="form-control-colum-2">
                                <div class="campo-form-control-2">
                                    <label for="">Modelo<span class="asterisco-label">*</span></label>
                                    <input type="text" name="modelo" value="{{$equipo_pesado->modelo}}">
                                    <p class="advertencia-error" id="error-modelo"></p>
                                </div>

                                <div class="campo-form-control-2">
                                    <label for="">Numero de serie<span class="asterisco-label">*</span></label>
                                    <input type="text" name="numero_de_serie"
                                        value="{{$equipo_pesado->numero_de_serie}}">
                                    <p class="advertencia-error" id="error-numero_de_serie"></p>
                                </div>
                            </div>

                            <div class="campo-form-control">
                                <label for="">Año de compra<span class="asterisco-label">*</span></label>
                                <input type="number" name="ano_de_compra" value="{{$equipo_pesado->ano_de_compra}}">
                                <p class="advertencia-error" id="error-ano_de_compra"></p>
                            </div>

                            <p class="form-aviso-campos"><i class="zmdi zmdi-label"></i> DATOS DE USO EN PLANTA</p>

                            <div class="form-control-colum-2">
                                <div class="campo-form-control-2">
                                    <label for="">Año de alta planta<span class="asterisco-label">*</span></label>
                                    <input type="number" name="ano_de_alta_planta"
                                        value="{{$equipo_pesado->ano_de_alta_planta}}">
                                    <p class="advertencia-error" id="error-ano_de_alta_planta"></p>
                                </div>

                                <div class="campo-form-control-2">
                                    <label for="">Estado del equipo al momento de alta<span
                                            class="asterisco-label">*</span></label>
                                    <input type="text" name="estado_del_equipo_al_momento_de_alta"
                                        value="{{$equipo_pesado->estado_del_equipo_al_momento_de_alta}}">
                                    <p class="advertencia-error" id="error-estado_del_equipo_al_momento_de_alta"></p>
                                </div>
                            </div>

                            <div class="form-control-colum-2">
                                <div class="campo-form-control-2">
                                    <label for="">Horometro al inicio operacion planta<span
                                            class="asterisco-label">*</span></label>
                                    <input type="text" name="horometro_al_inicio_operacion_planta"
                                        value="{{$equipo_pesado->horometro_al_inicio_operacion_planta}}">
                                    <p class="advertencia-error" id="error-horometro_al_inicio_operacion_planta"></p>
                                </div>

                                <div class="campo-form-control-2">
                                    <label for="">Linea de produccion asignada<span
                                            class="asterisco-label">*</span></label>
                                    <input type="text" name="linea_de_produccion_asignada"
                                        value="{{$equipo_pesado->linea_de_produccion_asignada}}">
                                    <p class="advertencia-error" id="error-linea_de_produccion_asignada"></p>
                                </div>
                            </div>

                            <div class="campo-form-control-area">
                                <label for="">Ubicacion<span class="asterisco-label">*</span></label>
                                <textarea name="ubicacion">{{$equipo_pesado->ubicacion}}</textarea>
                                <p class="advertencia-error" id="error-ubicacion"></p>
                            </div>

                            <p class="form-aviso-campos"><i class="zmdi zmdi-label"></i> REGISTRO FOTOGRAFICO</p>

                            <div class="campo-form-control">
                                <label>Archivo<span class="asterisco-label">*</span></label>
                                <input type="file" name="archivo" id="seleccionar-archivo">
                                <label for="seleccionar-archivo" class="file-btn">Seleccionar <i
                                        class="zmdi zmdi-attachment-alt"></i></label>
                                <p class="advertencia-error" id="error-archivo"></p>
                            </div>

                            <div class="image-pre-view">
                                @if($equipo_pesado->archivo==null)
                                <img src="{{asset('assets/images/image-preview.png')}}" alt="Archivo Subido"
                                    id="vista-previa">
                                @else
                                <img src="data:image/all;base64,{{base64_encode($equipo_pesado->archivo)}}"
                                    alt="archivo historial" id="vista-previa">
                                @endif
                            </div>

                            <p class="form-aviso-campos"><i class="zmdi zmdi-label"></i> DATOS TECNICOS</p>
                            <!-- datos tecnicos -->
                            <div class="form-control-colum-2">
                                <div class="campo-form-control-2">
                                    <label for="">Potencia und.<span class="asterisco-label">*</span></label>
                                    <input type="text" name="potencia_und" value="{{$equipo_pesado->potencia_und}}">
                                    <p class="advertencia-error" id="error-potencia_und"></p>
                                </div>

                                <div class="campo-form-control-2">
                                    <label for="">Potencia valor nominal<span class="asterisco-label">*</span></label>
                                    <input type="text" name="potencia_valor_nominal"
                                        value="{{$equipo_pesado->potencia_valor_nominal}}">
                                    <p class="advertencia-error" id="error-potencia_valor_nominal"></p>
                                </div>
                            </div>
                            <div class="campo-form-control-area">
                                <label for="">Potencia caracteristicas<span class="asterisco-label">*</span></label>
                                <textarea
                                    name="potencia_caracteristicas">{{$equipo_pesado->potencia_caracteristicas}}</textarea>
                                <p class="advertencia-error" id="error-potencia_caracteristicas"></p>
                            </div>

                            <!-- datos tecnicos -->
                            <div class="form-control-colum-2">
                                <div class="campo-form-control-2">
                                    <label for="">Voltaje und.<span class="asterisco-label">*</span></label>
                                    <input type="text" name="voltaje_und" value="{{$equipo_pesado->voltaje_und}}">
                                    <p class="advertencia-error" id="error-voltaje_und"></p>
                                </div>

                                <div class="campo-form-control-2">
                                    <label for="">Voltaje valor nominal<span class="asterisco-label">*</span></label>
                                    <input type="text" name="voltaje_valor_nominal"
                                        value="{{$equipo_pesado->voltaje_valor_nominal}}">
                                    <p class="advertencia-error" id="error-voltaje_valor_nominal"></p>
                                </div>
                            </div>
                            <div class="campo-form-control-area">
                                <label for="">Voltaje caracteristicas<span class="asterisco-label">*</span></label>
                                <textarea
                                    name="voltaje_caracteristicas">{{$equipo_pesado->voltaje_caracteristicas}}</textarea>
                                <p class="advertencia-error" id="error-voltaje_caracteristicas"></p>
                            </div>

                            <!-- datos tecnicos -->
                            <div class="form-control-colum-2">
                                <div class="campo-form-control-2">
                                    <label for="">Corriente und.<span class="asterisco-label">*</span></label>
                                    <input type="text" name="corriente_und" value="{{$equipo_pesado->corriente_und}}">
                                    <p class="advertencia-error" id="error-corriente_und"></p>
                                </div>

                                <div class="campo-form-control-2">
                                    <label for="">Corriente valor nominal<span class="asterisco-label">*</span></label>
                                    <input type="text" name="corriente_valor_nominal"
                                        value="{{$equipo_pesado->corriente_valor_nominal}}">
                                    <p class="advertencia-error" id="error-corriente_valor_nominal"></p>
                                </div>
                            </div>
                            <div class="campo-form-control-area">
                                <label for="">Corriente caracteristicas<span class="asterisco-label">*</span></label>
                                <textarea
                                    name="corriente_caracteristicas">{{$equipo_pesado->corriente_caracteristicas}}</textarea>
                                <p class="advertencia-error" id="error-corriente_caracteristicas"></p>
                            </div>


                            <!-- datos tecnicos -->
                            <div class="form-control-colum-2">
                                <div class="campo-form-control-2">
                                    <label for="">Capacidad de cucharon und.<span
                                            class="asterisco-label">*</span></label>
                                    <input type="text" name="capacidad_de_cucharon_und"
                                        value="{{$equipo_pesado->capacidad_de_cucharon_und}}">
                                    <p class="advertencia-error" id="error-capacidad_de_cucharon_und"></p>
                                </div>

                                <div class="campo-form-control-2">
                                    <label for="">Capacidad de cucharon valor nominal<span
                                            class="asterisco-label">*</span></label>
                                    <input type="text" name="capacidad_de_cucharon_valor_nominal"
                                        value="{{$equipo_pesado->capacidad_de_cucharon_valor_nominal}}">
                                    <p class="advertencia-error" id="error-capacidad_de_cucharon_valor_nominal"></p>
                                </div>
                            </div>
                            <div class="campo-form-control-area">
                                <label for="">Capacidad de cucharon caracteristicas<span
                                        class="asterisco-label">*</span></label>
                                <textarea
                                    name="capacidad_de_cucharon_caracteristicas">{{$equipo_pesado->capacidad_de_cucharon_caracteristicas}}</textarea>
                                <p class="advertencia-error" id="error-capacidad_de_cucharon_caracteristicas"></p>
                            </div>

                            <!-- datos tecnicos -->
                            <div class="form-control-colum-2">
                                <div class="campo-form-control-2">
                                    <label for="">Capacidad de diesel und.<span class="asterisco-label">*</span></label>
                                    <input type="text" name="capacidad_de_diesel_und"
                                        value="{{$equipo_pesado->capacidad_de_diesel_und}}">
                                    <p class="advertencia-error" id="error-capacidad_de_diesel_und"></p>
                                </div>

                                <div class="campo-form-control-2">
                                    <label for="">Capacidad de diesel valor nominal<span
                                            class="asterisco-label">*</span></label>
                                    <input type="text" name="capacidad_de_diesel_valor_nominal"
                                        value="{{$equipo_pesado->capacidad_de_diesel_valor_nominal}}">
                                    <p class="advertencia-error" id="error-capacidad_de_diesel_valor_nominal"></p>
                                </div>
                            </div>
                            <div class="campo-form-control-area">
                                <label for="">Capacidad de diesel caracteristicas<span
                                        class="asterisco-label">*</span></label>
                                <textarea
                                    name="capacidad_de_diesel_caracteristicas">{{$equipo_pesado->capacidad_de_diesel_caracteristicas}}</textarea>
                                <p class="advertencia-error" id="error-capacidad_de_diesel_caracteristicas"></p>
                            </div>


                            <!-- datos tecnicos -->
                            <div class="form-control-colum-2">
                                <div class="campo-form-control-2">
                                    <label for="">Otros und.<span class="asterisco-label">*</span></label>
                                    <input type="text" name="otros_und" value="{{$equipo_pesado->otros_und}}">
                                    <p class="advertencia-error" id="error-otros_und"></p>
                                </div>

                                <div class="campo-form-control-2">
                                    <label for="">Otros valor nominal<span class="asterisco-label">*</span></label>
                                    <input type="text" name="otros_valor_nominal"
                                        value="{{$equipo_pesado->otros_valor_nominal}}">
                                    <p class="advertencia-error" id="error-otros_valor_nominal"></p>
                                </div>
                            </div>
                            <div class="campo-form-control-area">
                                <label for="">Otros caracteristicas<span class="asterisco-label">*</span></label>
                                <textarea
                                    name="otros_caracteristicas">{{$equipo_pesado->otros_caracteristicas}}</textarea>
                                <p class="advertencia-error" id="error-otros_caracteristicas"></p>
                            </div>

                            <p class="form-aviso-campos"><i class="zmdi zmdi-label"></i> DISPONIBILIDAD DE INFORMACION
                                DE SOPORTE TECNICO</p>

                            <div class="campo-form-control-area">
                                <label for="">Manuales Impresos<span class="asterisco-label">*</span></label>
                                <textarea name="manuales_impresos">{{$equipo_pesado->manuales_impresos}}</textarea>
                                <p class="advertencia-error" id="error-manuales_impresos"></p>
                            </div>

                            <div class="campo-form-control">
                                <label>Manuales digitales<span class="asterisco-label">*</span></label>
                                <input type="file" name="manuales_digitales" id="seleccionar-archivo-pdf">
                                <label for="seleccionar-archivo-pdf" class="file-btn">Seleccionar <i
                                        class="zmdi zmdi-attachment-alt"></i></label>
                                <p class="advertencia-error" id="error-manuales_digitales"></p>
                            </div>

                            <div class="campo-form-control-area">
                                <label for="">Otros Manuales<span class="asterisco-label">*</span></label>
                                <textarea name="otros_manuales">{{$equipo_pesado->otros_manuales}}</textarea>
                                <p class="advertencia-error" id="error-otros_manuales"></p>
                            </div>

                            <!--Planos mecanicos digitales NO esta especificado si es archivo  -->
                            <div class="campo-form-control-area">
                                <label for="">Planos mecanicos digitales<span class="asterisco-label">*</span></label>
                                <textarea
                                    name="planos_mecanicos_digitales">{{$equipo_pesado->planos_mecanicos_digitales}}</textarea>
                                <p class="advertencia-error" id="error-planos_mecanicos_digitales"></p>
                            </div>

                            <div class="campo-form-control">
                                <label>Planos electricos digitales<span class="asterisco-label">*</span></label>
                                <input type="file" name="planos_electricos_digitales" id="seleccionar-archivo-pdf-2">
                                <label for="seleccionar-archivo-pdf-2" class="file-btn">Seleccionar <i
                                        class="zmdi zmdi-attachment-alt"></i></label>
                                <p class="advertencia-error" id="error-planos_electricos_digitales"></p>
                            </div>

                            <div class="campo-form-control-area">
                                <label for="">Otros planos<span class="asterisco-label">*</span></label>
                                <textarea name="otros_planos">{{$equipo_pesado->otros_planos}}</textarea>
                                <p class="advertencia-error" id="error-otros_planos"></p>
                            </div>

                            <div class="container-enviar">
                                <button type="button" class="enviar-reg" id="btn-accion" data-action="{{$action}}"><i
                                        class="zmdi zmdi-dialpad"></i>
                                    Enviar registro</button>
                            </div>
                        </form>

                    </div>

                </div>
            </main>
            <!-- Contenido-->
            <div class="overlay">
            </div>
        </div>
    </div>

    <script src="{{asset('assets/js/UnpkgSideBar.js')}}"></script>
    <script src="{{asset('assets/js/sidebar.js')}}"></script>
    <script src="{{asset('assets/js/CerrarSesion.js')}}?v={{config('constants.VERSION_JS')}}"></script>
    <script src="{{asset('assets/js/app/EquipoPesado.js')}}?v={{config('constants.VERSION_JS')}}"></script>
    <script src="{{asset('assets/js/ImagePreview.js')}}?v={{config('constants.VERSION_JS')}}"></script>
</body>


</html>