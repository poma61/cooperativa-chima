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
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}?v={{config('constants.VERSION_CSS')}}" type="text/css"
        media="all">

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
                    Cooperativa Minera Chima R.L. | <span class="texto-full">Registro de
                        Correspondencias</span>
                </h2>

                <div class="title-info">Informacion | Registro de Correspondencias Recibidas</div>
                <div class="main-container">
                    <section class="container-menu-opciones-vertical">
                        <ul class="list-menu-opciones">
                            @include('components/menu_opciones/MenuOptionRegistroCorrespondencias')

                            <li class="item-menu-opciones">
                                <a class="color-100"
                                    href="{{route('route-frm-show-registro-correspondencias-re',MyEncryption::encrypt($registro_correspondencias_re->id))}}">
                                    <i class="zmdi zmdi-border-color"></i><span> Actualizar</span> </a>
                            </li>
                            <li class="item-menu-opciones">
                                <a class="color-100" style="cursor:pointer;" id="btn-accion"
                                    data-action="confirm-destroy"
                                    data-id_reg="{{MyEncryption::encrypt($registro_correspondencias_re->id)}}">
                                    <i class="zmdi zmdi-delete"></i><span> Eliminar</span></a>
                            </li>
                            <li class="item-menu-opciones">
                                <a class="color-100"
                                    href="{{route('route-ver-registro-correspondencias-re',MyEncryption::encrypt($registro_correspondencias_re->id))}}">
                                    <i class="zmdi zmdi-file-text"></i><span> Ver Registro</span></a>
                            </li>
                            <li class="item-menu-opciones">
                                <a class="color-100"
                                    href="{{route('route-pdf-ver-registro-correspondencias-re',MyEncryption::encrypt($registro_correspondencias_re->id))}}">
                                    <i class="zmdi zmdi-download"></i><span> PDF</span> </a>
                            </li>
                            <li class="item-menu-opciones">
                                <a class="color-100"
                                    href="{{route('route-imprimir-ver-registro-correspondencias-re',MyEncryption::encrypt($registro_correspondencias_re->id))}}">
                                    <i class="zmdi zmdi-print"></i><span> Imprimir</span></a>
                            </li>

                        </ul>
                    </section>


                    <div class="container-info-all-de-registro">
                        <h3 class="title-info-all">Registro de Correspondencia Recibida</h3>
                        <div class="table-informacion-responsive">
                            <table class="table-informacion-all">
                                <tbody>
                                    <tr>
                                        <td>N° de Registro:</td>
                                        <td>{{$registro_correspondencias_re->num_reg}}</td>
                                    </tr>
                                    <tr>
                                        <td>Fecha:</td>
                                        <td>{{date_format(date_create($registro_correspondencias_re->fecha),'d/m/Y')}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pestaña Carpeta:</td>
                                        <td>{{$registro_correspondencias_re->pestana_carpeta}}</td>
                                    </tr>
                                    <tr>
                                        <td>Referencia:</td>
                                        <td>{{$registro_correspondencias_re->referencia}}</td>
                                    </tr>
                                    <tr>
                                        <td>Entregado Por:</td>
                                        <td>{{$registro_correspondencias_re->entregado_por}}</td>
                                    </tr>
                                    <tr>
                                        <td>Recibido Por:</td>
                                        <td>
                                            {{$registro_correspondencias_re->recibido_por}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cuenta:</td>
                                        <td>{{$registro_correspondencias_re->cuenta}}</td>
                                    </tr>
                                    <tr>
                                        <td>Descripción/Observacion:</td>
                                        <td>{{$registro_correspondencias_re->descripcion_observacion}}</td>
                                    </tr>
                                    <tr>
                                        <td>Fecha de Respuesta:</td>
                                        <td>{{date_format(date_create($registro_correspondencias_re->fecha_de_respuesta),'d/m/Y')}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Descripción:</td>
                                        <td>{{$registro_correspondencias_re->descripcion}}</td>
                                    </tr>

                                    <tr>

                                        <td colspan="2" style="text-align: center;">
                                            @if($registro_correspondencias_re->mime_type=='application/pdf')

                                            <iframe
                                                src="data:application/pdf;base64,{{base64_encode($registro_correspondencias_re->archivo)}}"
                                                frameborder="0" width="100%" height="800px"></iframe>
                                            @else
                                            <img class="info-all-image"
                                                src="data:image/all;base64,{{base64_encode($registro_correspondencias_re->archivo)}}"
                                                alt="imagen del usuario">
                                            @endif
                                        </td>
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
    <script src="{{asset('assets/js/app/RegistroCorrespondenciasRe.js')}}?v={{config('constants.VERSION_JS')}}">
    </script>
</body>

</html>