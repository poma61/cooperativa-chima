<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{asset('assets/css/normalize.css')}}" type="text/css" media="all">
    <link rel="stylesheet" href="{{asset('assets/css/pro-sideBar.css')}}?v={{config('constants.VERSION_CSS')}} "
        type="text/css" media="all">
        <link rel="stylesheet" href="{{asset('assets/css/sideBar.css')}}?v={{config('constants.VERSION_CSS')}} "
        type="text/css" media="all">
    <link rel="stylesheet" href="{{asset('assets/iconos/css/material-design-iconic-font.min.css')}}" type="text/css"
        media="all">
  
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
                <h2 class="texto-full-title">Cooperativa Minera Chima R.L. | <span class="texto-full">Socios</span></h2>

                <!-- menu opciones-->
                @include('components/menu_opciones/menuOptionSocios')
                <div class="title-info">Historial de antecedentes del Asociado</div>

                <!-- menu opciones por pagina-->
                <section class="container-menu-opciones-pagina">
                    <ul class="list-menu-opciones">
                        <li class="item-menu-opciones">
                            <a href="{{route('route-perfil-socios',MyEncryption::encrypt($socios->id))}}">Perfil <i
                                    class="zmdi zmdi-account-box"></i></a>
                        </li>

                      
                        <li class="item-menu-opciones">
                            <a href="{{route('route-historial-socios',MyEncryption::encrypt($socios->id))}}">Historial
                                <i class="zmdi zmdi-file-text"></i></a>
                        </li>
                        
                        <li class="item-menu-opciones">
                            <a href="{{route('route-frm-new-historial-socios',MyEncryption::encrypt($socios->id))}}">Agregar
                                Historial <i class="zmdi zmdi-plus-circle-o"></i></a>
                        </li>


                        <li class="item-menu-opciones">
                            <a href="{{route('route-pdf-historial-socios',MyEncryption::encrypt($socios->id))}}">PDF <i
                                    class="zmdi zmdi-download"></i></a>
                        </li>
                        <li class="item-menu-opciones">
                            <a href="{{route('route-imprimir-historial-socios',MyEncryption::encrypt($socios->id))}}">Imprimir
                                <i class="zmdi zmdi-print"></i></a>
                        </li>
                    </ul>

                </section>

                <div class="container-pdf">
                    <iframe src="data:application/pdf;base64,{{base64_encode($pdf)}}" frameborder="0"></iframe>
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
</body>

</html>