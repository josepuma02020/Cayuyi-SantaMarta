<?php
session_start();
if ($_SESSION['usuario'] && $_SESSION['Rol'] == 1) {
    include_once('conexion/conexion.php');
    setlocale(LC_ALL, "es_CO");
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
                <h1>Entrantes vs Salientes</h1>
            </section>
            <section>
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
            </section>
            <TABLE class="table table-striped  table-responsive-lg" id="tablaproductos">
                <THEAD>
                    <tr>
                        <th> Ruta </th>
                        <th> Entrantes </th>
                        <th> Salientes </th>
                    </tr>
                </THEAD>
                <TBODY>
                    <?php
                    $consultarutas = "select b.ruta,sum(a.entrantes)'entrantes',sum(a.salientes)'salientes' from revisionesrutas a 
                    INNER JOIN rutas b on b.id_ruta=a.ruta
                    where a.fecha BETWEEN '$desde' and '$hasta' GROUP by a.ruta";
                    $query = mysqli_query($link, $consultarutas) or die($consultarutas);
                    while ($filas1 = mysqli_fetch_array($query)) {
                    ?>
                        <TR>
                            <TD><?php echo $filas1['ruta'] ?> </TD>
                            <TD><?php echo $filas1['entrantes']  ?> </TD>
                            <TD><?php echo $filas1['salientes']; ?> </TD>
                        </TR>
                    <?php } ?>
                </tbody>

            </table>
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
<script type="text/javascript" src="librerias/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript" src="librerias/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#buscar').click(function() {
            a = 0;
            desde = $('#desde').val();
            hasta = $('#hasta').val();
            location.href = `entravssale.php?desde=${desde}&hasta=${hasta}`;
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