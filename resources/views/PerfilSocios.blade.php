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
                    Cooperativa Minera Chima R.L. | <span class="texto-full">Socios</span>
                </h2>

                <!-- menu opciones-->
                @include('components/menu_opciones/menuOptionSocios')

                <div class="title-info">Perfil del Asociado</div>
                <!-- content-->
                <!-- menu opciones por pagina-->
                <section class="container-menu-opciones-pagina">
                    <ul class="list-menu-opciones">

                        <li class="item-menu-opciones">
                            <a href="{{route('route-historial-socios',MyEncryption::encrypt($socios->id))}}">Historial
                                <i class="zmdi zmdi-file-text"></i></a>
                        </li>
                        <li class="item-menu-opciones">
                            <a href="{{route('route-frm-show-socios',MyEncryption::encrypt($socios->id))}}">Actualizar
                                <i class="zmdi zmdi-border-color"></i></a>
                        </li>
                        <li class="item-menu-opciones">

                            <a style="cursor:pointer;" id="btn-accion" data-accion="confirm-destroy"
                                data-id="{{MyEncryption::encrypt($socios->id)}}">
                                Eliminar <i class="zmdi zmdi-delete"></i></a>
                        </li>
                        <li class="item-menu-opciones">
                            <a href="{{route('route-perfil-socios',MyEncryption::encrypt($socios->id))}}">Perfil <i
                                    class="zmdi zmdi-account-box"></i></a>
                        </li>
                        <li class="item-menu-opciones">
                            <a href="{{route('route-pdf-perfil-socios',MyEncryption::encrypt($socios->id))}}">PDF
                                <i class="zmdi zmdi-download"></i> </a>
                        </li>
                        <li class="item-menu-opciones">
                            <a href="{{route('route-imprimir-perfil-socios',MyEncryption::encrypt($socios->id))}}">Imprimir
                                <i class="zmdi zmdi-print"></i></a>
                        </li>
                    </ul>
                </section>

                <div class="container-info-all-de-registro">
                    <h3 class="title-info-all">Informacion del Asociado</h3>
                    <div class="table-informacion-responsive">
                        <table class="table-informacion-all">
                            <tbody>
                                <tr>
                                    <td>N° de Item:</td>
                                    <td colspan="2">{{$socios->num_item}}</td>
                                </tr>
                                <tr>
                                    <td>Estado del Asociado</td>
                                    <td colspan="2">{{$socios->estado_del_asociado}}</td>
                                </tr>
                                <tr>
                                    <td>Nombre:</td>
                                    <td colspan="2">{{$socios->nombres}}</td>
                                </tr>
                                <tr>
                                    <td>Apellidos:</td>
                                    <td colspan="2">{{$socios->apellidos}}</td>
                                </tr>
                                <tr>
                                    <td>CI:</td>
                                    <td>{{$socios->ci}}</td>
                                    <td>Valido: {{date_format(date_create($socios->ci_valido),'d/m/Y')}}</td>
                                </tr>
                                <tr>
                                    <td>Fecha de Nacimiento:</td>
                                    <td colspan="2">{{date_format(date_create($socios->fecha_nacimiento),'d/m/Y')}}</td>
                                </tr>
                                <tr>
                                    <td>Lugar de Nacimiento:</td>
                                    <td colspan="2">{{$socios->lugar_de_nacimiento}}</td>
                                </tr>
                                <tr>
                                    <td>Estado Civil:</td>
                                    <td colspan="2">{{$socios->estado_civil}}</td>
                                </tr>
                                <tr>
                                    <td>Sexo:</td>
                                    <td colspan="2">{{$socios->sexo}}</td>
                                </tr>
                                <tr>
                                    <td>Celular de Contacto:</td>
                                    <td colspan="2">{{$socios->celular}}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align: center;">
                                        <img class="info-all-image"
                                            src="data:image/all;base64,{{base64_encode($socios->imagen)}}"
                                            alt="imagen del usuario">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3 class="title-info-all-2">Origen o procedencia de la acción</h3>

                    <div class="table-informacion-responsive">
                        <table class="table-informacion-all">
                            <tbody>
                                <tr>
                                    <td>Punta de Trabajo:</td>
                                    <td>{{$socios->punta_de_trabajo}}</td>
                                    <td>Grupo: {{$socios->grupo}}</td>
                                </tr>
                                <tr>
                                    <td>Fecha de Transferencia:</td>
                                    <td colspan="2">
                                        {{date_format(date_create($socios->fecha_de_transferencia),'d/m/Y')}}</td>
                                </tr>
                                <tr>
                                    <td>Suseción de Derecho:</td>
                                    <td colspan="2">{{$socios->susecion_de_derecho}}</td>
                                </tr>
                                <tr>
                                    <td>Transfiriente CC:</td>
                                    <td colspan="2">{{$socios->transfiriente_cc}}</td>
                                </tr>
                                <tr>
                                    <td>Parentesco:</td>
                                    <td colspan="2">{{$socios->parentesco}}</td>
                                </tr>
                                <tr>
                                    <td>Observacion:</td>
                                    <td colspan="2">
                                        {{$socios->observacion}}
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
    <script src="{{asset('assets/js/UnpkgSideBar.js')}}"></script>
    <script src="{{asset('assets/js/sidebar.js')}}"></script>
    <script src="{{asset('assets/js/app/Socios.js')}}?v={{config('constants.VERSION_JS')}}"></script>
</body>

</html>