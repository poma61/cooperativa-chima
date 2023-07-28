<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{public_path('assets/css/normalize.css')}}" type="text/css" media="all">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf-mantenimiento-equipo-pesado.css')}}" type="text/css"
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
                        <small>COOPERATIVA MINERA CHIMA R.L.</small>
                        <h2> HOJA DE SEGUIMIENTO MANTENIMIENTO-REPARACION</h2>
                    </td>
                </tr>
            </table>

        </header>
        <div class="container-table-informacion">
            <table class="table-informacion">
                <tbody>

                    <tr>
                        <td>NOMBRE COMUN DEL EQUIPO: </td>
                        <td> {{$equipo_pesado->nombre_comun_del_equipo}}</td>

                        <td> AÑO DE COMPRA:</td>
                        <td>{{$equipo_pesado->ano_de_compra}}</td>
                    </tr>

                    <tr>
                        <td>FABRICANTE: </td>
                        <td> {{$equipo_pesado->fabricante}}</td>

                        <td>ESTADO DEL EQUIPO AL MOMENTO DE ALTA:</td>
                        <td>{{$equipo_pesado->estado_del_equipo_al_momento_de_alta}}</td>
                    </tr>

                    <tr>
                        <td>AÑO DE FABRICACION: </td>
                        <td> {{$equipo_pesado->ano_de_fabricacion}}</td>

                        <td>AÑO DE ALTA EN PLANTA:</td>
                        <td>{{$equipo_pesado->ano_de_alta_planta}}</td>
                    </tr>

                    <tr>
                        <td>N° DE SERIE: </td>
                        <td colspan="3"> {{$equipo_pesado->numero_de_serie}}</td>
                    </tr>



                </tbody>
            </table>

        </div>
        <div class="container-table-informacion-all">
            <table class="table-informacion-all">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>FECHA DE INGRESO</th>
                        <th>CARACTERISTICAS</th>
                        <th>DESARROLLO</th>
                        <th>MATERIAL OCUPADO</th>
                        <th>MANTENIMIENTO PREVENTIVO</th>
                        <th>MANTENIMIENTO CORRECTIVO</th>
                        <th>FECHA DE SALIDA</th>
                        <th>OBSERVACION</th>

                    </tr>
                </thead>
                <tbody>

                    @foreach($mantenimiento_equipo_pesado as $row)

                    <tr>
                        <td>{{$row->num_reg}}</td>
                        <td>{{date_format(date_create($row->fecha_de_ingreso),'d/m/Y')}}</td>
                        <td>{{$row->caracteristicas}}</td>
                        <td>{{$row->desarrollo}}</td>
                        <td>{{$row->material_ocupado}}</td>
                        <td>{{$row->mantenimiento_preventivo}}</td>
                        <td>{{$row->mantenimiento_correctivo}}</td>
                        <td>{{date_format(date_create($row->fecha_de_salida),'d/m/Y')}}</td>
                        <td>{{$row->observacion}}</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

            <table class="table-footer-firma">
                <tbody>
                    <tr>
                        <td>
                            --------------------------------------------------- <p>FIRMA: JEFE DE MAQUINA</p>
                        </td>
                        <td>
                            ---------------------------------------------------- <p>FIRMA: MECANICO RESPONSABLE</p>
                        </td>
                    </tr>
                </tbody>
            </table>


    </main>
</body>

</html>

