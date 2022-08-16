/*=============================================
CARGAR LA TABLA DINÁMICA DE VENTAS
=============================================*/

// $.ajax({

// 	url: "ajax/datatable-ventas.ajax.php",
// 	success:function(respuesta){

// 		console.log("respuesta", respuesta);

// 	}

// })// 

$('.tablaVentas').DataTable({
    "ajax": "ajax/datatable-ventas.ajax.php",
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "language": {

        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }

    }

});


function cambios() {
    sumarTotalPrecios();

    // AGREGAR IMPUESTO

    agregarImpuesto();

    // AGRUPAR PRODUCTOS EN FORMATO JSON

    listarProductos();
}

/*=============================================
CUANDO CARGUE LA TABLA CADA VEZ QUE NAVEGUE EN ELLA
=============================================*/

$(".tablaVentas").on("draw.dt", function() {

    if (localStorage.getItem("quitarProducto") != null) {

        var listaIdProductos = JSON.parse(localStorage.getItem("quitarProducto"));

        for (var i = 0; i < listaIdProductos.length; i++) {

            $("button.recuperarBoton[idProducto='" + listaIdProductos[i]["idProducto"] + "']").removeClass('btn-default');
            $("button.recuperarBoton[idProducto='" + listaIdProductos[i]["idProducto"] + "']").addClass('btn-primary agregarProducto');

        }


    }


})


/*=============================================
QUITAR PRODUCTOS DE LA VENTA Y RECUPERAR BOTÓN
=============================================*/

var idQuitarProducto = [];

localStorage.removeItem("quitarProducto");

$(".formularioVenta").on("click", "button.quitarProducto", function() {

    $(this).parent().parent().parent().parent().remove();

    var idProducto = $(this).attr("idProducto");

    /*=============================================
    ALMACENAR EN EL LOCALSTORAGE EL ID DEL PRODUCTO A QUITAR
    =============================================*/

    if (localStorage.getItem("quitarProducto") == null) {

        idQuitarProducto = [];

    } else {

        idQuitarProducto.concat(localStorage.getItem("quitarProducto"))

    }

    idQuitarProducto.push({ "idProducto": idProducto });

    localStorage.setItem("quitarProducto", JSON.stringify(idQuitarProducto));

    $("button.recuperarBoton[idProducto='" + idProducto + "']").removeClass('btn-default');

    $("button.recuperarBoton[idProducto='" + idProducto + "']").addClass('btn-primary agregarProducto');

    if ($(".nuevoProducto").children().length == 0) {

        $("#nuevoImpuestoVenta").val(0);
        $("#nuevoTotalVenta").val(0);
        $("#totalVenta").val(0);
        $("#nuevoTotalVenta").attr("total", 0);

    } else {

        // SUMAR TOTAL DE PRECIOS

        sumarTotalPrecios()

        // AGREGAR IMPUESTO

        agregarImpuesto()

        // AGRUPAR PRODUCTOS EN FORMATO JSON

        listarProductos()

    }

})


/*=============================================
ESCOGE EL VALOR PARA LA COTIZACION
=============================================*/

let valorCotizacion = 0;

$('#seleccionarCotizacion').on('change', function() {
    valorCotizacion = $('#seleccionarCotizacion').val();
    console.log(valorCotizacion);

});

/*=============================================
AGREGANDO DETALLES A LAS ACTIVIDADES
=============================================*/

var numProducto = 0;
var tipoCliente = 0;
var estadoCliente = 0;
var clienteCompartido = 0;
var motivoCliente = 0;
var observacion = 0;
var fechaSeguimiento = 0;
var valorFactura = 0;
var visitAlmacen = 0;
var fecha = 0;

var date = new Date();

var day = date.getDate();
var month = date.getMonth() + 1;
var year = date.getFullYear();
var hours = date.getHours();
var minutes = date.getMinutes();
var seconds = date.getSeconds();

if (month < 10) month = "0" + month;
if (day < 10) day = "0" + day;
if (hours < 10) hours = "0" + hours;
if (minutes < 10) minutes = "0" + minutes;
if (seconds < 10) seconds = "0" + seconds;

var today = year + "-" + month + "-" + day + " " + hours + ":" + minutes + ":" + seconds;

