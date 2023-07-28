<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{public_path('assets/css/normalize.css')}}" type="text/css" media="all">
    <link rel="stylesheet" href="{{public_path('assets/css/pdf-ver-equipo-pesado.css')}}" type="text/css" media="all">


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
                    <td>
                        <img src="{{public_path('assets/images/logo-minero-1.png')}}" alt="">
                    </td>
                    <td>
                        <small>COOPERATIVA MINERA CHIMA R.L.</small>
                        <h2>FORMULARIO DE REGISTRO Y DESCRIPCION DE EQUIPO PESADO</h2>
                    </td>
                    <td>
                        <div class="content-info-page">
                            <p>CODIGO DOC</p>
                            <p>REVISION</p>
                            <p>VIGENTE DESDE {{date('Y')}}</p>
                            <p>PAGINA 1 de 1</p>

                        </div>
                    </td>
                </tr>
            </table>

        </header>

        <div class="container-info-all-de-registro">
            <h3 class="title-informacion-all">DATOS GENERALES</h3>

            <table class="table-informacion-all">
                <tr>
                    <td>NOMBRE COMUN DEL EQUIPO:</td>
                    <td colspan="3">{{$equipo_pesado->nombre_comun_del_equipo}}</td>
                </tr>
                <tr>
                    <td>CODIGO DE INVENTARIO INTERNO:</td>
                    <td colspan="3">{{$equipo_pesado->codigo_de_inventario_interno}}</td>
                </tr>

            </table>

            <table class="table-informacion-all">
                <tbody>

                    <tr class="sub-title-informacion-all">
                        <td colspan="2">
                            <h3 class="sub-title">DATOS DE ORIGEN</h3>
                        </td>
                        <td>
                            <h3 class="sub-title-2">REGISTRO FOTOGRAFICO</h3>
                        </td>
                    </tr>

                    <tr>
                        <td>FABRICANTE:</td>
                        <td>{{$equipo_pesado->fabricante}}</td>

                        <td rowspan="13" class="content-image">

                            <img src="data:image/all;base64,{{base64_encode($equipo_pesado->archivo)}}" alt="">
                        </td>
                    </tr>

                    <tr>
                        <td>AÑO VENCIMIENTO DE GARANTIA:</td>
                        <td>{{$equipo_pesado->ano_vencimiento_de_garantia}}</td>
                    </tr>

                    <tr>
                        <td>AÑO DE FABRICACION:</td>
                        <td>{{$equipo_pesado->ano_de_fabricacion}}</td>
                    </tr>

                    <tr>
                        <td>PAIS DE ORIGEN:</td>
                        <td>{{$equipo_pesado->pais_de_origen}}</td>
                    </tr>

                    <tr>
                        <td>MODELO:</td>
                        <td>{{$equipo_pesado->modelo}}</td>
                    </tr>
                    <tr>
                        <td>NUMERO DE SERIE:</td>
                        <td>{{$equipo_pesado->numero_de_serie}}</td>
                    </tr>

                    <tr>
                        <td>AÑO DE COMPRA:</td>
                        <td>{{$equipo_pesado->ano_de_compra}}</td>
                    </tr>

                    <tr class="sub-title-informacion-all">
                        <td colspan="2">
                            <h3 class="sub-title">DATOS DE USO EN PLANTA</h3>
                        </td>
                    </tr>

                    <tr>
                        <td>AÑO DE ALTA PLANTA:</td>
                        <td>{{$equipo_pesado->ano_de_alta_planta}}</td>
                    </tr>

                    <tr>
                        <td>ESTADO DEL EQUIPO AL MOMENTO DE ALTA:</td>
                        <td>{{$equipo_pesado->estado_del_equipo_al_momento_de_alta}}</td>
                    </tr>

                    <tr>
                        <td>HOROMETRO AL INICIO OPERACION PLANTA:</td>
                        <td>{{$equipo_pesado->horometro_al_inicio_operacion_planta}}</td>
                    </tr>
                    <tr>
                        <td>LINEA DE PRODUCCION ASIGNADA:</td>
                        <td>{{$equipo_pesado->linea_de_produccion_asignada}}</td>
                    </tr>

                    <tr>
                        <td>UBICACION:</td>
                        <td>{{$equipo_pesado->ubicacion}}</td>
                    </tr>

                </tbody>

            </table>
            <h3 class="title-informacion-all">DATOS TECNICOS</h3>
            <table class="table-informacion-all">
                <thead>
                    <tr>
                        <th>CARACTERISTICAS</th>
                        <th>Und.</th>
                        <th>Valor Nominal</th>
                        <th>
                            Cracateristicas - Observaciones especiales <p>(incluir adaptaciones o modificaciones)</p>
                        </th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>POTENCIA:</td>
                        <td>{{$equipo_pesado->potencia_und}}</td>
                        <td>{{$equipo_pesado->potencia_valor_nominal}}</td>
                        <td>{{$equipo_pesado->potencia_caracteristicas}}</td>

                    </tr>

                    <tr>
                        <td>VOLTAJE:</td>
                        <td>{{$equipo_pesado->voltaje_und}}</td>
                        <td>{{$equipo_pesado->voltaje_valor_nominal}}</td>
                        <td>{{$equipo_pesado->voltaje_caracteristicas}}</td>
                    </tr>

                    <tr>
                        <td>CORRIENTE:</td>
                        <td>{{$equipo_pesado->corriente_und}}</td>
                        <td>{{$equipo_pesado->corriente_valor_nominal}}</td>
                        <td>{{$equipo_pesado->corriente_caracteristicas}}</td>
                    </tr>


                    <tr>
                        <td>CAPACIDAD DE CUCHARON:</td>
                        <td>{{$equipo_pesado->capacidad_de_cucharon_und}}</td>
                        <td>{{$equipo_pesado->capacidad_de_cucharon_valor_nominal}}</td>
                        <td>{{$equipo_pesado->capacidad_de_cucharon_caracteristicas}}</td>
                    </tr>

                    <tr>
                        <td>CAPACIDAD DE DIESEL:</td>
                        <td>{{$equipo_pesado->capacidad_de_diesel_und}}</td>
                        <td>{{$equipo_pesado->capacidad_de_diesel_valor_nominal}}</td>
                        <td>{{$equipo_pesado->capacidad_de_diesel_caracteristicas}}</td>
                    </tr>

                    <tr>
                        <td>OTROS (Especificar):</td>
                        <td>{{$equipo_pesado->otros_und}}</td>
                        <td>{{$equipo_pesado->otros_valor_nominal}}</td>
                        <td>{{$equipo_pesado->otros_caracteristicas}}</td>
                    </tr>

                </tbody>
            </table>
            <h3 class="title-informacion-all">DISPONIBILIDAD DE INFORMACION DE SOPORTE TECNICO</h3>
            <table class="table-informacion-all">
                <tbody>
                    <tr>
                        <td>MANUALES IMPRESOS:</td>
                        <td>{{$equipo_pesado->manuales_impresos}}</td>
                        <td class="cell-personalizado">PLANOS MECANICOS DIGITALES:</td>
                        <td>{{$equipo_pesado->planos_mecanicos_digitales}}</td>
                    </tr>
                    <tr>
                        <td>MANUALES DIGITALES:</td>
                        <td class="text-color-100">Archivo PDF</td>
                        <td class="cell-personalizado">PLANOS ELECTRICOS DIGITALES:</td>
                        <td class="text-color-100">Archivo PDF</td>
                    </tr>

                    <tr>
                        <td>OTROS (Especificar):</td>
                        <td>{{$equipo_pesado->otros_manuales}}</td>
                        <td class="cell-personalizado">OTROS (Especificar):</td>
                        <td>{{$equipo_pesado->otros_planos}}</td>
                    </tr>
                </tbody>
            </table>
            
        </div>

        <table class="table-footer-firma">

                <tbody>
                    <tr>
                        <td>REVISADO Y APROBADO POR JEFE DE MAQUINAS</td>
                        <td>
                            <p>--------------------------------------</p>
                            <p>IVAN VARGAS SAAVEDRA</p>
                        </td>
                    </tr>
                </tbody>
            </table>

    </main>
</body>

</html>

