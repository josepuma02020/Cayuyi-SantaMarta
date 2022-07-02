<?php
if (isset($_SESSION['usuario'])) {
    setlocale(LC_ALL, "es_CO");
?>
    <html>

    <head>
        <link rel="shortcut  icon" href="../imagenes/logop.ico" type="image/x-icon" />
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./diseno/menu/cel.css" media="screen and (min-width:200px)" />
        <link rel="stylesheet" href="./diseno/menu/tablet.css" media="screen and (min-width:700px)" />
        <link rel="stylesheet" href="./diseno/menu/desktop.css" media="screen and (min-width:1025px)" />
        <title>Control de préstamos</title>
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
                    <a href="diario.php">Diario</a>
                    <a href="recorridosc.php">Enrutar</a>
                    <a href="rutas.php">Rutas</a>
                    <a href="gastos.php">Gastos</a>
                    <a href="cuotas.php">Liquidación</a>
                </div>
                <button class="dropdown-btn">Préstamos
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-container">
                    <a href="prestamos.php">Activos</a>
                    <a href="verificarcliente.php">Verificar Cliente</a>
                </div>
                <div class="dropdown-container">
                    <a href="contabilidad.php"> Informe Contable </a>
                </div>
                <button class="dropdown-btn" id="salir">Salir
                </button>
            </div>
            <?php
            if ($_SESSION['Rol'] == 1) {
                $consultaestadosistema = "select activo from usuarios where id_usuario = $_SESSION[id_usuario]";
                $queryestado = mysqli_query($link, $consultaestadosistema) or die($consultaestadosistema);
                $filaestado = mysqli_fetch_array($queryestado);
                $estado = $filaestado['activo'];
                if ($estado == 0) {
                    $clase = "success";
                } else {
                    $clase = "danger";
                }
            ?>
                <section>
                    <input type="hidden" id="estado" name="estado" value="<?php echo $estado ?>">
                    <span class="btn btn-<?php echo $clase ?> boton-parametro" id="cambiarestado">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-power" viewBox="0 0 16 16">
                            <path d="M7.5 1v7h1V1h-1z" />
                            <path d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812z" />
                        </svg><span class="fa fa-plus-circle"></span>
                    </span>
                </section>
            <?php }
            ?>
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
        document.getElementById("mimenu").style.width = "auto";
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
<script>
    $(document).ready(function() {
        $('#cambiarestado').click(function() {
            estado = $('#estado').val();
            alertify.alert('ATENCION!!', 'Se cambiara el estado del sistema permitiendo o denegando permiso de ingreso a usuarios diferentes al administrador.', function() {
                alertify.success('Ok');
                window.location.href = "rutas/cambiarestadosistema.php?estado=" + estado;
            });

        });
    });
</script>