$(".formularioVenta").on("click", ".btnAgregarProducto", function() {


    numProducto++;
    tipoCliente++;
    estadoCliente++;
    clienteCompartido++;
    motivoCliente++;
    observacion++;
    fechaSeguimiento++;
    valorFactura++;
    visitAlmacen++;
    fecha++;


    var datos = new FormData();
    datos.append("traerProductos", "ok");


    $.ajax({
        url: "ajax/productos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {


            $(".nuevoProducto").append(

                '<div class="row" style="padding:5px 15px">' +

                '<!-- Tipo del cliente -->' +

                '<div class="col-xs-2 style="padding-right:0px">' +

                '<div class="input-group">' +

                '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto><i class="fa fa-times"></i></button></span>' +

                '<select class="form-control nuevoTipoCliente" id="tipoCliente' + tipoCliente + '" idtipoCliente name="nuevoTipoCliente" required>' +

                '<option idtipoCliente= "idtipoCliente" value= "">- Origen Negociación -</option>' +

                '<option idtipoCliente= "idtipoCliente" value= "Llamada">Llamada</option>' +

                '<option idtipoCliente= "idtipoCliente" value= "Neo">Neo</option>' +

                '<option idtipoCliente= "idtipoCliente" value= "Visita Almacen">Visita Almacén</option>' +

                '<option idtipoCliente= "idtipoCliente" value= "Visita Obra">Visita Obra</option>' +

                '</select>' +

                '</div>' +

                '</div>' +

                '<!-- Campo Compartido -->' +

                '<div class="col-xs-2 style="padding-right:0px">' +

                '<select class="form-control nuevoCliCompartido" id="cliCompartido' + clienteCompartido + '" idCliCompartido name="nuevoCliCompartido">' +

                '<option idCliCompartido= "idCliCompartido" value= "">- Cliente Compartido -</option>' +

                '<option idCliCompartido= "idCliCompartido" value= "Adrián Rios">Adrián Ríos</option>' +

                '<option idCliCompartido= "idCliCompartido" value= "Janneth Luna">Janneth Luna</option>' +

                '<option idCliCompartido= "idCliCompartido" value= "Marcelo Vásquez">Marcelo Vásquez</option>' +

                '<option idCliCompartido= "idCliCompartido" value= "Juan Nieto">Juan Nieto</option>' +

                '<option idCliCompartido= "idCliCompartido" value= "Karla Saldana">Karla Saldaña</option>' +

                '<option idCliCompartido= "idCliCompartido" value= "Belen Morales">Belen Morales</option>' +

                '</select>' +

                '</div>' +

                '<!-- Estado Cliente -->' +

                '<div class="col-xs-2 style="padding-right:0px">' +

                '<select class="form-control nuevoEstadoCliente" id="estadoCliente' + estadoCliente + '" idestadoCliente name="nuevoEstadoCliente" required>' +

                '<option idestadoCliente= "idestadoCliente" value= "">- Estado Cliente -</option>' +

                '<option idestadoCliente= "idestadoCliente" value= "Seguimiento">Seguimiento</option>' +

                '<option idestadoCliente= "idestadoCliente" value= "Vendido">Vendido</option>' +

                '<option idestadoCliente= "idestadoCliente" value= "Perdido">Perdido</option>' +

                '</select>' +

                '</div>' +

                '<!-- Cliente Visito Almacen -->' +

                '<div class="col-xs-1 style="padding-right:0px">' +

                '<select class="form-control nuevoVisitaAlmacen" id="visitAlmacen' + visitAlmacen + '" idVisitaAlmacen name="nuevoVisitaAlmacen" required>' +

                '<option idVisitaAlmacen= "idVisitaAlmacen" value= "">- ¿Visito Almacen? -</option>' +

                '<option idVisitaAlmacen= "idVisitaAlmacen" value= "Si">Si</option>' +

                '<option idVisitaAlmacen= "idVisitaAlmacen" value= "No">No</option>' +

                '</select>' +

                '</div>' +


                '<!-- Motivo del Cliente -->' +

                '<div class="col-xs-2 style="padding-right:0px">' +

                '<select class="form-control nuevoMotivoCliente" id="motivoCliente' + motivoCliente + '" idmotivoCliente name="nuevoMotivoCliente" required disabled>' +

                '<option idmotivoCliente= "idmotivoCliente" value= "">- ¿Por que no compró? -</option>' +

                '<option idmotivoCliente= "idmotivoCliente" value= "Paralizo Obra">Paralizó obra</option>' +

                '<option idmotivoCliente= "idmotivoCliente" value= "Duramas">Duramas</option>' +

                '<option idmotivoCliente= "idmotivoCliente" value= "Competencia Precio">Competencia Precio</option>' +

                '<option idmotivoCliente= "idmotivoCliente" value= "Competencia Stock">Competencia Stock</option>' +

                '<option idmotivoCliente= "idmotivoCliente" value= "No Contesta/Apagado">No Contesta/Apagado</option>' +

                '<option idmotivoCliente= "idmotivoCliente" value= "Curiosidad">Curiosidad</option>' +

                '</select>' +

                '</div>' +

                '<!-- Fecha Seguimiento -->' +

                '<div class="col-xs-2" style="padding-left:0px">' +

                '<input type="date" class="form-control nuevoFechaSeguimiento" name="nuevoFechaSeguimiento" id="nuevoFechaSeguimiento' + fechaSeguimiento + '" placeholder="Ingresar fecha" required disabled>' +

                '</div>' +

                '<!-- Valor Factura -->' +

                '<div class="col-xs-1" style="padding-left:0px">' +

                '<input type="numeric" class="form-control nuevoValorFactura" name="nuevoValorFactura" id="nuevoValorFactura' + valorFactura + '" placeholder="Sub. Factura" required disabled>' +

                '</div>' +

                '<!--Observacion -->' +

                '<div class="col-xs-12" style="padding-left:14px">' +

                '<input type="text" class="form-control nuevoObservacion"  name="nuevoObservacion"  id ="nuevoObservacion' + observacion + '" placeholder="Ingresar Observacion" required disabled>' +

                '</div>' +

                '<!-- Fecha -->' +

                '<div class="col-xs-1" style="padding-left:0px">' +

                '<input type="hidden" class="form-control nuevoFecha" name="nuevoFecha" id="nuevoFecha' + fecha + '" value="' + today + '" placeholder="" required disabled >' +

                '</div>' +

                '</div>'

            );




            /*=============================================
            SELECCCIONAR ESTADO CLIENTE
            =============================================**/


            $(".formularioVenta").on("change", "select.nuevoEstadoCliente", function() {
                var estado = $(this).val();
                if (estado == "Vendido") {
                    document.getElementById("nuevoValorFactura" + valorFactura).disabled = false;
                } else if (estado != "Vendido") {
                    document.getElementById("nuevoValorFactura" + valorFactura).disabled = true;
                }

                if (estado == "Seguimiento" || estado == "Perdido") {
                    document.getElementById("nuevoObservacion" + observacion).disabled = false;
                } else if (estado != "Seguimiento" || estado != "Perdido") {
                    document.getElementById("nuevoObservacion" + observacion).disabled = true;
                }

                if (estado == "Seguimiento" || estado == "Vendido") {
                    document.getElementById("nuevoFechaSeguimiento" + fechaSeguimiento).disabled = false;

                } else if (estado != "Seguimiento" || estado != "Vendido") {
                    document.getElementById("nuevoFechaSeguimiento" + fechaSeguimiento).disabled = true;
                }

                if (estado == "Perdido") {
                    document.getElementById("motivoCliente" + motivoCliente).disabled = false;
                } else if (estado != "Perdido") {
                    document.getElementById("motivoCliente" + motivoCliente).disabled = true;
                }

                listarProductos()
            })

            localStorage.removeItem("quitarProducto");

        }


    })

})





