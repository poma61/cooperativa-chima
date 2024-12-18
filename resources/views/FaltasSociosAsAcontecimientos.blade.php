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
                <div class="title-info-color-3">Lista de Faltas Socios en Asambleas y Acontecimientos</div>
                <!-- menu opciones-->
                <x-menu_opciones.MenuOpFaltasSociosAsAcontecimientos />

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
                                    <th>N°</th>
                                    <th>Fecha</th>
                                    <th>Acontecimiento</th>
                                    <th>Socio</th>
                                    <th>Sancion Grm.</th>
                                    <th>Sancion Bs.</th>
                                    <th class="text-large">Observacion</th>
                                    <th colspan="4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                $cantidad_filas=20;
                                $num=1;
                                @endphp
                                @foreach($faltas_socios_as_acontecimientos as $row)
                                @if($cantidad_filas>0)
                                <tr>
                                    <td>{{$row->id}}</td>
                                    <td>{{date_format(date_create($row->fecha),'d/m/Y')}}</td>
                                    <td>{{$row->acontecimiento}}</td>
                                    <td>{{$row->nombres." ".$row->apellidos}}</td>
                                    <td>{{number_format($row->sancion_grm,2)}}</td>
                                    <td>{{number_format($row->sancion_bs,2)}}</td>
                                    <td>{{$row->observacion}}</td>


                                    <td>
                                        <a style="cursor:pointer;" data-id_reg="{{Crypt::encrypt($row->id)}}"
                                            class="delete-reg" id="delete"><i class="zmdi zmdi-delete"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('route-frm-show-faltas-socios-as-acontecimientos',Crypt::encrypt($row->id))}}"
                                            class="edit-reg"><i class="zmdi zmdi-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('route-pdf-id-faltas-socios-as-acontecimientos',Crypt::encrypt($row->id))}}"
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

                                    <td>{{$num}}</td>
                                    <td>{{date_format(date_create($row->fecha),'d/m/Y')}}</td>
                                    <td>{{$row->acontecimiento}}</td>
                                    <td>{{$row->nombres." ".$row->apellidos}}</td>
                                    <td>{{$row->sancion_grm}}</td>
                                    <td>{{$row->sancion_bs}}</td>
                                    <td>{{$row->observacion}}</td>

                                    <td>
                                        <a style="cursor:pointer;" data-id_reg="{{Crypt::encrypt($row->id)}}"
                                            class="delete-reg" id="delete"><i class="zmdi zmdi-delete"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('route-frm-show-faltas-socios-as-acontecimientos',Crypt::encrypt($row->id))}}"
                                            class="edit-reg"><i class="zmdi zmdi-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('route-pdf-id-faltas-socios-as-acontecimientos',Crypt::encrypt($row->id))}}"
                                            class="pdf-reg"><i class="zmdi zmdi-download"></i></a>
                                    </td>
                                    <td>
                                        <a data-id_reg_print="{{Crypt::encrypt($row->id)}}" class="print-reg"
                                            style="cursor:pointer;" id="print"><i class="zmdi zmdi-print"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endif
                                @php
                                $num++;
                                @endphp
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
            <div class="overlay">
            </div>

        </div>

    </div>

    <script src="{{asset('assets/js/DataTable.js')}}?v={{config('constants.VERSION_JS')}}"></script>
    <script src="{{asset('assets/js/app/FaltasSociosAsAcontecimientos.js')}}?v={{config('constants.VERSION_JS')}}">
    </script>
    <script src="{{asset('assets/js/UnpkgSideBar.js')}}"></script>
    <script src="{{asset('assets/js/sidebar.js')}}"></script>
    <script src="{{asset('assets/js/CerrarSesion.js')}}?v={{config('constants.VERSION_JS')}}"></script>
</body>

</html>