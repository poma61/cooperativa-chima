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
    <link rel="stylesheet" href="{{asset('assets/css/main300.css')}}?v={{config('constants.VERSION_CSS')}}"
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

                <div class="title-info-color-100">Registrar | Mantenimiento Reparacion - Equipo Pesado</div>
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

                    <div class="container-info-all-de-registro">
                        <h3 class="title-info-all">Informacion - Equipo Pesado</h3>
                        <div class="table-informacion-responsive">
                            <table class="table-informacion-all">
                                <tbody>
                                    <tr>
                                        <td>Nombre comun del equipo:</td>
                                        <td>{{$equipo_pesado->nombre_comun_del_equipo}}</td>
                                        <td>Año de compra:</td>
                                        <td>{{$equipo_pesado->ano_de_compra}}</td>
                                    </tr>
                                    <tr>
                                        <td>Fabricante:</td>
                                        <td>{{$equipo_pesado->fabricante}}</td>
                                        <td>Estado del equipo al momento de alta:</td>
                                        <td>{{$equipo_pesado->estado_del_equipo_al_momento_de_alta}}</td>
                                    </tr>
                                    <tr>
                                        <td>Año de fabricacion:</td>
                                        <td>{{$equipo_pesado->ano_de_fabricacion}}</td>
                                        <td>Año de alta en planta:</td>
                                        <td>{{$equipo_pesado->ano_de_alta_planta}}</td>
                                    </tr>
                                    <tr>
                                        <td>N° se serie</td>
                                        <td>{{$equipo_pesado->numero_de_serie}}</td>
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
                            </select>
                            <input type="text" name="buscar" class="busqueda" placeholder="Buscar...">
                        </div>
                        <div class="table-responsive">
                            <table id="tabla-datos" class="color-table-2">
                                <thead>
                                    <tr>
                                        <th>N° de registro</th>
                                        <th>Fecha de ingreso</th>
                                        <th>Caracteristicas</th>
                                        <th>Registro</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $cantidad_filas=20;
                                    @endphp
                                    @foreach($mantenimiento_equipo_pesado as $row)
                                    @if($cantidad_filas>0)
                                    <tr>
                                        <td>{{$row->num_reg}}</td>
                                        <td>{{date_format(date_create($row->fecha_de_ingreso),'d/m/Y')}}</td>
                                        <td>{{$row->caracteristicas}}</td>
                                        <td><a href="{{route('route-ver-mantenimiento-equipo-pesado',Crypt::encrypt($row->id))}}"
                                                class="ver-registro ">
                                                <i class="zmdi zmdi-wrench"></i></a></td>
                                    </tr>
                                    @php
                                    $cantidad_filas--;
                                    @endphp
                                    @else
                                    <tr>
                                        <td>{{$row->num_reg}}</td>
                                        <td>{{date_format(date_create($row->fecha_de_ingreso),'d/m/Y')}}</td>
                                        <td>{{$row->caracteristicas}}</td>
                                        <td><a href="{{route('route-ver-mantenimiento-equipo-pesado',Crypt::encrypt($row->id))}}"
                                                class="ver-registro ">
                                                <i class="zmdi zmdi-wrench"></i></a></td>
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