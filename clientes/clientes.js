function editarcliente(idu, nombre, cedula, direccion, telefono, nota) {
    cadenau = "nombre=" + nombre + "&nota=" + nota + "&idu=" + idu + "&cedula=" + cedula + "&direccion=" + direccion + "&telefono=" + telefono;
    $.ajax({
        type: "POST",
        url: "clientes/editarcliente.php",
        data: cadenau,
        success: function(r) {
            if (r == 1) {
                // console.log(r);
                // debugger;
                window.location.reload();
            } else {
                console.log(r);
                debugger;
            }
        }
    });
}

function agregardatoscliente(id) {
    $.ajax({
        type: "POST",
        data: "id=" + id,
        url: "clientes/agregardatoscliente.php",
        success: function(r) {
            console.log(r);
            dato = jQuery.parseJSON(r);
            console.log(dato);
            $('#nombreu').val(dato['nombre']);
            $('#cedulau').val(dato['cedula']);
            $('#telefonou').val(dato['telefono']);
            $('#direccionu').val(dato['direccion']);
            $('#idu').val(id);
            $('#activou').val(dato['activo']);
            $('#ultprestamo').val(dato['ultprestamo']);
            $('#fechault').val(dato['fecha']);
            $('#plazoult').val(dato['dias']);
            $('#diasatraso').val(dato['atraso']);
            $('#debe').val(dato['debe']);
            $('#rutapre').val(dato['ruta']);
            $('#fechacierre').val(dato['cierre']);
            $('#notau').val(dato['nota']);



        }
    });
}

function agregarcliente(nombre, apellido, cedula, direccion, telefono) {
    cadenau = "nombre=" + nombre + "&apellido=" + apellido + "&cedula=" + cedula + "&direccion=" + direccion + "&telefono=" + telefono;
    $.ajax({
        type: "POST",
        url: "clientes/agregarcliente.php",
        data: cadenau,
        success: function(r) {
            if (r == 1) {
                window.location.reload();
            } else {
                console.log(r);
                debugger;
            }
        }
    });
}