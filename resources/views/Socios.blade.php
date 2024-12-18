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
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}?v={{config('constants.VERSION_CSS')}} ">
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
                    Cooperativa Minera Chima R.L. | <span class="texto-full">Socios</span>
                </h2>
                <!-- menu opciones-->
                @include('components/menu_opciones/menuOptionSocios')

                <div class="title-info">Socios registrados</div>
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
                        <table id="tabla-datos" class="color-table-1">
                            <thead>
                                <tr>
                                    <th>N° de item</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Carnet</th>
                                    <th>Carnet valido hasta</th>
                                    <th>Celular</th>
                                    <th>Perfil de Socio</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $cantidad_filas=20;
                                @endphp
                                @foreach($socios as $row)
                                @if($cantidad_filas>0)
                                <tr>
                                    <td>{{$row->num_item}}</td>
                                    <td>{{$row->nombres}}</td>
                                    <td>{{$row->apellidos}}</td>
                                    <td>{{$row->ci}}</td>
                                    <td>{{date_format(date_create($row->ci_valido),'d/m/Y')}}</td>
                                    <td>{{$row->celular}}</td>
                                    <td>
                                        <a href="{{route('route-perfil-socios',Crypt::encrypt($row->id))}}"
                                            class="perfil-reg"><i class="zmdi zmdi-account-box"></i></a>
                                    </td>

                                </tr>
                                @php
                                $cantidad_filas--;
                                @endphp
                                @else
                                <tr style='display:none'>
                                    <td>{{$row->num_item}}</td>
                                    <td>{{$row->nombres}}</td>
                                    <td>{{$row->apellidos}}</td>
                                    <td>{{$row->ci}}</td>
                                    <td>{{date_format(date_create($row->ci_valido),'d/m/Y')}}</td>
                                    <td>{{$row->celular}}</td>
                                    <td>
                                        <a href="{{route('route-perfil-socios',Crypt::encrypt($row->id))}}"
                                            class="perfil-reg"><i class="zmdi zmdi-account-box"></i></a>
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

    <script src="{{asset('assets/js/CerrarSesion.js')}}?v={{config('constants.VERSION_JS')}}"></script>
</body>

</html>