<?php
session_start();
if ($_SESSION['usuario']) {
    include_once('conexion/conexion.php');
    include_once('funciones/funciones.php');
    setlocale(LC_ALL, "es_CO");
    //rutainfo
    $rutaactiva = $_SESSION['nruta'];
    if (isset($_GET['rutaa'])) {
        $rutainfo = $_GET['rutaa'];
    } else {
        $rutainfo = $_SESSION['ruta'];
    }
    if ($rutainfo == "") {
        $rutainfo = 0;
    }
    $consultanombreruta = "select ruta from rutas where id_ruta=$rutainfo";
    $query1 = mysqli_query($link, $consultanombreruta) or die($consultanombreruta);
    $filas2 = mysqli_fetch_array($query1);
    if (isset($filas2)) {
        $nomrutainfo = $filas2['ruta'];
    } else {
        $nomrutainfo = "";
    }

?>
    <HTML>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css" />
        <link rel="stylesheet" type="text/css" href="./diseno/defecto/cel.css" />
        <link rel="stylesheet" type="text/css" href="./diseno/defecto/tablet.css" media="screen and (min-width:450px)" />
        <link rel="stylesheet" type="text/css" href="./diseno/defecto/desktop.css" media="screen and (min-width:1000px)" />
        <link rel="stylesheet" type="text/css" href="librerias/alertify/css/alertify.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <SCRIPT src="librerias/jquery-3.5.1.min.js"></script>
        <SCRIPT src="librerias/alertify/alertify.js"></script>
        <SCRIPT lang="javascript" type="text/javascript" src="rutas/rutas.js"></script>
        <script src="librerias/bootstrap/js/bootstrap.js"></script>
        <link rel="shortcut  icon" href="imagenes/logop.png" type="image/x-icon" />
    </head>

    <body>
        <header>
            <?php include_once($_SESSION['menu']); ?>
        </header>
        <div class=" container container-md">
            <section class="titulo-pagina">
                <h1>Editar Recorrido</h1>
            </section>

            <?php
            if ($_SESSION['Rol'] == 1) {
            ?>
                <section class="parametros">
                    <div class="form-group col-md-3">
                        <h3>Buscar Ruta:</h3>
                        <select id="ruta" class="form-control input-sm">
                            <?php
                            $consultausuarios = "select a.*,COUNT(b.id_prestamo)'recorridos',c.nombre,c.apellido from rutas a left join prestamos b on a.id_ruta = b.ruta inner join usuarios c on c.id_usuario = a.encargado  GROUP by a.id_ruta";
                            $query = mysqli_query($link, $consultausuarios) or die($consultausuarios);
                            ?> <option value="0"></option>
                            <?php
                            while ($filas1 = mysqli_fetch_array($query)) {
                            ?>
                                <option value="<?php echo $filas1['id_ruta'] ?>"><?php echo $filas1['recorridos'] . '-' . $filas1['ruta'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <h3>Mostrando:</h3>
                        <input disabled class="form-control input-sm" type="text" id="mostrando" value="<?php echo $nomrutainfo; ?>">
                    </div>
                    <button type="button" id="buscar" class="btn btn-primary btn-parametro">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </section>
            <?php
            }
            ?>

            <div id="recarga">
                <TABLE class="table table-striped  table-responsive-lg" id="tablaproductos">
                    <THEAD>
                        <tr>
                            <th> Cliente </th>
                            <th> Direccion </th>
                            <th> Posicion </th>
                            <th> Pendiente </th>
                            <th> Acciones </th>
                        </tr>
                    </THEAD>
                    <TBODY>
                        <?php
                        $consultarutas = "SELECT a.id_prestamo,c.direccion,b.ruta,d.nombre 'nencargado',d.apellido 'aencargado' ,c.nombre,c.apellido,a.valorapagar,a.abonado,a.dias_atraso,a.posicion_ruta FROM prestamos a inner join rutas b on a.ruta=b.id_ruta inner join clientes c on c.id_cliente=a.cliente inner join usuarios d on d.id_usuario=b.encargado where a.valorapagar - a.abonado > 0 and a.ruta =  $rutainfo";
                        $query = mysqli_query($link, $consultarutas) or die($consultarutas);
                        while ($filas1 = mysqli_fetch_array($query)) {
                        ?>
                            <TR>
                                <TD><?php echo $filas1['nombre'] . ' ' . $filas1['apellido']; ?> </TD>
                                <TD><?php echo $filas1['direccion']; ?> </TD>
                                <TD><?php echo $filas1['posicion_ruta']; ?> </TD>
                                <TD><?php echo $filas1['valorapagar'] - $filas1['abonado']; ?> </TD>
                                <TD>
                                    <button onclick="obtenerdatosprestamo(<?php echo $filas1['id_prestamo'] ?>)" type="button" id="actualiza" class="btn btn-primary" data-toggle="modal" data-target="#editar">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pen" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M13.498.795l.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z" />
                                        </svg>
                                    </button>

                                </TD>

                            </TR>
                        <?php } ?>
                    </TBODY>
                </TABLE>
            </div>
        </div>
        <div class="modal fade" id="editar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Ruta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Ruta Actual:</label>
                                <input type="hidden" id="idu" name="idu">
                                <input disabled autocomplete="off" type="text" class="form-control input-group-sm" id="rutaactual" name="rutaactual">
                            </div>

                            <div class="form-group col-md-4">
                                <label>Posicion:</label>
                                <input autocomplete="off" min="0" type="text" class="form-control input-group-sm" id="posicionu" name="posicionu">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button id="editarruta" type="button" class="btn btn-primary">Editar</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <footer>

        <p>Author: Pumasoft<br>
            <a href="https://www.pumasoft.co">pumasoft.co</a>
        </p>

    </footer>

    </HTML>
<?php
} else {
    header('Location: ' . "usuarios/cerrarsesion.php");
}
?>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<SCRIPT type="text/javascript">
    $(document).ready(function() {
        $('#editarruta').click(function() {
            a = 0;
            idu = $('#idu').val()
            ruta = $('#ruta').val();
            posicion = $('#posicionu').val();
            if (posicion < 0) {
                a = 1;
                alertify.alert('ATENCION!!', 'Revisar el Campo : Posicion', function() {
                    alertify.success('Ok');
                });
            }
            if (a == 0) {
                editarrecorrido(idu, ruta, posicion);
                window.location.reload();
            }
        })
        $('#buscar').click(function() {
            a = 0;
            ruta = $('#ruta').val();
            fecha = $('#fechabuscar').val();
            if (ruta == 0) {
                a = 1
                alertify.alert('ATENCION!!', 'Seleccione una ruta para buscar', function() {
                    alertify.success('Ok');
                });
            }
            console.log(ruta);
            if (a == 0) {
                location.href = `recorridosc.php?rutaa=${ruta}`;
            }
        })
        tabla = $('#tablaproductos').DataTable({
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