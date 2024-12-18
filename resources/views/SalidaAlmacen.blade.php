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
                <h2 class="title-info-color-1">Almacen</h2>
                <!-- menu opciones-->
                <x-menu_opciones.MenuOpAlmacen />

                <div class="title-info-color-2">Listar Registros | Salida Almacen</div>


                <section class="container-menu-opciones">
                    <ul class="list-menu-opciones">
                        <li class="item-menu-opciones color-item-menu-opciones">
                            <a href="{{route('route-pdf-salida-almacen')}}"><i class="zmdi zmdi-download"></i> PDF</a>
                        </li>
                        <li class="item-menu-opciones color-item-menu-opciones">
                            <a href="{{route('route-imprimir-salida-almacen')}}"><i class="zmdi zmdi-print"></i>
                                Imprimir</a>
                        </li>
                    </ul>
                </section>


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
                                    <th>N°</th>
                                    <th>Cantidad</th>
                                    <th>UM</th>
                                    <th>Codigo</th>
                                    <th>Nombre del articulo</th>
                                    <th>Referencia</th>
                                    <th>Destino / Sector</th>
                                    <th>Entregado por</th>
                                    <th>Autorizado por</th>
                                    <th>Interesado</th>
                                    <th colspan="2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $cantidad_filas=20;
                                @endphp
                                @foreach($salida_almacen as $row)
                                @if($cantidad_filas>0)
                                <tr>

                                    <td>{{$row->num_reg}}</td>
                                    <td>{{$row->cantidad}}</td>
                                    <td>{{$row->um}}</td>
                                    <td>{{$row->codigo}}</td>
                                    <td>{{$row->nombre_del_articulo}}</td>
                                    <td>{{$row->referencia}}</td>
                                    <td>{{$row->destino_sector}}</td>
                                    <td>{{$row->entregado_por}}</td>
                                    <td>{{$row->autorizado_por}}</td>
                                    <td>{{$row->interesado}}</td>
                                    <td>
                                        <a style="cursor:pointer;" data-id_reg="{{Crypt::encrypt($row->id)}}"
                                            class="delete-reg" id="delete"><i class="zmdi zmdi-delete"></i>
                                        </a>

                                    </td>
                                    <td>
                                        <a href="{{route('route-frm-show-salida-almacen',Crypt::encrypt($row->id))}}"
                                            class="edit-reg"><i class="zmdi zmdi-refresh"></i>
                                        </a>
                                    </td>

                                </tr>
                                @php
                                $cantidad_filas--;
                                @endphp
                                @else
                                <tr style='display:none'>

                                    <td>{{$row->num_reg}}</td>
                                    <td>{{$row->cantidad}}</td>
                                    <td>{{$row->um}}</td>
                                    <td>{{$row->codigo}}</td>
                                    <td>{{$row->nombre_del_articulo}}</td>
                                    <td>{{$row->referencia}}</td>
                                    <td>{{$row->destino_sector}}</td>
                                    <td>{{$row->entregado_por}}</td>
                                    <td>{{$row->autorizado_por}}</td>
                                    <td>{{$row->interesado}}</td>
                                    <td>
                                        <a style="cursor:pointer;" data-id_reg="{{Crypt::encrypt($row->id)}}"
                                            class="delete-reg" id="delete"><i class="zmdi zmdi-delete"></i>
                                        </a>

                                    </td>
                                    <td>
                                        <a href="{{route('route-frm-show-salida-almacen',Crypt::encrypt($row->id))}}"
                                            class="edit-reg"><i class="zmdi zmdi-refresh"></i>
                                        </a>
                                    </td>

                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>N°</th>
                                    <th>Cantidad</th>
                                    <th>UM</th>
                                    <th>Codigo</th>
                                    <th>Nombre del articulo</th>
                                    <th>Referencia</th>
                                    <th>Destino / Sector</th>
                                    <th>Entregado por</th>
                                    <th>Autorizado por</th>
                                    <th>Interesado</th>
                                    <th colspan="2">Acciones</th>
                                </tr>
                            </tfoot>

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
            <div class="overlay">
            </div>

        </div>

    </div>


    <script src="{{asset('assets/js/DataTable.js')}}?v={{config('constants.VERSION_JS')}}"></script>
    <script src="{{asset('assets/js/app/SalidaAlmacen.js')}}?v={{config('constants.VERSION_JS')}}">
    </script>

    <script src="{{asset('assets/js/UnpkgSideBar.js')}}"></script>
    <script src="{{asset('assets/js/sidebar.js')}}"></script>
    <script src="{{asset('assets/js/CerrarSesion.js')}}?v={{config('constants.VERSION_JS')}}"></script>
</body>

</html>