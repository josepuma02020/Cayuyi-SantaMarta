<?php
session_start();
if ($_SESSION['usuario']) {
    include_once('conexion/conexion.php');
    include_once('funciones/funciones.php');
    setlocale(LC_ALL, "es_CO");
    $fechahoyval = date("Y") . '-' . date("m") . '-' . date("j");
    //autocompletar cliente
    $consulta = "SELECT `cedula`  FROM `clientes` ";
    $queryt = mysqli_query($link, $consulta) or die($consulta);
    $productos[] = array();
    while ($arregloproductos = mysqli_fetch_row($queryt)) {
        $productos[] = $arregloproductos[0];
    }
    array_shift($productos);
    $relleno = json_encode($productos);
    if (isset($_GET['desde'])) {
        $desde = $_GET['desde'];
    } else {
        $desde = date("Y-m-01");
    }
    if (isset($_GET['hasta'])) {
        $hasta = $_GET['hasta'];
    } else {
        $hasta = date("Y-m-d");
    }
?>
    <HTML>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css" />
        <link rel="stylesheet" href="diseno/defecto.css" />
        <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="librerias/alertify/css/alertify.css" />
        <link rel="stylesheet" type="text/css" href="librerias/alertify/css/themes/default.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <SCRIPT src="librerias/jquery-3.5.1.min.js"></script>
        <SCRIPT src="librerias/alertify/alertify.js"></script>
        <SCRIPT lang="javascript" type="text/javascript" src="funciones/funciones.js"></script>
        <script src="librerias/bootstrap/js/bootstrap.js"></script>
        <link type="text/css" href="librerias/jquery-ui-1.12.1.custom/jquery-ui.structure.min.css" rel="Stylesheet" />

    </head>

    <body>
        <header>
            <?php include_once('diseno/navegadoradmin.php'); ?>
        </header>
        <main>
            <div class=" container container-md" style="min-height: 40% " align="left">
                <div>
                    <h1 style="font-family:  monospace;">Registros Contables</h1>
                </div>
                <form class="form-group col-md-3">
                    <label for="ruta">
                        <h3 style="font-family:  monospace;">Ruta:</h3>
                        <select id="ruta" class="form-control input-sm">
                            <?php
                            $consultausuarios = "select a.*,COUNT(b.id_prestamo)'recorridos',c.nombre,c.apellido from rutas a left join prestamos b on a.id_ruta = b.ruta inner join usuarios c on c.id_usuario = a.encargado GROUP by a.id_ruta";
                            $query = mysqli_query($link, $consultausuarios) or die($consultausuarios);
                            ?> <option value="0"></option> <?php
                                                            while ($filas1 = mysqli_fetch_array($query)) {
                                                            ?>
                                <option value="<?php echo $filas1['id_ruta'] ?>"><?php echo $filas1['ruta'] . '  -  ' . $filas1['nombre'] . ' ' . $filas1['apellido'] ?></option>
                            <?php
                                                            }
                            ?>
                        </select>
                    </label>

                    <div class="form-group col-md-3">
                        <h3 style="font-family:  monospace;">Desde:</h3>
                        <input class="form-control input-sm" type="date" id="desde" value="<?php echo $desde ?>">
                    </div>
                    <div class="form-group col-sm-3">
                        <h3 style="font-family:  monospace;">Hasta:</h3>
                        <input class="form-control input-sm" type="date" id="hasta" value="<?php echo $hasta ?>">

                    </div>
                    <button style="top: 55px;right: 55px" type="button" id="buscar" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </form>
                <hr />
                <hr />

                <div id="recarga">
                    <br>
                    <TABLE class="table table-striped  table-responsive-lg" id="tablaproductos">
                        <THEAD>
                            <tr>
                                <th> Ruta </th>
                                <th> Encargado </th>
                                <th> Base </th>
                                <th> Cobro </th>
                                <th> Pleno </th>
                                <th> Prestamos</th>
                                <th> Papeleria </th>
                                <th> Gastos </th>
                                <th> Efectivo </th>
                                <th> Nuevos </th>
                                <th> Entrantes </th>
                                <th> Salientes </th>
                                <th> Clientes </th>
                                <th> Fecha </th>
                            </tr>
                        </THEAD>
                        <TBODY>
                            <?php
                            $consultarutas = "SELECT a.*,b.nombre,b.apellido,c.ruta 'nruta' from revisionesrutas a inner join usuarios b on a.encargado=b.id_usuario inner join rutas c on c.id_ruta=a.ruta where fecha between '$desde' and '$hasta'";
                            $query = mysqli_query($link, $consultarutas) or die($consultarutas);
                            while ($filas1 = mysqli_fetch_array($query)) {
                            ?>
                                <TR>
                                    <TD><?php echo $filas1['nruta'] ?> </TD>
                                    <TD><?php echo $filas1['nombre'] . ' ' . $filas1['apellido']; ?> </TD>
                                    <TD><?php echo $filas1['base'] ?> </TD>
                                    <TD><?php echo $filas1['cobro'] ?> </TD>
                                    <TD><?php echo $filas1['pleno']; ?> </TD>
                                    <TD><?php echo $filas1['prestamo']; ?> </TD>
                                    <TD><?php echo $filas1['papeleria']; ?> </TD>
                                    <TD><?php echo $filas1['gastos']; ?> </TD>
                                    <TD><?php echo $filas1['efectivo']; ?> </TD>
                                    <TD><?php echo $filas1['nuevos']; ?> </TD>
                                    <TD><?php echo $filas1['entrantes']; ?> </TD>
                                    <TD><?php echo $filas1['salientes']; ?> </TD>
                                    <TD><?php echo $filas1['clientes']; ?> </TD>
                                    <TD><?php echo $filas1['fecha']; ?> </TD>
                                </TR>
                            <?php } ?>
                        </TBODY>

                    </TABLE>

                </div>


                <div class="modal fade  " id="editar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg  " >
                        <div class="modal-content" >
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><b>Nuevo Prestamo</b></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" >
                                <div class="form-row autocompletar">
                                    <div class="form-group col-sm-4">
                                        <label>Cedula:</label>
                                        <input disabled autocomplete="off" type="hidden" style="font-size: medium" class="form-control input-group-sm" id="idu" name="idu" />
                                        <input disabled autocomplete="off" type="text" style="font-size: medium" class="form-control input-group-sm" id="cedulau" name="cedulau">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Nombre:</label>
                                        <input disabled autocomplete="off" disabled type="text" style="font-size: medium" class="form-control input-group-sm" id="nombreu" name="nombreu">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Ruta Actual:</label>
                                        <input disabled autocomplete="off" disabled type="text" style="font-size: medium" class="form-control input-group-sm" id="rutaactual" name="rutaactual">
                                    </div>

                                </div>
                                <div class="form-row">
                                    <div class="form-group col-sm-4">
                                        <label>Cambiar a Ruta:</label>
                                        <select id="nruta" class="form-control input-sm">
                                            <?php
                                            $consultausuarios = "select a.*,COUNT(b.id_prestamo)'recorridos',c.nombre,c.apellido from rutas a left join prestamos b on a.id_ruta = b.ruta inner join usuarios c on c.id_usuario = a.encargado  GROUP by a.id_ruta";
                                            $query = mysqli_query($link, $consultausuarios) or die($consultausuarios);
                                            ?> <option value="0"></option> <?php
                                                                            while ($filas1 = mysqli_fetch_array($query)) {
                                                                            ?>
                                                <option value="<?php echo $filas1['id_ruta'] ?>"><?php echo $filas1['recorridos'] . '-' . $filas1['ruta'] . '-' . $filas1['nombre'] . ' ' . $filas1['apellido'] ?></option>
                                            <?php
                                                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Fecha de Inicio:</label>
                                        <input disabled autocomplete="off" type="text" style="font-size: medium" class="form-control input-group-sm" id="fechau" name="fechau">
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label>Valor Prestamo:</label>
                                        <input disabled type="text" style="font-size: medium" class="form-control input-group-sm" id="valoru" name="valoru">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Valor a Pagar:</label>
                                        <input autocomplete="off" type="text" min="0" style="font-size: medium" class="form-control input-group-sm" id="totalpagaru" name="totalpagaru">
                                    </div>
                                </div>
                                <div class="form-row">


                                    <div class="form-group col-md-4">
                                        <label>Valor de Intereses:</label>
                                        <input disabled autocomplete="off" type="number" style="font-size: medium" class="form-control input-group-sm" id="valorinteresesu" name="valorinteresesu">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Abonado:</label>
                                        <input disabled autocomplete="off" type="number" style="font-size: medium" class="form-control input-group-sm" id="abonou" name="abonou">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Dias Atrasados:</label>
                                        <input disabled autocomplete="off" type="number" style="font-size: medium" class="form-control input-group-sm" id="atrasou" name="atrasou">
                                    </div>

                                </div>
                                <div class="form-row">
                                    <div class="form-group col-sm-4">
                                        <label>Intereses(%):</label>
                                        <input disabled autocomplete="off" type="number" style="font-size: medium" class="form-control input-group-sm" id="porcentajeu" name="porcentajeu">
                                    </div>

                                    <div class="form-group col-sm-2">
                                        <label>Dias para Pagar:</label>
                                        <input autocomplete="off" min="0" type="number" style="font-size: medium" class="form-control input-group-sm" id="diasu" name="diasu">
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label>Forma de Pago:</label>
                                        <input disabled autocomplete="off" type="text" maxlength="5" style="font-size: medium" class="form-control input-group-sm" id="formau" name="formau">
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label>Cambiar Forma P.</label>
                                        <select id="nformapago" class="form-control input-sm">
                                            <option value="0" selected>------</option>
                                            <option value="1">Diario</option>
                                            <option value="15">Quincenal</option>
                                            <option value="30">Mensual</option>

                                        </select>
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label>Cuota:</label>
                                        <input disabled autocomplete="off" type="number" maxlength="5" style="font-size: medium" class="form-control input-group-sm" id="cuotau" name="cuotau">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button id="editarprestamo" data-dismiss="modal" type="button" class="btn btn-primary">Editar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr />
                </div>
            </div>
        </main>
        <footer>
            <p>Author: Pumasoft<br>
                <a href="https://www.pumasoft.co">pumasoft.co</a>
            </p>
        </footer>
    </body>

    </HTML>

<?php
} else {
    header('Location: ' . "usuarios/cerrarsesion.php");
}
?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#buscar').click(function() {
            desde = $('#desde').val();
            hasta = $('#hasta').val();
            console.log(desde);
            location.href = `contabilidad.php?desde=${desde}&hasta=${hasta}`;
        })
    })
