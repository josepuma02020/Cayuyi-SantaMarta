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