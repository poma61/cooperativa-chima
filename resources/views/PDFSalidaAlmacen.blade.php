<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{public_path('assets/css/normalize.css')}}" type="text/css" media="all">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf-salida-almacen.css')}}" type="text/css" media="all">


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
                        <small>CONTROL GENERAL</small>
                        <h2>DE SALIDAS DE ALMACEN</h2>
                    </td>
                    <td>
                        <p>Cooperativa Minera "Chima R.L." </p>
                    </td>
                </tr>
            </table>
        </header>
        <div class="container-date">
            <p class="container-date__p">FECHA: ................................... de
                .................................. Del 20.......................</p>
        </div>
        <div class="container-table-informacion-all">
            <table class="table-informacion-all">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Cantidad</th>
                        <th>UM</th>
                        <th>Codigo</th>
                        <th>Nombre del articulo</th>
                        <th>Referencia</th>
                        <th>Destino / Sector</th>
                        <th>Entregado por</th>
                        <th>Autorizado por</th>
                        <th>Interesado</th>
                        <th>firma</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salida_almacen as $row)
                    <tr>
                        <td>{{$row->num_reg}}</td>
                        <td>{{$row->cantidad}}</td>
                        <td>{{$row->um}}</td>
                        <td>{{$row->codigo}}</td>
                        <td>{{$row->nombre_del_articulo}}</td>
                        <td>{{$row->referencia}}</td>
                        <td>{{$row->destino_sector}}</td>
                        <td>{{$row->entregado_por}}</td>
                        <td>{{$row->autorizado_por}}</td>
                        <td>{{$row->interesado}}</td>
                        <td><img src="data:image/all;base64,{{base64_encode($row->firma)}}" alt=""></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <table class="table-footer-firma">
            <tbody>
                <tr>
                    <td>
                        Israel Mena Vargas<p>JEFE DE ALMACEN</p>
                    </td>
                    <td>
                        Ivan Vargas <p>JEFE DE MAQUINAS</p>
                    </td>
                </tr>

            </tbody>
        </table>

    </main>
</body>

</html>