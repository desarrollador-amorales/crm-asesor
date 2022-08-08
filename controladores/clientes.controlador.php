<?php

class ControladorClientes{

	/*=============================================
	CREAR CLIENTES
	=============================================*/

	static public function ctrCrearCliente(){

		if(isset($_POST["nuevoCliente"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoCliente"]) &&
			   //preg_match('/^[0-9]+$/', $_POST["nuevoDocumentoId"]) &&
			   preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["nuevoEmail"]) && 
			   preg_match('/^[()\-0-9 ]+$/', $_POST["nuevoTelefono"]) && 
			   preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["nuevaDireccion"])){

			   	$tabla = "clientes";
				$pasado = 1;

			   	$datos = array("nombre"=>$_POST["nuevoCliente"],
							   "cedula"=> $_POST["nuevaCedula"],
					           "email"=>$_POST["nuevoEmail"],
					           "telefono"=>$_POST["nuevoTelefono"],
					           "direccion"=>$_POST["nuevaDireccion"],
					           "fecha_nacimiento"=>$_POST["nuevaFechaNacimiento"],
							   "estado"=>$_POST["estado"],
							   "cotizacion"=>$_POST["nuevaCotizacion"],
							   "interes"=>$_POST["interes"],
							   "tipo_cliente"=>$_POST["tipo_cliente"],
							   "producto_cotizado"=>$_POST["nuevoProductoCotizado"],
							   "fecha_seguimiento"=>$_POST["nuevaFechaSeguimiento"],
							   "contrato"=>$_POST["nuevoContrato"],								
							   "facturacion"=>$_POST["nuevoFacturacion"],
							   "observaciones"=>$_POST["nuevoObservaciones"],
							   "almacen"=>$_POST["nuevoAlmacen"],
							   "fechacierre"=> $_POST["nuevaFechaCierre"],
							   "valorCotizado"=> $_POST["nuevoValorCotizado"],
							   "id_asesor"=> $_SESSION["usuario"],
							   "pasado" => $pasado

							);


			   	$respuesta = ModeloClientes::mdlIngresarCliente($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El cliente ha sido guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "clientes";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El cliente no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "clientes";

							}
						})

			  	</script>';



			}

		}

	}

	/*=============================================
	MOSTRAR CLIENTES
	=============================================*/

	static public function ctrMostrarClientes($item, $valor){

		$tabla = "clientes";

		$respuesta = ModeloClientes::mdlMostrarClientes($tabla, $item, $valor);

		return $respuesta;

	}


	
	/*=============================================
	RELACIONAR COTIZACIONES CLIENTES
	=============================================*/

	static public function ctrRelacionarCotizacion(){

		$tabla = "cliente_proforma";

		if(isset($_POST["cotizacionRelacion"])){

			$datos = array ("cotizacionRelacion"=>$_POST["cotizacionRelacion"],
							"idCotizacion" => $_POST["idCotizacion"],
							"motivoRelacion" => $_POST["motivoRelacion"],
							"idAlmacen" => $_POST["idAlmacen"]
						);
			
			$respuesta = ModeloClientes::mdlEditarClienteProforma($tabla, $datos);


			if($respuesta == "ok"){
	
				echo'<script>
	
				swal({
					  type: "success",
					  title: "La cotizacion se relacionó correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
	
								window.location = "ventas-cre";
	
								}
							})
	
				</script>';
	
			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡No existe la cotizacion!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "ventas-cre";

							}
						})

			  	</script>';



			}

		}
	}

	

	/*=============================================
	EDITAR CLIENTE
	=============================================*/

	static public function ctrEditarCliente(){

		if(isset($_POST["editarCliente"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarCliente"]) &&
			   preg_match('/^[()\-0-9 ]+$/', $_POST["editarTelefono"])||
			   preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["editarEmail"]) ||
			   preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["editarDireccion"])
			   )
			   
			   {
			   
			   	$tabla = "clientes";

				 $datos = array("id"=>$_POST["idCliente"],
				 "nombre"=>$_POST["editarCliente"],
				 "cedula"=>$_POST["editarCedula"],
				 "email"=> $_POST["editarEmail"],
				 "telefono"=>$_POST["editarTelefono"],
				 "direccion"=>$_POST["editarDireccion"],
				 "fecha_nacimiento"=>$_POST["editarFechaNacimiento"],
				 "estado"=>$_POST["estado"],
				 "cotizacion"=>$_POST["editarCotizacion"],
				 "interes"=>$_POST["interes"],
				 "tipo_cliente"=>$_POST["tipoCliente"],
				 "producto_cotizado"=>$_POST["editarProductoCotizado"],
				 "fecha_seguimiento"=>$_POST["editarFechaSeguimiento"],
				 "contrato"=>$_POST["editarContrato"],								
				 "facturacion"=>$_POST["editarFacturacion"],
				 "observaciones"=>$_POST["editarObservaciones"],
				 "almacen"=> $_POST["editarAlmacen"],
				 "fechacierre"=> $_POST["editarFechaCierre"],
				 "valorcotizado"=> $_POST["editarValorCotizado"]

				 
			  );

			   	$respuesta = ModeloClientes::mdlEditarCliente($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "La Cliente ha sido actualizado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "clientes";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡La Actividad no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "clientes";

							}
						})

			  	</script>';



			}

		}

	}

	/*=============================================
	ELIMINAR CLIENTE
	=============================================*/

	static public function ctrEliminarCliente(){

		if(isset($_GET["idCliente"])){

			$tabla ="clientes";
			$datos = $_GET["idCliente"];

			$respuesta = ModeloClientes::mdlEliminarCliente($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El cliente ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then(function(result){
								if (result.value) {

								window.location = "clientes";

								}
							})

				</script>';

			}		

		}

	}


	/*=============================================
	MOSTRAR CLIENTES EXTERNA
	=============================================

	static public function ctrMostrarClientesExterno(){

		$tabla = "Clientes";

		$respuesta = ModeloClientes::mdlListarClientesBaseExterna($tabla);

		return $respuesta;

	} */

}

