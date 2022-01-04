<?php
session_start();
if ($_SESSION['usuario'] && $_SESSION['Rol'] == 1) {
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
        <link rel="stylesheet" href="diseno/defecto/desktop.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <SCRIPT src="librerias/jquery-3.5.1.min.js"></script>
        <SCRIPT src="librerias/alertify/alertify.js"></script>
        <SCRIPT lang="javascript" type="text/javascript" src="./rutas/rutas.js"></script>
        <script src="librerias/bootstrap/js/bootstrap.js"></script>
        <?php include_once('diseno/navegadoradmin.php'); ?>
    </head>

    <body>
        <header>
            <?php include_once($_SESSION['menu']); ?>
        </header>
        <div class=" container container-md">
            <section class="titulo-pagina">
                <h1>Tabla de Rutas</h1>
            </section>
            <div class="card-body">
                <span class="btn btn-primary" data-toggle="modal" data-target="#nuevousuario">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-plus" viewBox="0 0 16 16">
                        <path d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z" />
                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                    </svg> Nueva Ruta<span class="fa fa-plus-circle"></span>
                </span>
                <div class="modal fade" id="nuevousuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Nueva Ruta</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-row">
                                    <div class="form-group mitad">
                                        <label>Nombre de Ruta:</label>
                                        <input autocomplete="off" type="text" class="form-control input-group-sm" id="nombre" name="nombre">
                                    </div>
                                    <div class="form-group mitad">
                                        <label>Encargado:</label>
                                        <select id="encargado" class="form-control input-sm">
                                            <?php
                                            $consultausuarios = "select * from usuarios";
                                            $query = mysqli_query($link, $consultausuarios) or die($consultausuarios);
                                            ?> <option value="0"></option>
                                            <?php
                                            while ($filas1 = mysqli_fetch_array($query)) {
                                            ?>
                                                <option value="<?php echo $filas1['id_usuario'] ?>"><?php echo $filas1['nombre'] . ' ' . $filas1['apellido'] ?></option>
                                            <?php
                                            }
                                            ?>


                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button id="agregarruta" data-dismiss="modal" type="button" class="btn btn-primary">Agregar</button>
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
                            <th> Ruta </th>
                            <th> Encargado </th>
                            <th> Clientes </th>
                            <th> Atrasados </th>
                            <th> Recaudo Máximo </th>
                            <th> Pen.Prestado </th>
                            <th> Pen.Intereses </th>
                            <th> Acciones </th>
                        </tr>
                    </THEAD>
                    <TBODY>

                        <?php
                        $consultarutas = "SELECT a.ruta,a.id_ruta,COUNT(b.id_prestamo)'clientes',c.nombre,c.apellido 
                            from rutas a left join prestamos b on b.ruta=a.id_ruta 
                            inner join usuarios c on a.encargado=c.id_usuario GROUP by a.id_ruta";
                        $query = mysqli_query($link, $consultarutas) or die($consultarutas);
                        while ($filas1 = mysqli_fetch_array($query)) {
                            $consultaatrasados = "select sum(`valorapagar`/`dias_prestamo`)'recaudo',COUNT(id_prestamo)'atrasados' from prestamos where dias_atraso > 0 and ruta =$filas1[id_ruta]  and valorapagar>abonado";
                            $query1 = mysqli_query($link, $consultaatrasados) or die($consultaatrasados);
                            $atrasados = mysqli_fetch_array($query1);
                            $clientesatrasados = $atrasados['atrasados'];
                            if ($clientesatrasados >= 5) {
                                $clase = "aviso1";
                            } else {
                                $clase = "";
                            }
                        ?>
                            <TR>
                                <TD><?php echo $filas1['ruta']; ?> </TD>
                                <TD><?php echo $filas1['nombre'] . ' ' . $filas1['apellido']; ?> </TD>
                                <TD><?php echo $filas1['clientes']; ?> </TD>
                                <TD class="<?php echo $clase; ?>"><?php echo $clientesatrasados; ?> </TD>
                                <TD><?php
                                    $consultarecaudo = "select sum(valorapagar-valor_prestamo)'intereses',sum(valor_prestamo)'prestado',sum(`valorapagar`/`dias_prestamo`)'recaudo' from prestamos where  ruta =$filas1[id_ruta]  and valorapagar>abonado";
                                    $query2 = mysqli_query($link, $consultarecaudo) or die($consultarecaudo);
                                    $recaudo = mysqli_fetch_array($query2);
                                    $valorrecaudo = round($recaudo['recaudo'], 2);
                                    echo $valorrecaudo;
                                    ?></TD>
                                <TD><?php echo $recaudo['prestado']; ?> </TD>
                                <TD><?php echo $recaudo['intereses']; ?> </TD>

                                <TD>
                                    <SCRIPT lang="javascript" type="text/javascript" src="funciones/funciones.js"></script>
                                    <button onclick="agregardatosruta(<?php echo $filas1['id_ruta'] ?>)" type="button" id="actualiza" class="btn btn-primary" data-toggle="modal" data-target="#editar">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pen" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M13.498.795l.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z" />
                                        </svg>
                                    </button>
                                    <a target="_blank" href="rutas/guia.php?ruta=<?php echo $filas1['id_ruta'] ?>">
                                        <button title="Ver guía" type="button" id="guia" class="btn btn-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf" viewBox="0 0 16 16">
                                                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z" />
                                                <path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z" />
                                            </svg>
                                        </button>
                                    </a>
                                </TD>

                            </TR>
                        <?php } ?>
                    </TBODY>

                </TABLE>

            </div>
        </div>

        <div class="modal fade" id="editar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Ruta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" value="<?php echo $filas1['id_ruta'] ?>" id="idruta" name="idruta">

                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group mitad">
                                <label>Nombre de Ruta:</label>
                                <input autocomplete="off" type="text" style="font-size: medium" class="form-control input-group-sm" id="nombreu" name="nombreu">
                            </div>
                            <div class="form-group mitad">
                                <label>Encargado:</label>
                                <select id="encargadou" class="form-control input-sm">
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
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button id="editarruta" type="button" class="btn btn-primary">Editar Ruta</button>
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
            nombre = $('#nombreu').val();
            encargado = $('#encargadou').val();
            idruta = $('#idruta').val();
            console.log(nombre);

            if (a == 0) {

                editarruta(idruta, nombre, encargado);
                window.location.reload();
            }
        })
    })
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#agregarruta').click(function() {
            a = 0;
            nombre = $('#nombre').val();
            encargado = $('#encargado').val();
            if (nombre == "" || nombre.length < 4) {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor revisar el nombre de la ruta:El nombre de la ruta debe tener mas de 4 letras', function() {
                    alertify.success('Ok');
                });
            }
            if (encargado == "0") {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor escoger encargado de ruta', function() {
                    alertify.success('Ok');
                });
            }
            if (a == 0) {
                debugger;
                agregarruta(nombre, encargado);
                window.location.reload();
            }
        })
    })
</script>