</script>


<script type="text/javascript" src="librerias/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript" src="librerias/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>

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
<script type="text/javascript">
    $(document).ready(function() {
        $('#editarprestamo').click(function() {
            a = 0;
            idu = $('#idu').val();
            ruta = $('#nruta').val();
            totalpagar = $('#totalpagaru').val();
            prestamo = $('#valoru').val();
            dias = $('#diasu').val();
            nformapago = $('#nformapago').val();
            if (totalpagar <= prestamo) {
                a = 1;
                alertify.alert('ATENCION!!', 'El valor a pagar es menor al valor prestado', function() {
                    alertify.success('Ok');
                });
            }
            if (dias <= "0") {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor escribir en cuantos dias se pagará el prestamo:Debe ser mayor a 1', function() {
                    alertify.success('Ok');
                });
            }
            if (a == 0) {
                editarprestamo(idu, ruta, nformapago, totalpagar, dias);
                window.location.reload();
            }
        })
    })
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#agregarprestamo').click(function() {
            a = 0;
            cedula = $('#cedula').val();
            ruta = $('#ruta').val();
            posicion = $('#posicion').val();
            fecha = $('#fecha').val();
            valor = $('#valor').val();
            totalpagar = $('#totalpagar').val();
            formapago = $('#formapago').val();
            dias = $('#dias').val();
            if (cedula == "" || cedula.length < 4) {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor completar el campo "Cedula" : Debe ser mayor de 4 Digitos ', function() {
                    alertify.success('Ok');
                });
            }
            if (ruta == "0") {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor Seleccionar Ruta', function() {
                    alertify.success('Ok');
                });
            }
            if (posicion <= "0") {
                a = 1;
                alertify.alert('ATENCION!!', 'Escribir en que posicion(#) quedara asignado el prestamo en la Ruta', function() {
                    alertify.success('Ok');
                });
            }
            if (valor <= "0") {
                a = 1;
                alertify.alert('ATENCION!!', 'Escribir el Valor del Prestamo', function() {
                    alertify.success('Ok');
                });
            }
            if (totalpagar <= "0") {
                a = 1;
                alertify.alert('ATENCION!!', 'Escribir cuanto sera el Total a Pagar', function() {
                    alertify.success('Ok');
                });
            }
            if (dias <= "0") {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor escribir en cuantos dias se pagará el prestamo', function() {
                    alertify.success('Ok');
                });
            }
            if (a == 0) {
                agregarprestamo(formapago, cedula, ruta, posicion, fecha, valor, totalpagar, dias);
                window.location.reload();
            }
        })
    })
</script>