/*=============================================
VARIABLE LOCAL STORAGE
=============================================*/

if (localStorage.getItem("capturarRango3") != null) {

    $("#daterange1-btn span").html(localStorage.getItem("capturarRango3"));


} else {

    $("#daterange1-btn span").html('<i class="fa fa-calendar"></i> Rango de fecha')

}

/*=============================================
RANGO DE FECHAS
=============================================*/
$('#daterange1-btn').daterangepicker({
        ranges: {
            'Hoy': [moment(), moment()],
            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
            'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
            'Este mes': [moment().startOf('month'), moment().endOf('month')],
            'Último mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment(),
        endDate: moment(),
    },
    function(start, end) {
        $('#daterange1-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

        var fechaInicial = start.format('YYYY-MM-DD');

        var fechaFinal = end.format('YYYY-MM-DD');

        var capturarRango = $("#daterange1-btn span").html();

        localStorage.setItem("capturarRango3", capturarRango);

        window.location = "index.php?ruta=ventas-cre&fechaInicial=" + fechaInicial + "&fechaFinal=" + fechaFinal;

    }


)

/*=============================================
CANCELAR RANGO DE FECHAS
=============================================**/

$(".daterangepicker.opensright .range_inputs .cancelBtn").on("click", function() {

    localStorage.removeItem("capturarRango3");
    localStorage.clear();
    if (condition == "ventas_cre") {
        window.location = "ventas-cre";
    }
    if (condition == "vendidos") {
        window.location = "ventas-ganadas";
    }
    if (condition == "perdidas") {
        window.location = "ventas-perdidas";
    }

})

/*=============================================
CAPTURAR HOY
=============================================*/

$(".daterangepicker.opensright .ranges li").on("click", function() {

    var textoHoy = $(this).attr("data-range-key");

    if (textoHoy == "Hoy") {

        var d = new Date();

        var dia = d.getDate();
        var mes = d.getMonth() + 1;
        var año = d.getFullYear();


        dia = ("0" + dia).slice(-2);
        mes = ("0" + mes).slice(-2);

        var fechaInicial = año + "-" + mes + "-" + dia;
        var fechaFinal = año + "-" + mes + "-" + dia;

        localStorage.setItem("capturarRango3", "Hoy");

        if (condition == "ventas_cre") {
            window.location = "index.php?ruta=ventas-cre&fechaInicial=" + fechaInicial + "&fechaFinal=" + fechaFinal;
        }

    }

})