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
    <link rel="stylesheet" href="{{asset('assets/css/style700.css')}}?v={{config('constants.VERSION_CSS')}}"
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

                <div class="title-info-color-2">Configuraciones de usuario | {{Auth::user()->onHasRoles->first()->rol}} </div>
                <div class="detalle-info">
                    <p> Por su seguridad. Debe cambiar su contraseña frecuentemente.</p>
                </div>
                <!-- formulario-->
                <div class="container-form">

                    <p>Los campos marcados con (*) son obligatorios</p>

                    <form class="mi-form-control" id="mi-form" enctype="multipart/form-data">

                        <p class="form-aviso-campos"><i class="zmdi zmdi-label"></i> CREDENCIALES </p>

                        <div class="campo-form-control">
                            <label for="">Usuario<span class="asterisco-label">*</span></label>
                            <input type="text" name="usuario" value="{{Auth::user()->usuario}}">
                            <p class="advertencia-error" id="error-usuario"></p>
                        </div>

                        <div class="campo-form-control">
                            <label for="">Contraseña Antigua<span class="asterisco-label">*</span></label>
                            <input type="password" name="password_old" autocomplete="off">
                            <p class="advertencia-error" id="error-password_old"></p>
                        </div>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Contraseña Nueva<span class="asterisco-label">*</span></label>
                                <input type="password" name="password_new" autocomplete="off">
                                <p class="advertencia-error" id="error-password_new"></p>
                            </div>

                            <div class="campo-form-control-2">
                                <label for="">Confirmar contraseña<span class="asterisco-label">*</span></label>
                                <input type="password" name="password_new_confirmation" autocomplete="off">
                                <p class="advertencia-error" id="error-password_new_confirmation"></p>
                            </div>
                        </div>

                        <div class="campo-form-control">
                            <label>Foto<span class="asterisco-label">*</span></label>
                            <input type="file" name="foto" id="seleccionar-archivo">
                            <label for="seleccionar-archivo" class="file-btn">Seleccionar <i
                                    class="zmdi zmdi-attachment-alt"></i></label>
                            <p class="advertencia-error" id="error-foto"></p>
                        </div>

                        <div class="image-pre-view">
                            @if(Auth::user()->foto==null)
                            <img src="{{asset('assets/images/image-preview.png')}}" alt="foto usuario"
                                id="vista-previa">
                            @else
                            <img src="data:image/all;base64,{{base64_encode(Auth::user()->foto)}}" alt="foto usuario"
                                id="vista-previa">
                            @endif
                        </div>

                        <div class="container-enviar">
                            <button type="button" class="enviar-reg" id="btn-accion"><i class="zmdi zmdi-dialpad"></i>
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

    
    <script src="{{asset('assets/js/sidebar.js')}}"></script>
    <script src="{{asset('assets/js/UnpkgSideBar.js')}}"></script>

    <script src="{{asset('assets/js/app/SettingUser.js')}}?v={{config('constants.VERSION_JS')}}">
    </script>
    <script src="{{asset('assets/js/ImagePreview.js')}}?v={{config('constants.VERSION_JS')}}"></script>

    <script src="{{asset('assets/js/CerrarSesion.js')}}?v={{config('constants.VERSION_JS')}}"></script>

</body>

</html>