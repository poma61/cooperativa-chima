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

                <div class="title-info-color-2">Registrar | Comisiones - Control de Informes</div>

                <!-- menu opciones-->
                <x-menu_opciones.MenuOpRegistroComisionesInformes />

                <!-- formulario-->
                <div class="container-form">

                    <p>Los campos marcados con (*) son obligatorios</p>

                    <form class="mi-form-control" id="mi-form" enctype="multipart/form-data">
                        <p class="form-aviso-campos"><i class="zmdi zmdi-label"></i> INFORMACIÓN</p>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Registro N°<span class="asterisco-label">*</span></label>
                                @if($registro_comisiones_informes->id==0)
                                <input type="number" name="numero-de-registro" disabled
                                    value="{{str_pad($num_registro,5,'0',STR_PAD_LEFT)}}">
                                @else
                                <input type="number" name="numero-de-registro" disabled
                                    value="{{$registro_comisiones_informes->num_reg}}">
                                <input type="hidden" name="id-reg"
                                    value="{{Crypt::encrypt($registro_comisiones_informes->id)}}">
                                @endif
                            </div>
                            <div class="campo-form-control-2">
                                <label for="">Fecha Recibida<span class="asterisco-label">*</span></label>
                                <input type="date" name="fecha_recibida"
                                    value="{{$registro_comisiones_informes->fecha_recibida}}">
                                <p class="advertencia-error" id="error-fecha_recibida"></p>
                            </div>
                        </div>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Referencia<span class="asterisco-label">*</span></label>
                                <input type="text" name="referencia"
                                    value="{{$registro_comisiones_informes->referencia}}" maxlength="600">
                                <p class="advertencia-error" id="error-referencia"></p>
                            </div>
                            <div class="campo-form-control-2">
                                <label for="">Entregado Por<span class="asterisco-label">*</span></label>
                                <input type="text" name="entregado_por"
                                    value="{{$registro_comisiones_informes->entregado_por}}" maxlength="300">
                                <p class="advertencia-error" id="error-entregado_por"></p>
                            </div>
                        </div>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Cargo<span class="asterisco-label">*</span></label>
                                <input type="text" name="cargo" value="{{$registro_comisiones_informes->cargo}}"
                                    maxlength="300">
                                <p class="advertencia-error" id="error-cargo"></p>
                            </div>
                            <div class="campo-form-control-2">
                                <label for="">Fecha de la Comision<span class="asterisco-label">*</span></label>
                                <input type="date" name="fecha_de_la_comision"
                                    value="{{$registro_comisiones_informes->fecha_de_la_comision}}">
                                <p class="advertencia-error" id="error-fecha_de_la_comision"></p>
                            </div>
                        </div>

                        <div class="campo-form-control-area">
                            <label for="">Descripcion<span class="asterisco-label">*</span></label>
                            <textarea name="descripcion">{{$registro_comisiones_informes->descripcion}}</textarea>
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
                            @if($registro_comisiones_informes->archivo==null)
                            <img src="{{asset('assets/images/image-preview.png')}}" alt="Archivo Subido"
                                id="vista-previa">
                            @else
                            <img src="data:image/all;base64,{{base64_encode($registro_comisiones_informes->archivo)}}"
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
    <script src="{{asset('assets/js/app/RegistroComisionesInformes.js')}}?v={{config('constants.VERSION_JS')}}">
    </script>
    <script src="{{asset('assets/js/ImagePreview.js')}}?v={{config('constants.VERSION_JS')}}"></script>

    <script src="{{asset('assets/js/CerrarSesion.js')}}?v={{config('constants.VERSION_JS')}}"></script>

</body>

</html>