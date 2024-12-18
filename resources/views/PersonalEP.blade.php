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

            <main class="content">
                <h2 class="texto-full-title">
                    Cooperativa Minera Chima R.L. | <span class="texto-full">Personal</span>
                </h2>

                <!-- menu opciones-->
                @include('components/menu_opciones/menuOptionPersonal')

                <div class="title-info">Registros del Personal de Planta</div>

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
                                    <th>N° de empleado</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Carnet</th>
                                    <th>Celular de Contacto</th>
                                    <th>Perfil del Empleado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $cantidad_filas=20;
                                @endphp
                                @foreach($personal_ep as $row)
                                @if($cantidad_filas>0)
                                <tr>
                                    <td>{{$row->num_empleado}}</td>
                                    <td>{{$row->nombres}}</td>
                                    <td>{{$row->apellidos}}</td>
                                    <td>{{$row->ci}}</td>
                                    <td>{{$row->celular}}</td>
                                    <td><a href="{{route('route-perfil-personal-planta',Crypt::encrypt($row->id))}}"
                                            class="perfil-reg"><i class="zmdi zmdi-account-box"></i></a></td>
                                    </td>
                                </tr>
                                @else
                                <tr style='display:none'>
                                    <td>{{$row->num_empleado}}</td>
                                    <td>{{$row->nombres}}</td>
                                    <td>{{$row->apellidos}}</td>
                                    <td>{{$row->ci}}</td>
                                    <td>{{$row->celular}}</td>
                                    <td><a href="{{route('route-perfil-personal-planta',Crypt::encrypt($row->id))}}"
                                            class="perfil-reg"><i class="zmdi zmdi-account-box"></i></a></td>
                                    </td>
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

    <script src="{{asset('assets/js/UnpkgSideBar.js')}}"></script>
    <script src="{{asset('assets/js/sidebar.js')}}"></script>
    <script src="{{asset('assets/js/DataTable.js')}}?v={{config('constants.VERSION_JS')}} "></script>
    <script src="{{asset('assets/js/CerrarSesion.js')}}?v={{config('constants.VERSION_JS')}} "></script>

</body>

</html>