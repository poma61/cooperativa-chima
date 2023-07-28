<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{public_path('assets/css/normalize.css')}}" type="text/css" media="all">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf-id-inventario-secretaria-oficina.css')}}" type="text/css" media="all">


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
                        <h2>COOPERATIVA MINERA CHIMA R.L.</h2><small>Inventario Secretaria - Oficina</small><small>SEGUN INVENTARIO GESTION {{date('Y')}}</small>
                    </td>
                </tr>
            </table>
        </header>
        <div class="container-numero-registro">
            <h3 class="numero-registro">N° DE REGISTRO {{$inventario_secretaria_of->num_reg}} </h3>
        </div>

        <div class="container-info-all-de-registro">
          

            <table class="table-informacion-all">
                <tr>
                    <td>DETALLE:</td>
                    <td>{{$inventario_secretaria_of->detalle}}</td>
                </tr>
                <tr>
                    <td>CANTIDAD:</td>
                    <td>{{$inventario_secretaria_of->cantidad}}</td>
                </tr>
                <tr>
                    <td>ESTADO:</td>
                    <td>{{$inventario_secretaria_of->estado}}</td>
                </tr>
                <tr>
                    <td>OBSERVACION:</td>
                    <td>{{$inventario_secretaria_of->observacion}}</td>
                </tr>
            </table>

        </div>
    </main>
</body>

</html>

