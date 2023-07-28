<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{asset('assets/css/normalize.css')}}" type="text/css" media="all">
    <link rel="stylesheet" href="{{asset('assets/css/pro-sideBar.css')}}?v={{config('constants.VERSION_CSS')}} "
        type="text/css" media="all">
    <link rel="stylesheet" href="{{asset('assets/iconos/css/material-design-iconic-font.min.css')}}" type="text/css"
        media="all">
    <link rel="stylesheet" href="{{asset('assets/css/sideBar.css')}}?v={{config('constants.VERSION_CSS')}} "
        type="text/css" media="all">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}?v={{config('constants.VERSION_CSS')}} ">
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
                <div class="title-info">Perfil | Empleado de Mita</div>

                <!-- content-->
                <!-- menu opciones por pagina-->
                <section class="container-menu-opciones-pagina">
                    <ul class="list-menu-opciones">
                        <li class="item-menu-opciones">
                            <a
                                href="{{route('route-historial-personal-mita',MyEncryption::encrypt($personal_em->id))}}">Historial
                                <i class="zmdi zmdi-file-text"></i></a>
                        </li>
                        <li class="item-menu-opciones">
                            <a href="{{route('route-perfil-personal-mita',MyEncryption::encrypt($personal_em->id))}}"
                                class="perfil-reg">Perfil <i class="zmdi zmdi-account-box"></i></a>
                        </li>

                        <li class="item-menu-opciones">
                            <a href="{{route('route-frm-show-personal-mita',MyEncryption::encrypt($personal_em->id))}}">Actualizar
                                <i class="zmdi zmdi-border-color"></i></a>
                        </li>
                        <li class="item-menu-opciones">
                            <a style="cursor:pointer;" id="btn-accion" data-accion="confirm-destroy"
                                data-id_reg="{{MyEncryption::encrypt($personal_em->id)}}">Eliminar <i
                                    class="zmdi zmdi-delete"></i></a>
                        </li>

                        <li class="item-menu-opciones">
                            <a
                                href="{{route('route-pdf-perfil-personal-mita',MyEncryption::encrypt($personal_em->id))}}">PDF
                                <i class="zmdi zmdi-download"></i></i></a>
                        </li>
                        <li class="item-menu-opciones">
                            <a
                                href="{{route('route-imprimir-perfil-personal-mita',MyEncryption::encrypt($personal_em->id))}}">Imprimir
                                <i class="zmdi zmdi-print"></i></i></a>
                        </li>
                    </ul>
                </section>

                <div class="container-info-all-de-registro">
                    <h3 class="title-info-all">Informacion del Empleado de Mita</h3>
                    <div class="table-informacion-responsive">
                        <table class="table-informacion-all">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="text-align: center;">
                                        <img class="info-all-image"
                                            src="data:image/all;base64,{{base64_encode($personal_em->imagen)}}"
                                            alt="imagen del usuario">
                                    </td>
                                </tr>

                                <tr>
                                    <td>N° de Empleado:</td>
                                    <td colspan="2">{{$personal_em->num_empleado}}</td>
                                </tr>
                                <tr>
                                    <td>Estado del Empleado:</td>
                                    <td colspan="2">{{$personal_em->estado_del_empleado}}</td>
                                </tr>
                                <tr>
                                    <td>Nombres:</td>
                                    <td colspan="2">{{$personal_em->nombres}}</td>
                                </tr>
                                <tr>
                                    <td>Apellidos:</td>
                                    <td colspan="2">{{$personal_em->apellidos}}</td>
                                </tr>
                                <tr>
                                    <td>CI:</td>
                                    <td>{{$personal_em->ci}}</td>
                                    <td>Valido:{{date_format(date_create($personal_em->ci_valido),'d/m/Y')}}</td>
                                </tr>
                                <tr>
                                    <td>Fecha de Nacimiento:</td>
                                    <td colspan="2">
                                        {{date_format(date_create($personal_em->fecha_de_nacimiento),'d/m/Y')}}</td>
                                </tr>
                                <tr>
                                    <td>Lugar de Nacimiento:</td>
                                    <td colspan="2">{{$personal_em->lugar_de_nacimiento}}</td>
                                </tr>
                                <tr>
                                    <td>Profesiónn / Ocupacion:</td>
                                    <td colspan="2">{{$personal_em->profesion_ocupacion}}</td>
                                </tr>
                                <tr>
                                    <td>Estado Civil:</td>
                                    <td colspan="2">{{$personal_em->estado_civil}}</td>
                                </tr>
                                <tr>
                                    <td>Sexo:</td>
                                    <td colspan="2">{{$personal_em->sexo}}</td>
                                </tr>
                                <tr>
                                    <td>Licencia de Conducir:</td>
                                    <td>{{$personal_em->licencia_de_conducir}}</td>
                                    <td>Valido:
                                        {{date_format(date_create($personal_em->licencia_de_conducir_valido),'d/m/Y')}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Celular de Contacto:</td>
                                    <td colspan="2">{{$personal_em->celular}}</td>
                                </tr>
                                <tr>
                                    <td>Lugar de Trabajo:</td>
                                    <td colspan="2">{{$personal_em->lugar_de_trabajo}}</td>
                                </tr>
                                <tr>
                                    <td>Fecha de Ingreso:</td>
                                    <td colspan="2">{{date_format(date_create($personal_em->fecha_de_ingreso),'d/m/Y')}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Cargo a Desarrollar:</td>
                                    <td colspan="2">{{$personal_em->cargo_a_desarrollar}}</td>
                                </tr>

                                <tr>
                                    <td>Sueldo Asignado</td>
                                    <td colspan="2">
                                        {{number_format($personal_em->haber_basico,2).' '.$personal_em->divisa}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Ultima Vacación:</td>
                                    <td colspan="2">{{$personal_em->ultima_vacacion}}</td>
                                </tr>
                                <tr>
                                    <td>Fecha de Retiro:</td>
                                    @if($personal_em->fecha_de_retiro==null)
                                    <td colspan="2">Sin fecha de retiro</td>
                                    @else
                                    <td colspan="2">{{date_format(date_create($personal_em->fecha_de_retiro),'d/m/Y')}}
                                    </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Estado de Retiro:</td>
                                    <td colspan="2">{{$personal_em->estado_de_retiro}}</td>
                                </tr>
                                <tr>
                                    <td>Observación:</td>
                                    <td colspan="2">{{$personal_em->observacion}}</td>
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
    <script src="{{asset('assets/js/app/PersonalEM.js')}}?v={{config('constants.VERSION_JS')}}"></script>
    <script src="{{asset('assets/js/UnpkgSideBar.js')}}"></script>
    <script src="{{asset('assets/js/sidebar.js')}}"></script>
    <script src="{{asset('assets/js/CerrarSesion.js')}}?v={{config('constants.VERSION_JS')}}"></script>
</body>


</html>