<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{public_path('assets/css/normalize.css')}}" type="text/css" media="all">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf-id-registro-ac-entrega-doc.css')}}" type="text/css" media="all">


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
                        <h2>COOPERATIVA MINERA CHIMA R.L.</h2><small>Control de Actas Entrega de Documentacion</small>
                    </td>
                </tr>
            </table>
        </header>
        <div class="container-numero-registro">
            <h3 class="numero-registro">N° DE REGISTRO {{$registro_ac_entrega_doc->num_reg}} </h3>
        </div>

        <div class="container-info-all-de-registro">
          

            <table class="table-informacion-all">

                <tr>
                    <td>FECHA EMITIDA:</td>
                    <td>{{date_format(date_create($registro_ac_entrega_doc->fecha_emitida),'d/m/Y')}}</td>
                </tr>
                <tr>
                    <td>REFERENCIA:</td>
                    <td>{{$registro_ac_entrega_doc->referencia}}</td>
                </tr>
                <tr>
                    <td>DESCRIPCION:</td>
                    <td>{{$registro_ac_entrega_doc->descripcion}}</td>
                </tr>
                <tr>
                    <td>INSTITUCION/RESPONSABLE:</td>
                    <td>{{$registro_ac_entrega_doc->institucion_responsable}}</td>
                </tr>
                <tr>
                    <td>OBSERVACION:</td>
                    <td>{{$registro_ac_entrega_doc->observacion}}</td>
                </tr>
            </table>

        </div>
    </main>
</body>

</html>

