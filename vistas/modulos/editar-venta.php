<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Editar Actividad
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Editar Actividad</li>
    
    </ol>

  </section>


  <section class="content">

    <div class="row">

      <!--=====================================
      EL FORMULARIO
      ======================================-->
      
      <div class="col-lg-12 col-xs-12">
        
        <div class="box box-success">
          
          <div class="box-header with-border"></div>

          <form role="form" method="post" class="formularioVenta">

            <div class="box-body">
  
              <div class="box">

                <?php
                    $condition = "cotizacion";

                    $item = "id";
                    $valor = $_GET["idVenta"];
                    $valor2= $_GET["actividadRealizada"];
                    $numeroCotizacion= $_GET["numeroCotizacion"];
                    $idAlmacen= $_GET["idAlmacen"];

                    $venta = ControladorVentas::ctrMostrarVentas($item, $valor);
                    $historialCotizacionRelacionada = ControladorVentas::ctrMostrarHistorialCotizacionRelacionada($numeroCotizacion,$idAlmacen);
                    $historialCotizacion = ControladorVentas::ctrMostrarHistorialCotizacion($numeroCotizacion,$idAlmacen);
                    $detalleCotizacion = ControladorVentas::ctrMostrarDetalleCotizacion($numeroCotizacion,$idAlmacen);


                    $itemUsuario = "id";
                    $valorUsuario = $venta["id_vendedor"];

                    $vendedor = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

                    $itemCliente = "id";
                    $valorCliente = $venta["id_cliente"];

                    $cliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);


                ?>

                <!--=====================================
                ENTRADA DEL VENDEDOR
                ======================================-->
            
                <div class="form-group">
                
                  <div class="input-group">
                    
                    <input type="hidden" class="form-control" id="nuevoVendedor" value="<?php echo $vendedor["nombre"]; ?>" readonly>

                    <input type="hidden" name="idVendedor" value="<?php echo $vendedor["id"]; ?>">

                  </div>

                </div> 

                <!--=====================================
                ENTRADA DEL CÓDIGO
                ======================================--> 

                <div class="form-group">
                  
                  <div class="input-group">
                  
                   <input type="hidden" class="form-control" id="nuevaVenta" name="editarVenta" value="<?php echo $venta["codigo"]; ?>" readonly>
                   <input type="hidden" class="form-control" id="actividadRealizada" name="actividadRealizada" value="<?php echo $valor2 ?>" readonly>
               
                  </div>
                
                </div>

                <!--=====================================
                ENTRADA DEL CLIENTE
                ======================================--> 

                <div class="form-group">
                  
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                    
                    <select class="form-control" id="seleccionarCliente" name="seleccionarCliente">

                    <option value="<?php echo $cliente["id"]; ?>"><?php echo $cliente["nombre"]?></option>

                    <?php

                      $item = "id_asesor";
                      $valor = $_SESSION["usuario"];

                      $categorias = ControladorClientes::ctrMostrarClientes($item, $valor);

                       foreach ($categorias as $key => $value) {

                         echo '<option value="'.$value["id"].'">'.$value["nombre"];'</option>';

                       }

                    ?>

                    </select>
                    
                    <!-- <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAgregarCliente" data-dismiss="modal">Agregar cliente</button></span> -->
                    <input type="text" class="form-control" id="numeroCotizacion" name="numeroCotizacion" value="<?php echo $numeroCotizacion ?>" readonly>
                  
                  </div>

                </div>

                <div class="box">
                 <div class="input-group">
                   <strong><h4>Detalles Proforma</h4></strong>
                 </div>
                </div>
  
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-sm table-light ">
                      <thead>
                        <tr>
                          <th scope="col">Item</th>
                          <th scope="col">Descripcion</th>
                          <th scope="col">Cantidad</th>
                          <th scope="col">Precio</th>
                          <th scope="col">Descuento</th>
                          <th scope="col">Total</th>
                          <th scope="col">Observacion</th>                          
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $TotalProforma= 0;
                        foreach ($detalleCotizacion as $keyDetalle => $valueDetalle) {
                          $TotalProforma= $valueDetalle["total"]+$TotalProforma;
                            echo '<tr>
                              <th scope="row">'.$valueDetalle["codReal"].'</th>
                              <td>'.$valueDetalle["descripcionItem"].'</td>
                              <td>'.$valueDetalle["cantidad"].'</td>
                              <td>'.$valueDetalle["precio"].'</td>
                              <td>'.$valueDetalle["descuento"].'</td>
                              <td>'.$valueDetalle["total"].'</td>
                              <td>'.$valueDetalle["observacion"].'</td>
                            </tr>';
                        
                        }
                        echo '<tr>
                              <th scope="row"></th>
                              <td></td>
                              <td></td>
                              <td></td>
                              <th scope="row">Total</td>
                              <td>'.$TotalProforma.'</td>
                              <td></td>
                            </tr>';
                        
                        ?>
                      </tbody>

                    </table>
              </div>
              
              <div class="box"> </div>

              <div class="height d-flex justify-content-center align-items-left">

                    <button type="button" id="historial-btn" class="btn btn-primary" data-toggle="modal" data-target="#historialCotizacionModal">
                    <strong>Historial Cotizacion</strong>
                    </button>

                    <?php 
                      If ($valor2 == "0"){
                      echo '<button type="button" class="btn btn-success btnAgregarProducto"><strong>Agregar Actividad</strong></button>';
                    }

                      If ($valor2 == "1"){
                      echo '<button type="button" class="btn btn-success btnAgregarProducto1"><strong>Agregar Actividad</strong></button>';
                    }
                    ?>

                    <a href="javascript:history.back()" class="btn btn-warning"><strong>Regresar</strong></a>

              </div>

                <!--=====================================
                ENTRADA PARA AGREGAR DETALLE DE ACTIVIDAD
                ======================================-->
                
            <div class="form-group row nuevoProducto"> 
                
             <?php
 
                $listaProducto = json_decode($venta["productos"], true);

               foreach ($listaProducto as $key => $value) {
                  
                 // echo '<div class="row" style="padding:5px 15px">';

                  If(isset($value["tipo_cliente"])){
            
                echo ' <div class="col-xs-1" style="padding-right:0px">
                
                        <input type="hidden" class="form-control nuevoTipoCliente" idProducto="'.$value["tipo_cliente"].'" name="nuevoTipoCliente" value="'.$value["tipo_cliente"].'" readonly required>
                       
                        </div>'; 
                    }

                    If(isset($value["visita_almacen"])){
            
                      echo ' <div class="col-xs-1" style="padding-right:0px">
                      
                              <input type="hidden" class="form-control nuevoVisitaAlmacen" idProducto="'.$value["visita_almacen"].'" name="nuevoVisitaAlmacen" value="'.$value["visita_almacen"].'" readonly required>
                             
                              </div>'; 
                      }else{
                        echo ' <div class="col-xs-1" style="padding-right:0px">
                      
                        <input type="hidden" class="form-control nuevoVisitaAlmacen" idProducto="" name="nuevoVisitaAlmacen" value="" readonly required>
                       
                        </div>';
                      }

                    If(isset($value["cliente_compartido"])){
                         
                echo ' <div class="col-xs-1" style="padding-right:0px">

                         <input type="hidden" class="form-control nuevoCliCompartido" idProducto="'.$value["cliente_compartido"].'" name="nuevoCliCompartido" value="'.$value["cliente_compartido"].'" readonly required>
                         
          
                         </div>';
                    }

                echo ' <div class="col-xs-1" style="padding-right:0px">
            
                         <input type="hidden" class="form-control nuevoEstadoCliente" idProducto="'.$value["estado_cliente"].'" name="nuevoEstadoCliente" value="'.$value["estado_cliente"].'" readonly required>
                                                 
                         </div>

                         <div class="col-xs-1" style="padding-right:0px">
            
                         <input type="hidden" class="form-control nuevoMotivoCliente" idProducto="'.$value["motivo_cliente"].'" name="nuevoMotivoCliente" value="'.$value["motivo_cliente"].'" readonly required>

                         </div>

                         <div class="col-xs-1" style="padding-right:0px">

                         <input type="hidden" class="form-control nuevoFechaSeguimiento" idProducto="'.$value["fecha_seguimiento"].'" name="nuevoFechaSeguimiento" value="'.$value["fecha_seguimiento"].'" readonly required>
          
                         </div>

                         <div class="col-xs-1" style="padding-right:0px">
            
                         <input type="hidden" class="form-control nuevoValorFactura" idProducto="'.$value["valor_factura"].'" name="nuevoValorFactura" value="'.$value["valor_factura"].'" readonly required>
                         
                         </div>
                   
                         <div class="col-xs-5" style="padding-left:14px">               

                         <input type="hidden" class="form-control nuevoObservacion" idProducto="'.$value["observacion"].'" name="nuevoObservacion" value="'.$value["observacion"].'" readonly required>                         

                        </div>';

                        //</div>
                        
                      If(isset($value["fecha"])){
                      
                        echo '<input type="hidden" class="form-control nuevoFecha" idProducto="'.$value["fecha"].'" name="nuevoFecha" value="'.$value["fecha"].'" readonly required>'; 
                        
                      }else{
                          
                        echo '<input type="hidden" class="form-control nuevoFecha" idProducto="" name="nuevoFecha" value="" readonly required>';
                      }
                }               

                ?>
              
              <input type="hidden" id="listaProductos" name="listaProductos">

                </div> 
      
              </div>

          </div>

          <div class="box-footer">

          <?php 
            If($valor2 == "0" or $valor2 == "1"){

              echo '<button type="submit" class="btn btn-primary pull-right">Guardar cambios</button>';

            }
            
          ?>

          </div>

        </form>

        <?php

          $editarVenta = new ControladorVentas();
          $editarVenta -> ctrEditarVenta();
          
        ?>

        </div>
            
      </div>



    </div>
   
  </section>

