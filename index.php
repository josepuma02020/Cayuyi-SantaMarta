<!DOCTYPE html>
<html lang="es">
    <head>
        <title>BIENVENIDO</title>
        <meta name="viewport" content="width=device-width, initial-scale=1 ,user-scalable=no">
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
        <link rel="stylesheet"  type="text/css"  href="diseno/defecto.css" >
        <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css" >
        <link rel="stylesheet" type="text/css" href="librerias/alertify/css/alertify.css" >
        <link rel="stylesheet" type="text/css" href="librerias/alertify/css/themes/default.css" >
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <SCRIPT src="librerias/jquery-3.5.1.min.js"></script>
        <SCRIPT src="librerias/alertify/alertify.js"></script>
        <SCRIPT lang="javascript" type="text/javascript" src="funciones/funciones.js"></script>
        <script src="librerias/bootstrap/js/bootstrap.js"></script>
        <style>
            @media screen and (max-width:1200px){
                .textoadapatable{
                    font-size:5vw;
                    width: 50%;

                }
            }
        </style>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="diseno/defecto.css" />
    </head>
    <body >
        <br>
        <br><br>
        <br>
        <div class="container"  >
            <center>                            
                <h1 class="textoadapatable"><b>ORION</b></h1>                           
                <img src="../../ORION/orion.png" style="width: 8%;position:absolute ;left: 630px" align="middle">
                <br>
                <br>
                <br>
                <br>
                <h4 for="usuario" class="textoadapatable"><b>Usuario:</b></h4>
                <input type="text" style="width: 40%"  class=" form-control " id="usuario" placeholder="Ingrese su Usuario" name="usuario">                                                       
                <h4 for="usuario" class="textoadapatable"><b>Clave:</b></h4>
                <input type="password" style="width: 40%"  class="form-control " id="clave" placeholder="Ingrese su Contraseña" name="clave"> 
                <br>
                <button type="submit" id="iniciar" class="btn btn-default">Ingresar</button>
            </center>
        </div>
    </body>
    <footer>
        <center>
            <p>Author: Pumasoft<br>
                <a href="https://www.pumasoft.co">pumasoft.co</a></p>
        </center>
    </footer>

</html>
<script type="text/javascript">
    $(document).ready(function () {
        $('#iniciar').click(function () {
            console.log(1);
            a = 0;
            usuario = $('#usuario').val();
            if (usuario == "") {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor llenar el campo Usuario', function () {

                });
            }
            clave = $('#clave').val();
            if (clave == "") {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor llenar el campo de Clave', function () {

                });
            }
            if (a == 0) {
                iniciarsesion(usuario, clave);

            }
        })
    })
</script>