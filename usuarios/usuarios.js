function editarusuario(id, cedula, nombre, apellido, direccion, telefono, usuario, clave, rol) {
    cadenau = "id=" + id + "&cedula=" + cedula + "&nombre=" + nombre + "&rol=" + rol + "&apellido=" + apellido + "&direccion=" + direccion + "&telefono=" + telefono + "&clave=" + clave + "&usuario=" + usuario;
    $.ajax({
        type: "POST",
        url: "usuarios/editarusuario.php",
        data: cadenau,
        success: function(r) {
            if (r == 1) {
                // console.log(r);
                // debugger;
                window.location.reload();
            } else {
                // console.log(r);
                // debugger;
            }
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
                // console.log(r);
                // debugger;
                window.location.reload();
            } else {
                // console.log(r);
                // debugger;
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