$(".formularioVenta").on("click", ".btnAgregarProducto1", function() {

    numProducto++;
    tipoCliente++;
    estadoCliente++;
    clienteCompartido++;
    motivoCliente++;
    observacion++;
    fechaSeguimiento++;
    valorFactura++;
    visitAlmacen++;
    fecha++;

    var datos = new FormData();
    datos.append("traerProductos", "ok");


    $.ajax({
        url: "ajax/productos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {


            $(".nuevoProducto").append(

                '<div class="row" style="padding:5px 15px">' +

                '<!-- Estado Cliente -->' +

                '<div class="col-xs-2 style="padding-right:0px">' +

                '<div class="input-group">' +

                '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto><i class="fa fa-times"></i></button></span>' +

                '<!-- Tipo del cliente -->' +

                '<input type="hidden" class="form-control nuevoTipoCliente" name="nuevoTipoCliente">' +

                '<!-- Campo Compartido -->' +

                '<input type="hidden" class="form-control nuevoCliCompartido" name="nuevoCliCompartido">' +

                '<select class="form-control nuevoEstadoCliente" id="estadoCliente' + estadoCliente + '" idestadoCliente name="nuevoEstadoCliente" required>' +

                '<option idestadoCliente= "idestadoCliente" value= "">- Estado Cliente -</option>' +

                '<option idestadoCliente= "idestadoCliente" value= "Seguimiento">Seguimiento</option>' +

                '<option idestadoCliente= "idestadoCliente" value= "Vendido">Vendido</option>' +

                '<option idestadoCliente= "idestadoCliente" value= "Perdido">Perdido</option>' +

                '</select>' +

                '</div>' +

                '</div>' +

                '<!-- Cliente Visito Almacen -->' +

                '<div class="col-xs-2 style="padding-right:0px">' +

                '<select class="form-control nuevoVisitaAlmacen" id="visitAlmacen' + visitAlmacen + '" idVisitaAlmacen name="nuevoVisitaAlmacen" required>' +

                '<option idVisitaAlmacen= "idVisitaAlmacen" value= "">- ¿Visito Almacen? -</option>' +

                '<option idVisitaAlmacen= "idVisitaAlmacen" value= "Si">Si</option>' +

                '<option idVisitaAlmacen= "idVisitaAlmacen" value= "No">No</option>' +

                '</select>' +

                '</div>' +

                '<!-- Motivo del Cliente -->' +

                '<div class="col-xs-2 style="padding-right:0px">' +

                '<select class="form-control nuevoMotivoCliente" id="motivoCliente' + motivoCliente + '" idmotivoCliente name="nuevoMotivoCliente" required disabled>' +

                '<option idmotivoCliente= "idmotivoCliente" value= "">- ¿Por que no compró? -</option>' +

                '<option idmotivoCliente= "idmotivoCliente" value= "Paralizo Obra">Paralizó obra</option>' +

                '<option idmotivoCliente= "idmotivoCliente" value= "Duramas">Duramas</option>' +

                '<option idmotivoCliente= "idmotivoCliente" value= "Competencia Precio">Competencia Precio</option>' +

                '<option idmotivoCliente= "idmotivoCliente" value= "Competencia Stock">Competencia Stock</option>' +

                '<option idmotivoCliente= "idmotivoCliente" value= "No Contesta/Apagado">No Contesta/Apagado</option>' +

                '<option idmotivoCliente= "idmotivoCliente" value= "Curiosidad">Curiosidad</option>' +

                '</select>' +

                '</div>' +

                '<!-- Fecha Seguimiento -->' +

                '<div class="col-xs-1" style="padding-left:0px">' +

                '<input type="date" class="form-control nuevoFechaSeguimiento" name="nuevoFechaSeguimiento" id="nuevoFechaSeguimiento' + fechaSeguimiento + '" placeholder="Ingresar fecha" required disabled >' +

                '</div>' +

                '<!-- Valor Factura -->' +

                '<div class="col-xs-1" style="padding-left:0px">' +

                '<input type="numeric" class="form-control nuevoValorFactura" name="nuevoValorFactura" id="nuevoValorFactura' + valorFactura + '" placeholder="Sub. Factura" required disabled>' +

                '</div>' +

                '<!-- Observacion Cotizacion -->' +

                '<div class="col-xs-4" style="padding-left:0px">' +

                '<input type="text" class="form-control nuevoObservacion" name="nuevoObservacion" id ="nuevoObservacion' + observacion + '" placeholder="Ingresar Observacion" required disabled>' +

                '</div>' +

                '<!-- Fecha -->' +

                '<div class="col-xs-1" style="padding-left:0px">' +

                '<input type="hidden" class="form-control nuevoFecha" name="nuevoFecha" id="nuevoFecha' + fecha + '" value="' + today + '" placeholder="" required disabled >' +

                '</div>' +

                '</div>');

            /*=============================================
            SELECCCIONAR ESTADO CLIENTE
            =============================================**/


            $(".formularioVenta").on("change", "select.nuevoEstadoCliente", function() {
                var estado = $(this).val();
                if (estado == "Vendido") {
                    document.getElementById("nuevoValorFactura" + valorFactura).disabled = false;

                } else if (estado != "Vendido") {
                    document.getElementById("nuevoValorFactura" + valorFactura).disabled = true;
                }

                if (estado == "Seguimiento" || estado == "Perdido") {
                    document.getElementById("nuevoObservacion" + observacion).disabled = false;
                } else if (estado != "Seguimiento" || estado != "Perdido") {
                    document.getElementById("nuevoObservacion" + observacion).disabled = true;
                }

                if (estado == "Seguimiento" || estado == "Vendido") {
                    document.getElementById("nuevoFechaSeguimiento" + fechaSeguimiento).disabled = false;

                } else if (estado != "Seguimiento" || estado != "Vendido") {
                    document.getElementById("nuevoFechaSeguimiento" + fechaSeguimiento).disabled = true;
                }

                if (estado == "Perdido") {
                    document.getElementById("motivoCliente" + motivoCliente).disabled = false;
                } else if (estado != "Perdido") {
                    document.getElementById("motivoCliente" + motivoCliente).disabled = true;
                }
                listarProductos()
            })

        }


    })

})






