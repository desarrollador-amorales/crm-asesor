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
            $("#editarObra").find('option[value="' + respuesta["obra"] + '"]').prop('selected', true);
            $("#editarCallePrincipal").val(respuesta["calle_principal"]);
            $("#editarCalleSecundaria").val(respuesta["calle_secundaria"]);
            $("#editarSector").val(respuesta["sector"]);
            $("#editarCiudad").find('option[value="' + respuesta["ciudad"] + '"]').prop('selected', true);
            $("#editarObservacion").val(respuesta["observaciones"]);
            $('#editarEtapa').find('option[value="' + respuesta["etapa"] + '"]').prop('selected', true);
            $("#editarUbicacion").val(respuesta["ubicacion"]);
            if (respuesta["contacto1"] !== null && respuesta["contacto1"] !== "") {
                $("#editarcontacto1").find('option[value="' + respuesta["contacto1"] + '"]').prop('selected', true);
            } else {
                $("#editarcontacto1").find('option[value=""]').prop('selected', true);
            }
            if (respuesta["contacto2"] !== null && respuesta["contacto2"] !== "") {
                $("#editarcontacto2").find('option[value="' + respuesta["contacto2"] + '"]').prop('selected', true);
            } else {
                $("#editarcontacto2").find('option[value=""]').prop('selected', true);
            }

            if (respuesta["contacto1"] == "Profesional") {
                $("#editarNom1").val(respuesta["nombre_arq"]);
                $("#editarApe1").val(respuesta["apellido_arq"]);
                $("#editarTelefono1").val(respuesta["celular_arq"]);
            } else if (respuesta["contacto1"] == "Dueno") {
                $("#editarNom1").val(respuesta["nombre_obra"]);
                $("#editarApe1").val(respuesta["apellido_obra"]);
                $("#editarTelefono1").val(respuesta["celular_obra"]);
            } else if (respuesta["contacto1"] == "Maestro") {
                $("#editarNom1").val(respuesta["nombre_maes_obr"]);
                $("#editarApe1").val(respuesta["apellido_maes_obr"]);
                $("#editarTelefono1").val(respuesta["celular_maes_obr"]);
            } else if (respuesta["contacto1"] === "" || respuesta["contacto1"] === null) {
                $("#editarNom1").val("");
                $("#editarApe1").val("");
                $("#editarTelefono1").val("");
            }
            if (respuesta["contacto2"] == "Profesional") {
                $("#editarNom2").val(respuesta["nombre_arq"]);
                $("#editarApe2").val(respuesta["apellido_arq"]);
                $("#editarTelefono2").val(respuesta["celular_arq"]);
            } else if (respuesta["contacto2"] == "Dueno") {
                $("#editarNom2").val(respuesta["nombre_obra"]);
                $("#editarApe2").val(respuesta["apellido_obra"]);
                $("#editarTelefono2").val(respuesta["celular_obra"]);
            } else if (respuesta["contacto2"] == "Maestro") {
                $("#editarNom2").val(respuesta["nombre_maes_obr"]);
                $("#editarApe2").val(respuesta["apellido_maes_obr"]);
                $("#editarTelefono2").val(respuesta["celular_maes_obr"]);
            } else if (respuesta["contacto2"] === "" || respuesta["contacto2"] === null) {
                $("#editarNom2").val("");
                $("#editarApe2").val("");
                $("#editarTelefono2").val("");
            }

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