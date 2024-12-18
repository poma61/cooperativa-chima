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
    <link rel="stylesheet" href="{{asset('assets/css/style400.css')}}?v={{config('constants.VERSION_CSS')}}"
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
                <div class="title-info">Registro de Libro de Alzas</div>

                <div class="container-menu-opciones-all">
                    <!-- menu opciones-->
                    <x-menu_opciones.MenuOpRegistroAcLibroDeAlzas />
                </div>

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
                                    <th>Fecha Emitida</th>
                                    <th>Referencia</th>
                                    <th class="text-large">Descripcion</th>
                                    <th>Alza de</th>
                                    <th>Peso Oro Fisico</th>
                                    <th colspan="5">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>


                                @php
                                $cantidad_filas=20;
                                @endphp
                                @foreach($registro_ac_libro_de_alzas as $row)
                                @if($cantidad_filas>0)
                                <tr>
                                    <td>{{$row->num_reg}}</td>
                                    <td>{{date_format(date_create($row->fecha_emitida),'d/m/Y')}}</td>
                                    <td>{{$row->referencia}}</td>
                                    <td>{{$row->descripcion}}</td>
                                    <td>{{$row->alza_de}}</td>
                                    <td>{{number_format($row->peso_oro_fisico,2).' '.$row->simbolo}}</td>

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
                                        <a href="{{route('route-frm-show-registro-ac-libro-de-alzas',Crypt::encrypt($row->id))}}"
                                            class="edit-reg"><i class="zmdi zmdi-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('route-pdf-id-registro-ac-libro-de-alzas',Crypt::encrypt($row->id))}}"
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
                                    <td>{{date_format(date_create($row->fecha_emitida),'d/m/Y')}}</td>
                                    <td>{{$row->referencia}}</td>
                                    <td>{{$row->descripcion}}</td>
                                    <td>{{$row->alza_de}}</td>
                                    <td>{{$row->peso_oro_fisico.' '.$row->simbolo}}</td>

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
                                        <a href="{{route('route-frm-show-registro-ac-libro-de-alzas',Crypt::encrypt($row->id))}}"
                                            class="edit-reg"><i class="zmdi zmdi-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('route-pdf-id-registro-ac-libro-de-alzas',Crypt::encrypt($row->id))}}"
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
    <script src="{{asset('assets/js/app/RegistroAcLibroDeAlzas.js')}}?v={{config('constants.VERSION_JS')}}"></script>
    <script src="{{asset('assets/js/UnpkgSideBar.js')}}"></script>
    <script src="{{asset('assets/js/sidebar.js')}}"></script>
    <script src="{{asset('assets/js/CerrarSesion.js')}}?v={{config('constants.VERSION_JS')}}"></script>
</body>


</html>