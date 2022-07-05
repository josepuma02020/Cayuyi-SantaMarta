<?php
session_start();
if (time() - $_SESSION['tiempo'] > 500) {
    //session_destroy();
    /* Aquí redireccionas a la url especifica */
    session_destroy();
    header('Location: ' . "index.php?m=5");
    //die();
} else {
    $_SESSION['tiempo'] = time();
}
if ($_SESSION['usuario'] && ($_SESSION['Rol'] == 1 || $_SESSION['Rol'] == 2)) {
    include_once('conexion/conexion.php');
    include_once('funciones/funciones.php');
    setlocale(LC_ALL, "es_CO");
    date_default_timezone_set('America/Bogota');
    $fechahoyval = date("Y") . '-' . date("m") . '-' . date("j");
    //autocompletar cliente
    $consulta = "SELECT `cedula`  FROM `clientes` ";
    $queryt = mysqli_query($link, $consulta) or die($consulta);
    $productos[] = array();
    while ($arregloproductos = mysqli_fetch_row($queryt)) {
        $productos[] = $arregloproductos[0];
    }
    array_shift($productos);
    $relleno = json_encode($productos);
    if (isset($_GET['desde'])) {
        $desde = $_GET['desde'];
    } else {
        $desde = date("Y-m-01");
    }
    if (isset($_GET['hasta'])) {
        $hasta = $_GET['hasta'];
    } else {
        $hasta = date("Y-m-d");
    }
?>
    <HTML>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css" />
        <link rel="stylesheet" href="./diseno/defecto/desktop.css" />
        <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="librerias/alertify/css/alertify.css" />
        <link rel="stylesheet" type="text/css" href="librerias/alertify/css/themes/default.css" />
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <SCRIPT src="librerias/jquery-3.5.1.min.js"></script>
        <SCRIPT src="librerias/alertify/alertify.js"></script>
        <SCRIPT lang="javascript" type="text/javascript" src="contabilidad/contabilidad.js"></script>
        <script src="librerias/bootstrap/js/bootstrap.js"></script>
        <link type="text/css" href="librerias/jquery-ui-1.12.1.custom/jquery-ui.structure.min.css" rel="Stylesheet" />
        <link rel="shortcut  icon" href="imagenes/logop.png" type="image/x-icon" />
    </head>

    <body>
        <header>
            <?php include_once($_SESSION['menu']); ?>
        </header>
        <main style="width:95%;max-width:95%;" class=" container container-md">
            <section class="titulo-pagina">
                <h1>Registros Contables</h1>
            </section>
            <section class="parametros">
                <div class="form-group col-md-3">
                    <h3>Desde:</h3>
                    <input class="form-control input-sm" type="date" id="desde" value="<?php echo $desde ?>">
                </div>
                <div class="form-group col-sm-3">
                    <h3>Hasta:</h3>
                    <input class="form-control input-sm" type="date" id="hasta" value="<?php echo $hasta ?>">
                </div>
                <button type="button" id="buscar" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                    </svg>
                </button>
            </section>
            <TABLE class="table table-striped  table-responsive-lg" id="tablarevisiones">
                <THEAD>
                    <tr style="font-size:1rem ">
                        <th> Ruta </th>
                        <th style="width: 35% ;"> Fecha </th>
                        <th> Liquidador </th>
                        <th> Encargado </th>
                        <th> Base </th>
                        <th> Cobro </th>
                        <th> Pleno </th>
                        <th> Prést.</th>
                        <th> Pap.</th>
                        <th> Gastos </th>
                        <th> Efectivo </th>
                        <th> N </th>
                        <th> E </th>
                        <th> S </th>
                        <th> Cli. </th>

                        <?php
                        if ($_SESSION['Rol'] == 1) {
                        ?>
                            <th> Acciones </th>
                        <?php
                        }
                        ?>

                    </tr>
                </THEAD>
                <TBODY>
                    <?php
                    $consultarutas = "SELECT a.*,b.nombre,b.apellido,c.ruta 'nruta',c.id_ruta,d.nombre 'nombreliq',d.apellido'apellidoliq'  from revisionesrutas a inner join usuarios b on a.encargado=b.id_usuario inner join rutas c on c.id_ruta=a.ruta inner join usuarios d on d.id_usuario=a.idliquidador where fecha between '$desde' and '$hasta'";
                    $query = mysqli_query($link, $consultarutas) or die($consultarutas);
                    while ($filas1 = mysqli_fetch_array($query)) {
                    ?>
                        <TR style="font-size:1rem ">
                            <TD><a href="cuotas.php?<?php echo 'rutaa=' . $filas1['id_ruta'] . '&fecha=' . $filas1['fecha']; ?>"><?php echo $filas1['nruta'] ?> </a></TD>
                            <TD style="font-size:0.8rem "><?php echo ($filas1['fecha'] . ' ' . $filas1['hora']); ?> </TD>
                            <TD style="font-size:0.8rem "> <?php echo ($filas1['nombre'] . ' ' . $filas1['apellido']) ?> </TD>
                            <TD style="font-size:0.8rem "><?php echo ($filas1['nombreliq'] . ' ' . $filas1['apellidoliq']) ?> </TD>
                            <TD><?php echo number_format($filas1['base']) ?> </TD>
                            <TD><?php echo number_format($filas1['cobro']) ?> </TD>
                            <TD><?php echo number_format($filas1['pleno']); ?> </TD>
                            <TD><?php echo number_format($filas1['prestamo']); ?> </TD>
                            <TD><?php echo number_format($filas1['papeleria']); ?> </TD>
                            <TD><?php echo number_format($filas1['gastos']); ?> </TD>
                            <TD><?php echo number_format($filas1['efectivo']); ?> </TD>
                            <TD><?php echo number_format($filas1['nuevos']); ?> </TD>
                            <TD><?php echo number_format($filas1['entrantes']); ?> </TD>
                            <TD><?php echo number_format($filas1['salientes']); ?> </TD>
                            <TD><?php echo ($filas1['clientes']); ?> </TD>


                            <?php
                            if ($_SESSION['Rol'] == 1) {
                            ?>
                                <td>
                                    <button onclick="agregaridcontable(<?php echo $filas1['idhistorial'] ?>)" type="button" id="eeeee" class="btn btn-danger" data-toggle="modal" data-target="#eliminar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-excel" viewBox="0 0 16 16">
                                            <path d="M5.884 6.68a.5.5 0 1 0-.768.64L7.349 10l-2.233 2.68a.5.5 0 0 0 .768.64L8 10.781l2.116 2.54a.5.5 0 0 0 .768-.641L8.651 10l2.233-2.68a.5.5 0 0 0-.768-.64L8 9.219l-2.116-2.54z" />
                                            <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z" />
                                        </svg>
                                    </button>
                                </td>
                            <?php
                            }
                            ?>

                        </TR>
                    <?php } ?>
                </TBODY>
            </TABLE>
            <div class="modal fade" id="eliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 onclick="datoscuota(<?php echo $filas1['id_registro'] ?>)" class="modal-title" id="exampleModalLabel"><b>Eliminar Liquidación</b></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input disabled type="hidden" id="idu" name="idu">
                            Esta seguro que sea eliminar el cierre de ruta?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button id="eliminarcierre" data-dismiss="modal" type="button" class="btn btn-danger">Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <canvas id="grafico" height="80px"></canvas>
            <script>
                var mi_primer_grafico = {
                    type: "doughnut", //seleccionamos el tipo de grafico, en este caso es un grafico estilo pie, en esta parte podemos cambiar el tipo de grafico por el que deseamos
                    data: {
                        //le pasamos la data
                        datasets: [{
                            data: [1, 2, 4, 6], //esta es la data, podemos pasarle variables directamente desde el backend usando blade de la siguiente forma {{$dato1}},
                            backgroundColor: [ //seleccionamos el color de fondo para cada dato que le enviamos
                                "#04B404", "#FFBF00", "#FF0000", "#04B4AE",
                            ],
                        }],
                        labels: [ //añadimos las etiquetas correspondientes a la data
                            "Dato1", "Dato2", "Dato3", "Dato4",
                        ]
                    },
                    options: { //le pasamos como opcion adicional que sea responsivo
                        responsive: true,
                    }
                }
                var primer_grafico = document.getElementById('grafico').getContext('2d'); //seleccionamos el canvas
                window.pie = new Chart(primer_grafico, mi_primer_grafico);
            </script> -->
        </main>
        <footer>
            <p>Author: Pumasoft<br>
                <a href="https://www.pumasoft.co">pumasoft.co</a>
            </p>
        </footer>
    </body>

    </HTML>
<?php
} else {
    header('Location: ' . "usuarios/cerrarsesion.php");
}
?>
<script type="text/javascript" src="librerias/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript" src="librerias/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#eliminarcierre').click(function() {
            idu = $('#idu').val();
            eliminarcierre(idu);
            window.location.reload();
        });
        $('#buscar').click(function() {
            desde = $('#desde').val();
            hasta = $('#hasta').val();
            console.log(desde);
            location.href = `contabilidad.php?desde=${desde}&hasta=${hasta}`;
        });
        tabla = $('#tablarevisiones').DataTable({
            language: {
                url: '../vendor/datatables/es-ar.json',
                lengthMenu: "Mostrar _MENU_ Registros",
                loadingRecords: "Cargando...",
                search: "Buscar:",
                info: "Mostrando lista de Ventas",
                zeroRecords: "Sin Resultados",
                paginate: {
                    first: "Primera pagina",
                    previous: "Anterior",
                    next: "Siguiente",
                    last: "Ultima"
                },
            }
        });
    });
</script>