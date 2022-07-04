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
if ($_SESSION['usuario'] && $_SESSION['Rol'] == 1) {
    include_once('conexion/conexion.php');
    setlocale(LC_ALL, "es_CO");
    date_default_timezone_set('America/Bogota');
    $fechahoyval = date("Y") . '-' . date("m") . '-' . date("j");
    $id = $_GET['id'];

    //consultacliente
    $consulta = "select * from clientes where id_cliente = $id";
    $querycliente = mysqli_query($link, $consulta) or die($consulta);
    $cliente = mysqli_fetch_array($querycliente);
?>
    <HTML>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css" />
        <link rel="stylesheet" href="./diseno/defecto/desktop.css" />
        <link rel="stylesheet" type="text/css" href="librerias/alertify/css/alertify.css" />
        <link rel="stylesheet" type="text/css" href="librerias/alertify/css/themes/default.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <SCRIPT src="librerias/jquery-3.5.1.min.js"></script>
        <SCRIPT src="librerias/alertify/alertify.js"></script>
        <SCRIPT lang="javascript" type="text/javascript" src="./prestamos/prestamos.js"></script>
        <script src="librerias/bootstrap/js/bootstrap.js"></script>
        <link type="text/css" href="librerias/jquery-ui-1.12.1.custom/jquery-ui.structure.min.css" rel="Stylesheet" />
        <link rel="shortcut  icon" href="imagenes/logop.png" type="image/x-icon" />
    </head>

    <body>
        <header>
            <?php
            include_once($_SESSION['menu']);
            ?>
        </header>
        <main class=" container container-md">

            <section class="titulo-pagina">
                <h1>Historial de Cliente</h1>
            </section>
            <div class="form-group col-sm-3">
                <h4>Cliente:</h4>
                <input class="form-control input-sm" type="text" disabled id="desde" name="desde" value="<?php echo $cliente['nombre'] ?>">
            </div>

            <TABLE class="table table-striped  table-responsive-lg" id="tablahistorialcliente">
                <THEAD>
                    <tr>
                        <th> F.Préstamo</th>
                        <th> V.Prestado </th>
                        <th> V.a pagar </th>
                        <th> Saldo </th>
                        <th> F.Cierre </th>
                        <th> Detalles </th>
                    </tr>
                </THEAD>
                <TBODY>
                    <?php
                    $consultarutas = "select a.* ,b.nombre  from prestamos a inner join clientes b on b.id_cliente=a.cliente where cliente = $id";
                    $query = mysqli_query($link, $consultarutas) or die($consultarutas);
                    while ($filas1 = mysqli_fetch_array($query)) {
                    ?>
                        <TR>
                            <TD><?php echo $filas1['fecha']; ?> </TD>
                            <TD><?php echo number_format($filas1['valor_prestamo']); ?> </TD>
                            <TD><?php echo number_format($filas1['valorapagar']); ?> </TD>
                            <TD><?php echo number_format($filas1['valorapagar'] - $filas1['abonado']); ?> </TD>
                            <TD><?php echo $filas1['fechacierre']; ?> </TD>
                            <TD>
                                <SCRIPT lang="javascript" type="text/javascript" src="funciones/funciones.js"></script>
                                <button onclick="obtenerdatosprestamo(<?php echo $filas1['id_prestamo'] ?>)" type="button" id="actualiza" class="btn btn-primary" data-toggle="modal" data-target="#editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                    </svg>
                                </button>
                            </TD>
                        </TR>
                    <?php } ?>
                </tbody>

            </table>
        </main>
        <footer>

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
        tabla = $('#tablahistorialcliente').DataTable({
            language: {
                url: '../vendor/datatables/es-ar.json',
                lengthMenu: "Mostrar _MENU_ Registros",
                loadingRecords: "Cargando...",
                search: "Buscar:",
                info: "Mostrando lista de Préstamos",
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