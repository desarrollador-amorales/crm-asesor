<?php

require_once "conexion.php";
require_once "conexion_sql_srv.php"; 

class ModeloClientes{

	/*=============================================
	CREAR CLIENTE
	=============================================*/

	static public function mdlIngresarCliente($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, cedula, email, telefono, direccion, fecha_nacimiento, estado, interes, tipo_cliente, cotizacion, productoCotizado, fecha_seguimiento, contrato, facturacion, observaciones, almacen, fecha_cierre, valor_cotizado, id_asesor, pasado) VALUES (:nombre, :cedula, :email, :telefono, :direccion, :fecha_nacimiento, :estado, :interes, :tipo_cliente, :cotizacion, :productoCotizado, :fecha_seguimiento, :contrato, :facturacion, :observaciones, :almacen, :fechacierre, :valorCotizado, :id_asesor, :pasado)");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":cedula", $datos["cedula"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt->bindParam(":interes", $datos["interes"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo_cliente", $datos["tipo_cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":cotizacion", $datos["cotizacion"], PDO::PARAM_STR);
		$stmt->bindParam(":productoCotizado", $datos["producto_cotizado"], PDO::PARAM_STR);
		$stmt->bindParam(":contrato", $datos["contrato"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha_seguimiento", $datos["fecha_seguimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":facturacion", $datos["facturacion"], PDO::PARAM_STR);
		$stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
		$stmt->bindParam(":almacen", $datos["almacen"], PDO::PARAM_STR);
		$stmt->bindParam(":fechacierre", $datos["fechacierre"], PDO::PARAM_STR);
		$stmt->bindParam(":valorCotizado", $datos["valorCotizado"], PDO::PARAM_STR);
		$stmt->bindParam(":id_asesor",$datos["id_asesor"] , PDO::PARAM_STR);
		$stmt->bindParam(":pasado",$datos["pasado"], PDO::PARAM_STR);		

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt = null;

	}

	/*=============================================
	MOSTRAR CLIENTES
	=============================================*/

	static public function mdlMostrarClientes($tabla, $item, $valor){
		
		
		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

		    if ($item == 'pasado' or $item == 'id_asesor' or $item == 'Cotizacion'){
				return $stmt -> fetchAll();
			}
			else{
				return $stmt -> fetch();
			}	

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt = null;
	}

	/*=============================================
	EDITAR CLIENTE
	=============================================*/

	static public function mdlEditarCliente($tabla, $datos){

		if ($_SESSION["perfil"] == "Administrador"){
			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, cedula = :cedula, email = :email, telefono = :telefono, direccion = :direccion, fecha_nacimiento = :fecha_nacimiento, estado = :estado, interes =:interes ,cotizacion =:cotizacion, productoCotizado =:productoCotizado, fecha_seguimiento = :fecha_seguimiento, contrato =:contrato, facturacion =:facturacion, observaciones =:observaciones, tipo_cliente =:tipo_cliente, almacen =:almacen, fecha_cierre =:fechacierre, valor_cotizado =:valorcotizado  WHERE id = :id");
		}else{
			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, telefono = :telefono,  fecha_nacimiento = :fecha_nacimiento, estado = :estado, interes =:interes ,cotizacion =:cotizacion, productoCotizado =:productoCotizado, fecha_seguimiento = :fecha_seguimiento, contrato =:contrato, facturacion =:facturacion, observaciones =:observaciones, valor_cotizado =:valorcotizado  WHERE id = :id");
		}
		
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if ($_SESSION["perfil"] == "Administrador"){
			$stmt->bindParam(":cedula", $datos["cedula"], PDO::PARAM_STR);
			$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
			$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
			$stmt->bindParam(":tipo_cliente", $datos["tipo_cliente"], PDO::PARAM_STR);
			$stmt->bindParam(":fechacierre", $datos["fechacierre"], PDO::PARAM_STR);
			$stmt->bindParam(":almacen", $datos["almacen"], PDO::PARAM_STR);
		}
		
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);		
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt->bindParam(":interes", $datos["interes"], PDO::PARAM_STR);
		$stmt->bindParam(":cotizacion", $datos["cotizacion"], PDO::PARAM_STR);
		$stmt->bindParam(":productoCotizado", $datos["producto_cotizado"], PDO::PARAM_STR);
		$stmt->bindParam(":contrato", $datos["contrato"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha_seguimiento", $datos["fecha_seguimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":facturacion", $datos["facturacion"], PDO::PARAM_STR);
		$stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
		$stmt->bindParam(":valorcotizado", $datos["valorcotizado"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt = null;

	}

	/*=============================================
	ELIMINAR CLIENTE
	=============================================*/

	static public function mdlEliminarCliente($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}


		$stmt = null;

	}

	/*=============================================
	ACTUALIZAR CLIENTE
	=============================================*/

	static public function mdlActualizarCliente($tabla, $item1, $valor1, $valor){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE id = :id");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":id", $valor, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}


		$stmt = null;

	}


	/*=============================================
	ACTUALIZAR CLIENTE PROFORMA
	=============================================*/

	static public function mdlEditarClienteProforma($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  relacionado = 1 , cotizacion_relacion =:idCotizacion  WHERE cotizacion = :cotizacion");

		$stmt->bindParam(":cotizacion", $datos["idCotizacion"], PDO::PARAM_STR);
		$stmt->bindParam(":idCotizacion", $datos["cotizacionRelacion"] , PDO::PARAM_STR);

		

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		//$stmt->close();
		$stmt = null;

	}

}