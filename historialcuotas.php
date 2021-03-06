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
    $fecha_actual = date("Y-m-j");
    $fecha_inicio = date("Y-m-01");
    $rutaactiva = $_SESSION['nruta'];
    $nrutaactiva = $_SESSION['ruta'];
    if (isset($_GET['cliente'])) {
        $cliente = $_GET['cliente'];
    } else {
        $cliente = 0;
    }
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        $id = 0;
    }

    //dias para vencimiento de prestamo activo
    $consultavencimiento = "select dias_prestamo,fecha from prestamos where cliente=$cliente and abonado < valorapagar";
    $queryvencimiento = mysqli_query($link, $consultavencimiento) or die($consultavencimiento);
    $filasvencimiento = mysqli_fetch_array($queryvencimiento);
    if (isset($filasvencimiento)) {
        $diasprestamoactivo = $filasvencimiento['dias_prestamo'];
        $fechaprestamoactivo = $filasvencimiento['fecha'];
        $fechaprestamoactivo = date_create($fechaprestamoactivo);
        date_add($fechaprestamoactivo, date_interval_create_from_date_string("$diasprestamoactivo days"));
        $fechafinprestamo = date_format($fechaprestamoactivo, "d-m-Y");
        $fecha_actual = date_create($fecha_actual);
        $diff = $fecha_actual->diff($fechaprestamoactivo);
        $vencimiento = $diff->days;
        $fechafinprestamo = date_create($fechafinprestamo);
        if ($fechafinprestamo > $fecha_actual) {
            $vencimiento = $vencimiento * -1;
        }
    } else {
        $vencimiento = "0";
    }
    if ($vencimiento > 0) {
        $class = 'input-disabled-vencido';
    } else {
        $class = 'input-disabled-normal';
    }
    //consultadatoscliente

    if ($id != 0) {
        $consultacuota = "select a.nombre,b.fecha,a.cedula from clientes a inner join prestamos b on a.id_cliente=b.cliente where b.id_prestamo = $id";
    }
    if ($cliente != 0) {
        $consultacuota = "SELECT c.cedula,a.diasvence,a.cuota,a.fecha,c.nombre,b.valor_prestamo,b.valorapagar,a.saldo,b.formapago,a.atraso,b.dias_prestamo,b.fecha'fechaprestamo' FROM  registros_cuota a inner join prestamos b on b.id_prestamo=a.prestamo inner join clientes c on c.id_cliente=b.cliente where c.id_cliente = $cliente";
    }
    if (mysqli_query($link, $consultacuota)) {
        $query = mysqli_query($link, $consultacuota) or die($consultacuota);
        $filas1 = mysqli_fetch_array($query);
        $nombrecliente = $filas1['nombre'];
        $cedula = $filas1['cedula'];
        $fechaprestamo = $filas1['fecha'];
    }

