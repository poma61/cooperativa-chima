<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{public_path('assets/css/normalize.css')}}" type="text/css" media="all">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf-ver-registro-correspondencias-emi.css')}}" type="text/css" media="all">


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
                        <h2>Registro de Correspondencias Emitidas</h2>
                    </td>
                </tr>
            </table>

            <table class="table-informacion">
                <tr>
                    <td>
                        <h4>N° DE REGISTRO:</h4>
                    </td>
                    <td>
                        <h4>{{$registro_correspondencias_emi->num_reg}}</h4>
                    </td>
                  
                </tr>
                <tr>
                    <td>
                        <h4>FECHA EMITIDA:</h4>
                    </td>
                    <td>
                        <h4>{{date_format(date_create($registro_correspondencias_emi->fecha_emitida),'d/m/Y')}}</h4>
                    </td>
                </tr>

            </table>

        </header>

        <div class="container-info-all-de-registro">
            <h3 class="title-informacion-all">INFORMACIÓN</h3>

            <table class="table-informacion-all">
                
                    <tr>
                        <td>REFERENCIA:</td>
                        <td >{{$registro_correspondencias_emi->referencia}}</td>
                    </tr>
                    <tr>
                        <td>ENTREGAD A:</td>
                        <td>{{$registro_correspondencias_emi->entregado_a}}</td>
                    </tr>
                    <tr>
                        <td>CARGO:</td>
                        <td >{{$registro_correspondencias_emi->cargo}}</td>
                    </tr>
                    <tr>
                        <td>FECHA RECIBIDA:</td>
                        <td >{{date_format(date_create($registro_correspondencias_emi->fecha_recibida),'d/m/Y')}}</td>
                    </tr>
                    <tr>
                        <td>OBSERVACION:</td>
                        <td >{{$registro_correspondencias_emi->observacion}}</td>
                    </tr>
                    <tr>
                        <td>FECHA DE RESPUESTA:</td>
                        <td>{{date_format(date_create($registro_correspondencias_emi->fecha_de_respuesta),'d/m/Y')}}</td>
                    </tr>
                    <tr>
                        <td>DESCRIPCION:</td>
                        <td>{{$registro_correspondencias_emi->descripcion}}</td>    
                    </tr>

            </table>

        </div>
    </main>
</body>

</html>
