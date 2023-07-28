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
    <link rel="stylesheet" href="{{asset('assets/css/sideBar.css')}}?v={{config('constants.VERSION_CSS')}}"
        type="text/css" media="all">
    <link rel="stylesheet" href="{{asset('assets/css/style400.css')}}?v={{config('constants.VERSION_CSS')}}"
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

                <div class="title-info">Registrar Libro de Alzas</div>

                <div class="container-menu-opciones-all">
                    <!-- menu opciones-->
                    <x-menu_opciones.MenuOpRegistroAcLibroDeAlzas />
                </div>


                <!-- formulario-->
                <div class="container-form">
                    <h3 class="title-form-control">Libro de Alzas</h3>
                    <p>Los campos marcados con (*) son obligatorios</p>

                    <form class="mi-form-control" id="mi-form" enctype="multipart/form-data">
                        <p class="form-aviso-campos"><i class="zmdi zmdi-label"></i> INFORMACIÓN</p>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Registro N°<span class="asterisco-label">*</span></label>
                                @if($registro_ac_libro_de_alzas->id==0)
                                <input type="number" name="numero-de-registro" disabled
                                    value="{{str_pad($num_registro,5,'0',STR_PAD_LEFT)}}">
                                @else
                                <input type="number" name="numero-de-registro" disabled
                                    value="{{$registro_ac_libro_de_alzas->num_reg}}">
                                <input type="hidden" name="id-reg"
                                    value="{{MyEncryption::encrypt($registro_ac_libro_de_alzas->id)}}">
                                @endif
                            </div>
                            <div class="campo-form-control-2">
                                <label for="">Fecha Emitida<span class="asterisco-label">*</span></label>
                                <input type="date" name="fecha_emitida"
                                    value="{{$registro_ac_libro_de_alzas->fecha_emitida}}">
                                <p class="advertencia-error" id="error-fecha_emitida"></p>
                            </div>
                        </div>

                        <div class="campo-form-control">
                            <label for="">Referencia<span class="asterisco-label">*</span></label>
                            <input type="text" name="referencia" value="{{$registro_ac_libro_de_alzas->referencia}}"
                                maxlength="580">
                            <p class="advertencia-error" id="error-referencia"></p>
                        </div>

                        <div class="campo-form-control-area">
                            <label for="">Descripcion<span class="asterisco-label">*</span></label>
                            <textarea name="descripcion">{{$registro_ac_libro_de_alzas->descripcion}}</textarea>
                            <p class="advertencia-error" id="error-descripcion"></p>
                        </div>

                        <div class="campo-form-control">
                            <label for="">Alza de<span class="asterisco-label">*</span></label>
                            <select name="alza_de" id="">
                                @php
                                $opciones=array(
                                'General',//0
                                'Criva 1',
                                'Criva 2',
                                'Criva 3',
                                'Cabecera',
                                'Amalgamado',
                                'Escoria',
                                'Deportes',
                                'Ninguno',
                                'Otros',
                                'Sin especificar',//10
                                );
                                @endphp
                                <option value="">--Seleccionar--</option>
                                <option value="{{$opciones[0]}}" @if($registro_ac_libro_de_alzas->alza_de==$opciones[0])
                                    selected @endif >{{$opciones[0]}}</option>

                                <option value="{{$opciones[1]}}" @if($registro_ac_libro_de_alzas->alza_de==$opciones[1])
                                    selected @endif >{{$opciones[1]}}</option>

                                <option value="{{$opciones[2]}}" @if($registro_ac_libro_de_alzas->alza_de==$opciones[2])
                                    selected @endif >{{$opciones[2]}}</option>

                                <option value="{{$opciones[3]}}" @if($registro_ac_libro_de_alzas->alza_de==$opciones[3])
                                    selected @endif >{{$opciones[3]}}</option>

                                <option value="{{$opciones[4]}}" @if($registro_ac_libro_de_alzas->alza_de==$opciones[4])
                                    selected @endif >{{$opciones[4]}}</option>

                                <option value="{{$opciones[5]}}" @if($registro_ac_libro_de_alzas->alza_de==$opciones[5])
                                    selected @endif >{{$opciones[5]}}</option>

                                <option value="{{$opciones[6]}}" @if($registro_ac_libro_de_alzas->alza_de==$opciones[6])
                                    selected @endif >{{$opciones[6]}}</option>

                                <option value="{{$opciones[7]}}" @if($registro_ac_libro_de_alzas->alza_de==$opciones[7])
                                    selected @endif >{{$opciones[7]}}</option>

                                <option value="{{$opciones[8]}}" @if($registro_ac_libro_de_alzas->alza_de==$opciones[8])
                                    selected @endif >{{$opciones[8]}}</option>

                                <option value="{{$opciones[9]}}" @if($registro_ac_libro_de_alzas->alza_de==$opciones[9])
                                    selected @endif >{{$opciones[9]}}</option>

                                <option value="{{$opciones[10]}}" @if($registro_ac_libro_de_alzas->
                                    alza_de==$opciones[10])
                                    selected @endif >{{$opciones[10]}}</option>

                            </select>
                            <p class="advertencia-error" id="error-alza_de"></p>
                        </div>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Peso Oro Fisico<span class="asterisco-label">*</span></label>
                                <input type="number" name="peso_oro_fisico"
                                    value="{{$registro_ac_libro_de_alzas->peso_oro_fisico}}" step="0.01">
                                <p class="advertencia-error" id="error-peso_oro_fisico"></p>
                            </div>
                            <div class="campo-form-control-2">
                                <label for="">Simbolo<span class="asterisco-label">*</span></label>
                                <input type="text" name="simbolo" value="{{$registro_ac_libro_de_alzas->simbolo}}">
                                <p class="advertencia-error" id="error-simbolo"></p>
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
                            @if($registro_ac_libro_de_alzas->archivo==null)
                            <img src="{{asset('assets/images/image-preview.png')}}" alt="Archivo Subido"
                                id="vista-previa">
                            @else
                            <img src="data:image/all;base64,{{base64_encode($registro_ac_libro_de_alzas->archivo)}}"
                                alt="archivo historial" id="vista-previa">
                            @endif
                        </div>

                        <div class="container-enviar">
                            <button type="button" class="enviar-reg" id="btn-accion" data-action="{{$action}}"><i
                                    class="zmdi zmdi-dialpad"></i>
                                Enviar</button>
                        </div>
                    </form>

                </div>

            </main>
            <!-- Contenido-->
            <div class="overlay">
            </div>
        </div>
    </div>

    <script src="{{asset('assets/js/UnpkgSideBar.js')}}"></script>
    <script src="{{asset('assets/js/sidebar.js')}}"></script>
    <script src="{{asset('assets/js/app/RegistroAcLibroDeAlzas.js')}}?v={{config('constants.VERSION_JS')}}"></script>
    <script src="{{asset('assets/js/ImagePreview.js')}}?v={{config('constants.VERSION_JS')}}"></script>

    <script src="{{asset('assets/js/CerrarSesion.js')}}?v={{config('constants.VERSION_JS')}}"></script>

</body>

</html>