?>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css" />
        <link rel="stylesheet" type="text/css" href="./diseno/historialcuotas/cel.css" />
        <link rel="stylesheet" type="text/css" href="./diseno/historialcuotas/desktop.css" media="screen and (min-width:1000px)" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <SCRIPT src="librerias/jquery-3.5.1.min.js"></script>
        <SCRIPT src="librerias/alertify/alertify.js"></script>
        <SCRIPT lang="javascript" type="text/javascript" src="funciones/funciones.js"></script>
        <script src="librerias/bootstrap/js/bootstrap.js"></script>
        <link rel="shortcut  icon" href="imagenes/logop.png" type="image/x-icon" />
    </head>

    <body>
        <header>
            <?php include_once($_SESSION['menu']); ?>
        </header>
        <main class="container">
            <input type="hidden" value="<?php echo $cliente ?>" id="cliente" />
            <section class="titulo-pagina">
                <h1>Historial de Cuotas</h1>
            </section>
            <section class="parametros">
                <div class="form-group col-sm-3">
                    <h3>Cedula:</h3>
                    <input disabled class="form-control input-sm input-disabled-normal" type="text" id="mostrando" value="<?php echo $cedula; ?>">
                </div>
                <div class="form-group col-sm-3">
                    <h3>Cliente:</h3>
                    <input disabled class="form-control input-sm input-disabled-normal" type="text" id="mostrando" value="<?php echo $nombrecliente; ?>">
                </div>
                <!-- <div class="form-group col-sm-3">
                    <h3>Fecha del último préstamo:</h3>
                    <input disabled class="form-control input-sm <?php echo $class ?>" type="text" id="mostrando" value="<?php echo $fechaprestamo; ?>">
                </div> -->
            </section>
            <table class="table table-bordered" id="tablahistorial">
                <thead>
                    <tr>
                        <th>
                            Ult.Pago
                        </th>
                        <th>
                            Ini.Préstamo
                        </th>
                        <th>
                            Plazo
                        </th>
                        <th>
                            Préstamo
                        </th>
                        <th>
                            V.P
                        </th>
                        <th>
                            Cuota
                        </th>
                        <th>
                            Saldo
                        </th>
                        <th>
                            F.P
                        </th>
                        <th>
                            D.A
                        </th>
                        <th>
                            D.V
                        </th>
                    </tr>
                </thead>
                <TBODY>
                    <?php
                    if ($cliente != 0) {
                        $consultacuota = "SELECT b.dias_prestamo,b.fecrefinanciacion,a.diasvence,a.cuota,a.fecha,c.nombre,b.valor_prestamo,a.valorpagar,a.saldo,b.formapago,a.atraso,b.dias_prestamo,b.fecha'fechaprestamo' FROM  registros_cuota a inner join prestamos b on b.id_prestamo=a.prestamo inner join clientes c on c.id_cliente=b.cliente where c.id_cliente = $cliente";
                    }
                    if ($id != 0) {
                        $consultacuota = "SELECT b.dias_prestamo,b.fecrefinanciacion,b.fecha'fechaprestamo',a.diasvence,a.cuota,a.fecha,c.nombre,b.valor_prestamo,a.valorpagar,a.saldo,b.formapago,a.atraso,b.dias_prestamo,b.fecha'fechaprestamo' FROM  registros_cuota a inner join prestamos b on b.id_prestamo=a.prestamo inner join clientes c on c.id_cliente=b.cliente where b.id_prestamo = $id";
                    }
                    $query = mysqli_query($link, $consultacuota) or die($consultacuota);
                    while ($filas1 = mysqli_fetch_array($query)) {
                        $dias = $filas1['atraso'];
                        $diascuota = $filas1['diasvence'];
                        if ($diascuota <= 0) {
                            $class = "vencido";
                        }
                    ?>
                        <TR>
                            <?php
                            if ($filas1['fecha'] == $filas1['fecrefinanciacion']) {
                                $color = "#F7ED29";
                            } else {
                                $color = "";
                            }
                            ?>
                            <TD style=" background-color : <?php echo $color; ?>"><?php echo $filas1['fecha']; ?> </TD>
                            <TD><?php echo $filas1['fechaprestamo']; ?> </TD>
                            <TD><?php echo $filas1['dias_prestamo']; ?> </TD>
                            <TD><?php echo $filas1['valor_prestamo']; ?> </TD>
                            <TD><?php echo $filas1['valorpagar']; ?> </TD>
                            <TD><?php echo $filas1['cuota']; ?> </TD>
                            <?php
                            $saldo = $filas1['saldo'];
                            if ($saldo == 0) {
                                $color = "1DE97D";
                            } else {
                                $color = "";
                            }
                            ?><TD style="background-color: <?php echo $color ?>"><?php echo $saldo; ?> </TD>
                            <TD><?php
                                $diaspago = $filas1['formapago'];
                                switch ($diaspago) {
                                    case 1:
                                        $formadepago = 'D';
                                        break;
                                    case 15:
                                        $formadepago = 'Q';
                                        break;
                                    case 7:
                                        $formadepago = 'S';
                                        break;
                                    case 30:
                                        $formadepago = 'M';
                                        break;
                                }
                                echo $formadepago;
                                ?> </TD>
                            <?php
                            if ($dias > 0) {
                                $color = "#F34A4A";
                            } else {
                                $color = "";
                            }
                            ?>
                            <TD style="background-color: <?php echo $color; ?> ;"><?php echo $dias; ?> </TD>
                            <?php
                            $diasvencidos = $filas1['diasvence'];
                            if ($diasvencidos > 0) {
                                $color = "#F34A4A";
                            } else {
                                $color = "";
                            }
                            ?>
                            <TD style="background-color: <?php echo $color; ?> ;"> <?php echo $diasvencidos; ?> </TD>
                        </TR>
                    <?php } ?>
                </TBODY>
            </table>

        </main>
        <footer>
            <p>Author: Pumasoft<br>
                <a href="https://www.pumasoft.co">pumasoft.co</a>
            </p>
        </footer>
    </body>

    </html>

<?php
} else {
    header('Location: ' . "usuarios/cerrarsesion.php");
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#buscar').click(function() {
            a = 0;
            desde = $('#desde').val();
            hasta = $('#hasta').val();
            cliente = $('#cliente').val();
            if (a == 0) {
                location.href = `historialcuotas.php?cliente=${cliente}`;
            }
        })
        $('#revisar').click(function() {
            ide = $('#idrevisar').val();
            pleno = $('#pleno').val();
            base = $('#base').val();
            cobro = $('#cobro').val();
            prestamo = $('#prestamo').val();
            gasto = $('#gasto').val();
            nuevos = $('#nuevos').val();
            entrantes = $('#entrantes').val();
            salientes = $('#salientes').val();
            clientes = $('#clientes').val();
            console.log(clientes);
            revisarruta(ide, pleno, base, cobro, prestamo, gasto, nuevos, entrantes, salientes, clientes);
            window.location.reload();
        })
        tabla = $('#tablahistorial').DataTable({
            "order": [
                [0, "desc"]
            ],
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