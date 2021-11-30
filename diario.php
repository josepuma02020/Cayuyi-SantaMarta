<?php
session_start();
if ($_SESSION['usuario']) {
    include_once('conexion/conexion.php');
    include_once('funciones/funciones.php');
    setlocale(LC_ALL, "es_CO");
    $fechahoyval = date("Y") . '-' . date("m") . '-' . date("j");
    $fecha_actual = date("Y-m-j");
    $id = 0;
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
        <?php include_once('diseno/navegadoradmin.php'); ?>
    </head>

    <body>
        <main>
            <div class=" container container-md" style="min-height: 40% " align="left">
                <?php
                $consultarutas = "select a.formapago,a.id_prestamo,dias_atraso 'atraso' from prestamos a inner join rutas b on b.id_ruta=a.ruta where b.encargado =  $_SESSION[id_usuario] and (a.valorapagar - a.abonado) > 0  order by a.posicion_ruta";
                $query = mysqli_query($link, $consultarutas) or die($consultarutas);
                while ($filas1 = mysqli_fetch_array($query)) {
                    $diaspago = $filas1['formapago'];
                    switch ($diaspago) {
                        case 1:
                            $formadepago = 'Diario';
                            break;
                        case 15:
                            $formadepago = 'Quincenal';
                            break;
                        case 7:
                            $formadepago = 'Semanal';
                            break;
                        case 30:
                            $formadepago = 'Mensual';
                            break;
                    }
                    $consultaforma = "select max(fecha)'desde' from registros_cuota where prestamo = $filas1[id_prestamo] and cuota > 0";
                    $query1 = mysqli_query($link, $consultaforma) or die($consultaforma);
                    $filas5 = mysqli_fetch_array($query1);
                    $fecha1 = $filas5['desde'];

                    $dateDifference = abs(strtotime($fecha_actual) - strtotime($fecha1));
                    $years = floor($dateDifference / (365 * 60 * 60 * 24));
                    $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                    $diascuota = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                    $consultadatos = "select a.formapago,b.nombre,b.apellido, a.id_prestamo,(a.valorapagar - a.abonado)'debe',a.dias_atraso,(a.valorapagar/ a.dias_prestamo) 'cuota',b.telefono,b.direccion from prestamos a "
                        . "inner join clientes b on b.id_cliente=a.cliente where a.id_prestamo = $filas1[id_prestamo]";
                    $query1 = mysqli_query($link, $consultadatos) or die($consultadatos);
                    $filas2 = mysqli_fetch_array($query1);
                    $diasatrasados = $filas1['atraso'];

                    if ($filas2['formapago'] <= $diascuota) {
                        if ($filas2['dias_atraso'] > 5) {
                            $aviso = "EC1A3D";
                        } else {
                            $aviso = "";
                        }
                ?>
                        <div class="container-ruta " style="background-color: <?php echo $aviso ?>">
                            <div class="form-row">
                                <b><?php echo $filas2['nombre'] . ' ' . $filas2['apellido'] ?></b>
                            </div>
                            <div class="form-row">
                                <b> Dias Atrasados:</b><?php echo $diasatrasados ?>
                            </div>
                            <div class="form-row" style="color: ">
                                <b>Telefono:</b> <?php echo $filas2['telefono'] ?>
                                <a href="tel:+<?php echo $filas2['telefono'] ?>"><button onclick="agregardatoscliente(<?php echo $filas1['id_cliente'] ?>)" type="button" id="actualiza" class="btn btn-primary" data-toggle="modal" data-target="#editar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-outbound" viewBox="0 0 16 16">
                                            <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511zM11 .5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V1.707l-4.146 4.147a.5.5 0 0 1-.708-.708L14.293 1H11.5a.5.5 0 0 1-.5-.5z" />
                                        </svg></button></a>
                            </div>
                            <div class="form-row">
                                <b>Forma de Pago:</b> <?php echo $formadepago ?>
                            </div>
                            <div class="form-row">
                                <b>Direccion:</b> <?php echo $filas2['direccion'] ?>
                            </div>
                            <div class="form-row">
                                <b> <?php echo "Cuota:" . round($filas2['cuota']) ?></b>
                            </div>
                            <div class="form-row">
                                <b> <?php echo "Saldo:" . round($filas2['debe']) ?></b>
                            </div>

                            <div class="form-row">
                                <button onclick="obtenerdatosprestamo(<?php echo $filas1['id_prestamo'] ?>)" class="btn btn-success" id="cobrar" data-toggle="modal" data-target="#cc">Cobrar Cuota</button>
                                <button onclick="obtenerdatosprestamo(<?php echo $filas1['id_prestamo'] ?>)" class="btn btn-danger" id="nopago" data-toggle="modal" data-target="#nopaga">No Pagó</button>
                                <a href="historialcuotasc.php?id=<?php echo $filas1['id_prestamo'] ?>"><button onclick="agregardatoscliente(<?php echo $filas1['id_cliente'] ?>)" type="button" id="actualiza" class="btn btn-primary" data-toggle="modal" data-target="#editar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-checklist" viewBox="0 0 16 16">
                                            <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                                            <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z" />
                                        </svg></button></a>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
                <div class="modal fade" id="nopaga" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-md modal-dialog " style="width:25%;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><b>Esta seguro?</b></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <input type="hidden" id="idu1" name="idu1">
                            <div class="modal-body" align="center">
                                <h3>Se registrará que el cliente no pago la cuota</h3>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button id="no" type="button" class="btn btn-primary">Aceptar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="cc" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-md modal-dialog " style="width:25%;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><b>Recoger Cuota</b></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <input type="hidden" id="idu" name="idu">
                            <div class="modal-body" align="center">
                                <div class="form-row">
                                    <div class="form-group col-sm-4">
                                        <label>Dinero Recogido:</label>
                                        <input autocomplete="off" type="hidden" style="font-size: medium" class="form-control input-group-sm" id="idu" name="idu" />
                                        <input autocomplete="off" type="text" style="font-size: medium" class="form-control input-group-sm" id="dinero" name="dinero">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button id="recoger" type="button" class="btn btn-primary">Aceptar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="nopaga" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-md modal-dialog " style="width:25%;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><b>Esta seguro?</b></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <input type="hidden" id="idu" name="idu">
                            <div class="modal-body" align="center">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button id="no" type="button" class="btn btn-primary">Aceptar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </main>
<footer>
      <?php include_once("diseno/footer.php")  ?> 
</footer>
    </body>

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
<script type="text/javascript">
    $(document).ready(function() {
        $('#recoger').click(function() {
            a = 0;
            idu = $('#idu').val();
            recoger = $('#dinero').val();

            if (recoger <= 0) {
                a = 1;
                alertify.alert('ATENCION!!', 'El valor de la Cuota debe ser mayor a 1', function() {
                    alertify.success('Ok');
                });
            }
            if (a == 0) {
                registrarcuota(idu, recoger);
                window.location.reload();
            }
        })
    })
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#no').click(function() {
            a = 0;
            idu = $('#idu').val();
            if (a == 0) {
                registrarcuota(idu, a);
                window.location.reload();
            }
        })
    })
</script>