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

                <div class="title-info">Registro de Historial de Antecedentes de Empleados de Planta</div>
                <!-- content-->
                <!-- menu opciones por pagina-->
                <section class="container-menu-opciones-pagina">
                    <ul class="list-menu-opciones">
                        <li class="item-menu-opciones">
                            <a
                                href="{{route('route-historial-personal-planta',Crypt::encrypt($personal_ep->id))}}">Historial
                                <i class="zmdi zmdi-file-text"></i></a>
                        </li>
                    </ul>
                </section>

                <div class="container-info-all-de-registro">
                    <h3 class="title-info-all">Informacion del Empleado de Planta</h3>
                    <div class="table-informacion-responsive">
                        <table class="table-informacion-all">
                            <tbody>
                                <tr>
                                    <td>Nombres:</td>
                                    <td>{{$personal_ep->nombres}}</td>
                                </tr>
                                <tr>
                                    <td>Apellidos:</td>
                                    <td>{{$personal_ep->apellidos}}</td>
                                </tr>
                                <tr>
                                    <td>Carnet de Identidad:</td>
                                    <td>{{$personal_ep->ci}}</td>
                                </tr>
                                <tr>
                                    <td>Lugar de trabajo:</td>
                                    <td>{{$personal_ep->lugar_de_trabajo}}</td>
                                </tr>
                                <tr>
                                    <td>Cargo a desarrollar:</td>
                                    <td>{{$personal_ep->cargo_a_desarrollar}}</td>
                                </tr>
                                <tr>
                                    <td>N° de Empleado:</td>
                                    <td>{{$personal_ep->num_empleado}}</td>
                                </tr>
                                <tr>
                                    <td>Fecha de Ingreso:</td>
                                    <td>{{date_format(date_create($personal_ep->fecha_de_ingreso),'d/m/Y')}}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- formulario-->
                <div class="container-form">
                    <h3 class="title-form-control">Informacion del Historial de Antecedentes</h3>
                    <p>Los campos marcados con (*) son obligatorios</p>

                    <form class="mi-form-control" id="mi-form" enctype="multipart/form-data">
                        @if($historial_personal_ep->id==0)
                        <input type="hidden" value="{{Crypt::encrypt($personal_ep->id)}}" name="id-personal-ep">
                        @endif

                        @if($historial_personal_ep->id!=0)
                        <input type="hidden" name="id-reg"
                            value="{{Crypt::encrypt($historial_personal_ep->id)}}">
                        @endif

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Registro N°<span class="asterisco-label">*</span></label>
                                @if($historial_personal_ep->id==0)
                                <input type="number" name="numero-de-registro" disabled
                                    value="{{str_pad($num_registro,5,'0',STR_PAD_LEFT)}}">
                                @else
                                <input type="number" name="numero-de-registro" disabled
                                    value="{{$historial_personal_ep->num_reg}}">
                                @endif
                            </div>
                            <div class="campo-form-control-2">
                                <label for="">Fecha<span class="asterisco-label">*</span></label>
                                <input type="date" name="fecha" value="{{$historial_personal_ep->fecha}}">
                                <p class="advertencia-error" id="error-fecha"></p>
                            </div>
                        </div>

                        <div class="campo-form-control-area">
                            <label for="">Descripción<span class="asterisco-label">*</span></label>
                            <textarea name="descripcion">{{$historial_personal_ep->descripcion}}</textarea>
                            <p class="advertencia-error" id="error-descripcion"></p>
                        </div>

                        <div class="campo-form-control">
                            <label for="">Estado<span class="asterisco-label">*</span></label>
                            <select name="estado" id="">
                                @php
                                $opciones=array(
                                'Permiso',//0
                                'Vacación',
                                'Faltas',
                                'Atrasos',
                                'No corresponde',
                                'Ninguno',
                                'Otros',
                                'Sin especificar',
                                'Sin estado',//8
                                );
                                @endphp
                                <option value="">--Seleccionar--</option>
                                <option value="{{$opciones[0]}}" @if($historial_personal_ep->estado==$opciones[0])
                                    selected @endif >{{$opciones[0]}}</option>

                                <option value="{{$opciones[1]}}" @if($historial_personal_ep->estado==$opciones[1])
                                    selected @endif >{{$opciones[1]}}</option>

                                <option value="{{$opciones[2]}}" @if($historial_personal_ep->estado==$opciones[2])
                                    selected @endif >{{$opciones[2]}}</option>

                                <option value="{{$opciones[3]}}" @if($historial_personal_ep->estado==$opciones[3])
                                    selected @endif >{{$opciones[3]}}</option>

                                <option value="{{$opciones[4]}}" @if($historial_personal_ep->estado==$opciones[4])
                                    selected @endif >{{$opciones[4]}}</option>

                                <option value="{{$opciones[5]}}" @if($historial_personal_ep->estado==$opciones[5])
                                    selected @endif >{{$opciones[5]}}</option>

                                <option value="{{$opciones[6]}}" @if($historial_personal_ep->estado==$opciones[6])
                                    selected @endif >{{$opciones[6]}}</option>

                                <option value="{{$opciones[7]}}" @if($historial_personal_ep->estado==$opciones[7])
                                    selected @endif >{{$opciones[7]}}</option>

                                <option value="{{$opciones[8]}}" @if($historial_personal_ep->estado==$opciones[8])
                                    selected @endif >{{$opciones[8]}}</option>

                            </select>
                            <p class="advertencia-error" id="error-estado"></p>
                        </div>
                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Mes<span class="asterisco-label">*</span></label>
                                <input type="text" name="mes" value="{{$historial_personal_ep->mes}}">
                                <p class="advertencia-error" id="error-mes"></p>
                            </div>
                            <div class="campo-form-control-2">
                                <label for="">Dias<span class="asteriso-label">*</span></label>
                                <input type="text" name="dias" value="{{$historial_personal_ep->dias}}">
                                <p class="advertencia-error" id="error-dias"></p>
                            </div>
                        </div>

                        <div class="campo-form-control">
                            <label>Archivo<span class="asterisco-label">*</span></label>
                            <input type="file" name="archivo" id="seleccionar-archivo">
                            <label for="seleccionar-archivo" class="file-btn">Seleccionar <i
                                    class="zmdi zmdi-attachment-alt"></i></label>
                            <p class="advertencia-error" id="error-archivo"></p>
                        </div>

                        <div class="image-pre-view">
                            @if($historial_personal_ep->archivo==null)
                            <img src="{{asset('assets/images/image-preview.png')}}" alt="Archivo subido"
                                id="vista-previa">
                            @else
                            <img src="data:image/all;base64,{{base64_encode($historial_personal_ep->archivo)}}"
                                alt="Archivo subido" id="vista-previa">
                            @endif
                        </div>

                        <div class="container-enviar">
                            <button type="button" class="enviar-reg" id="btn-accion" data-action="{{$action}}"><i
                                    class="zmdi zmdi-dialpad"></i> Enviar</button>
                        </div>
                    </form>

                </div>

            </main>
            <!-- Contenido-->
            <div class="overlay">
            </div>
        </div>
    </div>

    <script src="{{asset('assets/js/app/HistorialPersonalEP.js')}}?v={{config('constants.VERSION_JS')}}"></script>
    <script src="{{asset('assets/js/ImagePreview.js')}}?v={{config('constants.VERSION_JS')}}"></script>

    <script src="{{asset('assets/js/UnpkgSideBar.js')}}"></script>
    <script src="{{asset('assets/js/sidebar.js')}}"></script>
    <script src="{{asset('assets/js/CerrarSesion.js')}}?v={{config('constants.VERSION_JS')}}"></script>
</body>


</html>