<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{public_path('assets/css/normalize.css')}}" type="text/css" media="all">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf-ver-historial-personal-planta.css')}}" type="text/css"
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
                        <h2>HISTORIAL DE ANTECEDENTES </h2><small>EMPLEADO DE PLANTA</small>
                    </td>
                </tr>
            </table>

        </header>
        <div class="container-table-informacion">
            <table class="table-informacion">
                <tbody>
                    <tr>
                        <td colspan="3">
                            <h4>REGISTRO N° {{$historial_personal_ep_personal_ep->num_reg}}</h4>
                        </td>

                    </tr>

                    <tr>
                        <td>
                            ESTADO:
                        </td>
                        <td>
                            {{$historial_personal_ep_personal_ep->estado}}
                        </td>
                        <td>
                            <small>FECHA DEL REGISTRO:</small>{{date_format(date_create($historial_personal_ep_personal_ep->fecha),'d/m/Y')}}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            MES :
                        </td>
                        <td>
                            {{$historial_personal_ep_personal_ep->mes}}
                        </td>
                        <td>
                            <small>DIAS:</small> {{$historial_personal_ep_personal_ep->dias}}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            NOMBRE COMPLETO:
                        </td>
                        <td colspan="2">
                            {{$historial_personal_ep_personal_ep->nombres.' '.$historial_personal_ep_personal_ep->apellidos}}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            CARNET DE IDENTIDAD:
                        </td>
                        <td colspan="2">
                            {{$historial_personal_ep_personal_ep->ci}}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            LUGAR DE TRABAJO:
                        </td>
                        <td colspan="2">
                            {{$historial_personal_ep_personal_ep->lugar_de_trabajo}}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            CARGO A DESARROLLAR:
                        </td>
                        <td colspan="2">
                            {{$historial_personal_ep_personal_ep->cargo_a_desarrollar}}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            N° DE EMPLEADO:
                        </td>
                        <td>
                            {{$historial_personal_ep_personal_ep->num_empleado}}
                        </td>
                        <td>
                            <small>FECHA DE INGRESO:</small> {{date_format(date_create($historial_personal_ep_personal_ep->fecha_de_ingreso),'d/m/Y')}}
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
                        <td>{{$historial_personal_ep_personal_ep->descripcion}}</td>
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