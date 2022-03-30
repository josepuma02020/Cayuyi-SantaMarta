function agregaridcontable(id) {
    $.ajax({
        type: "POST",
        data: "id=" + id,
        success: function(r) {
            $('#idu').val(id);
            console.log(id);
            debugger;
        }
    });
}

function eliminarcierre(id) {
    $.ajax({
        type: "POST",
        url: "contabilidad/eliminarcierre.php",
        data: "id=" + id,
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