<!DOCTYPE html>
<html lang="es">

<head>
    <title>Orion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1 ,user-scalable=no">
    <meta charset="utf-8">
    <meta name="description" content="Software para manejar y optimizar el proceso de tus rutas de cobro y prestamos.">
    <meta name="robots" context="index,follow">
    <link rel="stylesheet" href="./diseno/login/cel.css" />
    <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="librerias/alertify/css/alertify.css">
    <link rel="stylesheet" type="text/css" href="librerias/alertify/css/themes/default.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <SCRIPT src="librerias/jquery-3.5.1.min.js"></script>
    <SCRIPT src="librerias/alertify/alertify.js"></script>
    <SCRIPT lang="javascript" type="text/javascript" src="funciones/funciones.js"></script>
    <script src="librerias/bootstrap/js/bootstrap.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="shortcut  icon" href="imagenes/logop.png" type="image/x-icon" />
</head>

<body>
    <header>
    </header>
    <main class="container-login">
        <?php
        if (isset($_GET['m'])) {
            $m = $_GET['m'];
            switch ($m) {
                case 1:
        ?>
                    <script>
                        alertify.alert('Atencion!!', 'El usuario se encuentra Inactivo', function() {
                            alertify.success('Ok');
                        });
                    </script>
                <?php
                    break;
                case 2:
                ?>
                    <script>
                        alertify.alert('Atencion!!', 'Usuario o clave de ingreso incorrecto', function() {
                            alertify.success('Ok');
                        });
                    </script>
                <?php
                    break;
                case 3:
                ?>
                    <script>
                        alertify.alert('Atencion!!', 'Favor iniciar sesión', function() {
                            alertify.success('Ok');
                        });
                    </script>
        <?php
                    break;
            }
        }
        ?>
        <div class="titulo">
            <h1>ORION</h1>
        </div>
        <form action="verificarsesion.php" method="POST">
            <label class="form-item" for="usuario">
                <h3 class="">Usuario:</h3>
                <input required type="text" class=" form-control " id="usuario" placeholder="Ingrese su Usuario" name="usuario">
            </label>
            <label class="form-item" for="clave">
                <h3 class="">Clave:</h3>
                <input required type="password" class="form-control " id="clave" placeholder="Ingrese su Contraseña" name="clave">
            </label>
            <input type="submit" id="iniciar" class="btn btn-default" value="Iniciar sesion">
        </form>
    </main>
</body>
<footer>
    <p>Author: Pumasoft<br>
        <a href="https://www.pumasoft.co">pumasoft.co</a>
    </p>

</footer>

</html>