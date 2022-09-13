<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Editar Actividad Recorrido
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Editar Actividad Recorrido</li>
    
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
                    $condition = "recorrido";

                    $item = "id";
                    $valor = $_GET["idVenta"];
                    $valor2= $_GET["actividadRealizada"];
                    $numeroCotizacion= $_GET["numeroCotizacion"];
                    $idRecorrido= $_GET["idRecorrido"];
            

                    $venta = ControladorVentas::ctrMostrarVentas($item, $valor);
                    $historialRecorrido = ControladorVentas::ctrMostrarHistorialRecorrido($idRecorrido);
                    $detalleRecorrido = ControladorVentas::ctrMostrarDetalleRecorrido($idRecorrido);


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

                <div class="box">
                 <div class="input-group">
                   <strong><h4>Detalles Recorrido</h4></strong>
                 </div>
                </div>
  
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-sm table-light ">
                      <thead>
                        <tr>
                          <th scope="col">Obra</th>
                          <th scope="col">Calle Principal</th>
                          <th scope="col">Calle Secundaria</th>
                          <th scope="col">Sector</th>
                          <th scope="col">Ciudad</th>
                          <th scope="col">Arquitecto</th>
                          <th scope="col">Celular</th>
                          <th scope="col">Dueño Obra</th>
                          <th scope="col">Celular</th>
                          <th scope="col">Maestro Obra</th>
                          <th scope="col">Celular</th>
                          <th scope="col">Observacion</th>                          
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        foreach ($detalleRecorrido as $keyDetalle => $valueDetalle) {
                            echo '<tr>
                              <th scope="row">'.$valueDetalle["obra"].'</th>
                              <td>'.$valueDetalle["calle_principal"].'</td>
                              <td>'.$valueDetalle["calle_secundaria"].'</td>
                              <td>'.$valueDetalle["sector"].'</td>
                              <td>'.$valueDetalle["ciudad"].'</td>
                              <td>'.$valueDetalle["nombre_arq"].' '.$valueDetalle["apellido_arq"].'</td>
                              <td>'.$valueDetalle["celular_arq"].'</td>
                              <td>'.$valueDetalle["nombre_obra"].' '.$valueDetalle["apellido_obra"].'</td>
                              <td>'.$valueDetalle["celular_obra"].'</td>
                              <td>'.$valueDetalle["nombre_maes_obr"].' '.$valueDetalle["apellido_maes_obr"].'</td>
                              <td>'.$valueDetalle["celular_maes_obr"].'</td>
                              <td>'.$valueDetalle["observaciones"].'</td>
                            </tr>';
                        
                        }
                        
                        ?>
                      </tbody>

                    </table>
              </div>
              
              <div class="box"> </div>

              <div class="height d-flex justify-content-center align-items-left">

                   <button type="button" id="historial-btn" class="btn btn-primary" data-toggle="modal" data-target="#historialRecorridoModal">
                    <strong>Historial Recorrido</strong>
                    </button>

                    <?php 
                      If ($valor2 == "0"){
                      echo '<button type="button" class="btn btn-success btnAgregarRecorrido"><strong>Agregar Actividad</strong></button>';
                    }

                      If ($valor2 == "1"){
                      echo '<button type="button" class="btn btn-success btnAgregarRecorrido"><strong>Agregar Actividad</strong></button>';
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

                    If(isset($value["cliente_compartido"])){
                         
                echo ' <div class="col-xs-1" style="padding-right:0px">

                         <input type="hidden" class="form-control nuevoCliCompartido" idProducto="'.$value["cliente_compartido"].'" name="nuevoCliCompartido" value="'.$value["cliente_compartido"].'" readonly required>
                         
          
                         </div>';
                    }

                echo ' <div class="col-xs-1" style="padding-right:0px">
            
                         <input type="hidden" class="form-control nuevoEstadoCliente" idProducto="'.$value["estado_recorrido"].'" name="nuevoEstadoCliente" value="'.$value["estado_recorrido"].'" readonly required>
                                                 
                         </div>

                         <div class="col-xs-1" style="padding-right:0px">
            
                         <input type="hidden" class="form-control nuevoMotivoCliente" idProducto="'.$value["motivo_cliente"].'" name="nuevoMotivoCliente" value="'.$value["motivo_cliente"].'" readonly required>

                         </div>

                         <div class="col-xs-1" style="padding-right:0px">

                         <input type="hidden" class="form-control nuevoFechaSeguimiento" idProducto="'.$value["fecha_seguimiento"].'" name="nuevoFechaSeguimiento" value="'.$value["fecha_seguimiento"].'" readonly required>
          
                         </div>

                         <div class="col-xs-1" style="padding-right:0px">
            
                         <input type="hidden" class="form-control nuevoValorCotizacion" idProducto="'.$value["cotizacion"].'" name="nuevoValorCotizacion" value="'.$value["cotizacion"].'" readonly required>
                         
                         </div>
                   
                         <div class="col-xs-3" style="padding-left:14px">               

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

<div class="modal fade" id="historialRecorridoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <th scope="col">Cliente Compartido</th>
                <th scope="col">Estado</th>
                <th scope="col">Fecha Seguimiento</th>
                <th scope="col">Por qué se perdió?</th>
                <th scope="col">Cotizacion</th>
                <th scope="col">Observacion</th>
              </tr>
            </thead>
            <tbody>
            
        <?php

            $itemHis = "id";
            $valorHis = $_GET["idVenta"];
            $ventaHis = ControladorVentas::ctrMostrarVentas($itemHis, $valorHis);

          //Eliminar lo datos del historial            
              $stmt= Conexion::conectar()->prepare("DELETE FROM historial_recorrido  WHERE id_recorrido = $idRecorrido ");
              $stmt->execute();
            
              $listaProducto = json_decode($ventaHis["productos"], true);
              
              foreach ($listaProducto as $key => $valuePro) {

                $stmt=Conexion::conectar()->prepare("INSERT INTO historial_recorrido
                (id_recorrido, fecha, cliente_compartido, estado_recorrido, motivo_cliente, fecha_seguimiento, cotizacion, observacion) 
                VALUES 
                (:id_recorrido, :fecha, :cliente_compartido, :estado_recorrido, :motivo_cliente, :fecha_seguimiento, :cotizacion, :observacion)");

                $stmt->bindParam(":id_recorrido", $idRecorrido, PDO::PARAM_INT);
                $stmt->bindParam(":fecha", $valuePro["fecha"]);
                $stmt->bindParam(":cliente_compartido",$valuePro["cliente_compartido"], PDO::PARAM_STR);
                $stmt->bindParam(":estado_recorrido", $valuePro["estado_recorrido"], PDO::PARAM_STR);
                $stmt->bindParam(":motivo_cliente", $valuePro["motivo_cliente"], PDO::PARAM_STR);
                $stmt->bindParam(":fecha_seguimiento", $valuePro["fecha_seguimiento"]);
                $stmt->bindParam(":cotizacion", $valuePro["cotizacion"], PDO::PARAM_STR);        
                $stmt->bindParam(":observacion", $valuePro["observacion"], PDO::PARAM_STR);
                $stmt->execute();
              
              }

            foreach ($historialRecorrido as $keyHistorial => $valueHistorial) {
              $fechaCompara="0000-00-00 00:00:00";
              $valorFechaSeguimiento = $valueHistorial["fecha_seguimiento"] == $fechaCompara ? "":$valueHistorial["fecha_seguimiento"];
                  echo       
                  '<tr>
                  <th scope="row">'.($keyHistorial+1).'</th>
                  <td>'.$valueHistorial["fecha"].'</td>
                  <td>'.$valueHistorial["cliente_compartido"].'</td>
                  <td>'.$valueHistorial["estado_recorrido"].'</td>
                  <td style="word-wrap: break-word;min-width: 160px;max-width: 160px;white-space:normal;" >'.$valorFechaSeguimiento.'</td>
                  <td>'.$valueHistorial["motivo_cliente"].'</td>   
                  <td>'.$valueHistorial["cotizacion"].'</td>
                  <td style="word-wrap: break-word;min-width: 160px;max-width: 160px;white-space:normal;" >'.$valueHistorial["observacion"].'</td>
                </tr>';
            }

          ?>         

            </tbody>
          </table>

      </div>


        </div>
        <div class="modal-footer">
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