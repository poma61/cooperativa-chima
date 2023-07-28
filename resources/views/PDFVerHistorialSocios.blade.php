<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{public_path('assets/css/normalize.css')}}" type="text/css" media="all">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf-ver-historial-socios.css')}}" type="text/css"
        media="all">


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
                        <h2>HISTORIAL DE ANTECEDENTES </h2><small>SOCIOS</small>
                    </td>
                </tr>
            </table>

        </header>
        <div class="container-table-informacion">
            <table class="table-informacion">
                <tbody>
                    <tr>
                        <td colspan="3">
                            <h4>REGISTRO N° {{$historial_socios_socios->num_reg}}</h4>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            FECHA DEL REGISTRO:
                        </td>
                        <td colspan="2">
                            {{date_format(date_create($historial_socios_socios->fecha),'d/m/Y')}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            TIPO DE DOCUMENTO:
                        </td>
                        <td colspan="2">
                            {{$historial_socios_socios->tipo_de_documento}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            NOMBRE COMPLETO:
                        </td>
                        <td colspan="2">
                            {{$historial_socios_socios->nombres.' '.$historial_socios_socios->apellidos}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            CARNET DE IDENTIDAD:
                        </td>
                        <td colspan="2">
                            {{$historial_socios_socios->ci}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            PUNTA DE TRABAJO:
                        </td>
                        <td>
                            {{$historial_socios_socios->punta_de_trabajo}}
                        </td>
                        <td>AÑOS EN LA COOP: <p>100</p>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
        <div class="container-table-informacion-all">
            <table class="table-informacion-all">
                <tbody>
                    <tr>
                        <td>DESCRIPCION</td>
                    </tr>
                    <tr>
                        <td>{{$historial_socios_socios->descripcion}}</td>
                    </tr>
                   
                    <tr>
                        <td>  

                        </td>
                    </tr>
                   
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>