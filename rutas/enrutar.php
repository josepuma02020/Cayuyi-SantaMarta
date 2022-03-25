 <?php
    include('funciones.php');
    $data = $_POST['data'];
    echo $data;
    $tarjetasordenadas = json_encode($data);
    var_dump($tarjetasordenadas);

    (new Tarjeta())->ordernarTarjetas($tarjetasordenadas);
