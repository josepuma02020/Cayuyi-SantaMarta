<?php
if (isset($_SESSION['usuario'])) {
    setlocale(LC_ALL, "es_CO");
    include_once 'funciones/funciones.php';
?>
    <html>

    <head>
        <title style="font-family: cursive">Pumasoft</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>

    <body>
        <main>
            <div align="left">
                <span style="font-size:30px;cursor:pointer; align-self: flex-end" onclick="openNav()">&#9776; MENU
                </span>
                <h3 align="center" style="width: 20%;position: relative ;left: 1100px;bottom: 60px;"><a href="usuarios.php"><?php echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido'] . '  ' . $_SESSION['Rol'] ?></a></h3>
            </div>

            <div id="mimenu" class="sidenav" style="width: 0;">
                <a href="javascript:void(0)" class="closebtn" style="align-items: flex-end;left:100px  " onclick="closeNav()">&times;</a>
                <br>
                <br>
                <button class="dropdown-btn">Recorridos
                    <i class="fa fa-caret-down"></i>
                </button>
                <?php if ($_SESSION['Rol'] == 'Cobrador') {
                ?>
                    <div class="dropdown-container">
                        <a href="../../ORION/diario.php" style="font-size: medium ">Diario</a>
                        <a href="../../ORION/recorridosc.php" style="font-size: medium ">Editar Ruta</a>
                        <a href="../../ORION/cuotas.php" style="font-size: medium ">Cuotas Registradas</a>
                    </div>
                <?php } else { ?>
                <?php } ?>
                <div class="dropdown-container">
                    <a href="../../ORION/diario.php" style="font-size: medium ">Diario</a>
                    <a href="../../ORION/recorridos.php" style="font-size: medium ">Recorridos</a>
                    <a href="../../ORION/recorridosc.php" style="font-size: medium ">Editar Ruta</a>
                    <a href="../../ORION/cuotas.php" style="font-size: medium ">Cuotas Registradas</a>
                </div>
                <?php if ($_SESSION['Rol'] == 'Supervisor') { ?>
                    <button class="dropdown-btn">Rutas
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-container">
                        <a href="../../ORION/rutas.php" style="font-size: medium ">Rutas</a>
                        <a href="../../ORION/gastos.php" style="font-size: medium ">Gastos</a>

                    </div>
                <?php  } ?>
                <?php if ($_SESSION['Rol'] == 'Administrador') { ?>
                    <button class="dropdown-btn">Rutas
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-container">
                        <a href="../../ORION/rutas.php" style="font-size: medium ">Rutas</a>
                        <a href="../../ORION/gastos.php" style="font-size: medium ">Gastos</a>

                    </div>
                <?php } ?>
                <button class="dropdown-btn">Prestamos
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-container">
                    <?php if ($_SESSION['Rol'] == 'Cobrador') { ?>
                        <a href="../../ORION/clientesc.php" style="font-size: medium ">Clientes Activos</a>
                    <?php } else { ?>
                        <a href="../../ORION/prestamos.php" style="font-size: medium ">Activos</a>
                        <a href="../../ORION/prestamos.php?id=1" style="font-size: medium ">Cancelados</a>
                        <a href="../../ORION/clientes.php" style="font-size: medium ">Clientes</a>
                        <a href="../../ORION/clientesc.php" style="font-size: medium ">Clientes Activos</a>


                    <?php } ?>
                </div> <?php if ($_SESSION['Rol'] == 'Administrador') { ?>
                    <button class="dropdown-btn">Contabilidad
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-container">
                        <a href="../../ORION/ganancias.php" style="font-size: medium ">Balance </a>
                        <a href="../../ORION/contabilidad.php" style="font-size: medium "> Informe Contable </a>
                        <a href="../../ORION/transacciones.php" style="font-size: medium ">Transacciones</a>
                    </div>
                    <button class="dropdown-btn" id="usuarios">Usuarios
                    </button>
                <?php } ?>
                <?php if ($_SESSION['Rol'] == 'Supervisor') { ?>
                    <button class="dropdown-btn">Contabilidad
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-container">

                        <a href="../../ORION/contabilidad.php" style="font-size: medium "> Informe Contable </a>

                    </div>
                    <button class="dropdown-btn" id="usuarios">Usuarios
                    </button>
                <?php } ?>
                <?php if ($_SESSION['Rol'] == 'Supervisor') { ?>
                    <button class="dropdown-btn" id="usuarios">Usuarios
                    </button>
                <?php } ?>
                <button class="dropdown-btn" id="salir">Salir
                </button>
            </div>
        </main>
        
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
<script>
    $(document).ready(function() {
        $('#usuarios').click(function() {

            window.location.href = "usuarios.php";

        });
    });
</script>
<script>
    /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;

    for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }
</script>
<script>
    function openNav() {
        document.getElementById("mimenu").style.width = "250px";
    }

    function closeNav() {
        document.getElementById("mimenu").style.width = "0";
    }
</script>
<script>
    $(document).ready(function() {
        $('#salir').click(function() {

            window.location.href = "usuarios/cerrarsesion.php";

        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#Inicio').click(function() {

            window.location.href = "home.php";

        });
    });
</script>