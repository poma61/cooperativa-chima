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
                    Cooperativa Minera Chima R.L. | <span class="texto-full"> Registro de
                        Correspondencias</span>
                </h2>

                <div class="title-info">Informacion | Registro de Correspondencias Recibidas</div>
                <div class="main-container">
                    <section class="container-menu-opciones-vertical">
                        <ul class="list-menu-opciones">
                            @include('components/menu_opciones/MenuOptionRegistroCorrespondencias')

                            <li class="item-menu-opciones">
                                <a class="color-100"
                                    href="{{route('route-frm-show-registro-correspondencias-re',Crypt::encrypt($registro_correspondencias_re->id))}}">
                                    <i class="zmdi zmdi-border-color"></i><span> Actualizar</span> </a>
                            </li>
                            <li class="item-menu-opciones">
                                <a class="color-100" style="cursor:pointer;" id="btn-accion"
                                    data-action="confirm-destroy"
                                    data-id_reg="{{Crypt::encrypt($registro_correspondencias_re->id)}}">
                                    <i class="zmdi zmdi-delete"></i><span> Eliminar</span></a>
                            </li>
                            <li class="item-menu-opciones">
                                <a class="color-100"
                                    href="{{route('route-ver-registro-correspondencias-re',Crypt::encrypt($registro_correspondencias_re->id))}}">
                                    <i class="zmdi zmdi-file-text"></i><span> Ver Registro</span></a>
                            </li>
                            <li class="item-menu-opciones">
                                <a class="color-100"
                                    href="{{route('route-pdf-ver-registro-correspondencias-re',Crypt::encrypt($registro_correspondencias_re->id))}}">
                                    <i class="zmdi zmdi-download"></i><span> PDF</span> </a>
                            </li>
                            <li class="item-menu-opciones">
                                <a class="color-100"
                                    href="{{route('route-imprimir-ver-registro-correspondencias-re',Crypt::encrypt($registro_correspondencias_re->id))}}">
                                    <i class="zmdi zmdi-print"></i><span> Imprimir</span></a>
                            </li>

                        </ul>
                    </section>

                    <div class="container-pdf">
                        <iframe src="data:application/pdf;base64,{{base64_encode($pdf)}}" frameborder="0"></iframe>
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
    <script src="{{asset('assets/js/app/RegistroCorrespondenciasRe.js')}}?v={{config('constants.VERSION_JS')}}">
    </script>
</body>

</html>