/*=============================================
SELECCIONAR CLIENTE COMPARTIDO
=============================================**/

$(".formularioVenta").on("change", "select.nuevoCliCompartido", function() {
    listarProductos()
})


/*=============================================
SELECCIONAR VISITO ALMACEN
=============================================**/

$(".formularioVenta").on("change", "select.nuevoVisitaAlmacen", function() {
    listarProductos()
})

/*=============================================
SELECCIONAR TIPO DE CLIENTE
=============================================**/

$(".formularioVenta").on("change", "select.nuevoTipoCliente", function() {
    listarProductos()
})


/*=============================================
SELECCCIONAR MOTIVO CLIENTE
=============================================**/

$(".formularioVenta").on("change", "select.nuevoMotivoCliente", function() {
    listarProductos()
})


/*=============================================
    SELECCCIONAR FECHA SEGUMIENTO/VENDIDO
    =============================================**/

$(".formularioVenta").on("change", "input.nuevoFechaSeguimiento", function() {
    var estCliente = document.getElementById("estadoCliente" + estadoCliente).value;
    var fechaseg = document.getElementById("nuevoFechaSeguimiento" + fechaSeguimiento).value;

    var date = new Date();

    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();

    if (month < 10) month = "0" + month;
    if (day < 10) day = "0" + day;

    var today = year + "-" + month + "-" + day;

    if (estCliente == "Seguimiento") {

        if (fechaseg < today) {
            swal({
                title: 'La fecha no puede ser menor a la actual',
                type: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar'
            })
            document.getElementById("nuevoFechaSeguimiento" + fechaSeguimiento).value = today;
        }
    }
    listarProductos()
})

