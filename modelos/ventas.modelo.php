<?php

require_once "conexion.php";

class ModeloVentas{

	/*=============================================
	MOSTRAR VENTAS
	=============================================*/

	static public function mdlMostrarVentas($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id ASC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");

			$stmt -> execute();

			return $stmt -> fetchAll(); 

		}
		
		//$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	REGISTRO DE VENTA
	=============================================*/

	static public function mdlIngresarVenta($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codigo, id_cliente, id_vendedor, productos) VALUES (:codigo, :id_cliente, :id_vendedor, :productos)");

		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		//$stmt->close();
		$stmt = null;

	}


    /*=============================================
	REGISTRO DE VENTA CLIENTE PROFORMA
	=============================================*/

	static public function mdlIngresarVenta1($tabla, $datos){

		$pdo = new PDO("mysql:host=localhost;dbname=sis_inventario","root","");

		$stmt = $pdo->prepare("INSERT INTO $tabla(codigo, id_cliente, id_vendedor, productos) VALUES (:codigo, :id_cliente, :id_vendedor, :productos)");

		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);

		$stmt -> execute();

		$id = $pdo->lastInsertId();

		return $id;

	}

		/*=============================================
	EDITAR VENTA
	=============================================*/

	static public function mdlEditarVenta1($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  id_actividad = :id_actividad  WHERE id = :id");

		$stmt->bindParam(":id_actividad", $datos["id_actividad"], PDO::PARAM_INT);
		$stmt->bindParam(":id", $datos["id_cliente_proforma"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		//$stmt->close();
		$stmt = null;

	}

	/*=============================================
	EDITAR VENTA
	=============================================*/

	static public function mdlEditarVenta($tabla, $datos){

		$tabla1= "cliente_proforma";

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  id_cliente = :id_cliente, id_vendedor = :id_vendedor, productos = :productos WHERE codigo = :codigo");
		$stmt1 = Conexion::conectar()->prepare("UPDATE $tabla1 SET  actividad_realizada = 1 WHERE id_actividad = :id_actividad");


		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);

		$stmt1->bindParam(":id_actividad", $datos["id_actividad"], PDO::PARAM_INT);
		$stmt1->execute();

		if($stmt->execute()){
				
			return "ok";

		}else{

			return "error";
		
		}

		//$stmt->close();
		$stmt = null;

	}

	/*=============================================
	ELIMINAR VENTA
	=============================================*/

	static public function mdlEliminarVenta($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		//$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal, $item, $valor){

		if($fechaInicial == null){

		   if ($item == null) {
			   
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");

			$stmt -> execute();

			return $stmt -> fetchAll();	 

		}if ($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item= :$item ORDER BY id ASC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}


		}else if($fechaInicial == $fechaFinal){

		 if ($item == null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha like '%$fechaFinal%'");

			$stmt -> bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();
		}
		else{


			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item= :$item AND fecha like '%$fechaFinal%'");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);

			//$stmt -> bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);		

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		}else{

			$fechaActual = new DateTime();
			$fechaActual ->add(new DateInterval("P1D"));
			$fechaActualMasUno = $fechaActual->format("Y-m-d");

			$fechaFinal2 = new DateTime($fechaFinal);
			$fechaFinal2 ->add(new DateInterval("P1D"));
			$fechaFinalMasUno = $fechaFinal2->format("Y-m-d");

			if($fechaFinalMasUno == $fechaActualMasUno){

				if ($item == null){

					$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'");
					$stmt -> execute();
					return $stmt -> fetchAll();


				} else {

					$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item  AND fecha BETWEEN '$fechaInicial' AND '$fechaFinalMasUno' ");
					$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
					$stmt -> execute();
					return $stmt -> fetchAll();

				}

			}else{

				if ($item == null){

					$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal'");
					$stmt -> execute();
					return $stmt -> fetchAll();
				}
				else{
					$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND fecha BETWEEN '$fechaInicial' AND '$fechaFinal'");
					$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
					$stmt -> execute();
					return $stmt -> fetchAll();

				}


			}
		


		}

	}





	/*=============================================
	RANGO FECHAS PÓR COTIZACION
	=============================================*/	

	static public function mdlRangoFechasCotizacion($tabla, $fechaInicial, $fechaFinal, $item, $valor, $valor2){

		if($fechaInicial == null){

		   if ($item == null) {
			   
			$stmt = Conexion::conectar()->prepare("SELECT cp.*, c.id id_cliente, u.id id_asesor_interno FROM $tabla WHERE c.cedula = cp.ced_cliente and u.usuario = cp.id_asesor and cp.actividad_realizada = $valor2 ");

			$stmt -> execute();

			return $stmt -> fetchAll();	 

		}if ($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT cp.*, c.id as id_cliente, u.id as id_asesor_interno FROM $tabla WHERE c.cedula = cp.ced_cliente and u.usuario = cp.id_asesor and cp.relacionado = 0 and u.id= $valor and cp.actividad_realizada = $valor2");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}


		}else if($fechaInicial == $fechaFinal){

		 if ($item == null){

			$stmt = Conexion::conectar()->prepare("SELECT cp.*, c.id id_cliente, u.id id_asesor_interno FROM $tabla WHERE c.cedula = cp.ced_cliente and u.usuario = cp.id_asesor and cp.actividad_realizada = $valor2 and cp.fecha_cotizacion like '%$fechaFinal%'");

			$stmt -> execute();

			return $stmt -> fetchAll();
		}
		else{

			$stmt = Conexion::conectar()->prepare("SELECT cp.*, c.id id_cliente, u.id id_asesor_interno FROM $tabla WHERE c.cedula = cp.ced_cliente and u.usuario = cp.id_asesor and cp.relacionado = 0 AND u.id= $valor AND cp.actividad_realizada = $valor2 AND fecha_cotizacion like '%$fechaFinal%'");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		}else{

			$fechaActual = new DateTime();
			$fechaActual ->add(new DateInterval("P1D"));
			$fechaActualMasUno = $fechaActual->format("Y-m-d");

			$fechaFinal2 = new DateTime($fechaFinal);
			$fechaFinal2 ->add(new DateInterval("P1D"));
			$fechaFinalMasUno = $fechaFinal2->format("Y-m-d");

			if($fechaFinalMasUno == $fechaActualMasUno){

				if ($item == null){

					$stmt = Conexion::conectar()->prepare("SELECT cp.*, c.id id_cliente, u.id id_asesor_interno FROM $tabla WHERE c.cedula = cp.ced_cliente and u.usuario = cp.id_asesor AND cp.actividad_realizada = $valor2 AND cp.fecha_cotizacion  BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'");
					$stmt -> execute();
					return $stmt -> fetchAll();


				} else {

					$stmt = Conexion::conectar()->prepare("SELECT cp.*, c.id id_cliente, u.id id_asesor_interno FROM $tabla WHERE c.cedula = cp.ced_cliente and u.usuario = cp.id_asesor AND cp.actividad_realizada = $valor2 and u.id= $valor and cp.relacionado = 0  AND cp.fecha_cotizacion BETWEEN '$fechaInicial' AND '$fechaFinalMasUno' ");
					$stmt -> execute();
					return $stmt -> fetchAll();

				}

			}else{

				if ($item == null){

					$stmt = Conexion::conectar()->prepare("SELECT cp.*, c.id id_cliente, u.id id_asesor_interno FROM $tabla WHERE c.cedula = cp.ced_cliente and u.usuario = cp.id_asesor AND cp.actividad_realizada = $valor2 AND cp.fecha_cotizacion BETWEEN '$fechaInicial' AND '$fechaFinal'");
					$stmt -> execute();
					return $stmt -> fetchAll();
				}
				else{
					$stmt = Conexion::conectar()->prepare("SELECT cp.*, c.id id_cliente, u.id id_asesor_interno FROM $tabla WHERE c.cedula = cp.ced_cliente and u.usuario = cp.id_asesor AND cp.actividad_realizada = $valor2 and u.id= $valor  and cp.relacionado = 0 AND cp.fecha_cotizacion BETWEEN '$fechaInicial' AND '$fechaFinal'");
					$stmt -> execute();
					return $stmt -> fetchAll();

				}


			}
		


		}

	}

	/*=============================================
	SUMAR EL TOTAL DE VENTAS
	=============================================*/

	static public function mdlSumaTotalVentas($tabla){	

		$stmt = Conexion::conectar()->prepare("SELECT SUM(neto) as total FROM $tabla");

		$stmt -> execute();

		return $stmt -> fetch();

		//$stmt -> close();

		$stmt = null;

	}

	
}