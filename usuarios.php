<?php
session_start();
if ($_SESSION['usuario']) {
    include_once('conexion/conexion.php');
    include_once('funciones/funciones.php');
    setlocale(LC_ALL, "es_CO");
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
        <SCRIPT lang="javascript" type="text/javascript" src="./usuarios/usuarios.js"></script>
        <script src="librerias/bootstrap/js/bootstrap.js"></script>
        <?php include_once('diseno/navegadoradmin.php'); ?>
    </head>

    <body>
        <div class=" container container-md" style="min-height: 40% ">
            <div class="card-body">

                <span class="btn btn-primary" data-toggle="modal" style="font-size: medium" data-target="#nuevousuario">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-person" viewBox="0 0 16 16">
                        <path d="M12 1a1 1 0 0 1 1 1v10.755S12 11 8 11s-5 1.755-5 1.755V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z" />
                        <path d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                    </svg> Nuevo Usuario<span class="fa fa-plus-circle"></span>
                </span>
                <div class="modal fade" id="nuevousuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" align="center">
                        <div class="modal-content" align="center">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><b>Nuevo Usuario</b></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" align="center">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Cedula:</label>
                                        <input autocomplete="off" type="text" style="font-size: medium" class="form-control input-group-sm" id="cedula" name="cedula">

                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Nombre:</label>
                                        <input autocomplete="off" type="text" style="font-size: medium" class="form-control input-group-sm" id="nombre" name="nombre">

                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Apellido:</label>
                                        <input autocomplete="off" type="text" style="font-size: medium" class="form-control input-group-sm" id="apellido" name="apellido   ">

                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Direccion:</label>
                                        <input autocomplete="off" type="text" style="font-size: medium" class="form-control input-group-sm" id="direccion" name="direccion">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Telefono:</label>
                                        <input autocomplete="off" type="text" style="font-size: medium" class="form-control input-group-sm" id="telefono" name="telefono">

                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Rol:</label>
                                        <select id="rol" class="form-control input-sm">
                                            <option value="0"></option>
                                            <option value="Administrador">Administrador</option>
                                            <option value="Supervisor">Supervisor</option>
                                            <option value="Cobrador">Cobrador</option>

                                        </select>
                                    </div>

                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Usuario:</label>
                                        <input autocomplete="off" type="text" style="font-size: medium" class="form-control input-group-sm" id="usuario" name="usuario   ">

                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Clave:</label>
                                        <input autocomplete="off" type="password" style="font-size: medium" class="form-control input-group-sm" id="clave" name="clave">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Confirmar Clave:</label>
                                        <input autocomplete="off" type="password" style="font-size: medium" class="form-control input-group-sm" id="confimarclave" name="confimarclave">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button id="agregarusuario" data-dismiss="modal" type="button" class="btn btn-primary">Agregar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>

            </div>
            <div id="recarga">
                <TABLE class="table table-striped  table-responsive-lg" id="tablageneral">
                    <THEAD>
                        <tr>
                            <th> Cedula </th>
                            <th> Nombre </th>
                            <th> Usuario </th>
                            <th> Tipo de Usuario </th>
                            <th> Acciones </th>
                        </tr>
                    </THEAD>
                    <TBODY>

                        <?php
                        $consultarutas = "SELECT * FROM USUARIOS";
                        $query = mysqli_query($link, $consultarutas) or die($consultarutas);
                        while ($filas1 = mysqli_fetch_array($query)) {
                        ?>
                            <TR>
                                <TD><?php echo $filas1['cedula']; ?> </TD>
                                <TD><?php echo $filas1['nombre'] . ' ' . $filas1['apellido']; ?> </TD>
                                <TD><?php echo $filas1['usuario']; ?> </TD>
                                <TD><?php echo $filas1['Rol']; ?> </TD>
                                <TD>
                                    <SCRIPT lang="javascript" type="text/javascript" src="funciones/funciones.js"></script>
                                    <button onclick="agregardatosusuario(<?php echo $filas1['id_usuario'] ?>)" type="button" id="actualiza" class="btn btn-primary" data-toggle="modal" data-target="#editar">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pen" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M13.498.795l.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z" />
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
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><b>Editar Usuario</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Cedula:</label>
                                <input autocomplete="off" type="text" style="font-size: medium" class="form-control input-group-sm" id="cedulau" name="cedulau">
                                <input autocomplete="off" type="hidden" style="font-size: medium" class="form-control input-group-sm" id="idu" name="idu" />

                            </div>
                            <div class="form-group col-md-4">
                                <label>Nombre:</label>
                                <input autocomplete="off" type="text" style="font-size: medium" class="form-control input-group-sm" id="nombreu" name="nombreu">

                            </div>
                            <div class="form-group col-md-4">
                                <label>Apellido:</label>
                                <input autocomplete="off" type="text" style="font-size: medium" class="form-control input-group-sm" id="apellidou" name="apellidou">

                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Direccion:</label>
                                <input autocomplete="off" type="text" style="font-size: medium" class="form-control input-group-sm" id="direccionu" name="direccionu">

                            </div>
                            <div class="form-group col-md-4">
                                <label>Telefono:</label>
                                <input autocomplete="off" type="text" style="font-size: medium" class="form-control input-group-sm" id="telefonou" name="telefonou">

                            </div>
                            <div class="form-group col-md-2">
                                <label>Rol Actual:</label>
                                <input autocomplete="off" disabled type="text" style="font-size: medium" class="form-control input-group-sm" id="rolactual" name="rolactual">

                            </div>
                            <div class="form-group col-md-2">
                                <label>Nuevo Rol:</label>
                                <select id="rolu" class="form-control input-sm">
                                    <option value="0"></option>
                                    <option value="Administrador">Administrador</option>
                                    <option value="Supervisor">Supervisor</option>
                                    <option value="Cobrador">Cobrador</option>
                                    <option class="danger" value="Inactivo">Inactivo</option>

                                </select>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Usuario:</label>
                                <input autocomplete="off" type="text" style="font-size: medium" class="form-control input-group-sm" id="usuariou" name="usuario   ">

                            </div>
                            <div class="form-group col-md-4">
                                <label>Nueva Clave:</label>
                                <input autocomplete="off" type="password" style="font-size: medium" class="form-control input-group-sm" id="claveu" name="claveu">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Confirmar Clave:</label>
                                <input autocomplete="off" type="password" style="font-size: medium" class="form-control input-group-sm" id="confimarclaveu" name="confimarclaveu">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Ultima conexion:</label>
                                <input disabled autocomplete="off" type="text" style="font-size: medium" class="form-control input-group-sm" id="ultima" name="ultima   ">

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button id="editarusuario" data-dismiss="modal" type="button" class="btn btn-primary">Editar</button>
                    </div>
                </div>

            </div>
        </div>
    </body>
    <footer>

        <p>Author: Pumasoft<br>
            <a href="https://www.pumasoft.co">pumasoft.co</a>
        </p>

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

<script type="text/javascript">
    $(document).ready(function() {
        tabla = $('#tablageneral').DataTable({
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
        $('#editarusuario').click(function() {
            a = 0;
            cedula = $('#cedulau').val();
            nombre = $('#nombreu').val();
            apellido = $('#apellidou').val();
            direccion = $('#direccionu').val();
            telefono = $('#telefonou').val();
            usuario = $('#usuariou').val();
            clave = $('#claveu').val();
            rol = $('#rolu').val();
            id = $('#idu').val();
            confirmarclave = $('#confimarclaveu').val();

            if (nombre == "" || nombre.length < 4) {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor revisar el nombre del Usuario:El nombre de la ruta debe tener mas de 4 letras', function() {
                    alertify.success('Ok');
                });
            }
            if (apellido == "" || apellido.length < 2) {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor revisar el apellido del Usuario', function() {
                    alertify.success('Ok');
                });
            }
            if (cedula == "" || apellido.length < 2) {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor revisar la cedula del Usuario', function() {
                    alertify.success('Ok');
                });
            }
            if (usuario == "" || usuario.length < 2) {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor revisar el Usuario', function() {
                    alertify.success('Ok');
                });
            }
            if (telefono == "" || apellido.length < 2) {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor revisar el telefono del Usuario', function() {
                    alertify.success('Ok');
                });
            }
            if (clave != "") {
                if (clave.length < 2 || clave != confirmarclave) {
                    a = 1;
                    alertify.alert('ATENCION!!', 'Las claves no coinciden', function() {
                        alertify.success('Ok');
                    });
                }
            }
            if (a == 0) {
                editarusuario(id, cedula, nombre, apellido, direccion, telefono, usuario, clave, rol);
                window.location.reload();
            }
        })
    })
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#agregarusuario').click(function() {
            a = 0;
            cedula = $('#cedula').val();
            nombre = $('#nombre').val();
            apellido = $('#apellido').val();
            direccion = $('#direccion').val();
            telefono = $('#telefono').val();
            usuario = $('#usuario').val();
            clave = $('#clave').val();
            rol = $('#rol').val();
            confirmarclave = $('#confimarclave').val();
            if (rol == "") {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor seleccionar un Rol para el nuevo Usuario', function() {
                    alertify.success('Ok');
                });
            }
            if (nombre == "" || nombre.length < 4) {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor revisar el nombre del Usuario:El nombre de la ruta debe tener mas de 4 letras', function() {
                    alertify.success('Ok');
                });
            }
            if (apellido == "" || apellido.length < 2) {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor revisar el apellido del Usuario', function() {
                    alertify.success('Ok');
                });
            }
            if (cedula == "" || apellido.length < 2) {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor revisar la cedula del Usuario', function() {
                    alertify.success('Ok');
                });
            }
            if (usuario == "" || usuario.length < 2) {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor revisar el Usuario', function() {
                    alertify.success('Ok');
                });
            }
            if (telefono == "" || apellido.length < 2) {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor revisar el telefono del Usuario', function() {
                    alertify.success('Ok');
                });
            }
            if (clave == "" || clave.length < 2 || clave != confirmarclave) {
                a = 1;
                alertify.alert('ATENCION!!', 'Las claves no coinciden', function() {
                    alertify.success('Ok');
                });
            }
            if (a == 0) {

                agregarusuario(cedula, nombre, apellido, direccion, telefono, clave, usuario, rol);
                window.location.reload();
            }
        })
    })
</script>