/*=============================================
SELECCCIONAR OBSERVACION
=============================================**/

$(".formularioVenta").on("change", "input.nuevoObservacion", function() {
    listarProductos()
})


/*=============================================
SELECCCIONAR VALOR FACTURA
=============================================**/

$(".formularioVenta").on("change", "input.nuevoValorFactura", function() {
    listarProductos()
})



/*=============================================
SUMAR TODOS LOS PRECIOS
=============================================*/

function sumarTotalPrecios() {

    var precioItem = $(".nuevoPrecioProducto");

    var arraySumaPrecio = [];

    for (var i = 0; i < precioItem.length; i++) {

        arraySumaPrecio.push(Number($(precioItem[i]).val()));


    }

    function sumaArrayPrecios(total, numero) {

        return total + numero;

    }

    var sumaTotalPrecio = arraySumaPrecio.reduce(sumaArrayPrecios);

    $("#nuevoTotalVenta").val(sumaTotalPrecio);
    $("#totalVenta").val(sumaTotalPrecio);
    $("#nuevoTotalVenta").attr("total", sumaTotalPrecio);


}

/*=============================================
FUNCIÓN AGREGAR IMPUESTO
=============================================*/

function agregarImpuesto() {

    var impuesto = $("#nuevoImpuestoVenta").val();
    var precioTotal = $("#nuevoTotalVenta").attr("total");

    var precioImpuesto = Number(precioTotal * impuesto / 100);

    var totalConImpuesto = Number(precioImpuesto) + Number(precioTotal);

    $("#nuevoTotalVenta").val(totalConImpuesto);

    $("#totalVenta").val(totalConImpuesto);

    $("#nuevoPrecioImpuesto").val(precioImpuesto);

    $("#nuevoPrecioNeto").val(precioTotal);

}

/*=============================================
CUANDO CAMBIA EL IMPUESTO
=============================================*/

$("#nuevoImpuestoVenta").change(function() {

    agregarImpuesto();

});

