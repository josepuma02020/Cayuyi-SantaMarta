<?php
session_start();
if ($_SESSION['usuario']) {
    include_once('conexion/conexion.php');
    include_once('funciones/funciones.php');
    setlocale(LC_ALL, "es_CO");
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


            <div  class="container" >
                <div align="center"> 
                    <h1 style="font-family:  monospace;"> Historal de Transacciones</h1>
                </div>
                <div class="card-body">




                    <div  align="center" id="recarga">
                        <br/>

                        <table  class="table table-bordered" id="tablaproductos" style=" width:90% " align="center">     
                            <thead>   

                                <tr>
                                    <th style="width: 40%">
                                        Fecha
                                    </th>
                                    <th style="width: 40%">
                                        Transaccion
                                    </th>

                                    <th style="width: 50%">
                                        Ruta
                                    </th>
                                    <th style="width: 15%">
                                        Valor 
                                    </th>
                                    <th style="width: 15%">
                                        Comentario
                                    </th>
                                </tr>
                            </thead>   
                            <TBODY>
                                <?php
                                $consultacuota = "select b.ruta,a.fecha,a.tipo,a.valor,a.comentario from transacciones a inner join rutas b on a.ruta=b.id_ruta";
                                $query = mysqli_query($link, $consultacuota) or die($consultacuota);
                                while ($filas1 = mysqli_fetch_array($query)) {
                                    ?>
                                    <TR>   
                                        <TD><?php echo $filas1['fecha']; ?> </TD>
                                        <TD><?php
                            $diaspago = $filas1['tipo'];
                            switch ($diaspago) {
                                case 1:
                                    $formadepago = 'Retiro';
                                    break;
                                case 2:
                                    $formadepago = 'Consignación';
                                    break;
                            }
                            echo $formadepago;
                                    ?> </TD>                                                                                                    
                                        <TD><?php echo $filas1['ruta']; ?> </TD>
                                        <TD><?php echo $filas1['valor']; ?> </TD>
                                        <TD><?php echo $filas1['comentario']; ?> </TD>

                                   
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



