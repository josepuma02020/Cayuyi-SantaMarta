<?php
session_start();
if ($_SESSION['usuario']) {
    include_once('conexion/conexion.php');
    include_once('funciones/funciones.php');
    setlocale(LC_ALL, "es_CO");
    $fecha_actual = date("Y-m-j");
    $fecha_inicio = date("Y-m-01");
    $rutaactiva = $_SESSION['nruta'];
    $nrutaactiva = $_SESSION['ruta'];
    if (isset($_GET['cliente'])) {
        $cliente = $_GET['cliente'];
    } else {
        $cliente = 0;
    }
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        $id = 0;
    }
    //consulta cliente 
    $consultacliente = "select * from clientes where id_cliente = $cliente";
    $query = mysqli_query($link, $consultacliente) or die($consultacliente);
    $filas1 = mysqli_fetch_array($query);
    if (isset($filas1)) {
        $nombrecliente = $filas1['nombre'] . ' ' . $filas1['apellido'];
    } else {
        $nombrecliente = '';
    }
    //consultabase
    $consultabase = "select a.base,COUNT(b.id_prestamo) 'prestamos' from rutas a inner join prestamos b on b.ruta=a.id_ruta where id_ruta =$nrutaactiva and (b.valorapagar-b.abonado > 0) group by a.ruta";
    $query = mysqli_query($link, $consultabase) or die($consultabase);
    $filas1 = mysqli_fetch_array($query);
    $base = $filas1['base'];
    $clientesruta = $filas1['prestamos'];
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
            <input type="hidden" value="<?php echo $cliente ?>" id="cliente"/> 

            <div  class="container" >
                <div align="center"> 
                    <h1 style="font-family:  monospace;">Historial de Cuotas</h1>
                </div>
                <div class="card-body">


                    <div class="form-group col-sm-3">
                        <h3 style="font-family:  monospace;">Cliente:</h3>
                        <input disabled class="form-control input-sm" style=" width: 70%" type="text" id="mostrando" value="<?php echo $nombrecliente; ?>">
                    </div>      
     
                    <div  align="center" id="recarga">
                        <br/>

                        <table  class="table table-bordered" id="tablaproductos" style=" width:90% " align="center">     
                            <thead>   

                                <tr>
                                    <th style="width: 20%">
                                        Fecha
                                    </th>                                 
                                    <th style="width: 10%">
                                        Préstamo
                                    </th>
                                    <th style="width: 15%">
                                        V.P
                                    </th>
                                    <th style="width: 15%">
                                        Cuota
                                    </th>
                                    <th style="width: 15%">
                                        Saldo
                                    </th>
                                    <th style="width: 100%">
                                        Forma de Pago
                                    </th> 

                                    <th style="width: 15%">
                                        D.A  
                                    </th>                       
                                    <th style="width: 15%">
                                        Vencimiento(dias);
                                    </th>

                                </tr>
                            </thead>   
                            <TBODY>

                                <?php
                                if($id == 0){
                                     if ($cliente != 0) {
                                    $consultacuota = "SELECT a.diasvence,a.cuota,a.fecha,c.nombre,c.apellido,b.valor_prestamo,b.valorapagar,a.saldo,b.formapago,a.atraso,b.dias_prestamo,b.fecha'fechaprestamo' FROM  registros_cuota a inner join prestamos b on b.id_prestamo=a.prestamo inner join clientes c on c.id_cliente=b.cliente where b.cliente = $cliente";
                                } else {
                                    $consultacuota = "SELECT a.diasvence,a.cuota,a.fecha,c.nombre,c.apellido,b.valor_prestamo,b.valorapagar,a.saldo,b.formapago,a.atraso,b.dias_prestamo,b.fecha'fechaprestamo' FROM  registros_cuota a inner join prestamos b on b.id_prestamo=a.prestamo inner join clientes c on c.id_cliente=b.cliente ";
                                }
                                }else{
                                         $consultacuota = "SELECT a.diasvence,a.cuota,a.fecha,c.nombre,c.apellido,b.valor_prestamo,b.valorapagar,a.saldo,b.formapago,a.atraso,b.dias_prestamo,b.fecha'fechaprestamo' FROM  registros_cuota a inner join prestamos b on b.id_prestamo=a.prestamo inner join clientes c on c.id_cliente=b.cliente where a.prestamo = $id";
                              
                                }
                               
                                $query = mysqli_query($link, $consultacuota) or die($consultacuota);

                                while ($filas1 = mysqli_fetch_array($query)) {
                                    $dias = $filas1['atraso'];
                                    ?>
                                    <TR>   
                                        <TD><?php echo $filas1['fecha']; ?> </TD>
                                                                                       
                                        <TD><?php echo $filas1['valor_prestamo']; ?> </TD>
                                        <TD><?php echo $filas1['valorapagar']; ?> </TD>
                                        <TD><?php echo $filas1['cuota']; ?> </TD>
                                        <?php
                                        $saldo = $filas1['saldo'];
                                        if ($saldo == 0) {
                                            $color = "1DE97D";
                                        } else {
                                            $color = "";
                                        }
                                        ?><TD style="background-color: <?php echo $color ?>"><?php echo $saldo; ?> </TD>
                                        <TD><?php
                                            $diaspago = $filas1['formapago'];
                                            switch ($diaspago) {
                                                case 1:
                                                    $formadepago = 'D';
                                                    break;
                                                case 15:
                                                    $formadepago = 'Q';
                                                    break;
                                                case 7:
                                                    $formadepago = 'S';
                                                    break;
                                                case 30:
                                                    $formadepago = 'M';
                                                    break;
                                            }
                                            echo $formadepago;
                                            ?> </TD>
                                        <TD><?php echo $dias; ?> </TD>
                                        <TD><?php
                                        $diascuota = $filas1['diasvence'];
                                          echo $diascuota;
                                            ?> </TD>
                                    </TR>
                                <?php } ?>
                            </TBODY>
                        </table>

                    </div>
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
        $('#buscar').click(function () {
            a = 0;
            desde = $('#desde').val();
            hasta = $('#hasta').val();
            cliente = $('#cliente').val();
            if (a == 0) {
                location.href = `historialcuotas.php?cliente=${cliente}`;
            }
        })
    })
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#revisar').click(function () {
            ide = $('#idrevisar').val();
            pleno = $('#pleno').val();
            base = $('#base').val();
            cobro = $('#cobro').val();
            prestamo = $('#prestamo').val();
            gasto = $('#gasto').val();
            nuevos = $('#nuevos').val();
            entrantes = $('#entrantes').val();
            salientes = $('#salientes').val();
            clientes = $('#clientes').val();
            console.log(clientes);
            revisarruta(ide, pleno, base, cobro, prestamo, gasto, nuevos, entrantes, salientes, clientes);
            window.location.reload();
        })
    })
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
                info: "Mostrando lista de Cobros",
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