/*=============================================
FORMATO AL PRECIO FINAL
=============================================*/

$("#nuevoTotalVenta").number(true, 2);

/*=============================================
SELECCIONAR MÉTODO DE PAGO
=============================================*/

$("#nuevoMetodoPago").change(function() {

    var metodo = $(this).val();

    if (metodo == "Efectivo") {

        $(this).parent().parent().removeClass("col-xs-6");

        $(this).parent().parent().addClass("col-xs-4");

        $(this).parent().parent().parent().children(".cajasMetodoPago").html(

            '<div class="col-xs-4">' +

            '<div class="input-group">' +

            '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' +

            '<input type="text" class="form-control" id="nuevoValorEfectivo" placeholder="000000" required>' +

            '</div>' +

            '</div>' +

            '<div class="col-xs-4" id="capturarCambioEfectivo" style="padding-left:0px">' +

            '<div class="input-group">' +

            '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' +

            '<input type="text" class="form-control" id="nuevoCambioEfectivo" placeholder="000000" readonly required>' +

            '</div>' +

            '</div>'

        )

        // Agregar formato al precio

        $('#nuevoValorEfectivo').number(true, 2);
        $('#nuevoCambioEfectivo').number(true, 2);


        // Listar método en la entrada
        listarMetodos()

    } else {

        $(this).parent().parent().removeClass('col-xs-4');

        $(this).parent().parent().addClass('col-xs-6');

        $(this).parent().parent().parent().children('.cajasMetodoPago').html(

            '<div class="col-xs-6" style="padding-left:0px">' +

            '<div class="input-group">' +

            '<input type="number" min="0" class="form-control" id="nuevoCodigoTransaccion" placeholder="Código transacción"  required>' +

            '<span class="input-group-addon"><i class="fa fa-lock"></i></span>' +

            '</div>' +

            '</div>')

    }



})

/*=============================================
CAMBIO EN EFECTIVO
=============================================
$(".formularioVenta").on("change", "input#nuevoValorEfectivo", function() {

    var efectivo = $(this).val();

    var cambio = Number(efectivo) - Number($('#nuevoTotalVenta').val());

    var nuevoCambioEfectivo = $(this).parent().parent().parent().children('#capturarCambioEfectivo').children().children('#nuevoCambioEfectivo');

    nuevoCambioEfectivo.val(cambio);

})
**/
/*=============================================
CAMBIO TRANSACCIÓN
=============================================*/
$(".formularioVenta").on("change", "input#nuevoCodigoTransaccion", function() {

    // Listar método en la entrada
    listarMetodos()


})


/*=============================================
LISTAR TODOS LOS PRODUCTOS
=============================================*/

function listarProductos() {

    var listaProductos = [];

    var clienteCompartido = $(".nuevoCliCompartido");

    var tipoCliente = $(".nuevoTipoCliente");

    var visitaAlmacen = $(".nuevoVisitaAlmacen")

    var estadoCliente = $(".nuevoEstadoCliente");

    var motivoCliente = $(".nuevoMotivoCliente")

    var fechaSeguimiento = $(".nuevoFechaSeguimiento")

    var Observacion = $(".nuevoObservacion");

    var valorFactura = $(".nuevoValorFactura");

    var fecha = $(".nuevoFecha")


    for (var i = 0; i < estadoCliente.length; i++) {

        listaProductos.push({
            "tipo_cliente": $(tipoCliente[i]).val(),
            "cliente_compartido": $(clienteCompartido[i]).val(),
            "estado_cliente": $(estadoCliente[i]).val(),
            "visita_almacen": $(visitaAlmacen[i]).val(),
            "motivo_cliente": $(motivoCliente[i]).val(),
            "fecha_seguimiento": $(fechaSeguimiento[i]).val(),
            "observacion": $(Observacion[i]).val(),
            "valor_factura": $(valorFactura[i]).val(),
            "fecha": $(fecha[i]).val()
        })

    }

    $("#listaProductos").val(JSON.stringify(listaProductos));

}

/*=============================================
LISTAR MÉTODO DE PAGO
=============================================*/

function listarMetodos() {

    var listaMetodos = "";

    if ($("#nuevoMetodoPago").val() == "Efectivo") {

        $("#listaMetodoPago").val("Efectivo");

    } else {

        $("#listaMetodoPago").val($("#nuevoMetodoPago").val() + "-" + $("#nuevoCodigoTransaccion").val());

    }

}

