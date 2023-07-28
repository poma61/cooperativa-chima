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

                <div class="title-info-color-200">Informacion | Equipo Pesado</div>
                <div class="main-container">

                    <section class="container-menu-opciones-vertical">
                        <ul class="list-menu-opciones">
                            <!-- menu opciones de forma vertical -->
                            <x-menu_opciones.MenuOptionVerticalEquipoPesado />

                            <li class="item-menu-opciones">
                                <a class="color-100"
                                    href="{{route('route-mantenimiento-equipo-pesado',MyEncryption::encrypt($equipo_pesado->id))}}">
                                    <i class="zmdi zmdi-wrench"></i><span> Mantenimiento</span> </a>
                            </li>

                            <li class="item-menu-opciones">
                                <a class="color-100"
                                    href="{{route('route-frm-show-equipo-pesado',MyEncryption::encrypt($equipo_pesado->id))}}">
                                    <i class="zmdi zmdi-border-color"></i><span> Actualizar</span> </a>
                            </li>
                            <li class="item-menu-opciones">
                                <a class="color-100" style="cursor:pointer;" id="btn-accion"
                                    data-action="confirm-destroy"
                                    data-id_reg="{{MyEncryption::encrypt($equipo_pesado->id)}}">
                                    <i class="zmdi zmdi-delete"></i><span> Eliminar</span></a>
                            </li>

                            <li class="item-menu-opciones">
                                <a class="color-100"
                                    href="{{route('route-ver-equipo-pesado',MyEncryption::encrypt($equipo_pesado->id))}}">
                                    <i class="zmdi zmdi-file-text"></i><span> Registro</span></a>
                            </li>

                            <li class="item-menu-opciones">
                                <a class="color-100"
                                    href="{{route('route-pdf-ver-equipo-pesado',MyEncryption::encrypt($equipo_pesado->id))}}">
                                    <i class="zmdi zmdi-download"></i><span> PDF</span> </a>
                            </li>
                            <li class="item-menu-opciones">
                                <a class="color-100"
                                    href="{{route('route-imprimir-ver-equipo-pesado',MyEncryption::encrypt($equipo_pesado->id))}}">
                                    <i class="zmdi zmdi-print"></i><span> Imprimir</span></a>
                            </li>

                        </ul>
                    </section>


                    <div class="container-info-all-de-registro">
                        <h3 class="title-info-all">DESCRIPCION DE EQUIPO PESADO</h3>
                        <div class="table-informacion-responsive">
                            <table class="table-informacion-all">
                                <tbody>
                                    <tr class="title">
                                        <td colspan="4">
                                            <div class="title__div"><i class="zmdi zmdi-label"></i> DATOS GENERALES
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nombre comun del equipo:</td>
                                        <td>{{$equipo_pesado->nombre_comun_del_equipo}}</td>
                                        <td>Codigo de inventario interno:</td>
                                        <td>{{$equipo_pesado->codigo_de_inventario_interno}}</td>
                                    </tr>

                                    <tr class="title">
                                        <td colspan="4">
                                            <div class="title__div"><i class="zmdi zmdi-label"></i> DATOS DE ORIGEN
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Fabricante:</td>
                                        <td>{{$equipo_pesado->fabricante}}</td>
                                        <td>Año Vencimiento de garantia:</td>
                                        <td>{{$equipo_pesado->ano_vencimiento_de_garantia}}</td>
                                    </tr>

                                    <tr>
                                        <td>Año de fabricacion:</td>
                                        <td>{{$equipo_pesado->ano_de_fabricacion}}</td>
                                        <td>Pais de origen:</td>
                                        <td>{{$equipo_pesado->pais_de_origen}}</td>
                                    </tr>

                                    <tr>
                                        <td>Modelo:</td>
                                        <td>{{$equipo_pesado->modelo}}</td>
                                        <td>Numero de serie:</td>
                                        <td>{{$equipo_pesado->numero_de_serie}}</td>
                                    </tr>

                                    <tr>
                                        <td>Año de compra:</td>
                                        <td colspan="3">{{$equipo_pesado->ano_de_compra}}</td>
                                    </tr>

                                    <tr class="title">
                                        <td colspan="4">
                                            <div class="title__div">
                                                <i class="zmdi zmdi-label"></i> DATOS DE USO EN PLANTA
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Año de alta planta:</td>
                                        <td>{{$equipo_pesado->ano_de_alta_planta}}</td>
                                        <td>Estado del equipo al momento de alta:</td>
                                        <td>{{$equipo_pesado->estado_del_equipo_al_momento_de_alta}}</td>
                                    </tr>

                                    <tr>
                                        <td>Horometro al inicio operacion planta:</td>
                                        <td>{{$equipo_pesado->horometro_al_inicio_operacion_planta}}</td>
                                        <td>Linea de produccion asignada:</td>
                                        <td>{{$equipo_pesado->linea_de_produccion_asignada}}</td>
                                    </tr>

                                    <tr>
                                        <td>Ubicacion:</td>
                                        <td colspan="3">{{$equipo_pesado->ubicacion}}</td>
                                    </tr>

                                    <tr class="title">
                                        <td colspan="4">
                                            <div class="title__div"><i class="zmdi zmdi-label"></i> REGISTRO FOTOGRAFICO
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="4" style="text-align: center;">
                                            <img class="info-all-image"
                                                src="data:image/all;base64,{{base64_encode($equipo_pesado->archivo)}}"
                                                alt="imagen del usuario">

                                        </td>
                                    </tr>

                                    <tr class="title">
                                        <td colspan="4">
                                            <div class="title__div"><i class="zmdi zmdi-label"></i> DATOS TECNICOS
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Potencia und.:</td>
                                        <td>{{$equipo_pesado->potencia_und}}</td>
                                        <td>Potencia valor nominal:</td>
                                        <td>{{$equipo_pesado->potencia_valor_nominal}}</td>
                                    </tr>

                                    <tr>
                                        <td>Potencia caracteristicas:</td>
                                        <td colspan="3">{{$equipo_pesado->potencia_caracteristicas}}</td>
                                    </tr>

                                    <tr>
                                        <td>Voltaje und.:</td>
                                        <td>{{$equipo_pesado->voltaje_und}}</td>
                                        <td>Voltaje valor nominal:</td>
                                        <td>{{$equipo_pesado->voltaje_valor_nominal}}</td>
                                    </tr>
                                    <tr>
                                        <td>Voltaje caracteristicas:</td>
                                        <td colspan="3">{{$equipo_pesado->voltaje_caracteristicas}}</td>
                                    </tr>

                                    <tr>
                                        <td>Corriente und.:</td>
                                        <td>{{$equipo_pesado->corriente_und}}</td>
                                        <td>Corriente valor nominal:</td>
                                        <td>{{$equipo_pesado->corriente_valor_nominal}}</td>
                                    </tr>
                                    <tr>
                                        <td>Corriente caracteristicas:</td>
                                        <td colspan="3">{{$equipo_pesado->corriente_caracteristicas}}</td>
                                    </tr>

                                    <tr>
                                        <td>Capacidad de cucharon und.:</td>
                                        <td>{{$equipo_pesado->capacidad_de_cucharon_und}}</td>
                                        <td>Capacidad de cucharon valor nominal:</td>
                                        <td>{{$equipo_pesado->capacidad_de_cucharon_valor_nominal}}</td>
                                    </tr>
                                    <tr>
                                        <td>Capacidad de cucharon caracteristicas:</td>
                                        <td colspan="3">{{$equipo_pesado->capacidad_de_cucharon_caracteristicas}}</td>
                                    </tr>

                                    <tr>
                                        <td>Capacidad de diesel und.:</td>
                                        <td>{{$equipo_pesado->capacidad_de_diesel_und}}</td>
                                        <td>Capacidad de diesel valor nominal:</td>
                                        <td>{{$equipo_pesado->capacidad_de_diesel_valor_nominal}}</td>
                                    </tr>
                                    <tr>
                                        <td>Capacidad de diesel caracteristicas:</td>
                                        <td colspan="3">{{$equipo_pesado->capacidad_de_diesel_caracteristicas}}</td>
                                    </tr>

                                    <tr>
                                        <td>Otros und.:</td>
                                        <td>{{$equipo_pesado->otros_und}}</td>
                                        <td>Otros valor nominal:</td>
                                        <td>{{$equipo_pesado->otros_valor_nominal}}</td>
                                    </tr>
                                    <tr>
                                        <td>Otros caracteristicas:</td>
                                        <td colspan="3">{{$equipo_pesado->otros_caracteristicas}}</td>
                                    </tr>

                                    <tr class="title">
                                        <td colspan="4">
                                            <div class="title__div">
                                                <i class="zmdi zmdi-label"></i> DISPONIBILIDAD DE INFORMACION DE SOPORTE
                                                TECNICO
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Mamuales impresos:</td>
                                        <td colspan="3">{{$equipo_pesado->manuales_impresos}}</td>

                                    </tr>

                                    <tr>
                                        <td colspan="4" style="text-align: center;">
                                            Manuales digitales:
                                            <br>
                                            <br>
                                            <iframe
                                                src="data:application/pdf;base64,{{base64_encode($equipo_pesado->manuales_digitales)}}"
                                                type="application/pdf" width="90%" height="700px"></iframe>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td> Otros mamuales:</td>
                                        <td colspan="3">{{$equipo_pesado->otros_manuales}}</td>

                                    </tr>

                                    <tr>
                                        <td>Planos mecanicos digitales:</td>
                                        <td colspan="3">{{$equipo_pesado->planos_mecanicos_digitales}}</td>

                                    </tr>

                                    <tr>
                                        <td colspan="4" style="text-align: center;">
                                            Planos electricos digitales:
                                            <br>
                                            <br>
                                            <iframe
                                                src="data:application/pdf;base64,{{base64_encode($equipo_pesado->planos_electricos_digitales)}}"
                                                type="application/pdf" width="90%" height="700px"></iframe>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td> Otros planos:</td>
                                        <td colspan="3">{{$equipo_pesado->otros_planos}}</td>

                                    </tr>


                                </tbody>
                            </table>
                        </div>



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
    <script src="{{asset('assets/js/app/EquipoPesado.js')}}?v={{config('constants.VERSION_JS')}}"></script>
</body>

</html>