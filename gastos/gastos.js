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