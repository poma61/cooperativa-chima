<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{public_path('assets/css/normalize.css')}}" type="text/css" media="all">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf-perfil-socios.css')}}" type="text/css" media="all">


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
                        <h2>INFORMACION DEL ASOCIADO </h2><small>Y ORIGEN DE LA ACCION </small>
                    </td>
                </tr>
            </table>

            <table class="table-informacion">
                <tr>
                    <td>
                        <h4>N° DE ITEM:</h4>
                    </td>
                    <td>
                        <h4>{{$socios->num_item}}</h4>
                    </td>
                    <td rowspan="2"><img src="data:image/all;base64,{{base64_encode($socios->imagen)}}" alt=""></td>
                </tr>
                <tr>
                    <td>
                        <h4>ESTADO DEL ASOCIADO:</h4>
                    </td>
                    <td>
                        <h4>{{$socios->estado_del_asociado}}</h4>
                    </td>
                </tr>

            </table>

        </header>

        <div class="container-info-all-de-registro">
            <h3 class="title-informacion-all">INFORMACION DEL ASOCIADO</h3>

            <table class="table-informacion-all">
                
                    <tr>
                        <td>NOMBRES:</td>
                        <td colspan="3">{{$socios->nombres}}</td>
                    </tr>
                    <tr>
                        <td>APELLIDOS:</td>
                        <td colspan="3">{{$socios->apellidos}}</td>
                    </tr>
                    <tr>
                        <td>CARNET DE IDENTIDAD:</td>
                        <td>{{$socios->ci}}</td>
                        <td>VALIDO:</td>
                        <td>{{date_format(date_create($socios->ci_valido),'d/m/Y')}}</td>
                    </tr>
                    <tr>
                        <td>FECHA DE NACIMIENTO:</td>
                        <td colspan="3">{{date_format(date_create($socios->fecha_de_nacimiento),'d/m/Y')}}</td>
                    </tr>
                    <tr>
                        <td>LUGAR DE NACIMIENTO:</td>
                        <td colspan="3">{{$socios->lugar_de_nacimiento}}</td>
                    </tr>
                    <tr>
                        <td>ESTADO CIVIL:</td>
                        <td>{{$socios->estado_civil}}</td>
                        <td>SEXO:</td>
                        <td>{{$socios->sexo}}</td>
                    </tr>
                    <tr>
                        <td>CELULAR DE CONTACTO:</td>
                        <td colspan="3">{{$socios->celular}}</td>
                    </tr>
             
            </table>

            <h3 class="title-informacion-all-2">ORIGEN O PROCEDENCIA DE LA ACCIÓN</h3>

            <table class="table-informacion-all">
                <tbody>
                    <tr>
                        <td>PUNTA DE TRABAJO:</td>
                        <td>{{$socios->punta_de_trabajo}}</td>
                        <td>GRUPO:</td>
                        <td>{{$socios->grupo}}</td>
                    </tr>
                    <tr>
                        <td>FECHA DE TRANSFERENCIA:</td>
                        <td colspan="3">{{date_format(date_create($socios->fecha_de_transferencia),'d/m/Y')}}</td>
                    </tr>
                    <tr>
                        <td>SUSECION DE DERECHO:</td>
                        <td colspan="3">{{$socios->susecion_de_derecho}}</td>
                    </tr>
                    <tr>
                        <td>TRANSFIRIENTE CC:</td>
                        <td colspan="3">{{$socios->transfiriente_cc}}</td>
                    </tr>
                    <tr>
                        <td>PARENTESCO:</td>
                        <td colspan="3">{{$socios->parentesco}}</td>
                    </tr>
                    <tr class="lang-text">
                        <td>OBSERVACION:</td>
                        <td colspan="3">
                            {{$socios->observacion}}

                        </td>
                    </tr>
                </tbody>

            </table>

        </div>
    </main>
</body>

</html>