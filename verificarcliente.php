<?php
session_start();
if ($_SESSION['usuario']) {
    include_once('conexion/conexion.php');
    include_once('funciones/funciones.php');
    setlocale(LC_ALL, "es_CO");
    if (isset($_GET['cc'])) {
        $cedula = $_GET['cc'];
    } else {
        $cedula = "";
    }
?>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css" />
        <link rel="stylesheet" type="text/css" href="./diseno/defecto/cel.css" />
        <link rel="stylesheet" type="text/css" href="./diseno/defecto/desktop.css" media="screen and (min-width:1000px)" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <SCRIPT src="librerias/jquery-3.5.1.min.js"></script>
        <SCRIPT src="librerias/alertify/alertify.js"></script>
        <SCRIPT lang="javascript" type="text/javascript" src="funciones/funciones.js"></script>
        <script src="librerias/bootstrap/js/bootstrap.js"></script>

    </head>

    <body>
        <header>
            <?php include_once($_SESSION['menu']); ?>
        </header>

        <div class="container">
            <section class="titulo-pagina">
                <h1>Verificar cliente</h1>
            </section>
            <section class="parametros">
                <div class="form-group parametro-80">
                    <h3>Cedula:</h3>
                    <input class="form-control input-sm" type="text" id="cedula" value="<?php echo $cedula; ?>">
                </div>
                <button type="button" id="buscar" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                    </svg>
                </button>
            </section>
        </div>
        <footer>

            <p>Author: Pumasoft<br>
                <a href="https://www.pumasoft.co">pumasoft.co</a>
            </p>
        </footer>

    </body>

    </html>
<?php
} else {
    header('Location: ' . "usuarios/cerrarsesion.php");
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#buscar').click(function() {
            a = 0;
            cedula = $('#cedula').val();
            location.href = `verificarcliente.php?cc=${cedula}`;
        });
    });
</script>