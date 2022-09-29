<?php

require_once "controladores/ventas.controlador.php";
require_once "modelos/ventas.modelo.php";

$reporteGeneral= ControladorVentas::ctrMostrarHistorialReporteGeneral();



//Eliminar lo datos de la tabla
$stmt= Conexion::conectar()->prepare("TRUNCATE TABLE historial_proforma_reporte");
$stmt->execute();

foreach ($reporteGeneral as $key => $valueGeneral) {

        $listaProducto = json_decode($valueGeneral["productos"], true);
        $comparaClienteCompartido="- Cliente Compartido -";
        $comparaMotivoCliente = "- ¿Por que no compró? -";
        $condicion_recorrido =substr($valueGeneral['cotizacion'],0,3);
        //Listar los de detalles de la cotizacion e insertarlos en la tabla de historial_proforma
        foreach ($listaProducto as $key => $valuePro) {

            $stmt=Conexion::conectar()->prepare("INSERT INTO historial_proforma_reporte
            (id_almacen, nombre_almacen, cotizacion, id_asesor, nombre_vendedor, ced_cliente, fecha_creacion_cliente, fecha, origen_negociacion, cliente_compartido, estado_cliente, visita_almacen, motivo_cliente, fecha_seguimiento, valor_factura, cotizacion_recorrido, observacion) 
            VALUES 
            (:id_almacen, :nombre_almacen, :cotizacion, :id_asesor, :nombre_vendedor, :ced_cliente, :fecha_creacion_cliente, :fecha, :origen_negociacion, :cliente_compartido, :estado_cliente, :visita_almacen, :motivo_cliente, :fecha_seguimiento, :valor_factura, :cotizacion_recorrido, :observacion)");

            $stmt->bindParam(":id_almacen", $valueGeneral["id_almacen"], PDO::PARAM_STR);
            $stmt->bindParam(":nombre_almacen", $valueGeneral["nombre_almacen"], PDO::PARAM_STR);
            $stmt->bindParam(":cotizacion", $valueGeneral["cotizacion"], PDO::PARAM_STR);
            $stmt->bindParam(":id_asesor", $valueGeneral["usuario"], PDO::PARAM_STR);
            $stmt->bindParam(":nombre_vendedor", $valueGeneral["nombre"], PDO::PARAM_STR);
            $stmt->bindParam(":ced_cliente", $valueGeneral["cedula"], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_creacion_cliente", $valueGeneral["creacion_cliente"]);
            $stmt->bindParam(":fecha", $valuePro["fecha"]);
            $stmt->bindParam(":origen_negociacion", $valuePro["tipo_cliente"], PDO::PARAM_STR);
            $valorCliCompartido = $valuePro["cliente_compartido"] == $comparaClienteCompartido ? "":$valuePro["cliente_compartido"];
            $stmt->bindParam(":cliente_compartido",$valorCliCompartido , PDO::PARAM_STR);        
            if ($condicion_recorrido == 'EXT'){
                $stmt->bindParam(":estado_cliente", $valuePro["estado_recorrido"], PDO::PARAM_STR);
            }else{
                $stmt->bindParam(":estado_cliente", $valuePro["estado_cliente"], PDO::PARAM_STR);
            }
            $stmt->bindParam(":visita_almacen", $valuePro["visita_almacen"], PDO::PARAM_STR);
            $valorMotivoCliente = $valuePro["motivo_cliente"] == $comparaMotivoCliente ? "":$valuePro["motivo_cliente"];
            $stmt->bindParam(":motivo_cliente", $valorMotivoCliente, PDO::PARAM_STR);
            $stmt->bindParam(":fecha_seguimiento", $valuePro["fecha_seguimiento"]);
            $stmt->bindParam(":valor_factura", $valuePro["valor_factura"]);        
            $stmt->bindParam(":cotizacion_recorrido", $valuePro["cotizacion"], PDO::PARAM_STR);
            $stmt->bindParam(":observacion", $valuePro["observacion"], PDO::PARAM_STR);
            $stmt->execute();
        
        }

        $listaProducto= null;

        $historialCotizacionRelacionadaReporte = ControladorVentas::ctrMostrarHistorialCotizacionRelacionada($valueGeneral["cotizacion"], null);

        foreach ($historialCotizacionRelacionadaReporte as $key => $value) {
            $stmt =Conexion::conectar()->prepare("INSERT INTO historial_proforma_reporte
            (id_almacen,nombre_almacen, cotizacion, id_asesor, nombre_vendedor, ced_cliente, fecha_creacion_cliente, fecha, cotizacion_relacionada, motivo_relacion)
            VALUES
            (:id_almacen,:nombre_almacen, :cotizacion, :id_asesor, :nombre_vendedor, :ced_cliente, :fecha_creacion_cliente, :fecha, :cotizacion_relacionada, :motivo_relacion)");
        
              $stmt->bindParam(":id_almacen", $valueGeneral["id_almacen"], PDO::PARAM_STR);
              $stmt->bindParam(":nombre_almacen", $valueGeneral["nombre_almacen"], PDO::PARAM_STR);
              $stmt->bindParam(":cotizacion", $valueGeneral["cotizacion"], PDO::PARAM_STR);
              $stmt->bindParam(":id_asesor", $valueGeneral["usuario"], PDO::PARAM_STR);
              $stmt->bindParam(":nombre_vendedor", $valueGeneral["nombre"], PDO::PARAM_STR);
              $stmt->bindParam(":ced_cliente", $valueGeneral["cedula"], PDO::PARAM_STR);
              $stmt->bindParam(":fecha_creacion_cliente", $valueGeneral["creacion_cliente"]);
              $stmt->bindParam(":fecha", $value["fecha_motivo_relacion"]);
              $stmt->bindParam(":cotizacion_relacionada", $value["secundaria"], PDO::PARAM_STR);
              $stmt->bindParam(":motivo_relacion", $value["motivo_relacion"], PDO::PARAM_STR);
              $stmt->execute();
        
          }
        


}




?>