</div>

<!--=====================================
MODAL HISTORIAL COTIZACION
======================================-->

  <div class="modal fade" id="historialCotizacionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" >
      <div class="modal-content">
        <div class="modal-header float-right">
          <h3>Historial</h3>
        </div>
        <div class="modal-body">
            
    <div class="table-responsive">

        <table class="table table-striped" id="table">
            <thead class="table-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Fecha</th>
                <th scope="col">Origen Negociacion</th>
                <th scope="col">Cliente Compartido</th>
                <th scope="col">Visito Almacen?</th>
                <th scope="col">Estado</th>
                <th scope="col">Fecha Seguimiento</th>
                <th scope="col">Por que no compro?</th>
                <th scope="col">Valor Factura</th>
                <th scope="col">Observacion</th>
                <th scope="col">Cotizacion Relacionada</th>
                <th scope="col">Motivo Relacion</th>
              </tr>
            </thead>
            <tbody>
            
        <?php

            $itemHis = "id";
            $valorHis = $_GET["idVenta"];
            $ventaHis = ControladorVentas::ctrMostrarVentas($itemHis, $valorHis);

          //Eliminar lo datos del historial            
              $stmt= Conexion::conectar()->prepare("DELETE FROM historial_proforma  WHERE id_almacen = $idAlmacen and cotizacion =$numeroCotizacion and eliminar = 1");
              $stmt->execute();
            
              $listaProducto = json_decode($ventaHis["productos"], true);
              $comparaClienteCompartido="- Cliente Compartido -";
              $comparaMotivoCliente = "- ¿Por que no compró? -";
          //Listar los de detalles de la cotizacion e insertarlos en la tabla de historial_proforma
              foreach ($listaProducto as $key => $valuePro) {

                $stmt=Conexion::conectar()->prepare("INSERT INTO historial_proforma
                (id_almacen, cotizacion, ced_cliente, fecha, origen_negociacion, cliente_compartido, estado_cliente, visita_almacen, motivo_cliente, fecha_seguimiento, valor_factura, observacion) 
                VALUES 
                (:id_almacen, :cotizacion, :ced_cliente, :fecha, :origen_negociacion, :cliente_compartido, :estado_cliente, :visita_almacen, :motivo_cliente, :fecha_seguimiento, :valor_factura, :observacion)");

                $stmt->bindParam(":id_almacen", $idAlmacen, PDO::PARAM_STR);
                $stmt->bindParam(":cotizacion", $numeroCotizacion, PDO::PARAM_STR);
                $stmt->bindParam(":ced_cliente", $cliente["cedula"], PDO::PARAM_STR);
                $stmt->bindParam(":fecha", $valuePro["fecha"]);
                $stmt->bindParam(":origen_negociacion", $valuePro["tipo_cliente"], PDO::PARAM_STR);
                $valorCliCompartido = $valuePro["cliente_compartido"] == $comparaClienteCompartido ? "":$valuePro["cliente_compartido"];
                $stmt->bindParam(":cliente_compartido",$valorCliCompartido , PDO::PARAM_STR);
                $stmt->bindParam(":estado_cliente", $valuePro["estado_cliente"], PDO::PARAM_STR);
                $stmt->bindParam(":visita_almacen", $valuePro["visita_almacen"], PDO::PARAM_STR);
                $valorMotivoCliente = $valuePro["motivo_cliente"] == $comparaMotivoCliente ? "":$valuePro["motivo_cliente"];
                $stmt->bindParam(":motivo_cliente", $valorMotivoCliente, PDO::PARAM_STR);
                $stmt->bindParam(":fecha_seguimiento", $valuePro["fecha_seguimiento"]);
                $stmt->bindParam(":valor_factura", $valuePro["valor_factura"]);        
                $stmt->bindParam(":observacion", $valuePro["observacion"], PDO::PARAM_STR);
                $stmt->execute();
              
              }

              foreach ($historialCotizacionRelacionada as $key => $value) {
                $stmt =Conexion::conectar()->prepare("INSERT INTO historial_proforma
                (id_almacen, cotizacion, ced_cliente, fecha, cotizacion_relacionada, motivo_relacion)
                VALUES
                (:id_almacen, :cotizacion, :ced_cliente, :fecha, :cotizacion_relacionada, :motivo_relacion)");

                  $stmt->bindParam(":id_almacen", $idAlmacen, PDO::PARAM_STR);
                  $stmt->bindParam(":cotizacion", $numeroCotizacion, PDO::PARAM_STR);
                  $stmt->bindParam(":ced_cliente", $cliente["cedula"], PDO::PARAM_STR);
                  $stmt->bindParam(":fecha", $value["fecha_motivo_relacion"]);
                  $stmt->bindParam(":cotizacion_relacionada", $value["secundaria"], PDO::PARAM_STR);
                  $stmt->bindParam(":motivo_relacion", $value["motivo_relacion"], PDO::PARAM_STR);
                  $stmt->execute();

              }

            foreach ($historialCotizacion as $keyHistorial => $valueHistorial) {
              $fechaCompara="0000-00-00 00:00:00";
              $valorFecha = $valueHistorial["fecha"] == $fechaCompara ? "":$valueHistorial["fecha"];
              $valorFechaSeguimiento = $valueHistorial["fecha_seguimiento"] == $fechaCompara ? "":$valueHistorial["fecha_seguimiento"];
                  echo       
                  '<tr>
                  <th scope="row">'.($keyHistorial+1).'</th>
                  <td style="word-wrap: break-word;min-width: 160px;max-width: 160px;white-space:normal;" >'.$valorFecha.'</td>
                  <td>'.$valueHistorial["origen_negociacion"].'</td>
                  <td>'.$valueHistorial["cliente_compartido"].'</td>
                  <td>'.$valueHistorial["visita_almacen"].'</td>
                  <td>'.$valueHistorial["estado_cliente"].'</td>
                  <td style="word-wrap: break-word;min-width: 160px;max-width: 160px;white-space:normal;" >'.$valorFechaSeguimiento.'</td>
                  <td style="word-wrap: break-word;min-width: 160px;max-width: 160px;white-space:normal;" >'.$valueHistorial["motivo_cliente"].'</td>
                  <td>'.$valueHistorial["valor_factura"].'</td>
                  <td style="word-wrap: break-word;min-width: 160px;max-width: 160px;white-space:normal;" >'.$valueHistorial["observacion"].'</td>
                  <td>'.$valueHistorial["cotizacion_relacionada"].'</td>
                  <td style="word-wrap: break-word;min-width: 160px;max-width: 160px;white-space:normal;" >'.$valueHistorial["motivo_relacion"].'</td>
                </tr>';
            }

          ?>         

            </tbody>
          </table>

      </div>


        </div>
        <div class="modal-footer">
         <?php
           echo '<a href="vistas/modulos/descargar-reporte.php?reporte=historial_'.$numeroCotizacion.'_'.$idAlmacen.'&numCotizacion='.$numeroCotizacion.'&idAlmacen='.$idAlmacen.'">';
           ?>
          <button class="btn btn-success" style="margin-top:5px">Descargar Historial en Excel</button>
          </a>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>


  <script type="text/javascript">
  $(document).ready(function () {
  	$(".modal-dialog").css("width", "90%");

  });
  </script>