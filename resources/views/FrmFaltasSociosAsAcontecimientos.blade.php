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
    <link rel="stylesheet" href="{{asset('assets/css/style600.css')}}?v={{config('constants.VERSION_CSS')}}"
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

                <div class="title-info-color-3">Registrar | Faltas Socios en Asambleas y Acontecimientos</div>
                <!-- menu opciones-->
                <x-menu_opciones.MenuOpFaltasSociosAsAcontecimientos />

                <!-- formulario-->
                <div class="container-form">
                    <p>Los campos marcados con (*) son obligatorios</p>

                    <form class="mi-form-control" id="mi-form" enctype="multipart/form-data">
                        @if($faltas_socios_as_acontecimientos->id!=0)
                        <input type="hidden" name="id-reg"
                            value="{{Crypt::encrypt($faltas_socios_as_acontecimientos->id)}}">
                        @endif

                        <p class="form-aviso-campos"><i class="zmdi zmdi-label"></i> INFORMACIÓN</p>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Fecha<span class="asterisco-label">*</span></label>
                                <input type="date" name="fecha" value="{{$faltas_socios_as_acontecimientos->fecha}}">
                                <p class="advertencia-error" id="error-fecha"></p>
                            </div>
                            <div class="campo-form-control-2">
                                <label for="">Acontecimiento<span class="asterisco-label">*</span></label>
                                <input type="text" name="acontecimiento"
                                    value="{{$faltas_socios_as_acontecimientos->acontecimiento}}">
                                <p class="advertencia-error" id="error-acontecimiento"></p>
                            </div>
                        </div>

                        <div class="form-control-colum-2-search">
                            <div class="campo-form-control-2">
                                <label for="">Buscar socio por nombre completo o carnet</label>
                                <input type="search" name="texto-a-buscar" value="">

                            </div>
                            <div class="campo-form-control-2">
                                <button type="button" class="input-btn" id="btn-busqueda"><i
                                        class="zmdi zmdi-search"></i>
                                    Buscar</button>
                                <p id="txt-busqueda"></p>
                            </div>
                        </div>

                        <div class="campo-form-control">
                            <label for="">Nombre Completo - Socio<span class="asterisco-label">*</span></label>
                            <input type="text" name="nombre-completo-socio"
                                value="{{$faltas_socios_as_acontecimientos->nombres." ".$faltas_socios_as_acontecimientos->apellidos}}"
                                disabled>
                            <input type="hidden" name="id_socio"
                                value="{{$faltas_socios_as_acontecimientos->id_socio}}">
                            <p class="advertencia-error" id="error-id_socio"></p>
                        </div>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Sancion Grm.<span class="asterisco-label">*</span></label>
                                <input type="number" name="sancion_grm"
                                    value="{{number_format($faltas_socios_as_acontecimientos->sancion_grm,2,'.','')}}"
                                    step="0.01">
                                <p class="advertencia-error" id="error-sancion_grm"></p>
                            </div>
                            <div class="campo-form-control-2">
                                <label for="">Sancion Bs.<span class="asterisco-label">*</span></label>
                                <input type="number" name="sancion_bs"
                                    value="{{number_format($faltas_socios_as_acontecimientos->sancion_bs,2,'.','')}}"
                                    step="0.01">
                                <p class="advertencia-error" id="error-sancion_bs"></p>
                            </div>
                        </div>


                        <div class="campo-form-control-area">
                            <label for="">Observacion<span class="asterisco-label">*</span></label>
                            <textarea name="observacion"
                                placeholder="Escriba aquí...">{{$faltas_socios_as_acontecimientos->observacion}}</textarea>
                            <p class="advertencia-error" id="error-observacion"></p>
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
    <script src="{{asset('assets/js/app/FaltasSociosAsAcontecimientos.js')}}?v={{config('constants.VERSION_JS')}}">
    </script>

    <script src="{{asset('assets/js/CerrarSesion.js')}}?v={{config('constants.VERSION_JS')}}"></script>

</body>

</html>