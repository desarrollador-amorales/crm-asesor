/*=============================================
EDITAR CLIENTE
=============================================*/
$(".tablas").on("click", ".btnEditarCliente", function() {

    var idCliente = $(this).attr("idCliente");

    var datos = new FormData();
    datos.append("idCliente", idCliente);

    $.ajax({

        url: "ajax/clientes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {

            $("#idCliente").val(respuesta["id"]);
            $("#editarCliente").val(respuesta["nombre"]);
            $("#editarCedula").val(respuesta["cedula"]);
            $("#editarEmail").val(respuesta["email"]);
            $("#editarTelefono").val(respuesta["telefono"]);
            $("#editarDireccion").val(respuesta["direccion"]);
            $("#editarFechaNacimiento").val(respuesta["fecha_nacimiento"]);
            $('#estado').find('option[value="' + respuesta["Estado"] + '"]').prop('selected', true);
            $("#editarCotizacion").val(respuesta["Cotizacion"]);
            $('#interes').find('option[value="' + respuesta["Interes"] + '"]').prop('selected', true);
            $('#tipoCliente').find('option[value="' + respuesta["tipo_cliente"] + '"]').prop('selected', true);
            $("#editarProductoCotizado").val(respuesta["ProductoCotizado"]);
            $("#editarFechaSeguimiento").val(respuesta["fecha_seguimiento"]);
            $("#editarValorCotizado").val(respuesta["valor_cotizado"]);
            $("#editarFechaCierre").val(respuesta["fecha_cierre"]);
            $("#editarContrato").val(respuesta["Contrato"]);
            $("#editarFacturacion").val(respuesta["Facturacion"]);
            $("#editarObservaciones").val(respuesta["Observaciones"]);
            $('#editarAlmacen').find('option[value="' + respuesta["Almacen"] + '"]').prop('selected', true);

        }

    })

})

/*=============================================
ELIMINAR CLIENTE
=============================================*/
$(".tablas").on("click", ".btnEliminarCliente", function() {

    var idCliente = $(this).attr("idCliente");

    swal({
        title: '¿Está seguro de borrar el cliente?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar cliente!'
    }).then(function(result) {
        if (result.value) {

            window.location = "index.php?ruta=clientes&idCliente=" + idCliente;
        }

    })

})

/*=============================================
Nuevo Modal
=============================================*/