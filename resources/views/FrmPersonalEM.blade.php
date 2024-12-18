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
                    Cooperativa Minera Chima R.L. | <span class="texto-full">Personal</span>
                </h2>

                <!-- menu opciones-->
                @include('components/menu_opciones/menuOptionPersonal')

                <div class="title-info">Registrar Empleado de Mita</div>
                <!-- formulario-->
                <div class="container-form">
                    <h3 class="title-form-control">Formulario | Empleado de Mita</h3>
                    <p>Los campos marcados con (*) son obligatorios</p>

                    <form action="" class="mi-form-control" id="mi-form">

                        @if($personal_em->id!=0)
                        <input type="hidden" value="{{Crypt::encrypt($personal_em->id)}}" name="id-reg">
                        @endif
                        <p class="form-aviso-campos"><i class="zmdi zmdi-label"></i> INFORMACION DEL EMPLEADO</p>

                        <div class="campo-form-control">
                            <label for="">N° de Empleado<span class="advertencia-error">*</span></label>
                            @if($personal_em->id==0)
                            <input type="number" name="n-empleado" value="{{str_pad($num_registro,5,'0',STR_PAD_LEFT)}}"
                                disabled>
                            @else
                            <input type="number" name="n-empleado" value="{{$personal_em->num_empleado}}" disabled>
                            @endif
                        </div>

                        <div class="campo-form-control">
                            <label for="">Estado del Empleado<span class="asterisco-label">*</span></label>
                            <input type="text" name="estado_del_empleado" value="{{$personal_em->estado_del_empleado}}">
                            <p class="advertencia-error" id="error-estado_del_empleado"></p>
                        </div>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Nombres<span class="asterisco-label">*</span></label>
                                <input type="text" name="nombres" maxlength="150" value="{{$personal_em->nombres}}">
                                <p class="advertencia-error" id="error-nombres"></p>
                            </div>
                            <div class="campo-form-control-2">
                                <label for="">Apellidos<span class="asterisco-label">*</span></label>
                                <input type="text" name="apellidos" maxlength="150" value="{{$personal_em->apellidos}}">
                                <p class="advertencia-error" id="error-apellidos"></p>
                            </div>
                        </div>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Carnet de Identidad<span class="asterisco-label">*</span></label>
                                <input type="text" name="ci" maxlength="150" value="{{$personal_em->ci}}">
                                <p class="advertencia-error" id="error-ci"></p>
                            </div>
                            <div class="campo-form-control-2">
                                <label for="">Carnet Valido Hasta<span class="asterisco-label">*</span></label>
                                <input type="date" name="ci_valido" value="{{$personal_em->ci_valido}}">
                                <p class="advertencia-error" id="error-ci_valido"></p>
                            </div>
                        </div>

                        <div class="campo-form-control">
                            <label for="">Fecha de Nacimiento<span class="asterisco-label">*</span></label>
                            <input type="date" name="fecha_de_nacimiento" value="{{$personal_em->fecha_de_nacimiento}}">
                            <p class="advertencia-error" id="error-fecha_de_nacimiento"></p>
                        </div>

                        <div class="campo-form-control">
                            <label for="">Lugar de Nacimiento<span class="asterisco-label">*</span></label>
                            <input type="text" name="lugar_de_nacimiento" maxlength="150"
                                value="{{$personal_em->lugar_de_nacimiento}}">
                            <p class="advertencia-error" id="error-lugar_de_nacimiento"></p>
                        </div>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Profesión / Ocupación<span class="asterisco-label">*</span></label>
                                <input type="text" name="profesion_ocupacion" maxlength="150"
                                    value="{{$personal_em->profesion_ocupacion}}">
                                <p class="advertencia-error" id="error-profesion_ocupacion"></p>
                            </div>

                            <div class="campo-form-control-2">
                                <label for="">Estado Civil<span class="asterisco-label">*</span></label>
                                <input type="text" name="estado_civil" maxlength="100"
                                    value="{{$personal_em->estado_civil}}">
                                <p class="advertencia-error" id="error-estado_civil"></p>
                            </div>
                        </div>

                        <div class="campo-form-control">
                            <label for="">Sexo<span class="advertencia-error">*</span></label>
                            <select name="sexo" id="">
                                <option value="">--Seleccionar--</option>
                                <option value="Hombre" @if($personal_em->sexo=="Hombre") selected @endif >Hombre
                                </option>
                                <option value="Mujer" @if($personal_em->sexo=="Mujer") selected @endif >Mujer</option>
                            </select>
                            <p class="advertencia-error" id="error-sexo"></p>
                        </div>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Licencia de Conducir<span class="asterisco-label">*</span></label>
                                <input type="text" name="licencia_de_conducir"
                                    value="{{$personal_em->licencia_de_conducir}}">
                                <p class="advertencia-error" id="error-licencia_de_conducir"></p>
                            </div>

                            <div class="campo-form-control-2">
                                <label for="">Valido Hasta<span class="asterisco-label">*</span></label>
                                <input type="date" name="licencia_de_conducir_valido"
                                    value="{{$personal_em->licencia_de_conducir_valido}}">
                                <p class="advertencia-error" id="error-licencia_de_conducir_valido"></p>
                            </div>
                        </div>

                        <div class="campo-form-control">
                            <label for="">Celular de Contacto<span class="asterisco-label">*</span></label>
                            <input type="number" name="celular" min="1" value="{{$personal_em->celular}}">
                            <p class="advertencia-error" id="error-celular"></p>
                        </div>

                        <div class="campo-form-control">
                            <label for="">Lugar de Trabajo<span class="advertencia-error">*</span></label>
                            <select name="lugar_de_trabajo" id="">
                                <option value="">--Seleccionar--</option>
                                <option value="Taller Cerro" @if($personal_em->lugar_de_trabajo=="Taller Cerro")
                                    selected @endif >Taller Cerro</option>

                                <option value="Taller" @if($personal_em->lugar_de_trabajo=="Taller") selected @endif
                                    >Taller</option>

                                <option value="Pukaloma" @if($personal_em->lugar_de_trabajo=="Pukaloma") selected @endif
                                    >Pukaloma</option>

                                <option value="Pukaloma oficina" @if($personal_em->lugar_de_trabajo=="Pukaloma oficina")
                                    selected @endif >Pukaloma oficina</option>

                                <option value="Oficina" @if($personal_em->lugar_de_trabajo=="Oficina") selected @endif
                                    >Oficina</option>

                                <option value="Administracion" @if($personal_em->lugar_de_trabajo=="Administracion")
                                    selected @endif
                                    >Administracion</option>

                                <option value="Sin especificar" @if($personal_em->lugar_de_trabajo=="Sin especificar")
                                    selected @endif >Sin especificar</option>

                                <option value="Ninguno" @if($personal_em->lugar_de_trabajo=="Ninguno") selected @endif
                                    >Ninguno</option>

                                <option value="Otros" @if($personal_em->lugar_de_trabajo=="Otros") selected @endif
                                    >Otros</option>
                                @php
                                $txt_long="Sin lugar de trabajo";
                                @endphp
                                <option value="Sin lugar de trabajo" @if($personal_em->lugar_de_trabajo==$txt_long)
                                    selected @endif>Sin lugar de trabajo</option>

                            </select>
                            <p class="advertencia-error" id="error-lugar_de_trabajo"></p>
                        </div>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Fecha de Ingreso<span class="asterisco-label">*</span></label>
                                <input type="date" name="fecha_de_ingreso" value="{{$personal_em->fecha_de_ingreso}}">
                                <p class="advertencia-error" id="error-fecha_de_ingreso"></p>
                            </div>

                            <div class="campo-form-control-2">
                                <label for="">Cargo a Desarrollar<span class="asterisco-label">*</span></label>
                                <input type="text" name="cargo_a_desarrollar" maxlength="250"
                                    value="{{$personal_em->cargo_a_desarrollar}}">
                                <p class="advertencia-error" id="error-cargo_a_desarrollar"> </p>
                            </div>
                        </div>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Haber Basico<span class="asterisco-label">*</span></label>
                                <input type="number" name="haber_basico" step="0.01"
                                    value="{{$personal_em->haber_basico,}}">
                                <p class="advertencia-error" id="error-haber_basico"></p>
                            </div>

                            <div class="campo-form-control-2">
                                <label for="">Divisa<span class="asterisco-label">*</span></label>
                                <input type="text" name="divisa" maxlength="100" value="{{$personal_em->divisa}}">
                                <p class="advertencia-error" id="error-divisa"> </p>
                            </div>
                        </div>

                        <div class="form-control-colum-2">
                            <div class="campo-form-control-2">
                                <label for="">Ultima Vacacion<span class="asterisco-label">*</span></label>
                                <input type="text" name="ultima_vacacion" maxlength="150"
                                    value="{{$personal_em->ultima_vacacion}}">
                                <p class="advertencia-error" id="error-ultima_vacacion"></p>
                            </div>

                            <div class="campo-form-control-2">
                                <label for="">Fecha de Retiro<span class="asterisco-label">*</span></label>
                                <input type="date" name="fecha_de_retiro" value="{{$personal_em->fecha_de_retiro}}">
                            </div>
                        </div>


                        <div class="campo-form-control">
                            <label for="">Estado de Retiro<span class="asterisco-label">*</span></label>
                            <select name="estado_de_retiro" id="">
                                <option value="">--Seleccionar--</option>
                                <option value="Renuncia voluntaria" @if($personal_em->estado_de_retiro=="Renuncia
                                    voluntaria") selected @endif >Renuncia voluntaria</option>

                                <option value="Abandono" @if($personal_em->estado_de_retiro=="Abandono") selected @endif
                                    >Abandono</option>

                                <option value="Despido" @if($personal_em->estado_de_retiro=="Despido") selected @endif
                                    >Despido</option>

                                <option value="Otro motivo" @if($personal_em->estado_de_retiro=="Otro motivo") selected
                                    @endif >Otro motivo</option>

                                <option value="Ninguno" @if($personal_em->estado_de_retiro=="Ninguno") selected @endif
                                    >Ninguno</option>

                                <option value="Otros" @if($personal_em->estado_de_retiro=="Otros") selected @endif
                                    >Otros</option>

                                <option value="Sin especificar" @if($personal_em->estado_de_retiro=="Sin especificar")
                                    selected @endif >Sin especificar</option>
                                @php
                                $txt_long="Sin estado de retiro";
                                @endphp
                                <option value="Sin estado de retiro" @if($personal_em->estado_de_retiro==$txt_long)
                                    selected @endif >Sin estado de retiro</option>
                            </select>
                            <p class="advertencia-error" id="error-estado_de_retiro"> </p>
                        </div>

                        <div class="campo-form-control-area">
                            <label for="">Observación<span class="asterisco-label">*</span></label>
                            <textarea name="observacion">{{$personal_em->observacion}}</textarea>
                            <p class="advertencia-error" id="error-observacion"> </p>
                        </div>


                        <div class="campo-form-control">
                            <label>Imagen<span class="asterisco-label">*</span></label>
                            <input type="file" name="imagen" id="seleccionar-archivo">
                            <label for="seleccionar-archivo" class="file-btn">Seleccionar <i
                                    class="zmdi zmdi-attachment-alt"></i></label>
                            <p class="advertencia-error" id="error-imagen"></p>
                        </div>

                        <div class="image-pre-view">
                            @if($personal_em->imagen==null)
                            <img src="{{asset('assets/images/image-preview.png')}}" alt="imagen socio"
                                id="vista-previa">
                            @else
                            <img src="data:image/all;base64,{{base64_encode($personal_em->imagen)}}" alt="imagen socio"
                                id="vista-previa">
                            @endif
                        </div>

                        <div class="container-enviar">
                            <button type="button" class="enviar-reg" id="btn-accion" data-accion="{{$action}}"><i
                                    class="zmdi zmdi-dialpad"></i> Enviar</button>
                        </div>
                    </form>

                </div>

            </main>
            <!-- Contenido-->
            <div class="overlay">
            </div>
        </div>
    </div>



    <script src="{{asset('assets/js/app/PersonalEM.js')}}?v={{config('constants.VERSION_JS')}}"></script>
    <script src="{{asset('assets/js/ImagePreview.js')}}?v={{config('constants.VERSION_JS')}}"></script>

    <script src="{{asset('assets/js/UnpkgSideBar.js')}}"></script>
    <script src="{{asset('assets/js/sidebar.js')}}"></script>
    <script src="{{asset('assets/js/CerrarSesion.js')}}?v={{config('constants.VERSION_JS')}}"></script>
</body>


</html>