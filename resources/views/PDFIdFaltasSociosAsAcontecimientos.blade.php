<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{public_path('assets/css/normalize.css')}}" type="text/css" media="all">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf-id-faltas-socios-as-acontecimientos.css')}}" type="text/css" media="all">


    <title>Cooperativa Chima</title>
</head>

<body>

    <section class="margenes-pdf-all">
        <section class="margenes-pdf">

        </section>
    </section>

    <main class="container-pdf">
        <header class="encabezado">
            <table class="table-titles">
                <tr>
                    <td> <img src="{{public_path('assets/images/logo-minero-1.png')}}" alt=""></td>
                    <td>
                        <h2>COOPERATIVA MINERA CHIMA R.L.</h2><small>Faltas Socios - Asambleas y Acontecimientos</small>
                    </td>
                </tr>
            </table>
        </header>
        <div class="container-numero-registro">
            <h3 class="numero-registro">NOMBRE COMPLETO DEL SOCIO: {{$faltas_socios_as_acontecimientos->nombre_completo_socio}} </h3>
        </div>

        <div class="container-info-all-de-registro">       
            <table class="table-informacion-all">
                <tr>
                    <td>FECHA:</td>
                    <td>{{date_format(date_create($faltas_socios_as_acontecimientos->fecha),'d/m/Y')}}</td>
                </tr>
                <tr>
                    <td>ACONTECIMIENTO.:</td>
                    <td>{{$faltas_socios_as_acontecimientos->acontecimiento}}</td>
                </tr>
                <tr>
                    <td>SANCION GRM.:</td>
                    <td>{{$faltas_socios_as_acontecimientos->sancion_grm}}</td>
                </tr>
                <tr>
                    <td>SANCION BS.:</td>
                    <td>{{$faltas_socios_as_acontecimientos->sancion_bs}}</td>
                </tr>
                <tr>
                    <td>OBSERVACION:</td>
                    <td>{{$faltas_socios_as_acontecimientos->observacion}}</td>
                </tr>
             
            </table>

        </div>
    </main>
</body>

</html>

