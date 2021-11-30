<!DOCTYPE html>
<html lang="es">

<head>
    <title>Orion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1 ,user-scalable=no">
    <meta charset="utf-8">
    <meta name="description" content="Software para manejar y optimizar el proceso de tus rutas de cobro y prestamos.">
    <meta name="robots" context="index,follow">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="diseno/defecto.css">
    <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="librerias/alertify/css/alertify.css">
    <link rel="stylesheet" type="text/css" href="librerias/alertify/css/themes/default.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <SCRIPT src="librerias/jquery-3.5.1.min.js"></script>
    <SCRIPT src="librerias/alertify/alertify.js"></script>
    <SCRIPT lang="javascript" type="text/javascript" src="funciones/funciones.js"></script>
    <script src="librerias/bootstrap/js/bootstrap.js"></script>
    <style>
        @media screen and (max-width:1200px) {
            .textoadapatable {
                font-size: 5vw;
                width: 50%;

            }
        }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <main>
        <br>
        <br><br>
        <br>
        <div class="container">
            <center>
                <h1 class="textoadapatable"><b>ORION</b></h1>
                <img src="../../ORION/orion.png" style="width: 8%;position:absolute ;left: 630px" align="middle">
                <br>
                <br>
                <br>
                <br>
                <form action="verificarsesion.php" method="POST">
                    <label for="usuario">
                        <h4 class="textoadapatable"><b>Usuario:</b></h4>
                        <input required type="text" style="width: 100%" class=" form-control " id="usuario" placeholder="Ingrese su Usuario" name="usuario">
                    </label>
                    <br>
                    <label for="clave">
                        <h4 class="textoadapatable"><b>Clave:</b></h4>
                        <input required type="password" style="width: 100%" class="form-control " id="clave" placeholder="Ingrese su Contraseña" name="clave">
                    </label>
                    <br>
                    <br>
                    <input type="submit" id="iniciar" class="btn btn-default" value="Iniciar sesion">
                </form>
            </center>
        </div>
    </main>
</body>
<footer>
    <center>
        <p>Author: Pumasoft<br>
            <a href="https://www.pumasoft.co">pumasoft.co</a>
        </p>
    </center>
</footer>

</html>
