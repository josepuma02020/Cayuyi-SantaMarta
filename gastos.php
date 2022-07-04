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
    include_once('funciones/funciones.php');
    setlocale(LC_ALL, "es_CO");
    date_default_timezone_set('America/Bogota');
    $fechahoyval = date("Y") . '-' . date("m") . '-' . date("d");
?>
    <HTML>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css" />
        <link rel="stylesheet" href="diseno/defecto/desktop.css" />
        <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="librerias/alertify/css/alertify.css" />
        <link rel="stylesheet" type="text/css" href="librerias/alertify/css/themes/default.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <SCRIPT src="librerias/jquery-3.5.1.min.js"></script>
        <SCRIPT src="librerias/alertify/alertify.js"></script>
        <SCRIPT lang="javascript" type="text/javascript" src="./gastos/gastos.js"></script>
        <script src="librerias/bootstrap/js/bootstrap.js"></script>
        <link rel="shortcut  icon" href="imagenes/logop.png" type="image/x-icon" />
    </head>

    <body>
        <header>
            <?php include_once($_SESSION['menu']); ?>
        </header>
        <div class=" container container-md">
            <section class="titulo-pagina">
                <h1>Tabla de Gastos</h1>
            </section>
            <div class="card-body">
                <span class="btn btn-primary" data-toggle="modal" data-target="#nuevousuario">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-plus" viewBox="0 0 16 16">
                        <path d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z" />
                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                    </svg> Nuevo Gasto<span class="fa fa-plus-circle"></span>
                </span>
                <div class="modal fade" id="nuevousuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><b>Nuevo Gasto</b></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class=" form-row">
                                    <div class="form-group completo">
                                        <label>Comentario:</label>
                                        <input autocomplete="off" type="text" class="form-control input-group-sm" id="descripcion" name="descripcion">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group mitad">
                                        <label>Encargado:</label>
                                        <select id="encargado" class="form-control input-sm">
                                            <?php
                                            $consultausuarios = "select * from usuarios";
                                            $query = mysqli_query($link, $consultausuarios) or die($consultausuarios);
                                            ?> <option value="0"></option> <?php
                                                                            while ($filas1 = mysqli_fetch_array($query)) {
                                                                            ?>
                                                <option value="<?php echo $filas1['id_usuario'] ?>"><?php echo $filas1['nombre'] . ' ' . $filas1['apellido'] ?></option>
                                            <?php
                                                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group mitad">
                                        <label>Fecha:</label>
                                        <input autocomplete="off" value="<?php echo $fechahoyval ?>" type="date" class="form-control input-group-sm" id="fecha" name="fecha">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group mitad">
                                        <label>Gasto de:</label>
                                        <select id="tipogasto" class="form-control input-sm">
                                            <option value="0">---</option>
                                            <option value="1">Moto</option>
                                            <option value="2">Encargado</option>
                                            <option value="3">Pago a Empleado</option>
                                            <option value="4">Gastos Administrativos</option>
                                        </select>
                                    </div>
                                    <div class="form-group mitad">
                                        <label>Valor:</label>
                                        <input autocomplete="off" type="number" class="form-control input-group-sm" id="valor" name="valor">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button id="agregargasto" data-dismiss="modal" type="button" class="btn btn-primary">Agregar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
            <div id="recarga">
                <TABLE class="table table-striped  table-responsive-lg" id="tablaproductos">
                    <THEAD>
                        <tr>
                            <th> Razon </th>
                            <th> Descripcion </th>
                            <th> Encargado </th>
                            <th> Ruta </th>
                            <th> Valor </th>
                            <th> Fecha </th>
                            <th> Acciones </th>
                        </tr>
                    </THEAD>
                    <TBODY>
                        <?php
                        $consultarutas = "select a.*,b.ruta,c.nombre,c.apellido from gastos a inner join rutas b on b.id_ruta=a.ruta inner join usuarios c on c.id_usuario=a.encargado";
                        $query = mysqli_query($link, $consultarutas) or die($consultarutas);
                        while ($filas1 = mysqli_fetch_array($query)) {
                        ?>
                            <TR>
                                <TD><?php
                                    $tipo = $filas1['tipo'];
                                    switch ($tipo) {
                                        case 1:
                                            echo 'Moto';
                                            break;
                                        case 2:
                                            echo 'Gastos de Encargado';
                                            break;
                                        case 3:
                                            echo 'Pago a Encargado';
                                            break;
                                        case 4:
                                            echo 'Gastos Administrativos';
                                            break;
                                    }
                                    ?> </TD>
                                <TD><?php echo $filas1['descripcion']; ?> </TD>
                                <TD><?php echo $filas1['nombre'] . ' ' . $filas1['apellido']; ?> </TD>
                                <TD><?php echo $filas1['ruta']; ?> </TD>
                                <TD><?php echo number_format($filas1['valor']); ?> </TD>
                                <TD><?php echo $filas1['fecha']; ?> </TD>
                                <TD>
                                    <SCRIPT lang="javascript" type="text/javascript" src="funciones/funciones.js"></script>
                                    <button onclick="agregaridgasto(<?php echo $filas1['id_gasto'] ?>)" type="button" id="eliminargasto" class="btn btn-danger" data-toggle="modal" data-target="#eliminar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-excel" viewBox="0 0 16 16">
                                            <path d="M5.18 4.616a.5.5 0 0 1 .704.064L8 7.219l2.116-2.54a.5.5 0 1 1 .768.641L8.651 8l2.233 2.68a.5.5 0 0 1-.768.64L8 8.781l-2.116 2.54a.5.5 0 0 1-.768-.641L7.349 8 5.116 5.32a.5.5 0 0 1 .064-.704z" />
                                            <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
                                        </svg>
                                    </button>
                                </TD>
                            </TR>
                        <?php } ?>
                    </TBODY>
                </TABLE>
            </div>
        </div>
        <div class="modal fade" id="eliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Ruta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" id="idgasto" name="idgasto">

                    <div class="modal-body">
                        <div class="form-row">
                            <h4>Esta seguro que desea eliminar el Gasto?</h4>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button id="confirmareliminar" type="button" class="btn btn-danger">Eliminar</button>
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
<script type="text/javascript">
    $(document).ready(function() {

        tabla = $('#tablaproductos').DataTable({
            language: {
                url: '../vendor/datatables/es-ar.json',
                lengthMenu: "Mostrar _MENU_ Registros",
                loadingRecords: "Cargando...",
                search: "Buscar:",
                info: "Mostrando lista de Gastos",
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
        $('#confirmareliminar').click(function() {

            id = $('#idgasto').val();
            eliminargasto(id);
            window.location.reload();
        })
    })
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#agregargasto').click(function() {
            a = 0;
            valor = $('#valor').val();
            descripcion = $('#descripcion').val();
            fecha = $('#fecha').val();
            encargado = $('#encargado').val();
            tipogasto = $('#tipogasto').val();
            if (tipogasto == "0") {
                a = 1;
                alertify.alert('ATENCION!!', 'Especificar para que fue el Gasto', function() {
                    alertify.success('Ok');
                });
            }

            if (encargado == "0") {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor escoger encargado del gasto', function() {
                    alertify.success('Ok');
                });
            }
            if (valor < 0) {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor especificar el valor del gasto', function() {
                    alertify.success('Ok');
                });
            }
            if (a == 0) {
                agregargasto(valor, descripcion, fecha, encargado, tipogasto);
                window.location.reload();
            }
        });
    });
</script>