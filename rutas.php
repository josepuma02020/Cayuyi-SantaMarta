<?php
session_start();
if ($_SESSION['usuario']) {
    include_once('conexion/conexion.php');

    include_once('funciones/funciones.php');

    setlocale(LC_ALL, "es_CO");
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
        <body >
            <div  class=" container container-md" style="min-height: 40% "  align="left"  >
                <div class="card-body">
                    <span class="btn btn-primary" data-toggle="modal" style="font-size: medium"  data-target="#nuevousuario">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-plus" viewBox="0 0 16 16">
                            <path d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z"/>
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                        </svg> Nueva Ruta<span class="fa fa-plus-circle"></span>
                    </span>
                    <div class="modal fade" id="nuevousuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" align="center" >
                            <div class="modal-content" align="center">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Nueva Ruta</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" align="center">
                                    <div class="form-row">
                                        <div class="form-group col-md-5">
                                            <label>Nombre de Ruta:</label>
                                            <input autocomplete="off"  type="text" style="font-size: medium" class="form-control input-group-sm" id="nombre" name="nombre" >

                                        </div>
                                        <div class="form-group col-md-5">
                                            <label>Encargado:</label>
                                            <select id="encargado" class="form-control input-sm">
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


                                            </select>  </div> 
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
                <div  align="center" id="recarga" >

                    <TABLE class="table table-striped  table-responsive-lg"  id="tablaproductos"  >                   
                        <THEAD>
                            <tr>
                                <th> RUTA </th>
                                <th> ENCARGADO  </th>
                                <th> CLIENTES  </th>
                                <th> CLIENTES ATRASADOS </th>
                                <th> RECAUDO  </th>    
                                <th> ACCIONES  </th>
                            </tr>
                        </THEAD>
                        <TBODY>

                            <?php
                             $consultarutas = " select ifnull(c.dias_atraso,0)'atraso',ifnull(count(c.valorapagar/c.dias_prestamo) > 1,0) 'cuota', id_ruta,a.ruta,b.nombre,b.apellido,COUNT(c.id_prestamo) 'prestamos' from rutas a inner join usuarios b on a.encargado = b.id_usuario left join prestamos c on c.ruta=a.id_ruta GROUP by a.id_ruta";
                            $query = mysqli_query($link, $consultarutas) or die($consultarutas);
                            while ($filas1 = mysqli_fetch_array($query)) {
                                ?>
                                <TR>
                                    <TD><?php echo $filas1['ruta']; ?> </TD>
                                    <TD><?php echo $filas1['nombre'] . ' ' . $filas1['apellido']; ?> </TD>
                                    <TD><?php echo $filas1['prestamos']; ?> </TD>
                                    <?php
                               
                                        
                                        ?><TD style="background-color: <?php echo $alerta ?>"> <?php echo $filas1['atraso'];   ?> </TD>
                                    <TD ><?php echo number_format($filas1['cuota']); ?> </TD>
                                    <TD> 
                                        <SCRIPT lang="javascript" type="text/javascript" src="funciones/funciones.js"></script>
                                        <button onclick="agregardatosruta(<?php echo $filas1['id_ruta']?>)"    type="button" id="actualiza"  class="btn btn-primary" data-toggle="modal" data-target="#editar" >
                                            <svg  width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pen" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path    fill-rule="evenodd" d="M13.498.795l.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
                                            </svg> 
                                        </button> 

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
                        <input type="hidden" value="<?php echo $filas1['id_ruta'] ?>" id="idruta" name="idruta"  >

                            <div class="modal-body" align="center">
                                <div class="form-row">
                                    <div class="form-group col-md-5">
                                        <label>Nombre de Ruta:</label>
                                        <input autocomplete="off"  type="text" style="font-size: medium" class="form-control input-group-sm" id="nombreu" name="nombreu" >
                                    </div>
                                    <div class="form-group col-md-5">
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
            <center>
                <p>Author: Pumasoft<br>
                        <a href="https://www.pumasoft.co">pumasoft.co</a></p>
            </center>
        </footer>
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

<SCRIPT type="text/javascript">
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
        $('#editarruta').click(function () {
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
    $(document).ready(function () {
        $('#agregarruta').click(function () {
            a = 0;
            nombre = $('#nombre').val();
            encargado = $('#encargado').val();
            if (nombre == "" || nombre.length < 4) {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor revisar el nombre de la ruta:El nombre de la ruta debe tener mas de 4 letras', function () {
                    alertify.success('Ok');
                });
            }
            if (encargado == "0") {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor escoger encargado de ruta', function () {
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



