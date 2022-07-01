<?php
session_start();
if ($_SESSION['usuario']) {
    include_once('conexion/conexion.php');
    include_once('funciones/funciones.php');
    setlocale(LC_ALL, "es_CO");
    $fecha_actual = date("Y-m-j");
    $fecha_inicio = date("Y-m-01");
    $rutaactiva = $_SESSION['nruta'];
    $nrutaactiva = $_SESSION['ruta'];

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        $id = 0;
    }
    //consulta cliente 
    $consultacliente = "select a.nombre from clientes a inner join prestamos b on b.cliente=a.id_cliente where b.id_prestamo=$id";
    $query = mysqli_query($link, $consultacliente) or die($consultacliente);
    $filas1 = mysqli_fetch_array($query);
    if (isset($filas1)) {
        $nombrecliente = $filas1['nombre'];
    } else {
        $nombrecliente = '';
    }
    //consultabase
    $consultabase = "select a.base,COUNT(b.id_prestamo) 'prestamos' from rutas a inner join prestamos b on b.ruta=a.id_ruta where b.cliente =$id and (b.valorapagar-b.abonado > 0) group by a.ruta";
    $query = mysqli_query($link, $consultabase) or die($consultabase);
    $filas1 = mysqli_fetch_array($query);
    $base = $filas1['base'];
    $clientesruta = $filas1['prestamos'];
?>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css" />
        <link rel="stylesheet" type="text/css" href="./diseno/defecto/cel.css" />
        <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="librerias/alertify/css/alertify.css" />
        <link rel="stylesheet" type="text/css" href="librerias/alertify/css/themes/default.css" />
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
        <input type="hidden" value="<?php echo $cliente ?>" id="cliente" />
        <div class="container">
            <section class="titulo-pagina">
                <h1>Historial de Cuotas</h1>
            </section>
            <section class="parametros">
                <div class="form-group completo">
                    <h3>Cliente:</h3>
                    <input disabled class="form-control input-sm" type="text" id="mostrando" value="<?php echo $nombrecliente; ?>">
                </div>
            </section>
            <div id="recarga">
                <table class="table table-bordered tabla-cuotas-cel" id="tablaproductos">
                    <thead>
                        <tr>
                            <th>
                                Fecha
                            </th>
                            <th>
                                Cuo.
                            </th>
                            <th>
                                Sal.
                            </th>
                            <th>
                                D.A
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        echo $consultacuota = "SELECT a.diasvence,a.cuota,a.fecha,c.nombre,b.valor_prestamo,b.valorapagar,a.saldo,b.formapago,a.atraso,b.dias_prestamo,b.fecha'fechaprestamo' FROM  registros_cuota a inner join prestamos b on b.id_prestamo=a.prestamo inner join clientes c on c.id_cliente=b.cliente where a.prestamo = $id";
                        $query = mysqli_query($link, $consultacuota) or die($consultacuota);
                        while ($filas1 = mysqli_fetch_array($query)) {
                            $dias = $filas1['atraso'];
                            $diascuota = $filas1['diasvence'];
                            $diascuota = $diascuota * -1;
                            if ($diascuota < 0) {
                                $class = "vencido";
                            }
                        ?>
                            <TR>
                                <TD><?php echo $filas1['fecha']; ?> </TD>
                                <TD><?php echo $filas1['cuota']; ?> </TD>
                                <?php
                                $saldo = $filas1['saldo'];
                                if ($saldo == 0) {
                                    $color = "1DE97D";
                                } else {
                                    $color = "";
                                }
                                ?><TD style="background-color: <?php echo $color ?>"><?php echo $saldo; ?> </TD>

                                <TD><?php echo $dias; ?> </TD>
                            </TR>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <footer>
            <p>Author: Pumasoft<br>
                <a href="https://www.pumasoft.co">pumasoft.co</a>
            </p>
        </footer>
    </body>

    </html>

<?php
} else {
    echo "<script type=''>
        alert('favor iniciar sesion');
        window.location='index.php';
    </script>";
}
?>
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
    })
</script>
<script type="text/javascript">
    $(document).ready(function() {
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
    })
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        tabla = $('#tablaproductos').DataTable({
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