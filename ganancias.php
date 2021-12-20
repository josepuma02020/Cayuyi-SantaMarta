<?php
session_start();
if ($_SESSION['usuario'] && $_SESSION['Rol'] == '1') {
    include_once('conexion/conexion.php');
    include_once('funciones/funciones.php');
    setlocale(LC_ALL, "es_CO");
    $fecha_actual = date("Y-m-j");
    $fecha_inicio = date("Y-m-01");
    $consultarutas = "select * from rutas";
    $queryr = mysqli_query($link, $consultarutas) or die($consultarutas);
?>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css" />
        <link rel="stylesheet" href="./diseno/ganancias/cel.css" media="screen and (max-width:650px)" />
        <link rel="stylesheet" href="./diseno/ganancias/tablet.css" media="screen and (max-width:1000px)" />
        <link rel="stylesheet" href="./diseno/ganancias/desktop.css" media="screen and (min-width:1025px)" />
        <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="librerias/alertify/css/alertify.css" />
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
        <main class="container">
            <input type="hidden" value="<?php echo $mes ?>" id="mes" />
            <input type="hidden" value="<?php echo $año ?>" id="año" />
            <div class="titulo-pagina">
                <h1 class="titulo-tabla">Contabilidad de Rutas</h1>
            </div>
            <div class="panel-botones">
                <span class="btn btn-success btn-transaccion" data-toggle="modal" data-target="#retirardinero">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash icono-boton" viewBox="0 0 16 16">
                        <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4z" />
                        <path d="M0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V6a2 2 0 0 1-2-2H3z" />
                    </svg> Registrar Transacción<span class="fa fa-plus-circle"></span>
                </span>
            </div>
            <div class="modal fade" id="retirardinero" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title titulo-modal" id="exampleModalLabel">Mover Dinero</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <img src="../../puntodeventa/imagenes/dinero.png" width="100" height="100">
                            <form id="frmtransaccion" enctype="multipart/form-data" method="post" autocomplete="off">
                                <div class="form-row">
                                    <div class="form-group modal-mediano">
                                        <label>T.Transacción:</label>
                                        <select class="form-control input-sm" id="tipo" name="tipo">
                                            <option value="0" selected>Seleccione</option>
                                            <option value="1">Retiro</option>
                                            <option value="2">Consignación</option>
                                        </select>
                                    </div>
                                    <div class="form-group modal-mediano ">
                                        <label>Ruta:</label>
                                        <select id="ruta" class="form-control input-sm">
                                            <?php
                                            $consultausuarios = "select * from rutas";
                                            $query = mysqli_query($link, $consultausuarios) or die($consultausuarios);
                                            ?> <option value="0"></option>
                                            <?php
                                            while ($filas1 = mysqli_fetch_array($query)) {
                                            ?>
                                                <option value="<?php echo $filas1['id_ruta'] ?>"><?php echo $filas1['ruta'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group modal-mediano">
                                        <label>V.Base($):</label>
                                        <input disabled type="text" class="form-control input-sm" id="base" name="base">
                                    </div>
                                    <div class="form-group modal-mediano ">
                                        <label>V.Retirar($):</label>
                                        <input type="text" class="form-control input-sm" id="valorretiro" name="valorretiro">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group modal-largo ">
                                        <label>Comentarios:</label>
                                        <input class="form-control input-group-lg" type="text" id="comentario">
                                    </div>

                                </div>
                            </form>
                            <h5>Recuerde que el valor debe estar divido entre 1000.(Ejemplo: Para 32.000 debe registrarse como 32)</h5>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary boton-modal" data-dismiss="modal">Cancelar</button>
                            <button id="realizar" data-dismiss="modal" type="button" class="btn btn-primary boton-modal">Mover</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tablas">
                <?php
                while ($filas1 = mysqli_fetch_array($queryr)) {
                ?>
                    <table class="tabla-valores">
                        <thead>
                            <tr>
                                <th colspan="2">
                                    <h2 class="titulo-tabla-detalles"><?php echo $filas1['ruta'] ?></h2>
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    Cuenta
                                </th>
                                <th>
                                    Valor
                                </th>


                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td class="cuenta">
                                    <p>Base</p>
                                </td>
                                <TD class="valor">
                                    <p><?php echo $filas1['base']; ?></p>
                                </TD>
                            </tr>
                            <tr>
                                <?php
                                $consultaprestado = "select valorapagar,valor_prestamo,((valorapagar)-(valor_prestamo))'intereses',abonado from prestamos where ruta=$filas1[id_ruta] and valorapagar - abonado > 0";
                                $querycg = mysqli_query($link, $consultaprestado) or die($consultaprestado);
                                $intereses = 0;
                                $prestado = 0;
                                while ($filas2 = mysqli_fetch_array($querycg)) {
                                    if ($filas2['abonado'] > $filas2['valor_prestamo']) {
                                        $intereses = $intereses + $filas2['valorapagar'] - $filas2['abonado'];
                                    } else {
                                        $intereses = $intereses + $filas2['valorapagar'] - $filas2['valor_prestamo'];
                                        $prestado = $prestado + $filas2['valor_prestamo'] - $filas2['abonado'];
                                    }
                                }
                                ?>
                                <td class="cuenta">
                                    <p>Dinero a Recuperar</p>
                                </td>
                                <td class="valor"><?php echo $prestado; ?></TD>
                            </tr>
                            <tr>
                                <td class="cuenta">
                                    <p>Intereses a Recuperar</p>
                                </td>
                                <td class="valor"><?php echo $intereses; ?></TD>
                            </tr>
                            <tr>
                                <td class="cuenta">
                                    <p>Total</p>
                                </td>
                                <td class="valor"><?php echo $intereses + $prestado + $filas1['base']; ?></td>
                            </tr>
                    </table>
                <?php } ?>

            </div>

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
<script type="text/javascript">
    $(document).ready(function() {
        $('#realizar').click(function() {
            a = 0;
            valorretiro = $('#valorretiro').val();
            ruta = $('#ruta').val();
            tipo = $('#tipo').val();
            base = $('#base').val();
            comentario = $('#comentario').val();
            if (tipo == 0) {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor escoger el tipo de transacción', function() {
                    alertify.success('Ok');
                });
            }
            if (ruta == 0) {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor escoger una ruta', function() {
                    alertify.success('Ok');
                });
            }
            if (base < valorretiro) {
                a = 1;
                alertify.alert('ATENCION!!', 'No es posible realizar la transacción', function() {
                    alertify.success('Ok');
                });
            }
            if (a == 0) {
                transaccion(valorretiro, ruta, tipo, comentario);
                window.location.reload();
            }
        })
    })
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#ruta').change(function() {
            id = $('#ruta').val();
            $.ajax({
                type: "POST",
                data: "id=" + id,
                url: "rutas/baseruta.php",
                success: function(r) {
                    console.log(r);
                    dato = jQuery.parseJSON(r);
                    $('#base').val(dato['base']);
                }
            });
        });
    });
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