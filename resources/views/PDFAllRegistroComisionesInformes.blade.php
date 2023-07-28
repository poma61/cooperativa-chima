<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{public_path('assets/css/normalize.css')}}" type="text/css" media="all">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf-all-registro-comisiones-informes.css')}}" type="text/css" media="all">


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
                        <h2>Control de Informes</h2><small>Por Secretaria General</small>
                    </td>
                </tr>
            </table>
        </header>
    
        <div class="container-table-informacion-all">
            <table class="table-informacion-all">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Fecha Recibida</th>
                        <th>Referencia</th>
                        <th>Entregado Por</th>
                        <th>Cargo</th>
                        <th>Fecha de la Comision</th>
                        <th>Descripcion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registro_comisiones_informes as $row)               
                    <tr>
                        <td>{{$row->num_reg}}</td>
                        <td>{{date_format(date_create($row->fecha_recibida),'d/m/Y')}}</td>
                        <td>{{$row->referencia}}</td>
                        <td>{{$row->entregado_por}}</td>
                        <td>{{$row->cargo}}</td>
                        <td>{{date_format(date_create($row->fecha_de_la_comision),'d/m/Y')}}</td>
                        <td>{{$row->descripcion}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>

