<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{public_path('assets/css/normalize.css')}}" type="text/css" media="all">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf-id-documentacion-pdte-csjo-admin.css')}}" type="text/css" media="all">


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
                        <h2>COOPERATIVA MINERA CHIMA R.L.</h2><small>Inventario de Documentacion - Pdte. Csjo. Administracion</small><small>GESTION {{date('Y')}}</small>
                    </td>
                </tr>
            </table>
        </header>
        <div class="container-numero-registro">
            <h3 class="numero-registro">N° DE REGISTRO {{$doc_pdte_csjo_admin->num_reg}} </h3>
        </div>

        <div class="container-info-all-de-registro">
          

            <table class="table-informacion-all">
                <tr>
                    <td>DETALLE:</td>
                    <td>{{$doc_pdte_csjo_admin->detalle}}</td>
                </tr>
                <tr>
                    <td>CANTIDAD:</td>
                    <td>{{$doc_pdte_csjo_admin->cantidad}}</td>
                </tr>
                <tr>
                    <td>RUBRO:</td>
                    <td>{{$doc_pdte_csjo_admin->rubro}}</td>
                </tr>
                <tr>
                    <td>OBSERVACION:</td>
                    <td>{{$doc_pdte_csjo_admin->observacion}}</td>
                </tr>
            </table>

        </div>
    </main>
</body>

</html>

