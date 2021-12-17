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
        <link rel="stylesheet" href="./diseno/menu/cel.css" media="screen and (min-width:200px)" />
        <link rel="stylesheet" href="./diseno/menu/tablet.css" media="screen and (min-width:700px)" />
        <link rel="stylesheet" href="./diseno/menu/desktop.css" media="screen and (min-width:1025px)" />
    </head>

    <body>
        <main class="menu">
            <span class="titulo-menu" onclick="openNav()">&#9776; MENU
            </span>
            <div id="mimenu" class="sidenav" style="width: 0;">
                <a class="cerrar" href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                <button class="dropdown-btn">Rutas
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-container">
                    <a href="../../ORION/diario.php">Diario</a>
                    <a href="../../ORION/recorridosc.php">Editar Ruta</a>
                    <a href="../../ORION/cuotas.php">Cuotas Registradas</a>
                    <a href="../../ORION/rutas.php">Rutas</a>
                    <a href="../../ORION/gastos.php">Gastos</a>
                </div>
                <button class="dropdown-btn">Prestamos
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-container">
                    <a href="../../ORION/prestamos.php">Lista de Préstamos</a>
                    <a href="../../ORION/clientes.php">Clientes</a>
                    <a href="../../ORION/verificarcliente.php">Verificar Cliente</a>
                </div>
                <button class="dropdown-btn">Contabilidad
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-container">
                    <a href="../../ORION/ganancias.php">Contabilidad x Rutas </a>
                    <a href="../../ORION/contabilidad.php"> Informe Contable </a>
                    <a href="../../ORION/transacciones.php">Transacciones</a>
                </div>
                <button class="dropdown-btn" id="usuarios">Usuarios
                </button>
                <button class="dropdown-btn" id="salir">Salir
                </button>
            </div>
        </main>

    </body>

    </html>
<?php
} else {
    header('Location: ' . "index.php?m=3");
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
        document.getElementById("mimenu").style.width = "40%";
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