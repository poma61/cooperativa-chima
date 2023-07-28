<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{public_path('assets/css/normalize.css')}}" type="text/css" media="all">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf-perfil-personal.css')}}" type="text/css" media="all">


    <title>Cooperativa Chima</title>
</head>

<body>

    <section class="margenes-pdf-all">
        <section class="margenes-pdf">
        </section>
    </section>

    <main class="container-pdf">

        <div class="title-bissnes">
            <h3> COOPERATIVA MINERA CHIMA R.L. </h3>
        </div>
        <header class="encabezado">
            <table class="table-titles">
                <tr>
                    <td> <img src="{{public_path('assets/images/logo-minero-1.png')}}" alt=""></td>
                    <td>
                        <h2>INFORMACION DEL EMPLEADO </h2>
                    </td>
                </tr>
            </table>

            <table class="table-informacion">
                <tr>
                    <td>
                        <h4>N° DE ENPLEADO:</h4>
                    </td>
                    <td>
                        <h4>{{$personal_em->num_empleado}}</h4>
                    </td>
                    <td rowspan="2"><img src="data:image/all;base64,{{base64_encode($personal_em->imagen)}}" alt=""></td>
                </tr>
                <tr>
                    <td>
                        <h4>ESTADO DEL EMPLEADO:</h4>
                    </td>
                    <td>
                        <h4>{{$personal_em->estado_del_empleado}}</h4>
                    </td>
                </tr>

            </table>

        </header>

        <div class="container-info-all-de-registro">
            <h3 class="title-informacion-all">EMPLEADO DE MITA</h3>

            <table class="table-informacion-all">
                
                    <tr>
                        <td>NOMBRES:</td>
                        <td colspan="3">{{$personal_em->nombres}}</td>
                    </tr>
                    <tr>
                        <td>APELLIDOS:</td>
                        <td colspan="3">{{$personal_em->apellidos}}</td>
                    </tr>
                    <tr>
                        <td>CARNET DE IDENTIDAD:</td>
                        <td>{{$personal_em->ci}}</td>
                        <td>VALIDO:</td>
                        <td>{{date_format(date_create($personal_em->ci_valido),'d/m/Y')}}</td>
                    </tr>
                    <tr>
                        <td>FECHA DE NACIMIENTO:</td>
                        <td colspan="3">{{date_format(date_create($personal_em->fecha_de_nacimiento),'d/m/Y')}}</td>
                    </tr>
                    <tr>
                        <td>LUGAR DE NACIMIENTO:</td>
                        <td colspan="3">{{$personal_em->lugar_de_nacimiento}}</td>
                    </tr>
                    <tr>
                        <td>PROFESION:</td>
                        <td colspan="3">{{$personal_em->profesion_ocupacion}}</td>
                    </tr>
                    <tr>
                        <td>ESTADO CIVIL:</td>
                        <td>{{$personal_em->estado_civil}}</td>
                        <td>SEXO:</td>
                        <td>{{$personal_em->sexo}}</td>
                    </tr>
                    <tr>
                        <td>LICENCIA DE CONDUCIR:</td>
                        <td>{{$personal_em->licencia_de_conducir}}</td>
                        <td>VALIDO:</td>
                        <td>{{date_format(date_create($personal_em->licencia_de_conducir_valido),'d/m/Y')}}</td>
                    </tr>
                    <tr>
                        <td>CELULAR DE CONTACTO:</td>
                        <td colspan="3">{{$personal_em->celular}}</td>
                    </tr>
                    <tr>
                        <td>LUGAR DE TRABAJO</td>
                        <td colspan="3">{{$personal_em->lugar_de_trabajo}}</td>
                    </tr>
             
                    <tr>
                        <td>FECHA DE INGRESO</td>
                        <td colspan="3">{{date_format(date_create($personal_em->fecha_de_ingreso),'d/m/Y')}}</td>
                    </tr>
                    <tr>
                        <td>CARGO A DESARROLLAR</td>
                        <td colspan="3">{{$personal_em->cargo_a_desarrollar}}</td>
                    </tr>
                    <tr>
                        <td>HABER  BASICO</td>
                        <td colspan="3">{{$personal_em->divisa.' '.number_format($personal_em->haber_basico,2)}}</td>
                    </tr>
                    <tr>
                        <td>ULTIMA VACACION</td>
                        <td colspan="3">{{$personal_em->ultima_vacacion}}</td>
                    </tr>
                    <tr>
                        <td>FECHA DE RETIRO</td>
                        @if($personal_em->fecha_de_retiro==null)
                        <td colspan="3">Si fecha de retiro</td>
                        @else
                        <td colspan="3">{{date_format(date_create($personal_em->fecha_de_retiro),'d/m/Y')}}</td>
                        @endif
                    </tr>
                    <tr>
                        <td>ESTADO DE RETIRO</td>
                        <td colspan="3">{{$personal_em->estado_de_retiro}}</td>
                    </tr>
                    <tr >
                        <td>OBSERVACIÓN</td>
                        <td colspan="3" class="lang-text">{{$personal_em->observacion}}</td>
                    </tr>
            </table>

        </div>
    </main>
</body>

</html>
