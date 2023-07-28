<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{public_path('assets/css/normalize.css')}}" type="text/css" media="all">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf-all-registro-ac-libro-de-alzas.css')}}" type="text/css" media="all">


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
                        <h2>Control de Libro De Alzas</h2><small>Por Secretaria General</small>
                    </td>
                </tr>
            </table>
        </header>

        <div class="container-table-informacion-all">
            <table class="table-informacion-all">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Fecha Emitida</th>
                        <th>Referencia</th>
                        <th>Descripcion</th>
                        <th>Alza de</th>
                        <th>Peso Oro Fisico</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $total_peso=0;
                    $simbolo='';
                    @endphp
                    @foreach($registro_ac_libro_de_alzas as $row)
                    <tr>
                        <td>{{$row->num_reg}}</td>
                        <td>{{date_format(date_create($row->fecha_emitida),'d/m/Y')}}</td>
                        <td>{{$row->referencia}}</td>
                        <td>{{$row->descripcion}}</td>
                        <td>{{$row->alza_de}}</td>
                        <td>{{number_format($row->peso_oro_fisico,2).' '.$row->simbolo}}</td>
                    </tr>
                    @php
                    $total_peso=$total_peso+$row->peso_oro_fisico;
                    $simbolo=$row->simbolo;
                    @endphp
                    @endforeach
                    <!-- total del peso oro fisico -->
                    <tr>
                    <td colspan="5" style="text-align:right;">TOTAL PESO ORO FISICO:</td>
                        <td>{{number_format($total_peso,2).' '.$simbolo}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>