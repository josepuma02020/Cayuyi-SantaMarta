function eliminarcuota(idu) {
    cadenau = "id=" + idu;
    $.ajax({
        type: "POST",
        url: "prestamos/eliminarcuota.php",
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

function registrarcuota(idu, recoger) {
    cadenau = "idu=" + idu + "&recoger=" + recoger;

    $.ajax({
        type: "POST",
        url: "prestamos/registrarcuota.php",
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

function editarprestamo(idu, ruta, nformapago, totalpagar, dias, valoru) {
    cadenau = "idu=" + idu + "&ruta=" + ruta + "&valoru=" + valoru + "&nformapago=" + nformapago + "&totalpagar=" + totalpagar + "&dias=" + dias;
    $.ajax({
        type: "POST",
        url: "prestamos/editarprestamo.php",
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

function agregarprestamo(formapago, cedula, ruta, posicion, fecha, valor, totalpagar, dias, papeleria, direccion, telefono, nombre, apellido, domingo) {
    cadenau = "cedula=" + cedula + "&domingo=" + domingo + "&nombre=" + nombre + "&apellido=" + apellido + "&formapago=" + formapago + "&ruta=" + ruta + "&papeleria=" + papeleria + "&posicion=" + posicion + "&fecha=" + fecha + "&valor=" + valor + "&direccion=" + direccion + "&telefono=" + telefono + "&totalpagar=" + totalpagar + "&dias=" + dias;
    $.ajax({
        type: "POST",
        url: "prestamos/agregarprestamo.php",
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