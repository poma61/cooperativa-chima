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
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}?v={{config('constants.VERSION_CSS')}}"
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
                <h2 class="texto-full-title">
                    Cooperativa Minera Chima R.L. | <span class="texto-full">Personal</span>
                </h2>

                <!-- menu opciones-->
                @include('components/menu_opciones/menuOptionPersonal')

                <div class="title-info">Historial de Antecedentes del Empleado de Planta</div>
                <!-- content-->
                <!-- menu opciones por pagina-->
                <section class="container-menu-opciones-pagina">
                    <ul class="list-menu-opciones">

                        <li class="item-menu-opciones">
                            <a
                                href="{{route('route-historial-personal-planta',MyEncryption::encrypt($historial_personal_ep_personal_ep->id_personal_ep))}}">
                                Historial <i class="zmdi zmdi-file-text"></i></a>
                        </li>
                        <li class="item-menu-opciones">
                            <a
                                href="{{route('route-ver-historial-personal-planta',MyEncryption::encrypt($historial_personal_ep_personal_ep->id_historial_personal_ep))}}">
                                Ver Historial <i class="zmdi zmdi-file-text"></i></a>
                        </li>

                        <li class="item-menu-opciones">
                            <a
                                href="{{route('route-frm-show-historial-personal-planta',MyEncryption::encrypt($historial_personal_ep_personal_ep->id_historial_personal_ep))}}">
                                Actualizar <i class="zmdi zmdi-border-color"></i></a>
                        </li>
                        <li class="item-menu-opciones">
                            <a style="cursor:pointer" id="btn-accion"
                                data-id_personal_ep="{{MyEncryption::encrypt($historial_personal_ep_personal_ep->id_personal_ep)}}"
                                data-action="confirm-destroy"
                                data-id="{{MyEncryption::encrypt($historial_personal_ep_personal_ep->id_historial_personal_ep)}}">Eliminar
                                <i class="zmdi zmdi-delete"></i></a>
                        </li>
                        <li class="item-menu-opciones">
                            <a
                                href="{{route('route-pdf-ver-historial-personal-planta',MyEncryption::encrypt($historial_personal_ep_personal_ep->id_historial_personal_ep))}}">PDF
                                <i class="zmdi zmdi-download"></i></a>
                        </li>
                        <li class="item-menu-opciones">
                            <a
                                href="{{route('route-imprimir-ver-historial-personal-planta',MyEncryption::encrypt($historial_personal_ep_personal_ep->id_historial_personal_ep))}}">Imprimir
                                <i class="zmdi zmdi-print"></i></a>
                        </li>
                    </ul>
                </section>

                <div class="container-info-all-de-registro">
                    <h3 class="title-info-all">Informacion del Historial de Antecedente</h3>

                    <div class="table-informacion-responsive">
                        <h4>Informacion del Empleado</h4>
                        <table class="table-informacion-all">
                            <tbody>
                                <tr>
                                    <td>Nombres:</td>
                                    <td>{{$historial_personal_ep_personal_ep->nombres}}</td>
                                </tr>
                                <tr>
                                    <td>Apellidos:</td>
                                    <td>{{$historial_personal_ep_personal_ep->apellidos}}</td>
                                </tr>
                                <tr>
                                    <td>Carnet de Identidad:</td>
                                    <td>{{$historial_personal_ep_personal_ep->ci}}</td>
                                </tr>
                                <tr>
                                    <td>Lugar de Trabajo:</td>
                                    <td>{{$historial_personal_ep_personal_ep->lugar_de_trabajo}}</td>
                                </tr>
                                <tr>
                                    <td>Cargo a desarrollar</td>
                                    <td>{{$historial_personal_ep_personal_ep->cargo_a_desarrollar}}</td>
                                </tr>
                                <tr>
                                    <td>N° de Empleado</td>
                                    <td>{{$historial_personal_ep_personal_ep->num_empleado}}</td>
                                </tr>
                                <tr>
                                    <td>Fecha de Ingreso</td>
                                    <td>{{date_format(date_create($historial_personal_ep_personal_ep->fecha_de_ingreso),'d/m/Y')}}
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="table-informacion-responsive">
                        <h4>Contenido</h4>
                        <table class="table-informacion-all">
                            <tbody>
                                <tr>
                                    <td>Registro N°:</td>
                                    <td>{{$historial_personal_ep_personal_ep->num_reg}}</td>
                                </tr>
                                <tr>
                                    <td>Fecha:</td>
                                    <td>{{date_format(date_create($historial_personal_ep_personal_ep->fecha),'d/m/Y')}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Descripcion:</td>
                                    <td>
                                        {{$historial_personal_ep_personal_ep->descripcion}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Estado:</td>
                                    <td>{{$historial_personal_ep_personal_ep->estado}}</td>
                                </tr>
                                <tr>
                                    <td>Mes:</td>
                                    <td>{{$historial_personal_ep_personal_ep->mes}}</td>
                                </tr>
                                <tr>
                                    <td>Dias:</td>
                                    <td>{{$historial_personal_ep_personal_ep->dias}}</td>
                                </tr>

                                <tr>
                                    <td colspan="2" style="text-align: center;">
                                        @if($historial_personal_ep_personal_ep->mime_type=='application/pdf')
                                        <iframe
                                            src="data:application/pdf;base64,{{base64_encode($historial_personal_ep_personal_ep->archivo)}}"
                                            frameborder="0" width="100%" height="800px"></iframe>
                                        @else

                                        <img class="info-all-image"
                                            src="data:image/all;base64,{{base64_encode($historial_personal_ep_personal_ep->archivo)}}"
                                            alt="imagen">
                                    </td>
                                    @endif
                                    </td>
                                </tr>

                            </tbody>

                        </table>
                    </div>
                </div>

            </main>
            <!-- Contenido-->
            <div class="overlay">
            </div>
        </div>
    </div>

    <script src="{{asset('assets/js/app/HistorialPersonalEP.js')}}?v={{config('constants.VERSION_JS')}}"></script>

    <script src="{{asset('assets/js/UnpkgSideBar.js')}}"></script>
    <script src="{{asset('assets/js/sidebar.js')}}"></script>
    <script src="{{asset('assets/js/CerrarSesion.js')}}?v={{config('constants.VERSION_JS')}}"></script>
</body>

</html>