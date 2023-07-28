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
    <link rel="stylesheet" href="{{asset('assets/css/main300.css')}}?v={{config('constants.VERSION_CSS')}} ">
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
                                    href="{{route('route-mantenimiento-equipo-pesado',MyEncryption::encrypt($equipo_pesado->id))}}">
                                    <i class="zmdi zmdi-wrench"></i> <span>Mantenimiento</span></a>
                            </li>

                            @if($mantenimiento_equipo_pesado->id!=0)
                            <li class="item-menu-opciones">
                                <a class="color-100"
                                    href="{{route('route-ver-mantenimiento-equipo-pesado',MyEncryption::encrypt($mantenimiento_equipo_pesado->id))}}">
                                    <i class="zmdi zmdi-wrench"></i> <span> Registro</span></a>
                            </li>
                            @endif

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

                    <!-- formulario-->
                    <div class="container-form">
                        <h3 class="title-form-control">Formulario | Mantenimiento Reparacion - Equipo Pesado</h3>
                        <p>Los campos marcados con (*) son obligatorios</p>

                        <form action="" class="mi-form-control" id="mi-form">

                            @if($mantenimiento_equipo_pesado->id==0)
                            <input type="hidden" value="{{MyEncryption::encrypt($equipo_pesado->id)}}"
                                name="id-equipo-pesado">
                            @else
                            <input type="hidden" value="{{MyEncryption::encrypt($mantenimiento_equipo_pesado->id)}}"
                                name="id-reg">
                            @endif
                            <p class="form-aviso-campos"><i class="zmdi zmdi-label"></i> INFORMACION</p>

                            <div class="form-control-colum-2">
                                <div class="campo-form-control-2">
                                    <label for="">N° de registro<span class="advertencia-error">*</span></label>
                                    @if($mantenimiento_equipo_pesado->id==0)
                                    <input type="number" name="numero-de-registro"
                                        value="{{str_pad($num_registro,5,'0',STR_PAD_LEFT)}}" disabled>
                                    @else
                                    <input type="number" name="numero-de-registro"
                                        value="{{$mantenimiento_equipo_pesado->num_reg}}" disabled>
                                    @endif
                                </div>

                                <div class="campo-form-control-2">
                                    <label for="">Fecha de ingreso<span class="asterisco-label">*</span></label>
                                    <input type="date" name="fecha_de_ingreso"
                                        value="{{$mantenimiento_equipo_pesado->fecha_de_ingreso}}">
                                    <p class="advertencia-error" id="error-fecha_de_ingreso"></p>
                                </div>
                            </div>

                            <div class="campo-form-control-area">
                                <label for="">Caracteristicas<span class="asterisco-label">*</span></label>
                                <textarea
                                    name="caracteristicas">{{$mantenimiento_equipo_pesado->caracteristicas}}</textarea>
                                <p class="advertencia-error" id="error-caracteristicas"> </p>
                            </div>

                            <div class="campo-form-control-area">
                                <label for="">Desarrollo<span class="asterisco-label">*</span></label>
                                <textarea name="desarrollo">{{$mantenimiento_equipo_pesado->desarrollo}}</textarea>
                                <p class="advertencia-error" id="error-desarrollo"> </p>
                            </div>

                            <div class="campo-form-control-area">
                                <label for="">Material ocupado<span class="asterisco-label">*</span></label>
                                <textarea
                                    name="material_ocupado">{{$mantenimiento_equipo_pesado->material_ocupado}}</textarea>
                                <p class="advertencia-error" id="error-material_ocupado"> </p>
                            </div>

                            <div class="campo-form-control-area">
                                <label for="">Mantenimiento preventivo<span class="asterisco-label">*</span></label>
                                <textarea
                                    name="mantenimiento_preventivo">{{$mantenimiento_equipo_pesado->mantenimiento_preventivo}}</textarea>
                                <p class="advertencia-error" id="error-mantenimiento_preventivo"> </p>
                            </div>

                            <div class="campo-form-control-area">
                                <label for="">Mantenimiento correctivo<span class="asterisco-label">*</span></label>
                                <textarea
                                    name="mantenimiento_correctivo">{{$mantenimiento_equipo_pesado->mantenimiento_correctivo}}</textarea>
                                <p class="advertencia-error" id="error-mantenimiento_correctivo"> </p>
                            </div>

                            <div class="campo-form-control">
                                <label for="">Fecha de salida<span class="asterisco-label">*</span></label>
                                <input type="date" name="fecha_de_salida"
                                    value="{{$mantenimiento_equipo_pesado->fecha_de_salida}}">
                                <p class="advertencia-error" id="error-fecha_de_salida"></p>
                            </div>

                            <div class="campo-form-control-area">
                                <label for="">Observacion<span class="asterisco-label">*</span></label>
                                <textarea name="observacion">{{$mantenimiento_equipo_pesado->observacion}}</textarea>
                                <p class="advertencia-error" id="error-observacion"> </p>
                            </div>


                            <div class="container-enviar">
                                <button type="button" class="enviar-reg" id="btn-accion" data-action="{{$action}}"><i
                                        class="zmdi zmdi-dialpad"></i> Enviar</button>
                            </div>

                        </form>

                    </div>

                </div>
            </main>
            <!-- Contenido-->
            <div class="overlay">
            </div>
        </div>
    </div>


    <script src="{{asset('assets/js/app/MantenimientoEquipoPesado.js')}}?v={{config('constants.VERSION_JS')}}"></script>

    <script src="{{asset('assets/js/UnpkgSideBar.js')}}"></script>
    <script src="{{asset('assets/js/sidebar.js')}}"></script>
    <script src="{{asset('assets/js/CerrarSesion.js')}}?v={{config('constants.VERSION_JS')}}"></script>
</body>


</html>