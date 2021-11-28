<?php
session_start();
if ($_SESSION['usuario'] && $_SESSION['Rol'] == 'Administrador') {
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
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
            <meta charset="utf-8"/>
            <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
            <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css"/>
            <link rel="stylesheet" href="diseno/defecto.css" />
            <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css" />
            <link rel="stylesheet" type="text/css" href="librerias/alertify/css/alertify.css" />
            <link rel="stylesheet" type="text/css" href="librerias/alertify/css/themes/default.css" />
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
            <SCRIPT src="librerias/jquery-3.5.1.min.js"></script>
            <SCRIPT src="librerias/alertify/alertify.js"></script>
            <SCRIPT lang="javascript" type="text/javascript" src="funciones/funciones.js"></script>
            <script src="librerias/bootstrap/js/bootstrap.js"></script>
            <?php include_once('diseno/navegadoradmin.php'); ?>
        </head>
        <body>
            <input type="hidden" value="<?php echo $mes ?>" id="mes"/> 
            <input type="hidden" value="<?php echo $año ?>" id="año"/> 
            <div  class="container" >
                <div align="center"> 
                    <h1 style="font-family:  monospace;">BALANCE GENERAL</h1>
                </div>
                <span class="btn btn-success"  data-toggle="modal" style="font-size: medium; "  data-target="#retirardinero">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash" viewBox="0 0 16 16">
                        <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                        <path d="M0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V6a2 2 0 0 1-2-2H3z"/>
                    </svg> Registrar Transacción<span class="fa fa-plus-circle"></span>
                </span>
                <div class="modal fade" id="retirardinero" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" align="center" >
                        <div class="modal-content" align="center">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel" style="font-size: medium; font-weight: bold ">Mover Dinero</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" align="center">
                                <img src="../../puntodeventa/imagenes/dinero.png" width="100" height="100">
                                    <form id="frmnuevoproducto"  enctype="multipart/form-data" method="post" style="font-size: medium" autocomplete="off">
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label>Tipo de Transacción:</label>
                                                <select align="center" class="form-control input-sm" id="tipo" style="font-size: medium" name="tipo"  >
                                                    <option value="0" selected align="center">Seleccione</option>
                                                    <option value="1"  align="center">Retiro</option>
                                                    <option value="2"  align="center">Consignación</option>

                                                </select>  </div>
                                            <div class="form-group col-md-5">
                                                <label>Ruta:</label>
                                                <select id="ruta" class="form-control input-sm">
                                                    <?php
                                                    $consultausuarios = "select * from rutas";
                                                    $query = mysqli_query($link, $consultausuarios) or die($consultausuarios);
                                                    ?> <option value="0"></option> <?php
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
                                            <div class="form-group col-md-5">
                                                <label>Valor en Base($):</label>
                                                <input disabled type="text" class="form-control input-group-lg" id="base" name="base">
                                            </div>
                                            <div class="form-group col-md-5">
                                                <label>Valor($):</label>
                                                <input type="text" class="form-control input-group-lg" id="valorretiro" name="valorretiro">
                                            </div>

                                        </div> 
                                        <div class="form-row">
                                            <div class="form-group col-md-10">
                                                <label>Comentarios:</label>
                                                <input class="form-control input-group-lg" type="text" id="comentario">
                                            </div>

                                        </div> 
                                    </form>
                                    <h5>Recuerde que el valor debe estar divido entre 1000.(Ejemplo: Para 32.000 debe registrarse como 32)</h5>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button id="realizar" data-dismiss="modal" type="button" class="btn btn-primary">Mover</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div align="left"> 
                </div>
                <div  align="center" id="recarga">
                    <br/>
                    <?php
                    while ($filas1 = mysqli_fetch_array($queryr)) {
                        ?>
                        <b><h3 style="font-family:  monospace;"><?php echo $filas1['ruta'] ?></h3></b>
                        <table  class="table table-bordered" style=" width:90% " align="center">     
                            <thead>   
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
                                    <TD><b><h4>Base</h4></b></TD>
                                    <TD><?php echo $filas1['base']; ?></TD>
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
                                    <TD><b><h4>Dinero a Recuperar</h4></b></TD>
                                    <TD><?php echo $prestado; ?></TD>
                                </tr>
                                <tr> 
                                    <TD><b><h4>Intereses a Recuperar</h4></b></TD>
                                    <TD><?php echo $intereses; ?></TD>
                                </tr>
                                <tr> 
                                    <td><h4>Total</h4></td>
                                    <TD><?php echo $intereses + $prestado + $filas1['base']; ?></TD>
                                </tr>
                        </table>
                    <?php } ?>
                </div>
                <br/>
                <br/>
                <br/>
                <br/>              
            </div>
        </body>
    </html>
    <?php
} else {
    echo "<script type=''>
        alert('favor iniciar sesion');
        window.location='index.php';
    </script>";
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#realizar').click(function () {
            a = 0;
            valorretiro = $('#valorretiro').val();
            ruta = $('#ruta').val();
            tipo = $('#tipo').val();
            base = $('#base').val();
            comentario = $('#comentario').val();
            if (tipo == 0) {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor escoger el tipo de transacción', function () {
                    alertify.success('Ok');
                });
            }
            if (ruta == 0) {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor escoger una ruta', function () {
                    alertify.success('Ok');
                });
            }
            if (base < valorretiro) {
                a = 1;
                alertify.alert('ATENCION!!', 'No es posible realizar la transacción', function () {
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
    $(document).ready(function () {
        $('#ruta').change(function () {
            id = $('#ruta').val();
            $.ajax({
                type: "POST",
                data: "id=" + id,
                url: "rutas/baseruta.php",
                success: function (r) {
                    console.log(r);
                    dato = jQuery.parseJSON(r);
                    $('#base').val(dato['base']);
                }});
        });
    });

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

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



