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
    <link rel="stylesheet" href="{{asset('assets/css/styleCuadrados.css')}}?v={{config('constants.VERSION_CSS')}}"
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
                <h2 class="texto-full-title">
                    Cooperativa Minera Chima R.L. | <span class="texto-full">Registro de Actas</span>
                </h2>

                <div class="imagen-logo">
                    <img class="logo__img" src="/assets/images/logo-minero-1.png" alt="logo de la empresa">
                </div>

                <div class="container-cuadrados">
                    <div class="cuadrado-item">
                        <a href="{{route('route-frm-new-registro-ac-as-ordinarias')}}"><i
                                class="zmdi zmdi-collection-item-1"></i>
                            <p>Asambleas Ordinarias</p>
                    </div>
                    <div class="cuadrado-item">
                        <a href="{{route('route-frm-new-registro-ac-as-extra-ordinarias')}}"><i
                                class="zmdi zmdi-collection-item-2"></i>
                            <p>Asambleas Extraordinarias</p>
                    </div>

                    <div class="cuadrado-item">
                        <a href="{{route('route-registro-ac-as-organicas')}}"><i
                                class="zmdi zmdi-collection-item-3"></i>
                            <p>Asambleas Organicas</p>
                    </div>
                    <div class="cuadrado-item">
                        <a href="{{route('route-registro-ac-tribunal-de-honor')}}"><i
                                class="zmdi zmdi-collection-item-4"></i>
                            <p>Actas Tribunal de Honor</p>
                    </div>
                    <div class="cuadrado-item">
                        <a href="{{route('route-frm-new-registro-ac-reuniones')}}"><i
                                class="zmdi zmdi-collection-item-5"></i>
                            <p>Actas de Reuniones</p>
                    </div>
                    <div class="cuadrado-item">
                        <a href="{{route('route-frm-new-registro-ac-libro-de-alzas')}}"><i
                                class="zmdi zmdi-collection-item-6"></i>
                            <p>Libro de Alzas</p>
                    </div>

                    <div class="cuadrado-item">
                        <a href="{{route('route-registro-ac-entrega-doc')}}"><i class="zmdi zmdi-collection-item-7"></i>
                            <p>
                                Actas de Entrega Documentación
                            </p>
                    </div>
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