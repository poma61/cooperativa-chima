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
                                    href="{{route('route-mantenimiento-equipo-pesado',Crypt::encrypt($mantenimiento_equipo_pesado_equipo_pesado->id_equipo_pesado))}}">
                                    <i class="zmdi zmdi-wrench"></i><span> Mantenimiento</span> </a>
                            </li>

                            <li class="item-menu-opciones">
                                <a class="color-100"
                                    href="{{route('route-frm-new-mantenimiento-equipo-pesado',Crypt::encrypt($mantenimiento_equipo_pesado_equipo_pesado->id_equipo_pesado))}}">
                                    <i class="zmdi zmdi-plus"></i> <span>Nuevo Mantenimiento</span></a>
                            </li>

                            <!-- Acciones de registro -->
                            <li class="item-menu-opciones">
                                <a class="color-100"
                                    href="{{route('route-frm-show-mantenimiento-equipo-pesado',Crypt::encrypt($mantenimiento_equipo_pesado_equipo_pesado->id))}}">
                                    <i class="zmdi zmdi-border-color"></i><span> Actualizar</span> </a>
                            </li>

                            <li class="item-menu-opciones">
                                <a class="color-100" style="cursor:pointer;" id="btn-accion"
                                    data-action="confirm-destroy"
                                    data-id_reg="{{Crypt::encrypt($mantenimiento_equipo_pesado_equipo_pesado->id)}}"
                                    data-id_equipo_pesado="{{Crypt::encrypt($mantenimiento_equipo_pesado_equipo_pesado->id_equipo_pesado)}}">
                                    <i class="zmdi zmdi-delete"></i><span> Eliminar</span>
                                </a>
                            </li>

                        </ul>
                    </section>

                    <div class="container-info-all-de-registro">
                        <h3 class="title-info-all">REGISTRO | MANTENIMIENTO - REPARACION</h3>
                        <div class="table-informacion-responsive">
                            <table class="table-informacion-all">
                                <tbody>

                                    <tr class="title">
                                        <td colspan="4">
                                            <div class="title__div"><i class="zmdi zmdi-label"></i> DATOS GENERALES -
                                                EQUIPO PESADO
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Nombre comun del equipo:</td>
                                        <td>{{$mantenimiento_equipo_pesado_equipo_pesado->nombre_comun_del_equipo}}</td>
                                        <td>Año de compra:</td>
                                        <td>{{$mantenimiento_equipo_pesado_equipo_pesado->ano_de_compra}}</td>
                                    </tr>

                                    <tr>
                                        <td>Fabricante:</td>
                                        <td>{{$mantenimiento_equipo_pesado_equipo_pesado->fabricante}}</td>
                                        <td>Estado del equipo al momento de alta:</td>
                                        <td>{{$mantenimiento_equipo_pesado_equipo_pesado->estado_del_equipo_al_momento_de_alta}}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Año de fabricacion:</td>
                                        <td>{{$mantenimiento_equipo_pesado_equipo_pesado->ano_de_fabricacion}}</td>
                                        <td>Año de alta en planta:</td>
                                        <td>{{$mantenimiento_equipo_pesado_equipo_pesado->ano_de_alta_planta}}</td>
                                    </tr>

                                    <tr>
                                        <td>N° serie:</td>
                                        <td>{{$mantenimiento_equipo_pesado_equipo_pesado->numero_de_serie}}</td>
                                    </tr>

                                    <tr class="title">
                                        <td colspan="4">
                                            <div class="title__div"><i class="zmdi zmdi-label"></i> MANTENIMIENTO -
                                                REPARACION</div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>N° de registro</td>
                                        <td>{{$mantenimiento_equipo_pesado_equipo_pesado->num_reg}}

                                    </tr>

                                    <tr>
                                        <td>Fecha de Ingreso</td>
                                        <td>{{date_format(date_create($mantenimiento_equipo_pesado_equipo_pesado->fecha_de_ingreso),date('d/m/Y'))}}
                                        </td>
                                        <td>Caracteristicas</td>
                                        <td>{{$mantenimiento_equipo_pesado_equipo_pesado->caracteristicas}}</td>
                                    </tr>

                                    <tr>
                                        <td>Desarrollo</td>
                                        <td>{{$mantenimiento_equipo_pesado_equipo_pesado->desarrollo}}</td>
                                        <td>Material ocupado</td>
                                        <td>{{$mantenimiento_equipo_pesado_equipo_pesado->material_ocupado}}</td>
                                    </tr>

                                    <tr>
                                        <td>Mantenimiento preventivo</td>
                                        <td>{{$mantenimiento_equipo_pesado_equipo_pesado->mantenimiento_preventivo}}
                                        </td>
                                        <td>Mantenimiento Correctivo</td>
                                        <td>{{$mantenimiento_equipo_pesado_equipo_pesado->mantenimiento_correctivo}}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Fecha de salida</td>
                                        <td>{{$mantenimiento_equipo_pesado_equipo_pesado->fecha_de_salida}}</td>
                                        <td>Observacion</td>
                                        <td>{{$mantenimiento_equipo_pesado_equipo_pesado->observacion}}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </main>
            <!-- Contenido-->
            <div class="overlay"> </div>
        </div>
    </div>

    <script src="{{asset('assets/js/app/MantenimientoEquipoPesado.js')}}?v={{config('constants.VERSION_JS')}}"></script>
    <script src="{{asset('assets/js/UnpkgSideBar.js')}}"></script>
    <script src="{{asset('assets/js/sidebar.js')}}"></script>
    <script src="{{asset('assets/js/CerrarSesion.js')}}?v={{config('constants.VERSION_JS')}}"></script>


</body>

</html>