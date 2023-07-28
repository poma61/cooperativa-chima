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

            <main class="content">
                <h2 class="texto-full-title">
                    Cooperativa Minera Chima R.L. | <span class="texto-full">Memorandums</span>
                </h2>

                <div class="title-info-color-200">Registros - Memorandums</div>

                <div class="main-container">

                    <section class="container-menu-opciones-vertical">
                        <ul class="list-menu-opciones">
                            <!-- menu opciones de forma vertical -->
                            <x-menu_opciones.MenuOptionVerticalRegisMemo />

                            <li class="item-menu-opciones">
                                <a class="color-100" href="{{route('route-pdf-registro-memorandums')}}">
                                    <i class="zmdi zmdi-download"></i><span> PDF</span> </a>
                            </li>
                            <li class="item-menu-opciones">
                                <a class="color-100" href="{{route('route-imprimir-registro-memorandums')}}">
                                    <i class="zmdi zmdi-print"></i><span> Imprimir</span></a>
                            </li>

                        </ul>
                    </section>


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
                            <table id="tabla-datos" class="color-table-1">
                                <thead>
                                    <tr>
                                        <th>N° de Registro</th>
                                        <th>Fecha Emitida</th>
                                        <th>Entregado A</th>
                                        <th>Cargo</th>
                                        <th>Registro</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $cantidad_filas=20;
                                    $num=1;
                                    @endphp
                                    @foreach($registro_memorandums as $row)
                                    @if($cantidad_filas>0)
                                    <tr>
                                        <td>{{$row->num_reg}}</td>
                                        <td>{{date_format(date_create($row->fecha_emitida),'d/m/Y')}}</td>
                                        <td>{{$row->entregado_a}}</td>
                                        <td>{{$row->cargo}}</td>
                                        <td>
                                            <a href="{{route('route-ver-registro-memorandums',MyEncryption::encrypt($row->id))}}"
                                                class="perfil-reg"><i class="zmdi zmdi-file-text"></i></a>
                                        </td>

                                    </tr>
                                    @php
                                    $cantidad_filas--;
                                    @endphp
                                    @else
                                    <tr style='display:none'>

                                    <tr>
                                        <td>{{$row->num_reg}}</td>
                                        <td>{{date_format(date_create($row->fecha_emitida),'d/m/Y')}}</td>
                                        <td>{{$row->entregado_a}}</td>
                                        <td>{{$row->cargo}}</td>
                                        <td>
                                            <a href="{{route('route-ver-registro-memorandums',MyEncryption::encrypt($row->id))}}"
                                                class="perfil-reg"><i class="zmdi zmdi-file-text"></i></a>
                                        </td>


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
                </div>

            </main>
            <div class="overlay">
            </div>
        </div>
    </div>


    <script src="{{asset('assets/js/DataTable.js')}}?v={{config('constants.VERSION_JS')}}"></script>
    <script src="{{asset('assets/js/UnpkgSideBar.js')}}"></script>
    <script src="{{asset('assets/js/sidebar.js')}}"></script>
    <script src="{{asset('assets/js/CerrarSesion.js')}}?v={{config('constants.VERSION_JS')}}"></script>

</body>

</html>