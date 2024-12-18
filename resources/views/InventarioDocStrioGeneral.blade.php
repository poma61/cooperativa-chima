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
    <link rel="stylesheet" href="{{asset('assets/css/sideBar.css')}}?v={{config('constants.VERSION_CSS')}} "
        type="text/css" media="all">
    <link rel="stylesheet" href="{{asset('assets/css/style600.css')}}?v={{config('constants.VERSION_CSS')}} ">
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

                <h2 class="texto-full-title">Inventario de Archivos</h2>
                <!-- menu opciones-->
                @include('components/menu_opciones/menuOpInventarioDeArchivos')

                <div class="title-info-color-3">Listado de Registros | Inventario de Documentacion - Strio. General
                </div>

                <section class="container-menu-opciones">
                    <ul class="list-menu-opciones">
                        <li class="item-menu-opciones color-item-menu-opciones">
                            <a href="{{route('route-pdf-all-inventario-doc-strio-general')}}"><i
                                    class="zmdi zmdi-download"></i> PDF</a>
                        </li>
                        <li class="item-menu-opciones color-item-menu-opciones">
                            <a href="{{route('route-imprimir-all-inventario-doc-strio-general')}}"><i
                                    class="zmdi zmdi-print"></i> Imprimir</a>
                        </li>
                    </ul>
                </section>

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
                        <table id="tabla-datos" class="color-table-1">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Detalle</th>
                                    <th>Cantidad</th>
                                    <th>Rubro</th>
                                    <th>Observacion</th>
                                    <th colspan="5">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $cantidad_filas=20;
                                @endphp
                                @foreach($inventario_doc_strio_general as $row)
                                @if($cantidad_filas>0)
                                <tr>
                                    <td>{{$row->num_reg}}</td>
                                    <td>{{$row->detalle}}</td>
                                    <td>{{$row->cantidad}}</td>
                                    <td>{{$row->rubro}}</td>
                                    <td>{{$row->observacion}}</td>

                                    <td>
                                        <a style="cursor:pointer;" id="file"
                                            data-id_registro="{{Crypt::encrypt($row->id)}}" class="file-reg"><i
                                                class="zmdi zmdi-book-image"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a style="cursor:pointer;" data-id_reg="{{Crypt::encrypt($row->id)}}"
                                            class="delete-reg" id="delete"><i class="zmdi zmdi-delete"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('route-frm-show-inventario-doc-strio-general',Crypt::encrypt($row->id))}}"
                                            class="edit-reg"><i class="zmdi zmdi-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('route-pdf-id-inventario-doc-strio-general',Crypt::encrypt($row->id))}}"
                                            class="pdf-reg"><i class="zmdi zmdi-download"></i></a>
                                    </td>
                                    <td>
                                        <a data-id_reg_print="{{Crypt::encrypt($row->id)}}" class="print-reg"
                                            style="cursor:pointer;" id="print"><i class="zmdi zmdi-print"></i>
                                        </a>
                                    </td>
                                </tr>
                                @php
                                $cantidad_filas--;
                                @endphp
                                @else
                                <tr style='display:none'>
                                    <td>{{$row->num_reg}}</td>
                                    <td>{{$row->detalle}}</td>
                                    <td>{{$row->cantidad}}</td>
                                    <td>{{$row->rubro}}</td>
                                    <td>{{$row->observacion}}</td>

                                    <td>
                                        <a style="cursor:pointer;" id="file"
                                            data-id_registro="{{Crypt::encrypt($row->id)}}" class="file-reg"><i
                                                class="zmdi zmdi-book-image"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a style="cursor:pointer;" data-id_reg="{{Crypt::encrypt($row->id)}}"
                                            class="delete-reg" id="delete"><i class="zmdi zmdi-delete"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('route-frm-show-inventario-doc-strio-general',Crypt::encrypt($row->id))}}"
                                            class="edit-reg"><i class="zmdi zmdi-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('route-pdf-id-inventario-doc-strio-general',Crypt::encrypt($row->id))}}"
                                            class="pdf-reg"><i class="zmdi zmdi-download"></i></a>
                                    </td>
                                    <td>
                                        <a data-id_reg_print="{{Crypt::encrypt($row->id)}}" class="print-reg"
                                            style="cursor:pointer;" id="print"><i class="zmdi zmdi-print"></i>
                                        </a>
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
                            <!-- <p></p> -->
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

    <script src="{{asset('assets/js/UnpkgSideBar.js')}}"></script>
    <script src="{{asset('assets/js/sidebar.js')}}"></script>
    <script src="{{asset('assets/js/DataTable.js')}}?v={{config('constants.VERSION_JS')}} "></script>
    <script src="{{asset('assets/js/app/InventarioDocStrioGeneral.js')}}?v={{config('constants.VERSION_JS')}}">
    </script>
    <script src="{{asset('assets/js/CerrarSesion.js')}}?v={{config('constants.VERSION_JS')}}"></script>

</body>

</html>