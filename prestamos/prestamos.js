function editarcuota(idu, ncuota) {
    cadenau = "idu=" + idu + "&ncuota=" + ncuota;;
    $.ajax({
        type: "POST",
        url: "prestamos/editarcuota.php",
        data: cadenau,
        success: function (r) {
            if (r == 11) {
                // console.log(r);
                // debugger;
                //window.location.reload();
            } else {
                // console.log(r);
                // debugger;
            }
        }
    });
}

function editarprestamo(dias, valor, ruta, id, comentario) {
    cadenau = "dias=" + dias + "&valor=" + valor + "&ruta=" + ruta + "&id=" + id + "&comentario=" + comentario;
    $.ajax({
        type: "POST",
        url: "prestamos/refinanciar.php",
        data: cadenau,
        success: function (r) {
            if (r == 11) {
                console.log(r);
                // debugger;
                //window.location.reload();
            } else {
                console.log(r);
                // debugger;
            }
        }
    });
}

function eliminarcuota(idu) {
    cadenau = "id=" + idu;
    $.ajax({
        type: "POST",
        url: "prestamos/eliminarcuota.php",
        data: cadenau,
        success: function (r) {
            if (r == 11) {
                // console.log(r);
                //debugger;
                // window.location.reload();
            } else {
                //  console.log(r);
                // debugger;
            }
        }
    });
}

function revisarruta(ide, pleno, base, cobro, prestamo, gasto, nuevos, entrantes, salientes, clientes, papeleria, efectivo, fecha, valornuevos) {
    cadenau = "ide=" + ide + "&papeleria=" + papeleria + "&efectivo=" + efectivo + "&pleno=" + pleno + "&base=" + base + "&cobro=" + cobro + "&valornuevos=" + valornuevos + "&fecha=" + fecha + "&prestamo=" + prestamo + "&gasto=" + gasto + "&nuevos=" + nuevos + "&entrantes=" + entrantes + "&salientes=" + salientes + "&clientes=" + clientes;

    $.ajax({
        type: "POST",
        url: "rutas/revisarruta.php",
        data: cadenau,
        success: function (r) {
            if (r == 11) {
                // window.location.reload();
            } else {
                // console.log(r);
                // debugger;
            }
        }
    });
}

function registrarcuota(idu, recoger, fecha) {
    cadenau = "idu=" + idu + "&recoger=" + recoger + "&fecha=" + fecha;

    $.ajax({
        type: "POST",
        url: "prestamos/registrarcuota.php",
        data: cadenau,
        success: function (r) {
            if (r == 11) {
                console.log(r);
                // debugger;
                window.location.reload();
            } else {
                console.log(r);
                //debugger;
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
        success: function (r) {
            if (r == 1) {
                //console.log(r);
                // debugger;
                //window.location.reload();
            } else {
                //console.log(r);
                // debugger;
            }
        }
    });
}

function obtenerdatosprestamo(id) {
    $.ajax({
        type: "POST",
        data: "id=" + id,
        url: "prestamos/datosprestamo.php",
        success: function (r) {
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
            $('#fecharef').val(dato['fecharef']);
            $('#comentariou').val(dato['comentario']);

        }
    });
}