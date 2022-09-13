/*=============================================
EDITAR CLIENTE
=============================================*/
$(".tablas").on("click", ".btnEditarClienteRecorrido", function() {

    var idCliente = $(this).attr("idCliente");

    var datos = new FormData();
    datos.append("idCliente", idCliente);

    $.ajax({

        url: "ajax/clientes-recorrido.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {

            $("#idCliente").val(respuesta["id"]);
            $("#editarObra").val(respuesta["obra"]);
            $("#editarCallePrincipal").val(respuesta["calle_principal"]);
            $("#editarCalleSecundaria").val(respuesta["calle_secundaria"]);
            $("#editarSector").val(respuesta["sector"]);
            $("#editarCiudad").val(respuesta["ciudad"]);
            $("#editarObservacion").val(respuesta["observaciones"]);
            $('#editarEtapa').find('option[value="' + respuesta["etapa"] + '"]').prop('selected', true);
            $("#editarUbicacion").val(respuesta["ubicacion"]);
            $("#editarNomArq").val(respuesta["nombre_arq"]);
            $("#editarApeArq").val(respuesta["apellido_arq"]);
            $("#editarTelefonoArq").val(respuesta["celular_arq"]);
            $("#editarNomObra").val(respuesta["nombre_obra"]);
            $("#editarApeObra").val(respuesta["apellido_obra"]);
            $("#editarTelefonoObra").val(respuesta["celular_obra"]);
            $("#editarNomMaes").val(respuesta["nombre_maes_obr"]);
            $("#editarApeMaes").val(respuesta["apellido_maes_obr"]);
            $("#editarTelefonoMaes").val(respuesta["celular_maes_obr"]);


        }

    })

})

/*=============================================
ELIMINAR CLIENTE
=============================================*/
$(".tablas").on("click", ".btnEliminarClienteRecorrido", function() {

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

            window.location = "index.php?ruta=recorrido&idCliente=" + idCliente;
        }

    })

})

/*=============================================
Nuevo Modal
=============================================*/