/*=============================================
BOTON EDITAR VENTA
=============================================*/
$(".tablas").on("click", ".btnEditarVenta", function() {

    var idVenta = $(this).attr("idVenta");
    var actividadRealizada = $(this).attr("actividadRealizada");
    var numeroCotizacion = $(this).attr("numeroCotizacion");
    var idVendedor = $(this).attr("id_vendedor")
    var idSession = $(this).attr("id_session")
    var idAlmacen = $(this).attr("idAlmacen")
    var numCotizaciones = $(this).attr("numCotizaciones")
    var cotizaciones = $(this).attr("cotizaciones")


    if (idVendedor != idSession) {

        swal({
            title: 'Este cliente no esta asignado a tu lista',
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar'
        })

    } else if (numCotizaciones >= 2) {
        swal({
            title: 'Este cliente tiene abierta la cotizacion: (' + cotizaciones + ')',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Continuar'
        }).then(function(result) {
            if (result.value) {

                window.location = "index.php?ruta=editar-venta&idVenta=" + idVenta + "&actividadRealizada=" + actividadRealizada + "&numeroCotizacion=" + numeroCotizacion + "&idAlmacen=" + idAlmacen;
            }

        })
    } else {
        window.location = "index.php?ruta=editar-venta&idVenta=" + idVenta + "&actividadRealizada=" + actividadRealizada + "&numeroCotizacion=" + numeroCotizacion + "&idAlmacen=" + idAlmacen;
    }




})

/*=============================================
FUNCIÓN PARA DESACTIVAR LOS BOTONES AGREGAR CUANDO EL PRODUCTO YA HABÍA SIDO SELECCIONADO EN LA CARPETA
=============================================*/

function quitarAgregarProducto() {

    //Capturamos todos los id de productos que fueron elegidos en la venta
    var idProductos = $(".quitarProducto");

    //Capturamos todos los botones de agregar que aparecen en la tabla
    var botonesTabla = $(".tablaVentas tbody button.agregarProducto");

    //Recorremos en un ciclo para obtener los diferentes idProductos que fueron agregados a la venta
    for (var i = 0; i < idProductos.length; i++) {

        //Capturamos los Id de los productos agregados a la venta
        var boton = $(idProductos[i]).attr("idProducto");

        //Hacemos un recorrido por la tabla que aparece para desactivar los botones de agregar
        for (var j = 0; j < botonesTabla.length; j++) {

            if ($(botonesTabla[j]).attr("idProducto") == boton) {

                $(botonesTabla[j]).removeClass("btn-primary agregarProducto");
                $(botonesTabla[j]).addClass("btn-default");

            }
        }

    }

}

/*=============================================
CADA VEZ QUE CARGUE LA TABLA CUANDO NAVEGAMOS EN ELLA EJECUTAR LA FUNCIÓN:
=============================================*/

$('.tablaVentas').on('draw.dt', function() {

    quitarAgregarProducto();

})


/*=============================================
BORRAR VENTA
=============================================*/
$(".tablas").on("click", ".btnEliminarVenta", function() {

    var idVenta = $(this).attr("idVenta");

    swal({
        title: '¿Está seguro de borrar la actividad del cliente?',
        text: "¡Si no lo está puede cancelar la accíón!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar actividad!'
    }).then(function(result) {
        if (result.value) {

            window.location = "index.php?ruta=ventas&idVenta=" + idVenta;
        }

    })

})

/*=============================================
IMPRIMIR FACTURA
=============================================*/

$(".tablas").on("click", ".btnImprimirFactura", function() {

    var codigoVenta = $(this).attr("codigoVenta");

    window.open("extensiones/tcpdf/pdf/factura.php?codigo=" + codigoVenta, "_blank");

})

/*=============================================
IMPRIMIR Ticket
=============================================*/

$(".tablas").on("click", ".btnImprimirTicket", function() {

    var codigoVenta = $(this).attr("codigoVenta");

    window.open("extensiones/tcpdf/pdf/ticket.php?codigo=" + codigoVenta, "_blank");

})

/*=============================================
RANGO DE FECHAS
=============================================*/

