function transaccion(valorretiro, ruta, tipo, comentario) {
    cadenau = "valorretiro=" + valorretiro + "&ruta=" + ruta + "&tipo=" + tipo + "&comentario=" + comentario;

    $.ajax({
        type: "POST",
        url: "contabilidad/transaccion.php",
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






function datoscuota(id) {
    $.ajax({
        type: "POST",
        data: "id=" + id,
        url: "",
        success: function() {
            $('#idu').val(id);
        }
    });
}

function movercapital(valor, destino, origen) {
    cadenau = "valor=" + valor + "&destino=" + destino + "&origen=" + origen;

    $.ajax({
        type: "POST",
        url: "contabilidad/movercapital.php",
        data: cadenau,
        success: function(r) {
            if (r == 111) {

            } else {
                console.log(r);
                debugger;
            }
        }
    });
}

function retirar(valor, cuenta) {
    cadenau = "valor=" + valor + "&cuenta=" + cuenta;
    $.ajax({
        type: "POST",
        url: "contabilidad/retirar.php",
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





function editarusuario(id, cedula, nombre, apellido, direccion, telefono, usuario, clave, rol) {
    cadenau = "id=" + id + "&cedula=" + cedula + "&nombre=" + nombre + "&rol=" + rol + "&apellido=" + apellido + "&direccion=" + direccion + "&telefono=" + telefono + "&clave=" + clave + "&usuario=" + usuario;
    $.ajax({
        type: "POST",
        url: "usuarios/editarusuario.php",
        data: cadenau,
        success: function(r) {
            if (r == 1) {
                console.log(r);
                debugger
            } else {
                console.log(r);
                debugger;
            }
        }
    });
}

function agregardatosusuario(id) {
    $.ajax({
        type: "POST",
        data: "id=" + id,
        url: "usuarios/datosusuario.php",
        success: function(r) {
            console.log(r);
            dato = jQuery.parseJSON(r);
            $('#cedulau').val(dato['cedula']);
            $('#idu').val(dato['id']);
            $('#nombreu').val(dato['nombre']);
            $('#apellidou').val(dato['apellido']);
            $('#direccionu').val(dato['direccion']);
            $('#telefonou').val(dato['telefono']);
            $('#rolactual').val(dato['Rol']);
            $('#usuariou').val(dato['usuario']);
            $('#ultima').val(dato['ultconexion']);
        }
    });
}

function agregarusuario(cedula, nombre, apellido, direccion, telefono, clave, usuario, rol) {
    cadenau = "cedula=" + cedula + "&nombre=" + nombre + "&rol=" + rol + "&apellido=" + apellido + "&direccion=" + direccion + "&telefono=" + telefono + "&clave=" + clave + "&usuario=" + usuario;
    $.ajax({
        type: "POST",
        url: "usuarios/agregarusuario.php",
        data: cadenau,
        success: function(r) {
            if (r == 1) {
                console.log(r);
                debugger
            } else {
                console.log(r);
                debugger;
            }
        }
    });
}