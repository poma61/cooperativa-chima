<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{public_path('assets/css/normalize.css')}}" type="text/css" media="all">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf-ingreso-almacen.css')}}" type="text/css" media="all">


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
                        <small>Control General </small>
                        <h2>Ingreso Almacen</h2>
                    </td>
                    <td><p>Cooperativa Minera "Chima R.L." </p> </td>
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
                        <th>N° doc.</th>
                        <th>Cantidad</th>
                        <th>UM</th>
                        <th>Costo Unitario</th>
                        <th>Total</th>
                        <th>Descripcion</th>
                        <th>Codigo</th>
                        <th>Marca</th>
                        <th>Proveedor</th>
                        <th>Entregado Por</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($ingreso_almacen as $row)
                    <tr>
                        <td>{{$row->num_reg}}</td>
                        <td>{{$row->n_de_documento}}</td>
                        <td>{{$row->cantidad}}</td>
                        <td>{{$row->um}}</td>
                        <td>{{$row->divisa_costo_unitario." ".number_format($row->costo_unitario,2)}}</td>
                        <td>{{$row->divisa_total." ".number_format($row->total,2)}}</td>
                        <td>{{$row->descripcion}}</td>
                        <td>{{$row->codigo}}</td>
                        <td>{{$row->marca}}</td>
                        <td>{{$row->proveedor}}</td>
                        <td>{{$row->entregado_por}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <table class="table-footer-firma">
            <tbody>
                <tr>
                    <td>
                        Israel Mena <p>JEFE DE ALMACEN</p>
                    </td>

                    <td>
                        Ivan Vargas <p>JEFE DE MAQUINAS</p>
                    </td>

                    <td>
                        Isidoro Saavedra Cuajera <p>PDTE. CONSEJO VIGILANCIA</p>
                    </td>

                </tr>

            </tbody>
        </table>

    </main>
</body>

</html>

