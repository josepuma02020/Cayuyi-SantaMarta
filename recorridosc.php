<?php
session_start();
if ($_SESSION['usuario']) {
    include_once('conexion/conexion.php');
    include_once('funciones/funciones.php');
    setlocale(LC_ALL, "es_CO");
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
        <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="librerias/alertify/css/alertify.css" />
        <link rel="stylesheet" type="text/css" href="librerias/alertify/css/themes/default.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <SCRIPT src="librerias/jquery-3.5.1.min.js"></script>
        <SCRIPT src="librerias/alertify/alertify.js"></script>
        <SCRIPT lang="javascript" type="text/javascript" src="funciones/funciones.js"></script>
        <script src="librerias/bootstrap/js/bootstrap.js"></script>

    </head>

    <body>
        <header>
            <?php include_once('diseno/navegadoradmin.php'); ?>
        </header>
        <div class=" container container-md">
            <div class="titulo-pagina">
                <h1>Editar Recorrido</h1>
            </div>
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
                        $consultarutas = "SELECT a.id_prestamo,c.direccion,b.ruta,d.nombre 'nencargado',d.apellido 'aencargado' ,c.nombre,c.apellido,a.valorapagar,a.abonado,a.dias_atraso,a.posicion_ruta FROM prestamos a inner join rutas b on a.ruta=b.id_ruta inner join clientes c on c.id_cliente=a.cliente inner join usuarios d on d.id_usuario=b.encargado where a.valorapagar - a.abonado > 0 and a.ruta =  $_SESSION[ruta]";
                        $query = mysqli_query($link, $consultarutas) or die($consultarutas);
                        while ($filas1 = mysqli_fetch_array($query)) {
                        ?>
                            <TR>

                                <TD><?php echo $filas1['nombre'] . ' ' . $filas1['apellido']; ?> </TD>
                                <TD><?php echo $filas1['direccion']; ?> </TD>
                                <TD><?php echo $filas1['posicion_ruta']; ?> </TD>



                                <TD><?php echo $filas1['valorapagar'] - $filas1['abonado']; ?> </TD>
                                <TD>
                                    <SCRIPT lang="javascript" type="text/javascript" src="funciones/funciones.js"></script>
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
                    <input type="hidden" id="idu" name="idu">
                    <div class="modal-body" align="center">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Ruta Actual:</label>
                                <input disabled autocomplete="off" type="text" style="font-size: medium" class="form-control input-group-sm" id="rutaactual" name="rutaactual">
                            </div>

                            <div class="form-group col-md-4">
                                <label>Posicion:</label>
                                <input autocomplete="off" min="0" type="text" style="font-size: medium" class="form-control input-group-sm" id="posicionu" name="posicionu">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button id="editarruta" type="button" class="btn btn-primary">Editar Usuario</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <footer>
        <center>
            <p>Author: Pumasoft<br>
                <a href="https://www.pumasoft.co">pumasoft.co</a>
            </p>
        </center>
    </footer>

    </HTML>
<?php
} else {
    echo "<script type=''>
        alert('favor iniciar sesion');
        window.location='index.php';
    </script>";
}
?>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<SCRIPT type="text/javascript">
    $(document).ready(function() {

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
<script type="text/javascript">
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
    })
</script>