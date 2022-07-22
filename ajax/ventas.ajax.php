<?php

require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";

class AjaxVentas{

	/*=============================================
	EDITAR CLIENTE PROFORMA
	=============================================*/	

	public $idCliProforma;

	public function ajaxLeerDatosProforma(){

		$item = "id";
		$valor = $this->idCliProforma;

		$respuesta = ControladorVentas::ctrMostrarClientePorforma($item, $valor);

		echo json_encode($respuesta);


	}

}

/*=============================================
LEER PROFORMA
=============================================*/	

if(isset($_POST["idCliProforma"])){

	$venta = new AjaxVentas();
	$venta -> idCliProforma = $_POST["idCliProforma"];
	$venta -> ajaxLeerDatosProforma();

}