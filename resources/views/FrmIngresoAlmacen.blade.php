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

            <!-- Contenido-->
            <main class="content">
                <h2 class="title-info-color-1">Almacen</h2>
                <!-- menu opciones-->
                <x-menu_opciones.MenuOpAlmacen />

                <div class="title-info-color-1">Registrar | Ingreso Alamacen</div>

                <!-- formulario-->
                <div class="container-form">

                    <p>Los campos marcados con (*) son obligatorios</p>

                    <form class="mi-form-control" id="mi-form" enctype="multipart/form-data">
                        <p class="form-aviso-campos"><i class="zmdi zmdi-label"></i> INFORMACIÓN</p>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Registro N°<span class="asterisco-label">*</span></label>
                                @if($ingreso_almacen->id==0)
                                <input type="number" name="numero-de-registro" disabled
                                    value="{{str_pad($num_registro,5,'0',STR_PAD_LEFT)}}">
                                @else
                                <input type="number" name="numero-de-registro" disabled
                                    value="{{$ingreso_almacen->num_reg}}">
                                <input type="hidden" name="id-reg"
                                    value="{{MyEncryption::encrypt($ingreso_almacen->id)}}">
                                @endif
                            </div>
                            <div class="campo-form-control-2">
                                <label for="">N° de documento<span class="asterisco-label">*</span></label>
                                <input type="number" name="n_de_documento" value="{{$ingreso_almacen->n_de_documento}}">
                                <p class="advertencia-error" id="error-n_de_documento"></p>
                            </div>
                        </div>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Cantidad <span class="asterisco-label">*</span></label>
                                <input type="number" name="cantidad" value="{{$ingreso_almacen->cantidad}}">
                                <p class="advertencia-error" id="error-cantidad"></p>
                            </div>
                            <div class="campo-form-control-2">
                                <label for="">U.M.<span class="asterisco-label">*</span></label>
                                <input type="text" name="um" value="{{$ingreso_almacen->um}}" maxlength="400">
                                <p class="advertencia-error" id="error-um"></p>
                            </div>
                        </div>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Costo Unitario<span class="asterisco-label">*</span></label>
                                <input type="number" name="costo_unitario"
                                    value="{{number_format($ingreso_almacen->costo_unitario,2,'.','')}}" step="0.01">
                                <p class="advertencia-error" id="error-costo_unitario"></p>
                            </div>
                            <div class="campo-form-control-2">
                                <label for="">Divisa (Costo Unitario)<span class="asterisco-label">*</span></label>
                                <input type="text" name="divisa_costo_unitario"
                                    value="{{$ingreso_almacen->divisa_costo_unitario}}">
                                <p class="advertencia-error" id="error-divisa_costo_unitario"></p>
                            </div>
                        </div>


                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Total<span class="asterisco-label">*</span></label>
                                <input type="number" name="total"
                                    value="{{number_format($ingreso_almacen->total,2,'.','')}}" step="0.01">
                                <p class="advertencia-error" id="error-total"></p>
                            </div>
                            <div class="campo-form-control-2">
                                <label for="">Divisa (Total)<span class="asterisco-label">*</span></label>
                                <input type="text" name="divisa_total" value="{{$ingreso_almacen->divisa_total}}">
                                <p class="advertencia-error" id="error-divisa_total"></p>
                            </div>
                        </div>


                        <div class="campo-form-control-area">
                            <label for="">Descripcion<span class="asterisco-label">*</span></label>
                            <textarea name="descripcion">{{$ingreso_almacen->descripcion}}</textarea>
                            <p class="advertencia-error" id="error-descripcion"></p>
                        </div>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Codigo<span class="asterisco-label">*</span></label>
                                <input type="text" name="codigo" value="{{$ingreso_almacen->codigo}}">
                                <p class="advertencia-error" id="error-codigo"></p>
                            </div>
                            <div class="campo-form-control-2">
                                <label for="">Marca<span class="asterisco-label">*</span></label>
                                <input type="text" name="marca" value="{{$ingreso_almacen->marca}}">
                                <p class="advertencia-error" id="error-marca"></p>
                            </div>
                        </div>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Proveedor<span class="asterisco-label">*</span></label>
                                <input type="text" name="proveedor" value="{{$ingreso_almacen->proveedor}}">
                                <p class="advertencia-error" id="error-proveedor"></p>
                            </div>
                            <div class="campo-form-control-2">
                                <label for="">Entregado por<span class="asterisco-label">*</span></label>
                                <input type="text" name="entregado_por" value="{{$ingreso_almacen->entregado_por}}">
                                <p class="advertencia-error" id="error-entregado_por"></p>
                            </div>
                        </div>

                        <div class="container-enviar">
                            <button type="button" class="enviar-reg" id="btn-accion" data-action="{{$action}}"><i
                                    class="zmdi zmdi-dialpad"></i>
                                Enviar</button>
                        </div>
                    </form>

                </div>

            </main>
            <!-- Contenido-->
            <div class="overlay">
            </div>
        </div>
    </div>

    <script src="{{asset('assets/js/UnpkgSideBar.js')}}"></script>
    <script src="{{asset('assets/js/sidebar.js')}}"></script>
    <script src="{{asset('assets/js/app/IngresoAlmacen.js')}}?v={{config('constants.VERSION_JS')}}">
    </script>
    <script src="{{asset('assets/js/CerrarSesion.js')}}?v={{config('constants.VERSION_JS')}}"></script>

</body>

</html>