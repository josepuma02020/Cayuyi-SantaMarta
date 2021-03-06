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
if ($_SESSION['usuario']) {
    include_once('conexion/conexion.php');
    include_once('funciones/funciones.php');
    setlocale(LC_ALL, "es_CO");
    date_default_timezone_set('America/Bogota');
    $fecha_actual = date("Y-m-d");
    $fecha_inicio = date("Y-m-01");
    //ruta
    $rutaactiva = $_SESSION['nruta'];
    if (isset($_GET['rutaa'])) {
        $rutainfo = $_GET['rutaa'];
    } else {
        $rutainfo = $_SESSION['ruta'];
        if (isset($_SESSION['nruta'])) {
            $rutainfo = $_SESSION['ruta'];
        } else {
            $rutainfo = 1;
        }
    }
    //fechas
    if (isset($_GET['fecha'])) {
        $fecha = $_GET['fecha'];
    } else {
        $fecha = $fecha_actual;
    }

    //consultabase
    $consultabase = "select a.base,COUNT(b.id_prestamo) 'prestamos' from rutas a inner join prestamos b on b.ruta=a.id_ruta where id_ruta =$rutainfo and (b.valorapagar-b.abonado > 0) group by a.ruta";
    $query = mysqli_query($link, $consultabase) or die($consultabase);
    $filas1 = mysqli_fetch_array($query);
    $base = $filas1['base'];
    $clientesruta = $filas1['prestamos'];
    //nombreruta info
    $consultanombreruta = "select a.ruta ,b.nombre,b.apellido from rutas a inner join usuarios b on b.id_usuario=a.encargado where a.id_ruta=$rutainfo";
    $query1 = mysqli_query($link, $consultanombreruta) or die($consultanombreruta);
    $filas2 = mysqli_fetch_array($query1);
    $nomrutainfo = $filas2['ruta'] . ' - ' . $filas2['nombre'] . ' ' . $filas2['apellido'];
    //consultacerrado
    $consultaactivo = "SELECT fecha FROM `revisionesrutas` WHERE ruta=$rutainfo and fecha = '$fecha'";
    $queryactivo = mysqli_query($link, $consultaactivo) or die($consultaactivo);
    $filasactivo = mysqli_fetch_array($queryactivo);
    if (isset($filasactivo)) {
        $registrado = 1;
    } else {
        $registrado = 0;
    }
?>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css" />
        <link rel="stylesheet" type="text/css" href="./diseno/revisioncuotas/cel.css" />
        <link rel="stylesheet" type="text/css" href="./diseno/revisioncuotas/tablet.css" media="screen and (min-width:450px)" />
        <link rel="stylesheet" type="text/css" href="./diseno/revisioncuotas/desktop.css" media="screen and (min-width:1000px)" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <SCRIPT src="librerias/jquery-3.5.1.min.js"></script>
        <SCRIPT src="librerias/alertify/alertify.js"></script>
        <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="librerias/alertify/css/alertify.css" />
        <SCRIPT lang="javascript" type="text/javascript" src="./prestamos/prestamos.js"></script>
        <script src="librerias/bootstrap/js/bootstrap.js"></script>
        <link rel="shortcut  icon" href="imagenes/logop.png" type="image/x-icon" />
    </head>

    <body>
        <header>
            <?php include_once($_SESSION['menu']); ?>
        </header>
        <main>
            <input type="hidden" value="<?php echo $mes ?>" id="mes" />
            <input type="hidden" value="<?php echo $año ?>" id="año" />
            <div style="max-width: 80%;" class="container">
                <section class="titulo-pagina">
                    <h1>Liquidación de rutas</h1>
                </section>
                <section class="parametros">
                    <?php
                    if ($_SESSION['Rol'] == 1 or $_SESSION['Rol'] == 2) {
                    ?>
                        <div class="form-group col-md-3">
                            <h4>Buscar Ruta:</h4>
                            <select id="ruta" class="form-control input-sm">
                                <?php
                                $consultausuarios = "select a.*,COUNT(b.id_prestamo)'recorridos',c.nombre,c.apellido from rutas a left join prestamos b on a.id_ruta = b.ruta inner join usuarios c on c.id_usuario = a.encargado  GROUP by a.id_ruta";
                                $query = mysqli_query($link, $consultausuarios) or die($consultausuarios);
                                ?> <option value="0"></option>
                                <?php
                                while ($filas1 = mysqli_fetch_array($query)) {
                                ?>
                                    <option value="<?php echo $filas1['id_ruta'] ?>"><?php echo  $filas1['ruta'] . '-' . $filas1['nombre'] . ' ' . $filas1['apellido'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="form-group col-sm-3">
                        <h4>Mostrando:</h4>
                        <input disabled class="form-control input-sm" type="text" id="mostrando" value="<?php echo $nomrutainfo; ?>">
                    </div>
                    <?php
                    if ($_SESSION['Rol'] == 1 or $_SESSION['Rol'] == 2) {
                    ?>
                        <div class="form-group col-sm-3">
                            <h4>Fecha:</h4>
                            <input class="form-control input-sm" type="date" id="fechabuscar" value="<?php echo $fecha ?>">
                        </div>
                        <button type="button" id="buscar" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg>
                        </button>
                        <a target="_blank" href="rutas/guiageneral.php?fecha=<?php echo $fecha; ?>">
                            <button title="Ver todas las cuotas recogidas en el dia" type="button" id="buscar" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-columns" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M0 .5A.5.5 0 0 1 .5 0h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 0 .5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2A.5.5 0 0 1 .5 2h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2A.5.5 0 0 1 .5 4h10a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2A.5.5 0 0 1 .5 6h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2A.5.5 0 0 1 .5 8h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Z" />
                                </svg>
                            </button>
                        </a>
                    <?php } ?>
                </section>
                <div id="recarga">
                    <table style="font-size: 0.6rem;" class="table table-bordered" id="tablacuotas">
                        <thead>
                            <tr>
                                <!-- <th>
                                    Venc.Préstamo
                                </th> -->
                                <th style="width:35%;">
                                    Cliente
                                </th>
                                <th>
                                    Cobrado
                                </th>
                                <th>
                                    Saldo
                                </th>
                                <th>
                                    D.A
                                </th>
                            </tr>
                        </thead>
                        <TBODY>

                            <?php
                            $consultarutas = "select b.id_prestamo,a.prestamo,b.dias_atraso,a.id_registro,b.dias_atraso,sum(a.cuota) 'cuota',b.fecha,c.nombre,b.cliente,b.dias_prestamo from registros_cuota a inner join prestamos b on b.id_prestamo=a.prestamo inner join clientes c on c.id_cliente=b.cliente where a.fecha = '$fecha' and b.ruta=$rutainfo  group by b.cliente";
                            $query = mysqli_query($link, $consultarutas) or die($consultarutas);
                            $sumcobro = 0;
                            $sumprestamos = 0;
                            $pleno = 0;
                            $sumnuevos = 0;
                            $entrantes = 0;
                            $salientes = 0;
                            $clientes = 0;
                            $sumpapelerias = 0;
                            $renovados = 0;
                            while ($filas1 = mysqli_fetch_array($query)) {
                                $dias = $filas1['dias_atraso'];
                                $cuota = $filas1['cuota'];
                                $idprestamo = $filas1['id_prestamo'];
                                $fechaprestamo = $filas1['fecha'];
                                $diasprestamo = $filas1['dias_prestamo'];
                                $nombrecliente = $filas1['nombre'];
                                //verificar prestamo vencido
                                $date = date("d-m-Y");
                                $mod_date = strtotime($fechaprestamo . "+" . $diasprestamo . " days");
                                $fechavence = date("Y-m-d", $mod_date);
                                if ($fechavence <  $fecha) {
                                    $class = "vencido";
                                } else {
                                    $class = "";
                                }
                                $fechavence = date("d-m-Y", $mod_date);
                            ?>
                                <TR>
                                    <!-- <TD class="<?php echo $class ?>"><?php echo $fechavence ?> </TD> -->
                                    <TD><?php echo $nombrecliente ?> </TD>
                                    <TD><a href="historialcuotas.php?cliente=<?php echo $filas1['cliente']; ?>">
                                            <?php
                                            if ($cuota > 0) {
                                                $clientes = $clientes + 1;
                                            }
                                            $sumcobro = $sumcobro + $cuota;
                                            echo number_format($cuota);
                                            ?> </a></TD>
                                    <TD> <?php
                                            $consultaprestamo = "select (valorapagar-abonado) 'debe' from prestamos a where a.cliente = $filas1[cliente]  and (valorapagar - abonado) > 0";
                                            $query1 = mysqli_query($link, $consultaprestamo) or die($consultaprestamo);
                                            $filas2 = mysqli_fetch_array($query1);
                                            if (isset($filas2)) {
                                                $debe = $filas2['debe'];
                                            } else {
                                                $debe = 0;
                                            }
                                            echo number_format($debe);
                                            ?></TD>
                                    <?php
                                    $consultanuevo = "select count(a.valor_prestamo)'prestamos' from prestamos a where a.cliente = $filas1[cliente] and a.fecha  != '$fecha'";
                                    $query1 = mysqli_query($link, $consultanuevo) or die($consultanuevo);
                                    $filas2 = mysqli_fetch_array($query1);
                                    if (isset($filas2)) {
                                        $filas2['prestamos'];
                                        if ($filas2['prestamos'] >= 1) {
                                            $nuevo = "No";
                                        } else {
                                            $sumnuevos = $sumnuevos + 1;
                                            $nuevo = "Si";
                                        }
                                    }
                                    //consulta entrante
                                    $consultacierre = "select a.id_prestamo from prestamos a where a.cliente = $filas1[cliente] and a.fecha='$fecha'";
                                    $query1 = mysqli_query($link, $consultacierre) or die($consultacierre);
                                    $filas2 = mysqli_fetch_array($query1);
                                    if (isset($filas2['id_prestamo']) > 0) {
                                        $entrantes = $entrantes + 1;
                                        $entrante = "Si";;
                                    } else {
                                        $entrante = "No";
                                    }
                                    //consultasaliente
                                    $consultacierre = "select a.id_prestamo from prestamos a where a.cliente = $filas1[cliente] and a.fechacierre='$fecha'";
                                    $query1 = mysqli_query($link, $consultacierre) or die($consultacierre);
                                    $filas2 = mysqli_fetch_array($query1);
                                    if (isset($filas2['id_prestamo']) > 0) {
                                        $salientes = $salientes + 1;
                                        $dias = 0;
                                        $saliente = "Si";
                                    } else {
                                        $saliente = "No";
                                    }
                                    ?>
                                    <TD><?php echo $dias; ?></TD>
                                </TR>
                            <?php } ?>
                        </TBODY>
                    </table>

                </div>
                <div>
                    <h1>Resumen</h1>
                </div>
                <div id="recarga">
                    <table style="font-size: 0.6rem;" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    Base
                                </th>
                                <th>
                                    Cobro
                                </th>
                                <th>
                                    Prestamos
                                </th>
                                <th>
                                    Efectivo
                                </th>
                                <th>
                                    Clientes
                                </th>
                                <?php
                                if ($_SESSION['Rol'] == 1 or $_SESSION['Rol'] == 2) {
                                ?>
                                    <th>
                                        Aprobar
                                    </th>
                                <?php
                                }
                                ?>
                            </tr>
                        </thead>
                        <TBODY>

                            <?php
                            $consultarevision = "select * from revisionesrutas where ruta = $rutainfo and fecha = '$fecha'";
                            $query = mysqli_query($link, $consultarevision) or die($consultarevision);
                            $filas3 = mysqli_fetch_array($query);
                            $consultagastos = "select sum(valor)'valor' from gastos where fecha = '$fecha' and ruta = $rutainfo";
                            $query = mysqli_query($link, $consultagastos) or die($consultagastos);
                            $filas1 = mysqli_fetch_array($query);
                            $gasto = $filas1['valor'];
                            if (isset($filas3)) {
                                $base = $filas3['base'];
                                $sumcobro = $filas3['cobro'];
                                $pleno = $filas3['pleno'];
                                $sumprestamos = $filas3['prestamo'];
                                $sumpapelerias = $filas3['papeleria'];
                                $gasto = $filas3['gastos'];
                                $efectivo = $filas3['efectivo'];
                                $sumnuevos = $filas3['nuevos'];
                                $entrantes = $filas3['entrantes'];
                                $salientes = $filas3['salientes'];
                                $activo = "disabled";
                            } else {
                                $efectivo = $base + $sumcobro  - $gasto + $sumpapelerias - $sumprestamos;
                                $activo = "";
                            }
                            ?>
                            <TR>
                                <TD><?php echo number_format($base); ?> </TD>
                                <TD><?php echo number_format($sumcobro); ?> </TD>
                                <TD><?php echo number_format($sumprestamos); ?> </TD>
                                <TD><?php echo number_format($efectivo); ?> </TD>
                                <TD><?php
                                    $clientes = $clientes . ' / ' . $clientesruta;
                                    echo $clientes
                                    ?> </TD>

                                <input type="hidden" id="base" name="base" value="<?php echo $base ?>" />
                                <input type="hidden" id="cobro" name="cobro" value="<?php echo $sumcobro ?>" />
                                <input type="hidden" id="prestamo" name="prestamo" value="<?php echo $sumprestamos ?>" />
                                <input type="hidden" id="gasto" name="gasto" value="<?php echo $gasto ?>" />
                                <input type="hidden" id="nuevos" name="nuevos" value="<?php echo $sumnuevos ?>" />
                                <input type="hidden" id="entrantes" name="entrantes" value="<?php echo $entrantes ?>" />
                                <input type="hidden" id="salientes" name="salientes" value="<?php echo $salientes ?>" />
                                <input type="hidden" id="clientes" name="clientes" value="<?php echo $clientes ?>" />
                                <input type="hidden" id="efectivo" name="efectivo" value="<?php echo $efectivo ?>" />
                                <input type="hidden" id="pleno" name="pleno" value="<?php echo $pleno ?>" />
                                <input type="hidden" id="papeleria" name="pleno" value="<?php echo $sumpapelerias ?>" />
                                <input type="hidden" id="idrevisar" name="idrevisar" value="<?php echo $rutainfo ?>" />
                                <?php
                                if ($_SESSION['Rol'] == 1 or $_SESSION['Rol'] == 2) {
                                ?>
                                    <td>
                                        <button <?php echo $activo ?> type="button" id="revisar" class="btn btn-primary" data-toggle="modal" data-target="#editar">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-checklist" viewBox="0 0 16 16">
                                                <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                                                <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z" />
                                            </svg>
                                        </button>
                                    </td>
                                <?php
                                }
                                ?>
                            </TR>
                        </TBODY>
                    </table>
                </div>
            </div>

            <footer>
                <p>Author: Pumasoft<br>
                    <a href="https://www.pumasoft.co">pumasoft.co</a>
                </p>
            </footer>
        </main>
    </body>

    </html>

<?php
} else {
    header('Location: ' . "usuarios/cerrarsesion.php");
}
?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#editarcuota').click(function() {
            a = 0;
            idu = $('#idu').val();
            ncuota = $('#ncuota').val();
            editarcuota(idu, ncuota);
            window.location.reload();
        });
        $('#eliminarregistro').click(function() {
            a = 0;
            idu = $('#idu').val();
            eliminarcuota(idu);
            window.location.reload();
        });
        $('#buscar').click(function() {
            a = 0;
            ruta = $('#ruta').val();
            fecha = $('#fechabuscar').val();
            if (ruta == 0) {
                a = 1
                alertify.alert('Atencion!!', 'Favor escoger una ruta', function() {
                    alertify.success('Ok');
                });
            }
            console.log(ruta);
            if (a == 0) {
                location.href = `cuotas.php?rutaa=${ruta}&fecha=${fecha}`;
            }
        });
        $('#revisar').click(function() {
            ide = $('#idrevisar').val();
            console.log(ide);
            pleno = $('#pleno').val();
            base = $('#base').val();
            cobro = $('#cobro').val();
            prestamo = $('#prestamo').val();
            gasto = $('#gasto').val();
            nuevos = $('#nuevos').val();
            entrantes = $('#entrantes').val();
            salientes = $('#salientes').val();
            clientes = $('#clientes').val();
            papeleria = $('#papeleria').val();
            efectivo = $('#efectivo').val();
            fecha = $('#fechabuscar').val();
            revisarruta(ide, pleno, base, cobro, prestamo, gasto, nuevos, entrantes, salientes, clientes, papeleria, efectivo, fecha);
            window.location.reload();
        })
    })
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        tabla = $('#tablacuotas').DataTable({
            language: {
                url: '../vendor/datatables/es-ar.json',
                lengthMenu: "Mostrar _MENU_ Registros",
                loadingRecords: "Cargando...",
                search: "Buscar:",
                info: "Mostrando lista de Cobros",
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