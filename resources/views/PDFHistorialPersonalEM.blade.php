<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{public_path('assets/css/normalize.css')}}" type="text/css" media="all">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf-historial-personal-mita.css')}}" type="text/css" media="all">


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
                        <h2>HISTORIAL DE ANTECEDENTES </h2><small>EMPLEADO DE MITA</small>
                    </td>
                </tr>
            </table>

        </header>
        <div class="container-table-informacion">
            <table class="table-informacion">
                <tbody>
                    <tr>
                        <td colspan="3">
                            <h4>REGISTRO N° {{$personal_em->num_empleado}}</h4>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            NOMBRE COMPLETO:
                        </td>
                        <td  colspan="2">
                            {{$personal_em->nombres.' '.$personal_em->apellidos}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            CARNET DE IDENTIDAD:
                        </td>
                        <td colspan="2">
                            {{$personal_em->ci}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            LUGAR DE TRABAJO:
                        </td>
                        <td>
                            {{$personal_em->lugar_de_trabajo}}
                        </td>
                        
                    </tr>
                    <tr>
                        <td>
                            CARGO:
                        </td>
                        <td>
                            {{$personal_em->cargo_a_desarrollar}}
                        </td>
                        
                    </tr>
                    <tr>
                        <td>
                            N° DE EMPLEADO:
                        </td>
                        <td>
                            {{$personal_em->num_empleado}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            FECHA DE INGRESO:
                        </td>
                        <td>
                            {{date_format(date_create($personal_em->fecha_de_ingreso),'d/m/Y')}}
                        </td>
                        
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
                        <th>Estado</th>
                        <th>Mes</th>
                        <th>Dias</th>
                    </tr>
                </thead>
                <tbody>
            
                    @foreach($historial_personal_em as $row)
                
                    <tr>
                        <td>{{$row->num_reg}}</td>
                        <td>{{date_format(date_create($row->fecha),'d/m/Y')}}</td>
                        <td>{{$row->descripcion}}</td>
                        <td>{{$row->estado}}</td>
                        <td>{{$row->mes}}</td>
                        <td>{{$row->dias}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>

