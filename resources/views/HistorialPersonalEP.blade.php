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
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}?v={{config('constants.VERSION_CSS')}}"
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

                <h2 class="texto-full-title">
                    Cooperativa Minera Chima R.L. | <span class="texto-full">Personal</span>
                </h2>
                <!-- menu opciones-->
                @include('components/menu_opciones/menuOptionPersonal')

                <div class="title-info">Historial del Personal de Planta</div>

                <!-- menu opciones por pagina-->
                <section class="container-menu-opciones-pagina">
                    <ul class="list-menu-opciones">

                        <li class="item-menu-opciones">
                            <a href="{{route('route-perfil-personal-planta',Crypt::encrypt($personal_ep->id))}}">Perfil
                                <i class="zmdi zmdi-account-box"></i></a>
                        </li>

                        <li class="item-menu-opciones">
                            <a
                                href="{{route('route-historial-personal-planta',Crypt::encrypt($personal_ep->id))}}">Historial
                                <i class="zmdi zmdi-file-text"></i></a>
                        </li>

                        <li class="item-menu-opciones">
                            <a
                                href="{{route('route-frm-new-historial-personal-planta',Crypt::encrypt($personal_ep->id))}}">Agregar
                                Historial
                                <i class="zmdi zmdi-plus-circle-o"></i></a>
                        </li>
                        <li class="item-menu-opciones">
                            <a
                                href="{{route('route-pdf-historial-personal-planta',Crypt::encrypt($personal_ep->id))}}">PDF
                                <i class="zmdi zmdi-download"></i></a>
                        </li>
                        <li class="item-menu-opciones">
                            <a
                                href="{{route('route-imprimir-historial-personal-planta',Crypt::encrypt($personal_ep->id))}}">Imprimir
                                <i class="zmdi zmdi-print"></i></a>
                        </li>

                    </ul>
                </section>
                <div class="container-info-all-de-registro">
                    <h3 class="title-info-all">Informacion del Empleado de Planta</h3>
                    <div class="table-informacion-responsive">
                        <table class="table-informacion-all">
                            <tbody>
                                <tr>
                                    <td>Nombres:</td>
                                    <td>{{$personal_ep->nombres}}</td>
                                </tr>
                                <tr>
                                    <td>Apellidos:</td>
                                    <td>{{$personal_ep->apellidos}}</td>
                                </tr>
                                <tr>
                                    <td>Carnet de Identidad:</td>
                                    <td>{{$personal_ep->ci}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Data Table-->
                <div class="container-data-table">
                    <div class="selector-data-table">
                        <select class="cantidad-table-rows">
                            <option value="20" selected>Cantidad de Filas 20</option>
                            <option value="50">Cantidad de Filas 50</option>
                            <option value="100">Cantidad de Filas 100</option>
                            <option value="150">Cantidad de Filas 150</option>
                            <option value="200">Cantidad de Filas 200</option>
                            <option value="300">Cantidad de Filas 300</option>
                            <option value="350">Cantidad de Filas 350</option>
                            <option value="500">Cantidad de Filas 500</option>
                        </select>
                        <input type="text" name="buscar" class="busqueda" placeholder="Buscar...">
                    </div>
                    <div class="table-responsive">
                        <table id="tabla-datos" class="color-table-2">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Fecha</th>
                                    <th>Tipo de Documento</th>
                                    <th>Ver Historial</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $cantidad_filas=20;
                                @endphp
                                @foreach($historial_personal_ep as $row)
                                @if($cantidad_filas>0)
                                <tr>
                                    <td>{{$row->num_reg}}</td>
                                    <td>{{date_format(date_create($row->fecha),'d/m/Y')}}</td>
                                    <td>{{$row->estado}}</td>
                                    <td><a href="{{route('route-ver-historial-personal-planta',Crypt::encrypt($row->id))}}"
                                            class="ver-historial-reg">
                                            <i class="zmdi zmdi-file-text"></i></a></td>
                                </tr>
                                @php
                                $cantidad_filas--;
                                @endphp
                                @else
                                <tr>
                                    <td>{{$row->num_reg}}</td>
                                    <td>{{$row->fecha}}</td>
                                    <td>{{$row->estado}}</td>
                                    <td><a href="{{route('route-ver-historial-personal-planta',Crypt::encrypt($row->id))}}"
                                            class="ver-historial-reg">
                                            <i class="zmdi zmdi-file-text"></i></a></td>
                                </tr>
                                @endif

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="paginador">
                        <button type='button' class="btn-anterior"><i class="zmdi zmdi-arrow-left"></i></button>
                        <select class="total-table-pages">
                            <!-- agregar etiqueta option con javaScript-->
                        </select>
                        <button type='button' class="btn-siguiente"><i class="zmdi zmdi-arrow-right"></i></button>
                    </div>
                </div>
            </main>
            <!-- Contenido-->
            <div class="overlay">
            </div>
        </div>
    </div>

    <script src="{{asset('assets/js/DataTable.js')}}?v={{config('constants.VERSION_JS')}} "></script>
    <script src="{{asset('assets/js/UnpkgSideBar.js')}}"></script>
    <script src="{{asset('assets/js/sidebar.js')}}"></script>
    <script src="{{asset('assets/js/CerrarSesion.js')}}?v={{config('constants.VERSION_JS')}}"></script>
</body>

</html>