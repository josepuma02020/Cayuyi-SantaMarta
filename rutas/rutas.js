function revisarruta(ide, pleno, base, cobro, prestamo, gasto, nuevos, entrantes, salientes, clientes, papeleria, efectivo, fecha) {
    cadenau = "ide=" + ide + "&papeleria=" + papeleria + "&efectivo=" + efectivo + "&pleno=" + pleno + "&base=" + base + "&cobro=" + cobro + "&fecha=" + fecha + "&prestamo=" + prestamo + "&gasto=" + gasto + "&nuevos=" + nuevos + "&entrantes=" + entrantes + "&salientes=" + salientes + "&clientes=" + clientes;

    $.ajax({
        type: "POST",
        url: "rutas/revisarruta.php",
        data: cadenau,
        success: function(r) {
            if (r == 11) {
                console.log(r);
                debugger;
            } else {
                console.log(r);
                debugger;
            }
        }
    });
}

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