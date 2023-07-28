<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{public_path('assets/css/normalize.css')}}" type="text/css" media="all">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf-all-inventario-secretaria-oficina.css')}}" type="text/css" media="all">


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
                        <h2>INVENTARIO SECRETARIA - OFICINA</h2><small>SEGUN INVENTARIO GESTION {{date('Y')}}</small> 
                    </td>
                </tr>
            </table>
        </header>
    
        <div class="container-table-informacion-all">
            <table class="table-informacion-all">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Detalle</th>
                        <th>Cantidad</th>
                        <th>Estado</th>
                        <th>Observacion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inventario_secretaria_of as $row)               
                    <tr>
                        <td>{{$row->num_reg}}</td>
                        <td>{{$row->detalle}}</td>
                        <td>{{$row->cantidad}}</td>
                        <td>{{$row->estado}}</td>
                        <td>{{$row->observacion}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>

