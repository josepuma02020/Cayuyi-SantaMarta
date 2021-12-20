function agregardatosruta(id, ruta) {
    console.log(ruta);
    $('#idruta').val(id);
    $('#nombreu').val(ruta);
    $('#idruta').val(id);
}

function datosruta(id) {
    $.ajax({
        type: "POST",
        data: "id=" + id,
        url: "",
        success: function() {

            $('#idrevisar').val(id);
        }
    });
}

function editarrecorrido(idu, ruta, posicion) {
    cadenau = "idu=" + idu + "&ruta=" + ruta + "&posicion=" + posicion;

    $.ajax({
        type: "POST",
        url: "rutas/editarrecorrido.php",
        data: cadenau,
        success: function(r) {
            if (r == 111) {
                console.log(r);
                debugger;
            } else {
                console.log(r);
                debugger;
            }
        }
    });
}

function datosruta(id) {
    $.ajax({
        type: "POST",
        data: "id=" + id,
        url: "",
        success: function() {

            $('#idrevisar').val(id);
        }
    });
}

function editarruta(id, nombre, encargado) {
    cadenau = "nombre=" + nombre + "&encargado=" + encargado + "&id=" + id;
    $.ajax({
        type: "POST",
        url: "rutas/editarruta.php",
        data: cadenau,
        success: function(r) {
            if (r == 1) {
                console.log(r);
                debugger;
            } else {
                console.log(r);
                debugger;
            }
        }
    });
}

function agregarruta(nombre, encargado) {
    cadenau = "nombre=" + nombre + "&encargado=" + encargado;

    $.ajax({
        type: "POST",
        url: "rutas/agregarruta.php",
        data: cadenau,
        success: function(r) {
            if (r == 1) {
                window.location.href = "rutas.php"
            } else {
                console.log(r);
                debugger;
            }
        }
    });
}

function obtenerdatosprestamo(id) {
    $.ajax({
        type: "POST",
        data: "id=" + id,
        url: "prestamos/datosprestamo.php",
        success: function(r) {
            dato = jQuery.parseJSON(r);
            console.log(dato);
            $('#cedulau').val(dato['cedula']);
            $('#nombreu').val(dato['nombrecliente']);
            $('#rutaactual').val(dato['nombreruta']);
            $('#posicionu').val(dato['posicion']);
            $('#fechau').val(dato['fecha']);
            $('#valoru').val(dato['valor']);
            $('#totalpagaru').val(dato['pagar']);
            $('#valorinteresesu').val(dato['intereses']);
            $('#porcentajeu').val(dato['porcentaje'].toFixed(2));
            $('#diasu').val(dato['dias']);
            $('#cuotau').val((dato['cuota'] * dato['valorforma']).toFixed(2));
            $('#idu').val(dato['id']);
            $('#idu1').val(dato['id']);
            $('#formau').val(dato['formapago']);
            $('#abonou').val(dato['abonado']);
            $('#atrasou').val(dato['atraso']);
        }
    });
}