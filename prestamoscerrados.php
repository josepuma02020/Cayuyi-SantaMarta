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
if ($_SESSION['usuario'] && ($_SESSION['Rol'] == 1 || $_SESSION['Rol'] == 2)) {
    include_once('conexion/conexion.php');
    setlocale(LC_ALL, "es_CO");
    date_default_timezone_set('America/Bogota');
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
    $fechahoyval = date("Y") . '-' . date("m") . '-' . date("j");
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        $id = 0;
    }
    //autocompletar cliente
    $consulta = "SELECT `cedula`  FROM `clientes` ";
    $queryt = mysqli_query($link, $consulta) or die($consulta);
    $productos[] = array();
    while ($arregloproductos = mysqli_fetch_row($queryt)) {
        $productos[] = $arregloproductos[0];
    }
    array_shift($productos);
    $relleno = json_encode($productos);
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
                <h1>Préstamos cancelados</h1>
            </section>
            <div class="form-group col-sm-3">
                <h4>Desde:</h4>
                <input class="form-control input-sm" type="date" id="desde" name="desde" value="<?php echo $desde ?>">
            </div>
            <div class="form-group col-sm-3">
                <h4>Hasta:</h4>
                <input class="form-control input-sm" type="date" id="hasta" name="hasta" value="<?php echo $hasta ?>">
            </div>
            <button type="button" id="buscar" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                </svg>
            </button>
            <div class="modal fade  " id="nuevoprestamo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><b>Nuevo Prestamo</b></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h4 class="modal-subtitle"> Datos Cliente</h4>
                            <div class="form-row ">
                                <div class="form-group tres">
                                    <label>Cedula:</label>
                                    <input autocomplete="off" type="text" class="form-control" id="cedula" name="cedula">
                                </div>
                                <div class="form-group tres">
                                    <label>Nombre:</label>
                                    <input autocomplete="off" type="text" class="form-control input-group-sm" id="nombre" name="nombre">
                                </div>
                                <div class="form-group tres">
                                    <label>Telefono:</label>
                                    <input autocomplete="off" type="text" class="form-control" id="telefono" name="telefono">
                                </div>
                            </div>
                            <div class="form-row ">

                                <div class="form-group mitad">
                                    <label>Direccion:</label>
                                    <input autocomplete="off" type="text" class="form-control input-group-sm" id="direccion" name="direccion">
                                </div>
                                <div class="form-group mitad">
                                    <label>Comentario:</label>
                                    <input disabled autocomplete="off" type="text" class="form-control input-group-sm" id="nota" name="nota">
                                </div>
                            </div>
                            <h4 class="modal-subtitle">Ultimo préstamo</h4>
                            <div class="form-row ">
                                <div class="form-group tres">
                                    <label>Activo?:</label>
                                    <input disabled autocomplete="off" type="text" class="form-control input-group-sm" id="prestamos_activos" name="prestamos_activos">
                                </div>
                                <div class="form-group tres">
                                    <label>Valor Ult.Préstamo:</label>
                                    <input disabled autocomplete="off" type="numbre" class="form-control input-group-sm" id="ultprestamo" name="ultprestamo">
                                </div>
                                <div class="form-group tres">
                                    <label>Fecha Ult.Prestamo:</label>
                                    <input autocomplete="off" disabled type="date" class="form-control input-group-sm" id="fechault" name="fechault">
                                </div>
                                <div class="form-group cuatro">
                                    <label>Plazo(dias):</label>
                                    <input disabled autocomplete="off" type="text" class="form-control input-group-sm" id="plazoult" name="plazoult">
                                </div>
                                <div class="form-group cuatro">
                                    <label>D.A:</label>
                                    <input disabled autocomplete="off" type="text" class="form-control input-group-sm" id="diasatraso" name="diasatraso">
                                </div>
                            </div>
                            <div class="form-row ">
                                <div class="form-group tres">
                                    <label>Debe:</label>
                                    <input disabled autocomplete="off" type="number" class="form-control input-group-sm" id="debe" name="debe">
                                </div>
                                <div class="form-group tres">
                                    <label>Ruta:</label>
                                    <input autocomplete="off" disabled type="text" class="form-control input-group-sm" id="rutapre" name="rutapre">
                                </div>
                                <div class="form-group tres">
                                    <label>Fecha de Cierre:</label>
                                    <input disabled autocomplete="off" type="date" class="form-control input-group-sm" id="fechacierre" name="fechacierre">
                                </div>
                            </div>
                            <h4 class="modal-subtitle">Nuevo Préstamo</h4>
                            <div class="form-row">
                                <div class="form-group tres">
                                    <label>Ruta:</label>
                                    <select id="ruta" class="form-control input-sm">
                                        <?php
                                        $consultausuarios = "select a.*,COUNT(b.id_prestamo)'recorridos',c.nombre,c.apellido from rutas a left join prestamos b on a.id_ruta = b.ruta inner join usuarios c on c.id_usuario = a.encargado GROUP by a.id_ruta";
                                        $query = mysqli_query($link, $consultausuarios) or die($consultausuarios);
                                        ?> <option value="0"></option>
                                        <?php
                                        while ($filas1 = mysqli_fetch_array($query)) {
                                        ?>
                                            <option value="<?php echo $filas1['id_ruta'] ?>"><?php echo $filas1['ruta'] . '  -  ' . $filas1['nombre'] . ' ' . $filas1['apellido'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group tres">
                                    <label>Fecha de Inicio:</label>
                                    <?php
                                    $fechahoyval = date('Y-m-d');
                                    ?>
                                    <input autocomplete="off" value="<?php echo $fechahoyval; ?>" type="date" class="form-control input-group-sm" id="fecha" name="fecha">
                                </div>
                                <div class="form-group tres">
                                    <label>Papeleria:</label>
                                    <input autocomplete="off" min="0" value="" type="number" class="form-control input-group-sm" id="papeleria" name="papeleria">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group tres">
                                    <label>Valor Prestamo:</label>
                                    <input type="text" class="form-control input-group-sm" id="valor" name="valor">
                                </div>
                                <div class="form-group tres">
                                    <label>Valor a Pagar:</label>
                                    <input autocomplete="off" type="text" min="0" class="form-control input-group-sm" id="totalpagar" name="totalpagar">
                                </div>
                                <div class="form-group tres">
                                    <label>Valor de Intereses:</label>
                                    <input disabled autocomplete="off" type="number" class="form-control input-group-sm" id="valorintereses" name="valorintereses">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group tres">
                                    <label>Intereses(%):</label>
                                    <input step="0.01" disabled autocomplete="off" type="number" class="form-control input-group-sm" id="porcentaje" name="porcentaje">
                                </div>
                                <div class="form-group cuatro">
                                    <label>Dias:</label>
                                    <input autocomplete="off" min="0" type="number" class="form-control input-group-sm" id="dias" name="dias">
                                </div>
                                <div class="form-group cuatro">
                                    <label>P.Domingo:</label>
                                    <input autocomplete="off" min="0" value="0" type="number" class="form-control input-group-sm" id="domingo" name="domingo">
                                </div>
                                <div class="form-group cuatro">
                                    <label>For.Pago:</label>
                                    <select id="formapago" class="form-control input-sm">
                                        <option value="1">Diario</option>
                                        <option value="7">Semanal</option>
                                        <option value="15">Quincenal</option>
                                        <option value="30">Mensual</option>
                                    </select>
                                </div>
                                <div class="form-group cuatro">
                                    <label>Cuota:</label>
                                    <input disabled autocomplete="off" type="number" maxlength="5" class="form-control input-group-sm" id="cuota" name="cuota">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button id="agregarprestamo" data-dismiss="modal" type="button" class="btn btn-primary">Agregar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
            </div>

            <TABLE class="table table-striped  table-responsive-lg" id="tablaproductos">
                <THEAD>
                    <tr>
                        <th> Ruta </th>
                        <th> Cliente </th>
                        <th> F.Préstamo</th>
                        <th> V.Prestado </th>
                        <th> V.a pagar </th>
                        <th> F.Cierre </th>
                        <th> Detalles </th>
                    </tr>
                </THEAD>
                <TBODY>
                    <?php
                    $consultarutas = "select a.fechacierre,a.cliente,c.ruta'nombreruta',a.fecha,a.id_prestamo,b.nombre,a.valor_prestamo,valorapagar,abonado,dias_atraso from prestamos a inner join clientes b on a.cliente=b.id_cliente inner join rutas c on c.id_ruta=a.ruta where a.valorapagar <= (a.abonado) and a.fechacierre BETWEEN '$desde' and '$hasta'";
                    $query = mysqli_query($link, $consultarutas) or die($consultarutas);
                    while ($filas1 = mysqli_fetch_array($query)) {
                    ?>
                        <TR>
                            <TD><?php echo $filas1['nombreruta'] ?> </TD>
                            <TD>
                                <a href="historialcuotas.php?cliente=<?php echo $filas1['cliente']  ?>"><?php echo $filas1['nombre']  ?> </a>
                            </TD>
                            <TD><?php echo $filas1['fecha']; ?> </TD>
                            <TD><?php echo number_format($filas1['valor_prestamo']); ?> </TD>
                            <TD><?php echo number_format($filas1['valorapagar']); ?> </TD>
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
            <div class="modal fade  " id="editar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg  ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><b>Préstamo</b></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row ">
                                <div class="form-group tres">
                                    <label>Cedula:</label>
                                    <input disabled autocomplete="off" type="hidden" class="form-control input-group-sm" id="idu" name="idu" />
                                    <input disabled autocomplete="off" type="text" class="form-control input-group-sm" id="cedulau" name="cedulau">
                                </div>
                                <div class="form-group tres">
                                    <label>Nombre:</label>
                                    <input disabled autocomplete="off" disabled type="text" class="form-control input-group-sm" id="nombreu" name="nombreu">
                                </div>
                                <div class="form-group tres">
                                    <label>Ruta Actual:</label>
                                    <input disabled autocomplete="off" disabled type="text" class="form-control input-group-sm" id="rutaactual" name="rutaactual">
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="form-group tres">
                                    <label>Fecha de Inicio:</label>
                                    <input disabled autocomplete="off" type="text" class="form-control input-group-sm" id="fechau" name="fechau">
                                </div>
                                <div class="form-group cuatro">
                                    <label>Val.Préstamo:</label>
                                    <input disabled type="text" class="form-control input-group-sm" id="valoru" name="valoru">
                                </div>
                                <div class="form-group cuatro">
                                    <label>Valor a Pagar:</label>
                                    <input disabled autocomplete="off" type="text" min="0" class="form-control input-group-sm" id="totalpagaru" name="totalpagaru">
                                </div>
                            </div>
                            <div class="form-row">


                                <div class="form-group tres">
                                    <label>Valor de Intereses:</label>
                                    <input disabled autocomplete="off" type="number" class="form-control input-group-sm" id="valorinteresesu" name="valorinteresesu">
                                </div>
                                <div class="form-group tres">
                                    <label>Abonado:</label>
                                    <input disabled autocomplete="off" type="number" class="form-control input-group-sm" id="abonou" name="abonou">
                                </div>
                                <div class="form-group tres">
                                    <label>Dias Atrasados:</label>
                                    <input disabled autocomplete="off" type="number" class="form-control input-group-sm" id="atrasou" name="atrasou">
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="form-group tres">
                                    <label>Intereses(%):</label>
                                    <input disabled autocomplete="off" type="number" class="form-control input-group-sm" id="porcentajeu" name="porcentajeu">
                                </div>

                                <div class="form-group cuatro">
                                    <label>Dias:</label>
                                    <input disabled autocomplete="off" min="0" type="number" class="form-control input-group-sm" id="diasu" name="diasu">
                                </div>
                                <div class="form-group cuatro">
                                    <label>For.Pago:</label>
                                    <input disabled autocomplete="off" type="text" maxlength="5" class="form-control input-group-sm" id="formau" name="formau">
                                </div>
                                <div class="form-group cuatro">
                                    <label>Cuota:</label>
                                    <input disabled autocomplete="off" type="number" maxlength="5" class="form-control input-group-sm" id="cuotau" name="cuotau">
                                </div>

                            </div>
                            <h4 class="modal-subtitle">Refinanciación</h4>
                            <div class="form-row">
                                <div class="form-group tres">
                                    <label>Fecha refinanciación:</label>
                                    <input disabled autocomplete="off" type="text" class="form-control input-group-sm" id="fecharef" name="fecharef">
                                </div>
                                <div class="form-group tres">
                                    <label>Nuevo Valor a pagar:</label>
                                    <input autocomplete="off" type="number" class="form-control input-group-sm" id="valorref" name="valorref">
                                </div>

                                <div class="form-group tres">
                                    <label>Plazo:</label>
                                    <input autocomplete="off" min="0" type="number" class="form-control input-group-sm" id="diasref" name="diasref">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group completo">
                                    <label>Comentario:</label>
                                    <input disabled autocomplete="off" type="text" class="form-control input-group-sm" id="comentariou" name="comentariou">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
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
        $('#buscar').click(function() {
            a = 0;
            desde = $('#desde').val();
            hasta = $('#hasta').val();
            location.href = `prestamoscerrados.php?desde=${desde}&hasta=${hasta}`;
        });
        $('#nformapago').change(function() {
            dias = $('#diasu').val();
            totalpagar = $('#totalpagaru').val();
            nformapago = $('#nformapago').val();
            $('#cuotau').val((totalpagar / dias).toFixed(2) * nformapago);
        });
        $('#formapago').change(function() {
            dias = $('#dias').val();
            totalpagar = $('#totalpagar').val();
            formapago = $('#formapago').val();
            $('#cuota').val((totalpagar / dias).toFixed(2) * formapago);
        });
        $('#dias').change(function() {
            dias = $('#dias').val();
            totalpagar = $('#totalpagar').val();
            formapago = $('#formapago').val();
            $('#cuota').val((totalpagar / dias).toFixed(2) * formapago);
        });
        $('#diasu').change(function() {
            dias = $('#diasu').val();
            totalpagar = $('#totalpagaru').val();
            $('#cuotau').val((totalpagar / dias).toFixed(2));
        });
        $('#totalpagar').change(function() {
            dias = $('#dias').val();
            totalpagar = $('#totalpagar').val();
            $('#cuota').val((totalpagar / dias).toFixed(2));
        });
        $('#totalpagaru').change(function() {
            dias = $('#diasu').val();
            totalpagar = $('#totalpagaru').val();
            $('#cuotau').val((totalpagar / dias).toFixed(2));
        });
        $('#totalpagar').change(function() {
            valor = $('#valor').val();
            totalpagar = $('#totalpagar').val();
            porcentaje = (((totalpagar - valor) * 100) / valor);
            porcentaje = porcentaje.toFixed(2);
            $('#porcentaje').val(porcentaje);
            $('#valorintereses').val((totalpagar - valor));

        });
        $('#totalpagaru').change(function() {
            valor = $('#valoru').val();
            totalpagar = $('#totalpagaru').val();
            porcentaje = (((totalpagar - valor) * 100) / valor);
            porcentaje = porcentaje.toFixed(2);
            $('#porcentaje').val(porcentaje);
            $('#valorinteresesu').val((totalpagar - valor));

        });
        $('#valor').change(function() {
            valor = $('#valor').val();
            totalpagar = $('#totalpagar').val();
            porcentaje = (((totalpagar - valor) * 100) / valor);
            porcentaje = porcentaje.toFixed(2);
            $('#valorintereses').val((totalpagar - valor));
            $('#porcentaje').val(porcentaje);
        });
        $('#cedula').change(function() {
            $.ajax({
                type: "POST",
                url: "prestamos/datoscliente.php",
                data: "cliente=" + $('#cedula').val(),
                success: function(r) {
                    dato = jQuery.parseJSON(r);
                    $('#nombre').val(dato['nombre']);
                    $('#apellido').val(dato['apellido']);
                    $('#prestamos_activos').val(dato['prestamos']);
                    $('#ultprestamo').val(dato['valorultimo']);
                    $('#fechault').val(dato['fecha']);
                    $('#diasatraso').val(dato['dias']);
                    $('#debe').val(dato['debe']);
                    $('#rutapre').val(dato['ruta']);
                    $('#fechacierre').val(dato['cierre']);
                    $('#plazoult').val(dato['diasprestamo']);
                    $('#telefono').val(dato['telefono']);
                    $('#direccion').val(dato['direccion']);
                    $('#nota').val(dato['nota']);
                    console.log(dato['nombre']);
                }
            });
        });
        disponible = (<?php echo $relleno ?>);
        $("#cedula").autocomplete({
            source: disponible,
            lookup: disponible,
            minLength: 4
        });
        $("#cedula").autocomplete("option", "appendTo", ".eventInsForm");
        tabla = $('#tablaproductos').DataTable({
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
        $('#agregarprestamo').click(function() {
            a = 0;
            papeleria = $('#papeleria').val();
            cedula = $('#cedula').val();
            ruta = $('#ruta').val();
            posicion = $('#posicion').val();
            fecha = $('#fecha').val();
            valor = $('#valor').val();
            totalpagar = $('#totalpagar').val();
            formapago = $('#formapago').val();
            dias = $('#dias').val();
            direccion = $('#direccion').val();
            telefono = $('#telefono').val();
            nombre = $('#nombre').val();
            apellido = $('#apellido').val();
            domingo = $('#domingo').val();
            if (apellido == "") {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor completar el campo "Apellido" : Debe ser mayor de 4 Digitos ', function() {
                    alertify.success('Ok');
                });
            }
            if (nombre == "") {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor completar el campo "Nombre" : Debe ser mayor de 4 Digitos ', function() {
                    alertify.success('Ok');
                });
            }
            if (direccion == "" || direccion.length < 4) {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor completar el campo "Direccion" : Debe ser mayor de 4 Digitos ', function() {
                    alertify.success('Ok');
                });
            }
            if (telefono == "" || telefono.length < 4) {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor completar el campo "Telefono" : Debe ser mayor de 4 Digitos ', function() {
                    alertify.success('Ok');
                });
            }
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
                agregarprestamo(formapago, cedula, ruta, posicion, fecha, valor, totalpagar, dias, papeleria, direccion, telefono, nombre, apellido, domingo);
                window.location.reload();
            }
        });
    });
</script>