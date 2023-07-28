<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{public_path('assets/css/normalize.css')}}" type="text/css" media="all">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf-historial-socios.css')}}" type="text/css" media="all">


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
                            <h4>REGISTRO N° {{$socios->num_item}}</h4>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            NOMBRE COMPLETO:
                        </td>
                        <td  colspan="2">
                            {{$socios->nombres.' '.$socios->apellidos}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            CARNET DE IDENTIDAD:
                        </td>
                        <td colspan="2">
                            {{$socios->ci}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            PUNTA DE TRABAJO:
                        </td>
                        <td>
                            {{$socios->punta_de_trabajo}}
                        </td>
                        <td>AÑOS EN LA COOP: <p>......</p> </td>
                    </tr>
                </tbody>
            </table>

        </div>
        <div class="container-table-informacion-all">
            <table class="table-informacion-all">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Fecha</th>
                        <th>Descripcion</th>
                        <th>Tipo de Documento</th>
                    </tr>
                </thead>
                <tbody>
            
                    @foreach($historial_socios as $row)
                
                    <tr>
                        <td>{{$row->num_reg}}</td>
                        <td>{{date_format(date_create($row->fecha),'d/m/Y')}}</td>
                        <td>{{$row->descripcion}}</td>
                        <td>{{$row->tipo_de_documento}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>

