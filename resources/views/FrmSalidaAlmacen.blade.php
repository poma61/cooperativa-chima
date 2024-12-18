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
                <h2 class="title-info-color-1">Almacen</h2>
                <!-- menu opciones-->
                <x-menu_opciones.MenuOpAlmacen />

                <div class="title-info-color-2">Registrar | Salida Almacen</div>

                <!-- formulario-->
                <div class="container-form">

                    <p>Los campos marcados con (*) son obligatorios</p>

                    <form class="mi-form-control" id="mi-form" enctype="multipart/form-data">
                        <p class="form-aviso-campos"><i class="zmdi zmdi-label"></i> INFORMACIÓN</p>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Registro N°<span class="asterisco-label">*</span></label>
                                @if($salida_almacen->id==0)
                                <input type="number" name="numero-de-registro" disabled
                                    value="{{str_pad($num_registro,5,'0',STR_PAD_LEFT)}}">
                                @else
                                <input type="number" name="numero-de-registro" disabled
                                    value="{{$salida_almacen->num_reg}}">
                                <input type="hidden" name="id-reg"
                                    value="{{Crypt::encrypt($salida_almacen->id)}}">
                                @endif
                            </div>
                            <div class="campo-form-control-2">
                                <label for="">Cantidad<span class="asterisco-label">*</span></label>
                                <input type="number" name="cantidad" value="{{$salida_almacen->cantidad}}">
                                <p class="advertencia-error" id="error-cantidad"></p>
                            </div>
                        </div>

                        <div class="form-control-colum-2">

                            <div class="campo-form-control-2">
                                <label for="">U.M.<span class="asterisco-label">*</span></label>
                                <input type="text" name="um" value="{{$salida_almacen->um}}">
                                <p class="advertencia-error" id="error-um"></p>
                            </div>
                            <div class="campo-form-control-2">
                                <label for="">Codigo<span class="asterisco-label">*</span></label>
                                <input type="text" name="codigo" value="{{$salida_almacen->codigo}}">
                                <p class="advertencia-error" id="error-codigo"></p>
                            </div>

                        </div>


                        <div class="campo-form-control">
                            <label for="">Nombre del articulo<span class="asterisco-label">*</span></label>
                            <input type="text" name="nombre_del_articulo"
                                value="{{$salida_almacen->nombre_del_articulo}}">
                            <p class="advertencia-error" id="error-nombre_del_articulo"></p>
                        </div>

                        <div class="campo-form-control-area">
                            <label for="">Referencia<span class="asterisco-label">*</span></label>
                            <textarea name="referencia">{{$salida_almacen->referencia}}</textarea>
                            <p class="advertencia-error" id="error-referencia"></p>
                        </div>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Destino / Sector<span class="asterisco-label">*</span></label>
                                <input type="text" name="destino_sector" value="{{$salida_almacen->destino_sector}}">
                                <p class="advertencia-error" id="error-destino_sector"></p>
                            </div>
                            <div class="campo-form-control-2">
                                <label for="">Entregado Por<span class="asterisco-label">*</span></label>
                                <input type="text" name="entregado_por" value="{{$salida_almacen->entregado_por}}">
                                <p class="advertencia-error" id="error-entregado_por"></p>
                            </div>
                        </div>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Autorizado Por<span class="asterisco-label">*</span></label>
                                <input type="text" name="autorizado_por" value="{{$salida_almacen->autorizado_por}}">
                                <p class="advertencia-error" id="error-autorizado_por"></p>
                            </div>
                            <div class="campo-form-control-2">
                                <label for="">Interesado<span class="asterisco-label">*</span></label>
                                <input type="text" name="interesado" value="{{$salida_almacen->interesado}}">
                                <p class="advertencia-error" id="error-interesado"></p>
                            </div>
                        </div>

                        <div class="campo-form-control">
                            <label>Firma digital<span class="asterisco-label">*</span></label>
                            <input type="file" name="firma" id="seleccionar-archivo">
                            <label for="seleccionar-archivo" class="file-btn">Seleccionar <i
                                    class="zmdi zmdi-attachment-alt"></i></label>
                            <p class="advertencia-error" id="error-firma"></p>
                        </div>

                        <div class="image-pre-view">
                            @if($salida_almacen->firma==null)
                            <img src="{{asset('assets/images/image-preview.png')}}" alt="imagen socio"
                                id="vista-previa">
                            @else
                            <img src="data:image/all;base64,{{base64_encode($salida_almacen->firma)}}"
                                alt="imagen socio" id="vista-previa">
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
    <script src="{{asset('assets/js/app/SalidaAlmacen.js')}}?v={{config('constants.VERSION_JS')}}">
    </script>
    <script src="{{asset('assets/js/ImagePreview.js')}}?v={{config('constants.VERSION_JS')}}"></script>
    <script src="{{asset('assets/js/CerrarSesion.js')}}?v={{config('constants.VERSION_JS')}}"></script>

</body>

</html>