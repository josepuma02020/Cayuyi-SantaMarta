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

function eliminargasto(id) {
    cadenau = "id=" + id;
    $.ajax({
        type: "POST",
        url: "gastos/eliminargasto.php",
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

function agregaridgasto(id) {
    $.ajax({
        type: "POST",
        data: "id=" + id,
        url: "",
        success: function() {
            $('#idgasto').val(id);
        }
    });
}

function agregargasto(valor, descripcion, fecha, encargado, tipogasto) {
    cadenau = "valor=" + valor + "&descripcion=" + descripcion + "&tipogasto=" + tipogasto + "&fecha=" + fecha + "&encargado=" + encargado;
    $.ajax({
        type: "POST",
        url: "gastos/agregargasto.php",
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
    "&encargado=" + encargado;
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

function agregarprestamo(formapago, cedula, ruta, posicion, fecha, valor, totalpagar, dias, papeleria) {
    cadenau = "cedula=" + cedula + "&formapago=" + formapago + "&ruta=" + ruta + "&papeleria=" + papeleria + "&posicion=" + posicion + "&fecha=" + fecha + "&valor=" + valor + "&totalpagar=" + totalpagar + "&dias=" + dias;
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

function editarcliente(idu, nombre, apellido, cedula, direccion, telefono) {
    cadenau = "nombre=" + nombre + "&apellido=" + apellido + "&idu=" + idu + "&cedula=" + cedula + "&direccion=" + direccion + "&telefono=" + telefono;
    $.ajax({
        type: "POST",
        url: "clientes/editarcliente.php",
        data: cadenau,
        success: function(r) {
            if (r == 1) {

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
            $('#apellidou').val(dato['apellido']);
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

function agregardatosruta(id, ruta) {
    console.log(ruta);
    $('#idruta').val(id);
    $('#nombreu').val(ruta);
    $('#idruta').val(id);
}