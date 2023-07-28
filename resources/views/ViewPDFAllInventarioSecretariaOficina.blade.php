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

            <main class="content">
                <h2 class="texto-full-title">Inventario de Archivos</h2>

                @include('components/menu_opciones/menuOpInventarioDeArchivos')

                <div class="title-info-color-2">Imprimir Registros | Inventario Secretaria - Oficina</div>

                <section class="container-menu-opciones">
                    <ul class="list-menu-opciones">
                        <li class="item-menu-opciones color-item-menu-opciones">
                            <a href="{{route('route-pdf-all-inventario-secretaria-oficina')}}"><i
                                    class="zmdi zmdi-download"></i> PDF</a>
                        </li>
                        <li class="item-menu-opciones color-item-menu-opciones">
                            <a href="{{route('route-imprimir-all-inventario-secretaria-oficina')}}"><i
                                    class="zmdi zmdi-print"></i> Imprimir</a>
                        </li>
                    </ul>
                </section>

                <div class="container-pdf">
                    <iframe src="data:application/pdf;base64,{{base64_encode($pdf)}}" frameborder="0"></iframe>
                </div>

            </main>
            <div class="overlay">
            </div>

        </div>

    </div>

    <script src="{{asset('assets/js/UnpkgSideBar.js')}}"></script>
    <script src="{{asset('assets/js/sidebar.js')}}"></script>
    <script src="{{asset('assets/js/CerrarSesion.js')}}?v={{config('constants.VERSION_JS')}}"></script>
</body>

</html>