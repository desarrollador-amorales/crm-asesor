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
	MOSTRAR HISTORIAL COTIZACION RELACIONADA
	=============================================*/

	static public function mdlMostrarHistorialCotizacionRelacionada($tabla, $numeroCotizacion, $idAlmacen){


			$stmt = Conexion::conectar()->prepare("SELECT cp.cotizacion_relacion as principal,cp.cotizacion secundaria, cp.relacionado , cp.motivo_relacion, cp.fecha_motivo_relacion FROM $tabla WHERE cp.relacionado = '1' and cp.motivo_relacion is not null and cp.cotizacion_relacion = $numeroCotizacion ");

			$stmt -> execute();

			return $stmt -> fetchAll(); 

	}

	/**
	 * MOSTRAR HISTORIAL GENERAL PARA REPORTES
	 */

	static public function mdlReporteGeneral($tabla){


		//$stmt = Conexion::conectar()->prepare("SELECT cp.cotizacion, cp.id_almacen, cp.nombre_almacen,u.usuario,v.id_cliente, u.nombre, c.cedula, c.fecha_nacimiento as creacion_cliente , v.productos FROM $tabla WHERE productos != '[]' and cp.id_actividad = v.id and u.id = v.id_vendedor and c.id = v.id_cliente ");

		$stmt = Conexion::conectar()->prepare("SELECT cp.cotizacion, cp.id_almacen, cp.nombre_almacen, u.usuario, v.id_cliente, u.nombre, cp.ced_cliente as cedula,(CASE WHEN (select c.fecha_nacimiento from clientes c where c.id= v.id_cliente) IS NULL THEN cp.fecha_cotizacion ELSE (select c.fecha_nacimiento from clientes c where c.id= v.id_cliente )END) AS creacion_cliente, v.productos FROM $tabla WHERE  v.productos != '[]' and cp.id_actividad = v.id and u.id = v.id_vendedor ");

		$stmt -> execute();

		return $stmt -> fetchAll(); 

}



	/*=============================================
	MOSTRAR HISTORIAL COTIZACION 
	=============================================*/

	static public function mdlMostrarHistorialCotizacion($tabla, $numeroCotizacion, $idAlmacen){


		$stmt = Conexion::conectar()->prepare("SELECT hp.* FROM $tabla WHERE  hp.cotizacion= $numeroCotizacion and hp.id_almacen= $idAlmacen order by hp.fecha asc");

		$stmt -> execute();

		return $stmt -> fetchAll(); 

}


	/*=============================================
	MOSTRAR DETALLE COTIZACION 
	=============================================*/

	static public function mdlMostrarDetalleCotizacion($tabla, $numeroCotizacion, $idAlmacen){


		$stmt = Conexion::conectar()->prepare("SELECT dp.* FROM $tabla WHERE  dp.cotizacion= $numeroCotizacion and dp.id_almacen= $idAlmacen order by dp.fecha asc");

		$stmt -> execute();

		return $stmt -> fetchAll(); 

}


	/*=============================================
	MOSTRAR VENTAS LEER DATOS
	=============================================*/

	static public function mdlMostrarVentasLeerDatos($tabla, $item, $valor, $valor1){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item and id_almacen = $valor1 ORDER BY id ASC");

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

		$condicionProductos1= '"estado_cliente":"Vendido"';
		$condicionProductos2= '"estado_cliente":"Perdido"';
		$condicionRecorridoProductos2= '"estado_recorrido":"Perdido"';
		$condicionRecorridoProductos1= '"estado_recorrido":"Cotizado"';
		$ubicacionAsignada= $_SESSION["ubicacion"];

		if($fechaInicial == null){

		   if ($item == null) {

				if ($valor2 == "1"){

					$stmt = Conexion::conectar()->prepare("SELECT cp.*,u.nombre, u.id id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE  u.usuario = cp.id_asesor and cp.relacionado = 0 and cp.actividad_realizada = $valor2 and u.ubicacion = '".$ubicacionAsignada."' and cp.id_actividad = v.id and v.productos not like '%$condicionProductos1%' and v.productos not like '%$condicionProductos2%' and v.productos not like '%$condicionRecorridoProductos1%' and v.productos not like '%$condicionRecorridoProductos2%' ");		

				}
				else if($valor2 == "2"){
					$stmt = Conexion::conectar()->prepare("SELECT cp.*,u.nombre, u.id id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor and cp.relacionado = 0 and cp.actividad_realizada = 1 and u.ubicacion = '".$ubicacionAsignada."' and cp.id_actividad = v.id and (v.productos like '%$condicionProductos1%' or v.productos like '%$condicionRecorridoProductos1%') ");		
				}
				
				else if($valor2 == "3"){
					$stmt = Conexion::conectar()->prepare("SELECT cp.*,u.nombre, u.id id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor and cp.relacionado = 0 and cp.actividad_realizada = 1 and u.ubicacion = '".$ubicacionAsignada."' and cp.id_actividad = v.id and (v.productos like '%$condicionProductos2%' or v.productos like '%$condicionRecorridoProductos2%') ");		
				}
				
				else {
					$stmt = Conexion::conectar()->prepare("SELECT cp.*,u.nombre, u.id id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE u.usuario = cp.id_asesor and cp.relacionado = 0 and cp.actividad_realizada = $valor2 and u.ubicacion = '".$ubicacionAsignada."'");
				}  
			
			$stmt -> execute();

			return $stmt -> fetchAll();	 

		}if ($item != null){

			if ($valor2 == "1"){
				
				$stmt = Conexion::conectar()->prepare("SELECT cp.*,u.nombre, u.id as id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor and cp.relacionado = 0 and u.id= $valor and cp.actividad_realizada = $valor2 and cp.id_actividad = v.id and v.productos not like '%$condicionProductos1%' and v.productos not like '%$condicionProductos2%' and v.productos not like '%$condicionRecorridoProductos1%' and v.productos not like '%$condicionRecorridoProductos2%' ");

			}
			else if ($valor2 == "2"){
				
				$stmt = Conexion::conectar()->prepare("SELECT cp.*,u.nombre, u.id as id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor and cp.relacionado = 0 and u.id= $valor and cp.actividad_realizada = 1 and cp.id_actividad = v.id and (v.productos like '%$condicionProductos1%' or v.productos like '%$condicionRecorridoProductos1%')");

			}

			else if ($valor2 == "3"){
				
				$stmt = Conexion::conectar()->prepare("SELECT cp.*,u.nombre, u.id as id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor and cp.relacionado = 0 and u.id= $valor and cp.actividad_realizada = 1 and cp.id_actividad = v.id and (v.productos like '%$condicionProductos2%' or v.productos like '%$condicionRecorridoProductos2%')");

			}
			
			else{

				$stmt = Conexion::conectar()->prepare("SELECT cp.*,u.nombre, u.id as id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE u.usuario = cp.id_asesor and cp.relacionado = 0 and u.id= $valor and cp.actividad_realizada = $valor2 ");
			}


			$stmt -> execute();

			return $stmt -> fetchAll();

		}


		}else if($fechaInicial == $fechaFinal){

		 if ($item == null){

			if($valor2 == "1"){	

				$stmt = Conexion::conectar()->prepare("SELECT cp.*,u.nombre, u.id id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor and cp.relacionado = 0 and cp.actividad_realizada = $valor2 and u.ubicacion = '".$ubicacionAsignada."' and cp.id_actividad = v.id and v.productos not like '%$condicionProductos1%' and v.productos not like '%$condicionProductos2%' and v.productos not like '%$condicionRecorridoProductos1%' and v.productos not like '%$condicionRecorridoProductos2%' and cp.fecha_cotizacion like '%$fechaFinal%'");

			}
			
			else if($valor2 == "2"){	

				$stmt = Conexion::conectar()->prepare("SELECT cp.*,u.nombre, u.id id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor and cp.relacionado = 0 and cp.actividad_realizada = 1 and u.ubicacion = '".$ubicacionAsignada."' and cp.id_actividad = v.id and (v.productos like '%$condicionProductos1%' or v.productos  like '%$condicionRecorridoProductos1%') ");

			}

			else if($valor2 == "3"){	

				$stmt = Conexion::conectar()->prepare("SELECT cp.*,u.nombre, u.id id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor and cp.relacionado = 0 and cp.actividad_realizada = 1 and u.ubicacion = '".$ubicacionAsignada."' and cp.id_actividad = v.id and (v.productos like '%$condicionProductos2%' or v.productos  like '%$condicionRecorridoProductos2%') ");

			}
			
			else{
				$stmt = Conexion::conectar()->prepare("SELECT cp.*,u.nombre, u.id id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor and cp.relacionado = 0 and cp.actividad_realizada = $valor2 and u.ubicacion = '".$ubicacionAsignada."' and cp.fecha_cotizacion like '%$fechaFinal%'");
			}

			$stmt -> execute();

			return $stmt -> fetchAll();
		}
		else{

			if($valor2 == "1"){
				$stmt = Conexion::conectar()->prepare("SELECT cp.*, u.nombre, u.id id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor and cp.relacionado = 0 AND u.id= $valor AND cp.actividad_realizada = $valor2 and cp.id_actividad = v.id and v.productos not like '%$condicionProductos1%' and v.productos not like '%$condicionProductos2%' and v.productos not like '%$condicionRecorridoProductos1%' and v.productos not like '%$condicionRecorridoProductos2%' AND fecha_cotizacion like '%$fechaFinal%'");

			}else if($valor2 == "2"){

				$stmt = Conexion::conectar()->prepare("SELECT cp.*, u.nombre, u.id id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor and cp.relacionado = 0 AND u.id= $valor AND cp.actividad_realizada = 1 and cp.id_actividad = v.id and (v.productos like '%$condicionProductos1%' or v.productos like '%$condicionRecorridoProductos1%')  AND fecha_cotizacion like '%$fechaFinal%'");

			}
			else if($valor2 == "3"){

				$stmt = Conexion::conectar()->prepare("SELECT cp.*, u.nombre, u.id id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor and cp.relacionado = 0 AND u.id= $valor AND cp.actividad_realizada = 1 and cp.id_actividad = v.id and (v.productos like '%$condicionProductos2%'or v.productos like '%$condicionRecorridoProductos2%') AND fecha_cotizacion like '%$fechaFinal%'");

			}
			
			else{
				$stmt = Conexion::conectar()->prepare("SELECT cp.*, u.nombre, u.id id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor and cp.relacionado = 0 AND u.id= $valor AND cp.actividad_realizada = $valor2 AND fecha_cotizacion like '%$fechaFinal%'");
			}

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

					if($valor2 == "1"){
						
						$stmt = Conexion::conectar()->prepare("SELECT cp.*, u.nombre, u.id id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor and cp.relacionado = 0  AND cp.actividad_realizada = $valor2 and u.ubicacion = '".$ubicacionAsignada."' and cp.id_actividad = v.id and v.productos not like '%$condicionProductos1%' and v.productos not like '%$condicionProductos2%' and v.productos not like '%$condicionRecorridoProductos1%' and v.productos not like '%$condicionRecorridoProductos2%' AND cp.fecha_cotizacion  BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'");

					}else if ($valor2 == "2"){
						
						$stmt = Conexion::conectar()->prepare("SELECT cp.*, u.nombre, u.id id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor and cp.relacionado = 0  AND cp.actividad_realizada = 1 and u.ubicacion = '".$ubicacionAsignada."' and cp.id_actividad = v.id and ( v.productos like '%$condicionProductos1%' or v.productos like '%$condicionRecorridoProductos1%') AND cp.fecha_cotizacion  BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'");
					}

					else if ($valor2 == "3"){
						
						$stmt = Conexion::conectar()->prepare("SELECT cp.*, u.nombre, u.id id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor and cp.relacionado = 0  AND cp.actividad_realizada = 1 and u.ubicacion = '".$ubicacionAsignada."' and cp.id_actividad = v.id and ( v.productos like '%$condicionProductos2%' or v.productos like '%$condicionRecorridoProductos2%')  AND cp.fecha_cotizacion  BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'");
					}
					
					else{
						$stmt = Conexion::conectar()->prepare("SELECT cp.*, u.nombre, u.id id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor and cp.relacionado = 0  AND cp.actividad_realizada = $valor2 and u.ubicacion = '".$ubicacionAsignada."' AND cp.fecha_cotizacion  BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'");
					}

					$stmt -> execute();
					return $stmt -> fetchAll();


				} else {

					if ($valor2 == "1"){
						
						$stmt = Conexion::conectar()->prepare("SELECT cp.*, u.nombre, u.id id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor  AND cp.actividad_realizada = $valor2 and u.id= $valor and cp.relacionado = 0 and cp.id_actividad = v.id and v.productos not like '%$condicionProductos1%' and v.productos not like '%$condicionProductos2%' and v.productos not like '%$condicionRecorridoProductos1%' and v.productos not like '%$condicionRecorridoProductos2%'  AND cp.fecha_cotizacion BETWEEN '$fechaInicial' AND '$fechaFinalMasUno' ");

					} else if($valor2 == "2"){
						$stmt = Conexion::conectar()->prepare("SELECT cp.*, u.nombre, u.id id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor  AND cp.actividad_realizada = 1 and u.id= $valor and cp.relacionado = 0 and cp.id_actividad = v.id and (v.productos like '%$condicionProductos1%' or v.productos like '%$condicionRecorridoProductos1%')  AND cp.fecha_cotizacion BETWEEN '$fechaInicial' AND '$fechaFinalMasUno' ");

					}

					else if($valor2 == "3"){
						$stmt = Conexion::conectar()->prepare("SELECT cp.*, u.nombre, u.id id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor  AND cp.actividad_realizada = 1 and u.id= $valor and cp.relacionado = 0 and cp.id_actividad = v.id and (v.productos like '%$condicionProductos2%' or v.productos like '%$condicionRecorridoProductos2%') AND cp.fecha_cotizacion BETWEEN '$fechaInicial' AND '$fechaFinalMasUno' ");

					}
					
					else{	
						$stmt = Conexion::conectar()->prepare("SELECT cp.*, u.nombre, u.id id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor AND cp.actividad_realizada = $valor2 and u.id= $valor and cp.relacionado = 0  AND cp.fecha_cotizacion BETWEEN '$fechaInicial' AND '$fechaFinalMasUno' ");
					}

					$stmt -> execute();
					return $stmt -> fetchAll();

				}

			}else{

				if ($item == null){

					if($valor2 == "1"){
						
						$stmt = Conexion::conectar()->prepare("SELECT cp.*, u.nombre, u.id id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor and cp.relacionado = 0 AND cp.actividad_realizada = $valor2 and u.ubicacion = '".$ubicacionAsignada."'  and cp.relacionado = 0 and cp.id_actividad = v.id and v.productos not like '%$condicionProductos1%' and v.productos not like '%$condicionProductos2%' and v.productos not like '%$condicionRecorridoProductos1%' and v.productos not like '%$condicionRecorridoProductos2%' AND cp.fecha_cotizacion BETWEEN '$fechaInicial' AND '$fechaFinal'");
					}
					else if($valor2 == "2"){

						$stmt = Conexion::conectar()->prepare("SELECT cp.*, u.nombre, u.id id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor and cp.relacionado = 0 AND cp.actividad_realizada = 1 and u.ubicacion = '".$ubicacionAsignada."' and cp.relacionado = 0 and cp.id_actividad = v.id and (v.productos like '%$condicionProductos1%' or v.productos like '%$condicionRecorridoProductos1%') AND cp.fecha_cotizacion BETWEEN '$fechaInicial' AND '$fechaFinal'");

					}
					else if($valor2 == "3"){

						$stmt = Conexion::conectar()->prepare("SELECT cp.*, u.nombre, u.id id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor and cp.relacionado = 0 AND cp.actividad_realizada = 1 and u.ubicacion = '".$ubicacionAsignada."' and cp.relacionado = 0 and cp.id_actividad = v.id and (v.productos like '%$condicionProductos2%' or v.productos like '%$condicionRecorridoProductos2%') AND cp.fecha_cotizacion BETWEEN '$fechaInicial' AND '$fechaFinal'");

					}
					else{
						$stmt = Conexion::conectar()->prepare("SELECT cp.*, u.nombre, u.id id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor and cp.relacionado = 0 AND cp.actividad_realizada = $valor2 and u.ubicacion = '".$ubicacionAsignada."' AND cp.fecha_cotizacion BETWEEN '$fechaInicial' AND '$fechaFinal'");
					}
					
					$stmt -> execute();
					return $stmt -> fetchAll();
				}
				else{

					if ($valor2 == "1"){
						$stmt = Conexion::conectar()->prepare("SELECT cp.*, u.nombre, u.id id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor AND cp.actividad_realizada = $valor2 and u.id= $valor  and cp.relacionado = 0 and cp.id_actividad = v.id and v.productos not like '%$condicionProductos1%' and v.productos not like '%$condicionProductos2%' and v.productos not like '%$condicionRecorridoProductos1%' and v.productos not like '%$condicionRecorridoProductos2%' AND cp.fecha_cotizacion BETWEEN '$fechaInicial' AND '$fechaFinal'");
					}
					
					else if($valor2 == "2"){
						$stmt = Conexion::conectar()->prepare("SELECT cp.*, u.nombre, u.id id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor AND cp.actividad_realizada = 1 and u.id= $valor  and cp.relacionado = 0 and cp.id_actividad = v.id and (v.productos like '%$condicionProductos1%' or v.productos like '%$condicionRecorridoProductos1%') AND cp.fecha_cotizacion BETWEEN '$fechaInicial' AND '$fechaFinal'");
					}					
					else if($valor2 == "3"){
						$stmt = Conexion::conectar()->prepare("SELECT cp.*, u.nombre, u.id id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor AND cp.actividad_realizada = 1 and u.id= $valor  and cp.relacionado = 0 and cp.id_actividad = v.id and (v.productos like '%$condicionProductos2%' or v.productos like '%$condicionRecorridoProductos2%') AND cp.fecha_cotizacion BETWEEN '$fechaInicial' AND '$fechaFinal'");
					}					
					
					else{
						$stmt = Conexion::conectar()->prepare("SELECT cp.*, u.nombre, u.id id_asesor_interno,(select u2.nombre from usuarios u2 where u2.usuario=cp.usuIde) UsuIde FROM $tabla WHERE   u.usuario = cp.id_asesor AND cp.actividad_realizada = $valor2 and u.id= $valor  and cp.relacionado = 0 AND cp.fecha_cotizacion BETWEEN '$fechaInicial' AND '$fechaFinal'");
					}
					
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


	/*=============================================
	NUMERO DE COTIZACIONES POR CLIENTE
	=============================================*/

	static public function mdlCotizacionesCliente($tabla, $id_asesor, $ced_cliente ){
		
		$vendido= '"estado_cliente":"Vendido"';
		$perdido= '"estado_cliente":"Perdido"';

		$stmt = Conexion::conectar()->prepare("SELECT COUNT(*) as num, ced_cliente, group_concat(' ',cotizacion) as cotizaciones from $tabla where cp.id_asesor = '$id_asesor' and cp.ced_cliente = '$ced_cliente' and cp.relacionado = 0 and v.id = cp.id_actividad and v.productos not like '%$vendido%' and v.productos not like '%$perdido%' group by ced_cliente having COUNT(ced_cliente) >=2 ");

		$stmt -> execute();

		return $stmt -> fetch();

		//$stmt -> close();

		$stmt = null;

	}

	/*=============================================
		VENTAS POR FECHAS
	=============================================*/

	static public function mdlReporteGeneralVentas($tabla, $id_asesor, $ced_cliente ){
		
		$vendido= '"estado_cliente":"Vendido"';
		$perdido= '"estado_cliente":"Perdido"';

		$stmt = Conexion::conectar()->prepare("SELECT COUNT(*) as num, ced_cliente, group_concat(' ',cotizacion) as cotizaciones from $tabla where cp.id_asesor = '$id_asesor' and cp.ced_cliente = '$ced_cliente' and cp.relacionado = 0 and v.id = cp.id_actividad and v.productos not like '%$vendido%' and v.productos not like '%$perdido%' group by ced_cliente having COUNT(ced_cliente) >=2 ");

		$stmt -> execute();

		return $stmt -> fetch();

		//$stmt -> close();

		$stmt = null;

	}


	/*=============================================
	MOSTRAR DETALLE COTIZACION 
	=============================================*/

	static public function mdlMostrarDetalleRecorrido($tabla, $id){

		$stmt = Conexion::conectar()->prepare("SELECT re.* FROM $tabla WHERE re.id= $id");
		
		$stmt -> execute();

		return $stmt -> fetchAll(); 

}

	/*=============================================
	MOSTRAR HISTORIAL RECORRIDO 
	=============================================*/

	static public function mdlMostrarHistorialRecorrido($tabla, $idRecorrido){


		$stmt = Conexion::conectar()->prepare("SELECT hr.* FROM $tabla WHERE  hr.id_recorrido= $idRecorrido order by hr.fecha asc");

		$stmt -> execute();

		return $stmt -> fetchAll(); 

}


	
}