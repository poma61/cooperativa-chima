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
                    Cooperativa Minera Chima R.L. | <span class="texto-full">Registro de Correspondencias</span>
                </h2>

                <div class="title-info">Registrar Correspondencia Recibida</div>

                <div class="main-container">

                    <section class="container-menu-opciones-vertical">
                        <ul class="list-menu-opciones">
                            @include('components/menu_opciones/MenuOptionRegistroCorrespondencias')
                        </ul>
                    </section>

                    <!-- formulario-->
                    <div class="container-form">
                        <h3 class="title-form-control">Formulario de Correspondencia Recibida</h3>
                        <p>Los campos marcados con (*) son obligatorios</p>

                        <form class="mi-form-control" id="mi-form" enctype="multipart/form-data">
                            <p class="form-aviso-campos"><i class="zmdi zmdi-label"></i> INFORMACIÓN DE LA
                                CORRESPONDENCIA
                            </p>

                            <div class="form-control-colum-2">
                                <div class="campo-form-control-2">
                                    <label for="">Registro N°<span class="asterisco-label">*</span></label>
                                    @if($registro_correspondencias_re->id==0)
                                    <input type="number" name="numero-de-registro" disabled
                                        value="{{str_pad($num_registro,5,'0',STR_PAD_LEFT)}}">
                                    @else
                                    <input type="number" name="numero-de-registro" disabled
                                        value="{{$registro_correspondencias_re->num_reg}}">
                                    <input type="hidden" name="id-reg"
                                        value="{{Crypt::encrypt($registro_correspondencias_re->id)}}">
                                    @endif
                                </div>
                                <div class="campo-form-control-2">
                                    <label for="">Fecha<span class="asterisco-label">*</span></label>
                                    <input type="date" name="fecha" value="{{$registro_correspondencias_re->fecha}}">
                                    <p class="advertencia-error" id="error-fecha"></p>
                                </div>
                            </div>


                            <div class="form-control-colum-2">
                                <div class="campo-form-control-2">
                                    <label for="">Pestaña/Carpeta<span class="asterisco-label">*</span></label>
                                    <input type="text" name="pestana_carpeta"
                                        value="{{$registro_correspondencias_re->pestana_carpeta}}" maxlength="250">
                                    <p class="advertencia-error" id="error-pestana_carpeta"></p>
                                </div>
                                <div class="campo-form-control-2">
                                    <label for="">Referencia<span class="asterisco-label">*</span></label>
                                    <input type="text" name="referencia"
                                        value="{{$registro_correspondencias_re->referencia}}" maxlength="250">
                                    <p class="advertencia-error" id="error-referencia"></p>
                                </div>
                            </div>

                            <div class="form-control-colum-2">
                                <div class="campo-form-control-2">
                                    <label for="">Entregado Por<span class="asterisco-label">*</span></label>
                                    <input type="text" name="entregado_por"
                                        value="{{$registro_correspondencias_re->entregado_por}}" maxlength="250">
                                    <p class="advertencia-error" id="error-entregado_por"></p>
                                </div>
                                <div class="campo-form-control-2">
                                    <label for="">Recibido Por<span class="asterisco-label">*</span></label>
                                    <input type="text" name="recibido_por"
                                        value="{{$registro_correspondencias_re->recibido_por}}" maxlength="250">
                                    <p class="advertencia-error" id="error-recibido_por"></p>
                                </div>
                            </div>

                            <div class="campo-form-control">
                                <label for="">Cuenta<span class="asterisco-label">*</span></label>
                                <input type="text" name="cuenta" value="{{$registro_correspondencias_re->cuenta}}"
                                    maxlength="250">
                                <p class="advertencia-error" id="error-cuenta"></p>
                            </div>


                            <div class="campo-form-control-area">
                                <label for="">Descripción/Observacion<span class="asterisco-label">*</span></label>
                                <textarea
                                    name="descripcion_observacion">{{$registro_correspondencias_re->descripcion_observacion}}</textarea>
                                <p class="advertencia-error" id="error-descripcion_observacion"></p>
                            </div>

                            <div class="campo-form-control">
                                <label for="">Fecha de Respuesta<span class="asterisco-label">*</span></label>
                                <input type="date" name="fecha_de_respuesta"
                                    value="{{$registro_correspondencias_re->fecha_de_respuesta}}">
                                <p class="advertencia-error" id="error-fecha_de_respuesta"></p>
                            </div>

                            <div class="campo-form-control-area">
                                <label for="">Descripción<span class="asterisco-label">*</span></label>
                                <textarea name="descripcion">{{$registro_correspondencias_re->descripcion}}</textarea>
                                <p class="advertencia-error" id="error-descripcion"></p>
                            </div>

                            <div class="campo-form-control">
                                <label>Archivo<span class="asterisco-label">*</span></label>
                                <input type="file" name="archivo" id="seleccionar-archivo">
                                <label for="seleccionar-archivo" class="file-btn">Seleccionar <i
                                        class="zmdi zmdi-attachment-alt"></i></label>
                                <p class="advertencia-error" id="error-archivo"></p>
                            </div>

                            <div class="image-pre-view">
                                @if($registro_correspondencias_re->archivo==null)
                                <img src="{{asset('assets/images/image-preview.png')}}" alt="Archivo Subido"
                                    id="vista-previa">
                                @else
                                <img src="data:image/all;base64,{{base64_encode($registro_correspondencias_re->archivo)}}"
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

    <script src="{{asset('assets/js/app/RegistroCorrespondenciasRe.js')}}?v={{config('constants.VERSION_JS')}}">
    </script>
    <script src="{{asset('assets/js/ImagePreview.js')}}?v={{config('constants.VERSION_JS')}}"></script>
</body>


</html>