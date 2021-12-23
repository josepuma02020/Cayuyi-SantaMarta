<?php
session_start();
if ($_SESSION['usuario']) {
    include_once('conexion/conexion.php');
    include_once('funciones/funciones.php');
    setlocale(LC_ALL, "es_CO");
    $fecha_actual = date("Y-m-j");
    if (isset($_GET['cc'])) {
        $cedula = $_GET['cc'];
    } else {
        $cedula = "";
    }

?>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css" />
        <link rel="stylesheet" type="text/css" href="./diseno/defecto/cel.css" media="screen and (max-width:650px)" />
        <link rel="stylesheet" type="text/css" href="./diseno/defecto/desktop.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <SCRIPT src="librerias/jquery-3.5.1.min.js"></script>
        <SCRIPT src="librerias/alertify/alertify.js"></script>
        <SCRIPT lang="javascript" type="text/javascript" src="funciones/funciones.js"></script>
        <script src="librerias/bootstrap/js/bootstrap.js"></script>

    </head>

    <body>
        <header>
            <?php include_once($_SESSION['menu']); ?>
        </header>
        <main class="container">
            <section class="titulo-pagina">
                <h1>Verificar cliente</h1>
            </section>
            <section class="parametros">

                <div class="form-group">
                    <h3>Cedula:</h3>
                    <input class=" form-control input-sm" type="text" id="cedula" value="<?php echo $cedula; ?>">
                </div>
                <button type="button submit" id="buscar" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                    </svg>
                </button>

            </section>
            <section>


                <?php
                if ($cedula != "") {
                    $consulta = "select * from clientes where cedula = $cedula";
                    $query = mysqli_query($link, $consulta) or die($consulta);
                    while ($filas1 = mysqli_fetch_array($query)) {
                ?>
                        <section>
                            <label class="parametro-80">
                                <h4 class="info-cliente">Cedula:</h4>
                                <p class="info-cliente"><?php echo $filas1['cedula'] ?></p>
                            </label>
                            <label class="parametro-80">
                                <h4 class="info-cliente">Nombre:</h4>
                                <p class="info-cliente"> <?php echo $filas1['nombre'] . ' ' . $filas1['apellido']; ?></p>
                            </label>
                            <label class="parametro-80">
                                <h4 class="info-cliente">Dirección:</h4>
                                <p class="info-cliente"><?php echo $filas1['direccion'] ?></p>
                            </label>
                            <label class="parametro-80">
                                <h4 class="info-cliente">Telefono:</h4>
                                <p class="info-cliente"><?php echo $filas1['telefono'] ?></p>
                            </label>
                        </section>
                        <?php
                        $consultapendiente = "select a.*,b.ruta 'nruta' from prestamos a inner join rutas b on b.id_ruta=a.ruta where a.abonado < a.valor_prestamo and a.cliente =$filas1[id_cliente]";
                        $querypendiente = mysqli_query($link, $consultapendiente) or die($consultapendiente);
                        $filas2 = mysqli_fetch_array($querypendiente);
                        if (isset($filas2)) {
                            $querypendiente = mysqli_query($link, $consultapendiente) or die($consultapendiente);
                            while ($filas2 = mysqli_fetch_array($querypendiente)) {
                                //dias para vencimiento de prestamo activo
                                $diasprestamoactivo = $filas2['dias_prestamo'];
                                $fechaprestamoactivo = $filas2['fecha'];
                                $fechaprestamoactivo = date_create($fechaprestamoactivo);
                                date_add($fechaprestamoactivo, date_interval_create_from_date_string("$diasprestamoactivo days"));
                                $fechafinprestamo = date_format($fechaprestamoactivo, "d-m-Y");
                                $fecha_actual = date_create($fecha_actual);
                                $diff = $fecha_actual->diff($fechaprestamoactivo);
                                $diasvenc = $diff->days * -1;
                                $vencimiento = $diasvenc . ' dias';

                                if ($vencimiento <= 0) {
                                    $class = 'input-disabled-vencido';
                                } else {
                                    $class = 'input-disabled-normal';
                                }
                        ?>
                                <table class="table table-striped  table-responsive-lg">
                                    <thead>
                                        <tr>
                                            <th>V.P</th>
                                            <th>V.A.P</th>
                                            <th>Abonado</th>
                                            <th>Fecha</th>
                                            <th>Ruta</th>
                                            <th>Vigencia</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $filas2['valor_prestamo']; ?></td>
                                            <td><?php echo $filas2['valorapagar']; ?></td>
                                            <td><?php echo $filas2['abonado']; ?></td>
                                            <td><?php echo $filas2['fecha']; ?></td>
                                            <td><?php echo $filas2['nruta']; ?></td>
                                            <td class="<?php echo $class; ?>"><?php echo $vencimiento ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            <?php
                            }
                        } else {
                            ?>
                            <h3> El cliente no tiene prestamos pendientes</h3>
                        <?php
                        }
                        ?>
            </section>
    <?php
                    }
                }
    ?>
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
            cedula = $('#cedula').val();
            location.href = `verificarcliente.php?cc=${cedula}`;
        });
    });
</script>