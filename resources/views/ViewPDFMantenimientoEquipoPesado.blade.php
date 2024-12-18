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
    <link rel="stylesheet" href="{{asset('assets/css/main300.css')}}?v={{config('constants.VERSION_CSS')}}">
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
                <div class="title-info-color-100">Imprimir | Mantenimiento Reparacion - Equipo Pesado</div>
                <div class="main-container">

                    <section class="container-menu-opciones-vertical">
                        <ul class="list-menu-opciones">
                            <!-- menu opciones de forma vertical -->
                            <x-menu_opciones.MenuOptionVerticalEquipoPesado />

                            <li class="item-menu-opciones">
                                <a class="color-100"
                                    href="{{route('route-ver-equipo-pesado',Crypt::encrypt($equipo_pesado->id))}}">
                                    <i class="zmdi zmdi-file-text"></i><span> Registro</span></a>
                            </li>

                            <li class="item-menu-opciones">
                                <a class="color-100"
                                    href="{{route('route-mantenimiento-equipo-pesado',Crypt::encrypt($equipo_pesado->id))}}">
                                    <i class="zmdi zmdi-wrench"></i> <span>Mantenimiento</span></a>
                            </li>

                            <li class="item-menu-opciones">
                                <a class="color-100"
                                    href="{{route('route-frm-new-mantenimiento-equipo-pesado',Crypt::encrypt($equipo_pesado->id))}}">
                                    <i class="zmdi zmdi-plus"></i> <span>Nuevo Mantenimiento</span></a>
                            </li>
                            
                            <li class="item-menu-opciones">
                                <a class="color-100"
                                    href="{{route('route-pdf-mantenimiento-equipo-pesado',Crypt::encrypt($equipo_pesado->id))}}">
                                    <i class="zmdi zmdi-download"></i><span>PDF</span></a>
                            </li>
                            <li class="item-menu-opciones">
                                <a class="color-100"
                                    href="{{route('route-imprimir-mantenimiento-equipo-pesado',Crypt::encrypt($equipo_pesado->id))}}">
                                    <i class="zmdi zmdi-print"></i><span>Imprmir</span></a>
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


    <script src="{{asset('assets/js/CerrarSesion.js')}}?v={{config('constants.VERSION_JS')}}"></script>
</body>

</html>