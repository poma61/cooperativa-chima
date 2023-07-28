<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{public_path('assets/css/normalize.css')}}" type="text/css" media="all">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf-all-faltas-socios-as-acontecimientos.css')}}" type="text/css" media="all">


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
                        <h2>LISTA DE FALTAS SOCIOS EN ASAMBLEAS Y ACONTECIMIENTOS</h2>
                    </td>
                </tr>
            </table>
        </header>
    
        <div class="container-table-informacion-all">
            <table class="table-informacion-all">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Fecha</th>
                        <th>Acontecimiento</th>
                        <th>Socio</th>
                        <th>Sancion Grm.</th>
                        <th>Sancion Bs.</th>
                        <th>Observacion</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                    $total_sancion_grm=0;
                    $total_sancion_bs=0;
                    $num=1;
                    @endphp
                    @foreach($faltas_socios_as_acontecimientos as $row)               
                    <tr>
                        <td>{{$num}}</td>
                        <td>{{date_format(date_create($row->fecha),'d/m/Y')}}</td>
                        <td>{{$row->acontecimiento}}</td>
                        <td>{{$row->nombres." ".$row->apellidos}}</td>
                        <td>{{number_format($row->sancion_grm,2)}}</td>
                        <td>{{number_format($row->sancion_bs,2)}}</td>
                        <td>{{$row->observacion}}</td>
                    </tr>

                    @php 
                    $total_sancion_grm=$total_sancion_grm+$row->sancion_grm;
                    $total_sancion_bs=$total_sancion_grm+$row->sancion_bs;
                    $num++;
                    @endphp
                    @endforeach
                </tbody>
                <tr>
                    <td colspan="4">MONTO A COBRAR EN ORO FISICO</td>
                    <td>{{number_format($total_sancion_grm,2)}}</td>
                    <td>{{number_format($total_sancion_bs,2)}}</td>
                    <td></td>
                </tr>
            </table>
        </div>
    </main>
</body>

</html>

