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

                @include('components/menu_opciones/menuOptionSocios')

                <div class="title-info">Registro de Socios</div>

                <!-- formulario-->
                <div class="container-form">
                    <h3 class="title-form-control">Formulario del Asociado</h3>
                    <p>Los campos marcados con (*) son obligatorios</p>

                    <form class="mi-form-control" id="mi-form">
                        @if($socios->id!=0)
                        <input type="hidden" value="{{MyEncryption::encrypt($socios->id)}}" name="id-reg">
                        @endif
                        <input type="hidden" value="{{MyEncryption::encrypt(Auth::user()->id)}}" name="id_usuario">
                        <p class="form-aviso-campos"><i class="zmdi zmdi-label"></i> INFORMACION DEL ASOCIADO</p>

                        <div class="campo-form-control">
                            <label for="">N° de item<span class="asterisco-label">*</span></label>
                            @if($socios->id==0)
                            <input type="number" disabled value="{{str_pad($num_registro, 5, "0", STR_PAD_LEFT)}}"
                                name="num_reg__">
                            @else
                            <input type="number" disabled value="{{$socios->num_item}}" name="num_reg__">
                            @endif
                        </div>

                        <div class="campo-form-control">
                            <label for="">Estado del Asociado<span class="asterisco-label">*</span></label>
                            <input type="text" name="estado_del_asociado" value="{{$socios->estado_del_asociado}}">
                            <p class="advertencia-error" id="error-estado_del_asociado"></p>
                        </div>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Nombres<span class="asterisco-label">*</span></label>
                                <input type="text" name="nombres" maxlength="100" value="{{$socios->nombres}}">
                                <p class="advertencia-error" id="error-nombres"></p>
                            </div>
                            <div class="campo-form-control-2">
                                <label for="">Apellidos<span class="asterisco-label">*</span></label>
                                <input type="text" name="apellidos" maxlength="100" value="{{$socios->apellidos}}">
                                <p class="advertencia-error" id="error-apellidos"></p>
                            </div>
                        </div>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Carnet de Identidad<span class="asterisco-label">*</span></label>
                                <input type="text" name="ci" maxlength="150" value="{{$socios->ci}}">
                                <p class="advertencia-error" id="error-ci"></p>
                            </div>
                            <div class="campo-form-control-2">
                                <label for="">Carnet Valido Hasta<span class="asterisco-label">*</span></label>
                                <input type="date" name="ci_valido" value="{{$socios->ci_valido}}">
                                <p class="advertencia-error" id="error-ci_valido"></p>
                            </div>
                        </div>

                        <div class="campo-form-control">
                            <label for="">Lugar de Nacimiento<span class="asterisco-label">*</span></label>
                            <input type="text" name="lugar_de_nacimiento" maxlength="250"
                                value="{{$socios->lugar_de_nacimiento}}">
                            <p class="advertencia-error" id="error-lugar_de_nacimiento"></p>
                        </div>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Fecha de Nacimiento<span class="asterisco-label">*</span></label>
                                <input type="date" name="fecha_de_nacimiento" value="{{$socios->fecha_de_nacimiento}}">
                                <p class="advertencia-error" id="error-fecha_de_nacimiento"></p>
                            </div>
                            <div class="campo-form-control-2">
                                <label for="">Estado Civil<span class="asterisco-label">*</span></label>
                                <input type="text" name="estado_civil" maxlength="100"
                                    value="{{$socios->estado_civil}}">
                                <p class="advertencia-error" id="error-estado_civil"></p>
                            </div>
                        </div>

                        <div class="campo-form-control">
                            <label for="">Sexo<span class="asterisco-label">*</span></label>
                            <select name="sexo" id="">
                                <option value="">--Seleccionar--</option>
                                <option value="Hombre" @if($socios->sexo=='Hombre') selected @endif>Hombre</option>
                                <option value="Mujer" @if($socios->sexo=='Mujer') selected @endif>Mujer</option>
                            </select>
                            <p class="advertencia-error" id="error-sexo"></p>
                        </div>

                        <div class="campo-form-control">
                            <label for="">Celular de Contacto<span class="asterisco-label">*</span></label>
                            <input type="text" name="celular" maxlength="100" value="{{$socios->celular}}">
                            <p class="advertencia-error" id="error-celular"></p>
                        </div>

                        <div class="campo-form-control">
                            <label>Imagen<span class="asterisco-label">*</span></label>
                            <input type="file" name="imagen" id="seleccionar-archivo">
                            <label for="seleccionar-archivo" class="file-btn">Seleccionar <i
                                    class="zmdi zmdi-attachment-alt"></i></label>
                            <p class="advertencia-error" id="error-imagen"></p>
                        </div>

                        <div class="image-pre-view">
                            @if($socios->imagen==null)
                            <img src="{{asset('assets/images/image-preview.png')}}" alt="imagen socio"
                                id="vista-previa">
                            @else
                            <img src="data:image/all;base64,{{base64_encode($socios->imagen)}}" alt="imagen socio"
                                id="vista-previa">
                            @endif
                        </div>

                        <p class="form-aviso-campos"><i class="zmdi zmdi-label"></i> ORIGEN O PROCEDENCIA DE LA ACCION
                        </p>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Punta de Trabajo<span class="asterisco-label">*</span></label>
                                <input type="text" name="punta_de_trabajo" maxlength="100"
                                    value="{{$socios->punta_de_trabajo}}">
                                <p class="advertencia-error" id="error-punta_de_trabajo"></p>
                            </div>
                            <div class="campo-form-control-2">
                                <label for="">Grupo<span class="asterisco-label">*</span></label>
                                <input type="text" name="grupo" maxlength="100" value="{{$socios->grupo}}">
                                <p class="advertencia-error" id="error-grupo"></p>
                            </div>
                        </div>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Fecha de Transferencia<span class="asterisco-label">*</span></label>
                                <input type="date" name="fecha_de_transferencia"
                                    value="{{$socios->fecha_de_transferencia}}">
                                <p class="advertencia-error" id="error-fecha_de_transferencia"></p>
                            </div>
                            <div class="campo-form-control-2">
                                <label for="">Suseción de Derecho<span class="asterisco-label">*</span></label>
                                <input type="text" name="susecion_de_derecho" maxlength="255"
                                    value="{{$socios->susecion_de_derecho}}">
                                <p class="advertencia-error" id="error-susecion_de_derecho"></p>
                            </div>
                        </div>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Transfiriente CC<span class="asterisco-label">*</span></label>
                                <input type="text" name="transfiriente_cc" maxlength="100"
                                    value="{{$socios->transfiriente_cc}}">
                                <p class="advertencia-error" id="error-transfiriente_cc"></p>
                            </div>
                            <div class="campo-form-control-2">
                                <label for="">Parentesco<span class="asterisco-label">*</span></label>
                                <input type="text" name="parentesco" maxlength="100" value="{{$socios->parentesco}}">
                                <p class="advertencia-error" id="error-parentesco"></p>
                            </div>
                        </div>

                        <div class="campo-form-control-area">
                            <label for="">Observación<span class="asterisco-label">*</span></label>
                            <textarea name="observacion" id=""
                                placeholder="Escribe aquí...">{{$socios->observacion}}</textarea>
                            <p class="advertencia-error" id="error-observacion"></p>
                        </div>

                        <div class="container-enviar">
                            <button type="button" class="enviar-reg" id="btn-accion" data-accion='{{$action}}'><i
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
    <script src="{{asset('assets/js/app/Socios.js')}}"></script>
    <script src="{{asset('assets/js/ImagePreview.js')}}?v={{config('constants.VERSION_JS')}}"></script>

    <script src="{{asset('assets/js/CerrarSesion.js')}}?v={{config('constants.VERSION_JS')}}"></script>

</body>

</html>