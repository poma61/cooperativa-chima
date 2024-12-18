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

        <!-- overlay-->
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

                <div class="title-info">Registro de Historial de Antecedentes | Asociados</div>
                <!-- content-->
                <!-- menu opciones por pagina-->
                <section class="container-menu-opciones-pagina">
                    <ul class="list-menu-opciones">
                        <li class="item-menu-opciones">
                            <a href="{{route('route-historial-socios',Crypt::encrypt($socios->id))}}">Historial
                                <i class="zmdi zmdi-file-text"></i></a>
                        </li>
                    </ul>
                </section>

                <div class="container-info-all-de-registro">
                    <h3 class="title-info-all">Informacion del Socio</h3>
                    <div class="table-informacion-responsive">
                        <table class="table-informacion-all">
                            <tbody>
                                <tr>
                                    <td>Nombres:</td>
                                    <td>{{$socios->nombres}}</td>
                                </tr>
                                <tr>
                                    <td>Apellidos:</td>
                                    <td>{{$socios->apellidos}}</td>
                                </tr>
                                <tr>
                                    <td>Carnet de Identidad:</td>
                                    <td>{{$socios->ci}}</td>
                                </tr>
                                <tr>
                                    <td>Punta de Trabajo:</td>
                                    <td>{{$socios->punta_de_trabajo}}</td>
                                </tr>
                                <tr>
                                    <td>Años en la COOP. </td>
                                    <td>- - - -</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- formulario-->
                <h3 class="title-form-control">Informacion del Historial de Antecedentes</h3>
                <div class="container-form">
                    <p>Los campos marcados con (*) son obligatorios</p>

                    <form class="mi-form-control" id="mi-form">
                        <input type="hidden" name="id_socio" value="{{Crypt::encrypt($socios->id)}}">
                        @if($historial_socios->id!=0)
                        <input type="hidden" name="id-reg" value="{{Crypt::encrypt($historial_socios->id)}}">
                        @endif
                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Registro N°<span class="asterisco-label">*</span></label>
                                @if($historial_socios->id==0)
                                <input type="number" disabled value="{{str_pad($num_registro,5,'0',STR_PAD_LEFT)}}"
                                    name="num-reg__">
                                @else
                                <input type="number" disabled value="{{$historial_socios->num_reg}}" name="num-reg__">
                                @endif
                            </div>
                            <div class="campo-form-control-2">
                                <label for="">Fecha<span class="asterisco-label">*</span></label>
                                <input type="date" name="fecha" value="{{$historial_socios->fecha}}">
                                <p class="advertencia-error" id="error-fecha"></p>
                            </div>
                        </div>
                        <div class="campo-form-control-area">
                            <label for="">Descripción<span class="asterisco-label">*</span></label>
                            <textarea name="descripcion">{{$historial_socios->descripcion}}</textarea>
                            <p class="advertencia-error" id="error-descripcion"></p>
                        </div>

                        <div class="campo-form-control">
                            <label for="">Tipo de documento<span class="asterisco-label">*</span></label>
                            <select name="tipo_de_documento" id="">
                                <option value="">--Seleccionar--</option>
                                <option value="Falla" @if($historial_socios->tipo_de_documento=='Falla') selected @endif
                                    >Falla</option>
                                <option value="Atrasos" @if($historial_socios->tipo_de_documento=='Atrasos') selected
                                    @endif >Atrasos</option>
                                <option value="Memorandums" @if($historial_socios->tipo_de_documento=='Memorandums')
                                    selected @endif >Memorandums</option>
                                <option value="Informe" @if($historial_socios->tipo_de_documento=='Informe') selected
                                    @endif >Informe</option>
                                <option value="Actas" @if($historial_socios->tipo_de_documento=='Actas') selected @endif
                                    >Actas</option>
                                <option value="Otros" @if($historial_socios->tipo_de_documento=='Otros') selected @endif
                                    >Otros</option>
                                <option value="Ninguno" @if($historial_socios->tipo_de_documento=='Ninguno') selected
                                    @endif >Ninguno</option>
                            </select>
                            <p class="advertencia-error" id="error-tipo_de_documento"></p>
                        </div>

                        <div class="campo-form-control">
                            <label>Archivo<span class="asterisco-label">*</span></label>
                            <input type="file" name="archivo" id="seleccionar-archivo">
                            <label for="seleccionar-archivo" class="file-btn">Seleccionar <i
                                    class="zmdi zmdi-attachment-alt"></i></label>
                            <p class="advertencia-error" id="error-archivo"></p>
                        </div>

                        <div class="image-pre-view">
                            @if($historial_socios->archivo==null)
                            <img src="{{asset('assets/images/image-preview.png')}}" alt="ARCHIVO SUBIDO"
                                id="vista-previa">
                            @else
                            <img src="data:image/all;base64,{{base64_encode($historial_socios->archivo)}}"
                                alt="archivo historial" id="vista-previa">
                            @endif
                        </div>

                        <div class="container-enviar">
                            <button type="button" class="enviar-reg" id="btn-accion" data-accion="{{$action}}"><i
                                    class="zmdi zmdi-dialpad"></i> Enviar</button>
                        </div>
                    </form>

                </div>

            </main>
            <!-- Contenido-->
            <!-- overlay-->
            <div class="overlay">
            </div>
        </div>
    </div>

    <script src="{{asset('assets/js/UnpkgSideBar.js')}}"></script>
    <script src="{{asset('assets/js/sidebar.js')}}"></script>
    <script src="{{asset('assets/js/app/HistorialSocios.js')}}?v={{config('constants.VERSION_JS')}}"></script>
    <script src="{{asset('assets/js/ImagePreview.js')}}?v={{config('constants.VERSION_JS')}}"></script>

    <script src="{{asset('assets/js/CerrarSesion.js')}}?v={{config('constants.VERSION_JS')}}"></script>
</body>


</html>