$('#daterange-btn').daterangepicker({
        ranges: {
            'Hoy': [moment(), moment()],
            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
            'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
            'Este mes': [moment().startOf('month'), moment().endOf('month')],
            'Último mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment(),
        endDate: moment()
    },
    function(start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

        var fechaInicial = start.format('YYYY-MM-DD');

        var fechaFinal = end.format('YYYY-MM-DD');

        var capturarRango = $("#daterange-btn span").html();

        localStorage.setItem("capturarRango", capturarRango);

        window.location = "index.php?ruta=ventas&fechaInicial=" + fechaInicial + "&fechaFinal=" + fechaFinal;

    }

)

/*=============================================
RANGO DE FECHAS PARA COTIZACIONES VENDIDAS
=============================================*/

$('#daterange2-btn').daterangepicker({
        ranges: {},
        startDate: moment(),
        endDate: moment()
    },
    function(start, end) {
        $('#daterange2-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

        var fechaInicial = start.format('YYYY-MM-DD');

        var fechaFinal = end.format('YYYY-MM-DD');

        var capturarRango = $("#daterange2-btn span").html();

        localStorage.setItem("capturarRango", capturarRango);

        window.location = "index.php?ruta=ventas-ganadas&fechaInicial=" + fechaInicial + "&fechaFinal=" + fechaFinal;

    }

)

/*=============================================
RANGO DE FECHAS PARA COTIZACIONES PERDIDAS
=============================================*/

$('#daterange3-btn').daterangepicker({
        ranges: {},
        startDate: moment(),
        endDate: moment()
    },
    function(start, end) {
        $('#daterange3-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

        var fechaInicial = start.format('YYYY-MM-DD');

        var fechaFinal = end.format('YYYY-MM-DD');

        var capturarRango = $("#daterange3-btn span").html();

        localStorage.setItem("capturarRango", capturarRango);

        window.location = "index.php?ruta=ventas-perdidas&fechaInicial=" + fechaInicial + "&fechaFinal=" + fechaFinal;

    }

)

/*=============================================
CANCELAR RANGO DE FECHAS
=============================================*/

$(".daterangepicker.opensleft .range_inputs .cancelBtn").on("click", function() {

    localStorage.removeItem("capturarRango");
    localStorage.clear();
    window.location = "ventas";
})

/*=============================================
CAPTURAR HOY
=============================================*/

$(".daterangepicker.opensleft .ranges li").on("click", function() {

    var textoHoy = $(this).attr("data-range-key");

    if (textoHoy == "Hoy") {

        var d = new Date();

        var dia = d.getDate();
        var mes = d.getMonth() + 1;
        var año = d.getFullYear();

        // if(mes < 10){

        // 	var fechaInicial = año+"-0"+mes+"-"+dia;
        // 	var fechaFinal = año+"-0"+mes+"-"+dia;

        // }else if(dia < 10){

        // 	var fechaInicial = año+"-"+mes+"-0"+dia;
        // 	var fechaFinal = año+"-"+mes+"-0"+dia;

        // }else if(mes < 10 && dia < 10){

        // 	var fechaInicial = año+"-0"+mes+"-0"+dia;
        // 	var fechaFinal = año+"-0"+mes+"-0"+dia;

        // }else{

        // 	var fechaInicial = año+"-"+mes+"-"+dia;
        //    	var fechaFinal = año+"-"+mes+"-"+dia;

        // }

        dia = ("0" + dia).slice(-2);
        mes = ("0" + mes).slice(-2);

        var fechaInicial = año + "-" + mes + "-" + dia;
        var fechaFinal = año + "-" + mes + "-" + dia;

        localStorage.setItem("capturarRango", "Hoy");

        window.location = "index.php?ruta=ventas&fechaInicial=" + fechaInicial + "&fechaFinal=" + fechaFinal;

    }

})

/*=============================================
ABRIR ARCHIVO XML EN NUEVA PESTAÑA
=============================================*/

$(".abrirXML").click(function() {

    var archivo = $(this).attr("archivo");
    window.open(archivo, "_blank");


})

/*=============================================
BOTON LEER DATOS
=============================================*/
$(".tablas").on("click", ".btnLeerDatos", function() {

    var idCliProforma = $(this).attr("idCliProforma");
    var idAlmacen = $(this).attr("idAlmacen");

    var datos = new FormData();
    datos.append("idCliProforma", idCliProforma);
    datos.append("idAlmacen", idAlmacen);


    $.ajax({

        url: "ajax/ventas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {

            $("#idCotizacion").val(respuesta["cotizacion"]);
            $("#idAlmacen").val(respuesta["id_almacen"]);
        }

    })




})