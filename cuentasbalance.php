<?php
session_start();
if ($_SESSION['usuario']) {
    include_once('conexion/conexion.php');
    include_once('funciones/funciones.php');
    setlocale(LC_ALL, "es_CO");
    $fecha_actual = date("Y-m-j");
    ?>
    <HTML>
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
                    <h1 style="font-family:  monospace;">Tabla de Bases x Rutas</h1>
                </div>
                <br>
                    <div align="left">
               

                      


                    </div>
                    
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
                                                    <label>Razon del Retiro:</label>
                                                    <select align="center" class="form-control input-sm" id="cuentaretiro" style="font-size: medium" name="cuentaretiro"  >
                                                        <option value="0" selected align="center">Seleccione</option>
                                                        <option value="1"  align="center">Pago a Empleado</option>
                                                        <option value="2"  align="center">Merienda</option>
                                                        <option value="2"  align="center">Ganacia Propia</option>
                                                        <option value="2"  align="center">Mantenimientos de Moto</option>
                                                    </select>  </div>
                                                <div class="form-group col-md-5">
                                                    <label>Recibe:</label>
                                                    <select id="recibe" class="form-control input-sm">
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
                                            <div class="form-row">
                                                <div class="form-group col-md-5">
                                                    <label>Valor($):</label>
                                                    <input type="text" class="form-control input-group-lg" id="valorretiro" name="valorretiro">
                                                </div>
                                                <div class="form-group col-md-5">
                                                    <label>Cuenta:</label>
                                                    <select align="center" class="form-control input-sm" id="cuentaretiro" style="font-size: medium" name="cuentaretiro"  >
                                                        <option value="0" selected align="center">Seleccione</option>
                                                        <?php
                                                        $consultat = "select * from cuentasbalance";
                                                        $queryt = mysqli_query($link, $consultat) or die('error');
                                                        while ($filasa = mysqli_fetch_array($queryt)) {
                                                            ?>
                                                            <option value="<?php echo $filasa['id_cuenta']; ?>"><?php echo $filasa['Cuenta'] . '- ' . number_format($filasa['Valor']) ?></option>
                                                        <?php } ?>
                                                    </select>
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
                                    <button id="retirar" data-dismiss="modal" type="button" class="btn btn-primary">Mover</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div  align="center" id="recarga">
                        <br/>
                        <table class="table table-bordered" style=" width:90% " align="center">     
                            <thead>                           
                                <tr>
                                    <th>
                                        Ruta
                                    </th>
                                    <th style="width: 50%">
                                        Valor
                                    </th>   

                                </tr>
                            </thead>   
                            <tbody>   
                                <?php
                                $consultacuentasgenerales = "Select * from rutas";
                                $querycg = mysqli_query($link, $consultacuentasgenerales) or die($consultacuentasgenerales);
                                $sumtotal = 0;
                                while ($filas1 = mysqli_fetch_array($querycg)) {
                                    ?>
                                    <tr>                            
                                        <TD><?php echo $filas1['ruta']; ?> </TD>
                                         <TD><?php $sumtotal=$sumtotal+$filas1['base'];echo $filas1['base']; ?> </TD>
                                     
                                    </tr>
                                <?php }
                                ?>
                                <TR style="font-weight: bolder">

                                    <TD><?php echo "TOTAL" ?> </TD>
                                    <TD><?php echo $sumtotal; ?> </TD>
                                </TR>
                            </tbody>
                        </table>
                         <span class="btn btn-success"  data-toggle="modal" style="font-size: medium; "  data-target="#retirardinero">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash" viewBox="0 0 16 16">
                                <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                                <path d="M0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V6a2 2 0 0 1-2-2H3z"/>
                            </svg> Retirar Dinero<span class="fa fa-plus-circle"></span>
                        </span>
                    </div>
                    
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

<script type="text/javascript">
    $(document).ready(function () {
        $('#retirar').click(function () {
            valor = $('#valorretiro').val();
            cuenta = $('#cuentaretiro').val();
            a = 0;
            if (cuenta == '0') {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor escoger origen del movimiento', function () {
                    alertify.success('Ok');
                });
            }

            if (valor <= 0) {
                a = 1;
                alertify.alert('ATENCION!!', 'El valor del movimiento debe ser mayor a $1000', function () {
                    alertify.success('Ok');
                });
            }
            if (a == 0) {
                retirar(valor, cuenta);
                window.location.reload();
            }

        })
    })
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#mover').click(function () {
            valor = $('#valor').val();
            origen = $('#origen').val();
            destino = $('#destino').val();
            a = 0;
            if (origen == '0') {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor escoger origen del movimiento', function () {
                    alertify.success('Ok');
                });
            }
            if (destino == '0') {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor escoger destino del movimiento', function () {
                    alertify.success('Ok');
                });
            }
            if (valor <= 0) {
                a = 1;
                alertify.alert('ATENCION!!', 'El valor del movimiento debe ser mayor a $1000', function () {
                    alertify.success('Ok');
                });
            }
            if (a == 0) {
                movercapital(valor, origen, destino);
                window.location.reload();
            }

        })
    })
</script>



