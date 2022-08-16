<?php

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class ControladorVentas{

	/*=============================================
	MOSTRAR VENTAS
	=============================================*/

	static public function ctrMostrarVentas($item, $valor){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);
 
		return $respuesta;

	}


	/*=============================================
	MOSTRAR HISTORIAL COTIZACION RELACIONADA
	=============================================*/

	static public function ctrMostrarHistorialCotizacionRelacionada($numeroCotizacion, $idAlmacen){

		$tabla = "cliente_proforma cp";

		$respuesta = ModeloVentas::mdlMostrarHistorialCotizacionRelacionada($tabla, $numeroCotizacion, $idAlmacen);
 
		return $respuesta;

	}

	/*=============================================
	MOSTRAR HISTORIAL COTIZACION
	=============================================*/

	static public function ctrMostrarHistorialCotizacion($numeroCotizacion, $idAlmacen){

		$tabla = "historial_proforma hp";

		$respuesta = ModeloVentas::mdlMostrarHistorialCotizacion($tabla, $numeroCotizacion, $idAlmacen);
 
		return $respuesta;

	}



    /*=============================================
	MOSTRAR CLIENTES PROFORMAS
	=============================================*/

	static public function ctrMostrarClientePorforma($item, $valor, $valor1){

		$tabla = "cliente_proforma";

		$respuesta = ModeloVentas::mdlMostrarVentasLeerDatos($tabla, $item, $valor, $valor1);
 
		return $respuesta;

	}

	/*=============================================
	CREAR VENTA
	=============================================*/

	static public function ctrCrearVenta(){

		if(isset($_POST["nuevaVenta"])){

			/*=============================================
			ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
			=============================================*/

			if($_POST["listaProductos"] == ""){

					echo'<script>

				swal({
					  type: "error",
					  title: "La actividad no se ha ejecuta si no hay detalles",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "ventas";

								}
							})

				</script>';

				return;
			}


			$listaProductos = json_decode($_POST["listaProductos"], true);

			$totalProductosComprados = array();

			foreach ($listaProductos as $key => $value) {

			   //array_push($totalProductosComprados, $value["cantidad"]);
				
			   $tablaProductos = "productos";

			    $item = "id";
			   // $valor = $value["id"];
			    $orden = "id";

			    //$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);

				$item1a = "ventas";
				//$valor1a = $value["cantidad"] + $traerProducto["ventas"];

			    //$nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);

				$item1b = "stock";
				//$valor1b = $value["stock"];

				//$nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);

			}

			$tablaClientes = "clientes";

			$item = "id";
			$valor = $_POST["seleccionarCliente"];

			$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $item, $valor);

			$item1a = "compras";
				
			$valor1a = array_sum($totalProductosComprados) + $traerCliente["compras"];

			$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valor);

			$item1b = "ultima_compra";

			date_default_timezone_set('America/Bogota');

			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$valor1b = $fecha.' '.$hora;

			$fechaCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1b, $valor1b, $valor);

			/*=============================================
			GUARDAR LA COMPRA
			=============================================*/	

			$tabla = "ventas";

			$datos = array("id_vendedor"=>$_POST["idVendedor"],
						   "id_cliente"=>$_POST["seleccionarCliente"],
						   "codigo"=>$_POST["nuevaVenta"],
						   "productos"=>$_POST["listaProductos"]
						   //"impuesto"=>$_POST["nuevoPrecioImpuesto"],
						   //"neto"=>$_POST["nuevoPrecioNeto"],
						   //"total"=>$_POST["totalVenta"]
						   //"metodo_pago"=>$_POST["listaMetodoPago"]
						);

			$respuesta = ModeloVentas::mdlIngresarVenta($tabla, $datos);

			if($respuesta == "ok"){

				// $impresora = "epson20";

				// $conector = new WindowsPrintConnector($impresora);

				// $imprimir = new Printer($conector);

				// $imprimir -> text("Hola Mundo"."\n");

				// $imprimir -> cut();

				// $imprimir -> close();

				/**$impresora = "epson20";

				$conector = new WindowsPrintConnector($impresora);

				$printer = new Printer($conector);

				$printer -> setJustification(Printer::JUSTIFY_CENTER);

				$printer -> text(date("Y-m-d H:i:s")."\n");//Fecha de la factura

				$printer -> feed(1); //Alimentamos el papel 1 vez*/

				/**$printer -> text("Inventory System"."\n");//Nombre de la empresa

				$printer -> text("NIT: 71.759.963-9"."\n");//Nit de la empresa

				$printer -> text("Dirección: Calle 44B 92-11"."\n");//Dirección de la empresa

				$printer -> text("Teléfono: 300 786 52 49"."\n");//Teléfono de la empresa

				$printer -> text("FACTURA N.".$_POST["nuevaVenta"]."\n");//Número de factura

				$printer -> feed(1); //Alimentamos el papel 1 vez*/

				/**$printer -> text("Cliente: ".$traerCliente["nombre"]."\n");//Nombre del cliente

				$tablaVendedor = "usuarios";
				$item = "id";
				$valor = $_POST["idVendedor"];

				$traerVendedor = ModeloUsuarios::mdlMostrarUsuarios($tablaVendedor, $item, $valor);

				$printer -> text("Vendedor: ".$traerVendedor["nombre"]."\n");//Nombre del vendedor

				$printer -> feed(1); //Alimentamos el papel 1 vez*/

				/**foreach ($listaProductos as $key => $value) {

					$printer->setJustification(Printer::JUSTIFY_LEFT);

					$printer->text($value["descripcion"]."\n");//Nombre del producto

					$printer->setJustification(Printer::JUSTIFY_RIGHT);

					$printer->text("$ ".number_format($value["precio"],2)." Und x ".$value["cantidad"]." = $ ".number_format($value["total"],2)."\n");

				}

				$printer -> feed(1); //Alimentamos el papel 1 vez*/			
				
				/**$printer->text("NETO: $ ".number_format($_POST["nuevoPrecioNeto"],2)."\n"); //ahora va el neto

				$printer->text("IMPUESTO: $ ".number_format($_POST["nuevoPrecioImpuesto"],2)."\n"); //ahora va el impuesto

				$printer->text("--------\n");

				$printer->text("TOTAL: $ ".number_format($_POST["totalVenta"],2)."\n"); //ahora va el total

				$printer -> feed(1); //Alimentamos el papel 1 vez*/	

				/**$printer->text("Muchas gracias por su compra"); //Podemos poner también un pie de página

				$printer -> feed(3); //Alimentamos el papel 3 veces*/

				/**$printer -> cut(); //Cortamos el papel, si la impresora tiene la opción

				$printer -> pulse(); //Por medio de la impresora mandamos un pulso, es útil cuando hay cajón moneder

				$printer -> close();*/

	
				echo'<script>

				localStorage.removeItem("rango");

				swal({
					  type: "success",
					  title: "Actividad guardada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "ventas";

								}
							})

				</script>';

			}

		}

	}

	/*=============================================
	EDITAR VENTA
	=============================================*/

	static public function ctrEditarVenta(){

		if(isset($_POST["editarVenta"])){

			/*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
			=============================================*/
			$tabla = "ventas";

			$item = "codigo";
			$valor = $_POST["editarVenta"];
			$actividadRealizada = $_POST["actividadRealizada"];
			

			$traerVenta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

			/*=============================================
			REVISAR SI VIENE PRODUCTOS EDITADOS
			=============================================*/

			if($_POST["listaProductos"] == ""){

				echo'<script>

				swal({
					  type: "error",
					  title: "La actividad no se ejecuta si no existen detalles",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {';

									if($actividadRealizada == "1" ){
										echo 'window.location = "ventas";';
									}else if($actividadRealizada == "0" ){
										echo 'window.location = "ventas-cre";';
									}

							echo'}
							})

				</script>';

				return;


			}else{

				$listaProductos = $_POST["listaProductos"];
				$cambioProducto = true;
			}

			if($cambioProducto){

				$productos =  json_decode($traerVenta["productos"], true);

				$totalProductosComprados = array();

				/**foreach ($productos as $key => $value) {

					//array_push($totalProductosComprados, $value["cantidad"]);
					
					$tablaProductos = "productos";

					$item = "id";
					//$valor = $value["id"];
					$orden = "id";

					$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);

					$item1a = "ventas";
					//$valor1a = $traerProducto["ventas"] - $value["cantidad"];

					//$nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);

					$item1b = "stock";
					//$valor1b = $value["cantidad"] + $traerProducto["stock"];

					//$nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);

				}**/

				$tablaClientes = "clientes";

				$itemCliente = "id";
				//$valorCliente = $_POST["seleccionarCliente"];

				//$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $itemCliente, $valorCliente);

				$item1a = "compras";
				//$valor1a = $traerCliente["compras"] - array_sum($totalProductosComprados);		

				//$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valorCliente);

				/*=============================================
				ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
				=============================================*/

				$listaProductos_2 = json_decode($listaProductos, true);

				$totalProductosComprados_2 = array();

				foreach ($listaProductos_2 as $key => $value) {

					//array_push($totalProductosComprados_2, $value["cantidad"]);
					
					$tablaProductos_2 = "productos";

					$item_2 = "id";
					//$valor_2 = $value["id"];
					$orden = "id";

					//$traerProducto_2 = ModeloProductos::mdlMostrarProductos($tablaProductos_2, $item_2, $valor_2, $orden);

					$item1a_2 = "ventas";
					//$valor1a_2 = $value["cantidad"] + $traerProducto_2["ventas"];

					//$nuevasVentas_2 = ModeloProductos::mdlActualizarProducto($tablaProductos_2, $item1a_2, $valor1a_2, $valor_2);

					$item1b_2 = "stock";
					//$valor1b_2 = $value["stock"];

					//$nuevoStock_2 = ModeloProductos::mdlActualizarProducto($tablaProductos_2, $item1b_2, $valor1b_2, $valor_2);

				}

				$tablaClientes_2 = "clientes";

				$item_2 = "id";
				//$valor_2 = $_POST["seleccionarCliente"];

				//$traerCliente_2 = ModeloClientes::mdlMostrarClientes($tablaClientes_2, $item_2, $valor_2);

				$item1a_2 = "compras";

				//$valor1a_2 = array_sum($totalProductosComprados_2) + $traerCliente_2["compras"];

				//$comprasCliente_2 = ModeloClientes::mdlActualizarCliente($tablaClientes_2, $item1a_2, $valor1a_2, $valor_2);

				$item1b_2 = "ultima_compra";

				date_default_timezone_set('America/Bogota');

				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$valor1b_2 = $fecha.' '.$hora;

				//$fechaCliente_2 = ModeloClientes::mdlActualizarCliente($tablaClientes_2, $item1b_2, $valor1b_2, $valor_2);

			}

			/*=============================================
			GUARDAR CAMBIOS DE LA COMPRA
			=============================================*/	

			$datos = array("id_vendedor"=>$_POST["idVendedor"],
						   "id_cliente"=>$_POST["seleccionarCliente"],
						   "codigo"=>$_POST["editarVenta"],
						   "id_actividad"=> $traerVenta["id"],
						   "productos"=>$listaProductos);


			$respuesta = ModeloVentas::mdlEditarVenta($tabla, $datos);

			if($respuesta == "ok"){


				if( $_POST["actividadRealizada"] == "0"){

					echo'<script>

					localStorage.removeItem("rango");

					swal({
						type: "success",
						title: "La actividad ha sido editada correctamente",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
						}).then((result) => {
									if (result.value) {

									window.location = "ventas-cre";

									}
								})

					</script>';

				}
				if ($_POST["actividadRealizada"] == "1"){

					echo'<script>

					localStorage.removeItem("rango");

					swal({
						type: "success",
						title: "La actividad ha sido editada correctamente",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
						}).then((result) => {
									if (result.value) {

									window.location = "ventas";

									}
								})

					</script>';

				}
		}

		}

	}


	/*=============================================
	ELIMINAR VENTA
	=============================================*/

	static public function ctrEliminarVenta(){

		if(isset($_GET["idVenta"])){

			$tabla = "ventas";

			$item = "id";
			$valor = $_GET["idVenta"];

			$traerVenta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

			/*=============================================
			ACTUALIZAR FECHA ÚLTIMA COMPRA
			=============================================*/

			$tablaClientes = "clientes";

			$itemVentas = null;
			$valorVentas = null;

			$traerVentas = ModeloVentas::mdlMostrarVentas($tabla, $itemVentas, $valorVentas);

			$guardarFechas = array();

			foreach ($traerVentas as $key => $value) {
				
				if($value["id_cliente"] == $traerVenta["id_cliente"]){

					array_push($guardarFechas, $value["fecha"]);

				}

			}

			if(count($guardarFechas) > 1){

				if($traerVenta["fecha"] > $guardarFechas[count($guardarFechas)-2]){

					$item = "ultima_compra";
					$valor = $guardarFechas[count($guardarFechas)-2];
					$valorIdCliente = $traerVenta["id_cliente"];

					$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorIdCliente);

				}else{

					$item = "ultima_compra";
					$valor = $guardarFechas[count($guardarFechas)-1];
					$valorIdCliente = $traerVenta["id_cliente"];

					$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorIdCliente);

				}


			}else{

				$item = "ultima_compra";
				$valor = "0000-00-00 00:00:00";
				$valorIdCliente = $traerVenta["id_cliente"];

				$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorIdCliente);

			}

			/*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
			=============================================*/

			//$productos =  json_decode($traerVenta["productos"], true);

			$totalProductosComprados = array();

			/**foreach ($productos as $key => $value) {

				//array_push($totalProductosComprados, $value["cantidad"]);
				
				$tablaProductos = "productos";

				$item = "id";
				//$valor = $value["id"];
				$orden = "id";

				$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);

				$item1a = "ventas";
				//$valor1a = $traerProducto["ventas"] - $value["cantidad"];

				//$nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);

				$item1b = "stock";
				//$valor1b = $value["cantidad"] + $traerProducto["stock"];

				//$nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);

			}**/

			$tablaClientes = "clientes";

			$itemCliente = "id";
			$valorCliente = $traerVenta["id_cliente"];

			$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $itemCliente, $valorCliente);

			$item1a = "compras";
			$valor1a = $traerCliente["compras"] - array_sum($totalProductosComprados);

			$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valorCliente);

			/*=============================================
			ELIMINAR VENTA
			=============================================*/

			$respuesta = ModeloVentas::mdlEliminarVenta($tabla, $_GET["idVenta"]);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "La actividad ha sido borrada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "ventas";

								}
							})

				</script>';

			}		
		}

	}

	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function ctrRangoFechasVentas($fechaInicial, $fechaFinal, $item, $valor){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal, $item, $valor);

		return $respuesta;
		
	}



	/*=============================================
	RANGO FECHAS COTIZACION CLIENTES
	=============================================*/	

	static public function ctrRangoFechasCotizacionCliente($fechaInicial, $fechaFinal, $item, $valor, $valor2){

		if ($valor2 == "1" or $valor2 == "2" or $valor2 == "3"){
			
			$tabla = " cliente_proforma cp, clientes c, usuarios u, ventas v ";	
		}else{

			$tabla = " cliente_proforma cp, clientes c, usuarios u ";
		}


		$respuesta = ModeloVentas::mdlRangoFechasCotizacion($tabla, $fechaInicial, $fechaFinal, $item, $valor, $valor2);

		return $respuesta;
		
	}


	/*=============================================
	UNA O MAS COTIZACIONES CLIENTES
	=============================================*/	

	static public function ctrCotizacionesCliente($id_asesor, $ced_cliente){

		$tabla = "cliente_proforma cp";

		$respuesta = ModeloVentas::mdlCotizacionesCliente($tabla, $id_asesor, $ced_cliente);

		return $respuesta;
		
	}


	/*=============================================
	DESCARGAR EXCEL
	=============================================*/

	public function ctrDescargarReporte(){

		if(isset($_GET["reporte"])){

			$tabla = "ventas";

			if(isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])){

				$item = null;
				$valor = null;

				$ventas = ModeloVentas::mdlRangoFechasVentas($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"],$item,$valor);

			}else{

				$item = null;
				$valor = null;

				$ventas = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

			}


			/*=============================================
			CREAMOS EL ARCHIVO DE EXCEL
			=============================================*/

			$Name = $_GET["reporte"].'.xls';

			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$Name.'"');
			header("Content-Transfer-Encoding: binary");
		
			echo utf8_decode("<table border='0'> 

					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>CÓDIGO</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>CLIENTE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>VENDEDOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PRODUCTOS</td>
					<td style='font-weight:bold; border:1px solid #eee;'>IMPUESTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>NETO</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>METODO DE PAGO</td	
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>		
					</tr>");

			foreach ($ventas as $row => $item){

				$cliente = ControladorClientes::ctrMostrarClientes("id", $item["id_cliente"]);
				$vendedor = ControladorUsuarios::ctrMostrarUsuarios("id", $item["id_vendedor"]);

			 echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>".$item["codigo"]."</td> 
			 			<td style='border:1px solid #eee;'>".$cliente["nombre"]."</td>
			 			<td style='border:1px solid #eee;'>".$vendedor["nombre"]."</td>
			 			<td style='border:1px solid #eee;'>");

			 	$productos =  json_decode($item["productos"], true);

			 	foreach ($productos as $key => $valueProductos) {
			 			
			 			echo utf8_decode($valueProductos["cantidad"]."<br>");
			 		}

			 	echo utf8_decode("</td><td style='border:1px solid #eee;'>");	

		 		foreach ($productos as $key => $valueProductos) {
			 			
		 			echo utf8_decode($valueProductos["descripcion"]."<br>");
		 		
		 		}

		 		echo utf8_decode("</td>
					<td style='border:1px solid #eee;'>$ ".number_format($item["impuesto"],2)."</td>
					<td style='border:1px solid #eee;'>$ ".number_format($item["neto"],2)."</td>	
					<td style='border:1px solid #eee;'>$ ".number_format($item["total"],2)."</td>
					<td style='border:1px solid #eee;'>".$item["metodo_pago"]."</td>
					<td style='border:1px solid #eee;'>".substr($item["fecha"],0,10)."</td>		
		 			</tr>");


			}


			echo "</table>";

		}

	}


	/*=============================================
	DESCARGAR EXCEL HISTORIAL
	=============================================*/

	public function ctrDescargarHistorial(){

		if(isset($_GET["reporte"])){


			if(isset($_GET["numCotizacion"]) && isset($_GET["idAlmacen"])){

				$historialCotizacion = ControladorVentas::ctrMostrarHistorialCotizacion($_GET["numCotizacion"],$_GET["idAlmacen"]);


			/*=============================================
			CREAMOS EL ARCHIVO DE EXCEL
			=============================================*/

			$Name = $_GET["reporte"].'.xls';

			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$Name.'"');
			header("Content-Transfer-Encoding: binary");
		
			echo utf8_decode("<table border='0'> 

					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>ORIGEN NEGOCIACION</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>CLIENTE COMPARTIDO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>VISITO ALMACEN ?</td>
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA SEGUIMIENTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>POR QUÉ NO COMPRO?</td>
					<td style='font-weight:bold; border:1px solid #eee;'>VALOR FACTURA</td>
					<td style='font-weight:bold; border:1px solid #eee;'>OBSERVACION</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>COTIZACION RELACIONADA</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>MOTIVO RELACION</td
					</tr>");

			foreach ($historialCotizacion as $row => $valueHistorial){
				$fechaCompara="0000-00-00 00:00:00";
              	$valorFecha = $valueHistorial["fecha"] == $fechaCompara ? "":$valueHistorial["fecha"];
              	$valorFechaSeguimiento = $valueHistorial["fecha_seguimiento"] == $fechaCompara ? "":$valueHistorial["fecha_seguimiento"];

			 echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>".$valorFecha."</td> 
			 			<td style='border:1px solid #eee;'>".$valueHistorial["origen_negociacion"]."</td>
			 			<td style='border:1px solid #eee;'>".$valueHistorial["cliente_compartido"]."</td>
						<td style='border:1px solid #eee;'>".$valueHistorial["visita_almacen"]."</td>
						<td style='border:1px solid #eee;'>".$valorFechaSeguimiento."</td>
						<td style='border:1px solid #eee;'>".$valueHistorial["motivo_cliente"]."</td>
						<td style='border:1px solid #eee;'>$ ".number_format($valueHistorial["valor_factura"],2)."</td>
						<td style='border:1px solid #eee;'>".$valueHistorial["observacion"]."</td>
						<td style='border:1px solid #eee;'>".$valueHistorial["cotizacion_relacionada"]."</td>
						<td style='border:1px solid #eee;'>".$valueHistorial["motivo_relacion"]."</td>
						</tr>");
			}


			echo "</table>";

		 }
		}

	}



	/*=============================================
	SUMA TOTAL VENTAS
	=============================================*/

	public function ctrSumaTotalVentas(){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlSumaTotalVentas($tabla);

		return $respuesta;

	}

	/*=============================================
	DESCARGAR XML
	=============================================*/

	static public function ctrDescargarXML(){

		if(isset($_GET["xml"])){


			$tabla = "ventas";
			$item = "codigo";
			$valor = $_GET["xml"];

			$ventas = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

			// PRODUCTOS

			$listaProductos = json_decode($ventas["productos"], true);

			// CLIENTE

			$tablaClientes = "clientes";
			$item = "id";
			$valor = $ventas["id_cliente"];

			$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $item, $valor);

			// VENDEDOR

			$tablaVendedor = "usuarios";
			$item = "id";
			$valor = $ventas["id_vendedor"];

			$traerVendedor = ModeloUsuarios::mdlMostrarUsuarios($tablaVendedor, $item, $valor);

			//http://php.net/manual/es/book.xmlwriter.php

			$objetoXML = new XMLWriter();

			$objetoXML->openURI($_GET["xml"].".xml"); //Creación del archivo XML

			$objetoXML->setIndent(true); //recibe un valor booleano para establecer si los distintos niveles de nodos XML deben quedar indentados o no.

			$objetoXML->setIndentString("\t"); // carácter \t, que corresponde a una tabulación

			$objetoXML->startDocument('1.0', 'utf-8');// Inicio del documento
			
			// $objetoXML->startElement("etiquetaPrincipal");// Inicio del nodo raíz

			// $objetoXML->writeAttribute("atributoEtiquetaPPal", "valor atributo etiqueta PPal"); // Atributo etiqueta principal

			// 	$objetoXML->startElement("etiquetaInterna");// Inicio del nodo hijo

			// 		$objetoXML->writeAttribute("atributoEtiquetaInterna", "valor atributo etiqueta Interna"); // Atributo etiqueta interna

			// 		$objetoXML->text("Texto interno");// Inicio del nodo hijo
			
			// 	$objetoXML->endElement(); // Final del nodo hijo
			
			// $objetoXML->endElement(); // Final del nodo raíz


			$objetoXML->writeRaw('<fe:Invoice xmlns:fe="http://www.dian.gov.co/contratos/facturaelectronica/v1" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:clm54217="urn:un:unece:uncefact:codelist:specification:54217:2001" xmlns:clm66411="urn:un:unece:uncefact:codelist:specification:66411:2001" xmlns:clmIANAMIMEMediaType="urn:un:unece:uncefact:codelist:specification:IANAMIMEMediaType:2003" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2" xmlns:qdt="urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2" xmlns:sts="http://www.dian.gov.co/contratos/facturaelectronica/v1/Structures" xmlns:udt="urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.dian.gov.co/contratos/facturaelectronica/v1 ../xsd/DIAN_UBL.xsd urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2 ../../ubl2/common/UnqualifiedDataTypeSchemaModule-2.0.xsd urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2 ../../ubl2/common/UBL-QualifiedDatatypes-2.0.xsd">');

			$objetoXML->writeRaw('<ext:UBLExtensions>');

			foreach ($listaProductos as $key => $value) {
				
				$objetoXML->text($value["descripcion"].", ");
			
			}

			

			$objetoXML->writeRaw('</ext:UBLExtensions>');

			$objetoXML->writeRaw('</fe:Invoice>');

			$objetoXML->endDocument(); // Final del documento

			return true;	
		}

	}

}