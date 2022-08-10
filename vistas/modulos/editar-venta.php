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

                    $item = "id";
                    $valor = $_GET["idVenta"];
                    $valor2= $_GET["actividadRealizada"];
                    $numeroCotizacion= $_GET["numeroCotizacion"];
                    $idAlmacen= $_GET["idAlmacen"];

                    $venta = ControladorVentas::ctrMostrarVentas($item, $valor);
                    $historial = ControladorVentas::ctrMostrarHistorialCotizacion($numeroCotizacion,$idAlmacen);


                    $itemUsuario = "id";
                    $valorUsuario = $venta["id_vendedor"];

                    $vendedor = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

                    $itemCliente = "id";
                    $valorCliente = $venta["id_cliente"];

                    $cliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

                    //$porcentajeImpuesto = $venta["impuesto"] * 100 / $venta["neto"];


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

                      $item = 'id_asesor';
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

              

                  <div class="height d-flex justify-content-center align-items-left">

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#historialCotizacionModal">
                    Historial Cotizacion
                    </button>

                  </div>

                  <?php 
                  If ($valor2 != "0"){
                  echo ' <hr>

                  <div class="form-group row">
                  
                  <div class="col-xs-1" style="padding-right:0px">
                  
                  <strong >Origen Negociacion</strong>

                  </div>

                  <div class="col-xs-1" style="padding-right:0px">
                  
                  <strong >Visito Almacen</strong>

                  </div>


                  <div class="col-xs-1" style="padding-right:0px">

                  <strong>Cliente Compartido</strong>

                  </div>

                  <div class="col-xs-1" style="padding-right:0px">

                  <strong>Estado Cliente</strong>

                  </div>
                
                  <div class="col-xs-1" style="padding-right:0px">

                  <strong>Motivo Cliente</strong>

                  </div>

                  <div class="col-xs-1" style="padding-right:0px">

                  <strong>Fecha Seguimiento</strong>

                  </div>

                  <div class="col-xs-1" style="padding-right:0px">

                  <strong>Valor Factura</strong>

                  </div>

                  <div class="col-xs-5" style="padding-left:14px">

                  <strong>Observacion</strong>

                  </div>


                </div>';
                }
                
                ?>

                <!--=====================================
                ENTRADA PARA AGREGAR PRODUCTO
                 
                ======================================-->
                
                <div class="form-group row nuevoProducto"> 
               

                <?php

                $listaProducto = json_decode($venta["productos"], true);

                foreach ($listaProducto as $key => $value) {

                  $item = "id";
                  //$valor = $value["id"];
                  $orden = "id";

                  $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

                  //$stockAntiguo = $respuesta["stock"] + $value["cantidad"];
                  
                  echo '<div class="row" style="padding:5px 15px">';

                  If(isset($value["tipo_cliente"])){
            
                echo ' <div class="col-xs-1" style="padding-right:0px">
                
                        <input type="text" class="form-control nuevoTipoCliente" idProducto="'.$value["tipo_cliente"].'" name="nuevoTipoCliente" value="'.$value["tipo_cliente"].'" readonly required>
                       
                        </div>'; 
                    }

                    If(isset($value["visita_almacen"])){
            
                      echo ' <div class="col-xs-1" style="padding-right:0px">
                      
                              <input type="text" class="form-control nuevoVisitaAlmacen" idProducto="'.$value["visita_almacen"].'" name="nuevoVisitaAlmacen" value="'.$value["visita_almacen"].'" readonly required>
                             
                              </div>'; 
                      }else{
                        echo ' <div class="col-xs-1" style="padding-right:0px">
                      
                        <input type="text" class="form-control nuevoVisitaAlmacen" idProducto="" name="nuevoVisitaAlmacen" value="" readonly required>
                       
                        </div>';
                      }

                    If(isset($value["cliente_compartido"])){
                         
                echo ' <div class="col-xs-1" style="padding-right:0px">

                         <input type="text" class="form-control nuevoCliCompartido" idProducto="'.$value["cliente_compartido"].'" name="nuevoCliCompartido" value="'.$value["cliente_compartido"].'" readonly required>
                         
          
                         </div>';
                    }

                echo ' <div class="col-xs-1" style="padding-right:0px">
            
                         <input type="text" class="form-control nuevoEstadoCliente" idProducto="'.$value["estado_cliente"].'" name="nuevoEstadoCliente" value="'.$value["estado_cliente"].'" readonly required>
                                                 
                         </div>

                         <div class="col-xs-1" style="padding-right:0px">
            
                         <input type="text" class="form-control nuevoMotivoCliente" idProducto="'.$value["motivo_cliente"].'" name="nuevoMotivoCliente" value="'.$value["motivo_cliente"].'" readonly required>

                         </div>

                         <div class="col-xs-1" style="padding-right:0px">

                         <input type="date" class="form-control nuevoFechaSeguimiento" idProducto="'.$value["fecha_seguimiento"].'" name="nuevoFechaSeguimiento" value="'.$value["fecha_seguimiento"].'" readonly required>
          
                         </div>

                         <div class="col-xs-1" style="padding-right:0px">
            
                         <input type="text" class="form-control nuevoValorFactura" idProducto="'.$value["valor_factura"].'" name="nuevoValorFactura" value="'.$value["valor_factura"].'" readonly required>
                         
                         </div>
                   
                         <div class="col-xs-5" style="padding-left:14px">               

                         <input type="text" class="form-control nuevoObservacion" idProducto="'.$value["observacion"].'" name="nuevoObservacion" value="'.$value["observacion"].'" readonly required>                         

                        </div>

                      </div>';
                }


                ?>
              

                </div>

                <input type="hidden" id="listaProductos" name="listaProductos">

                <!--=====================================
                BOTÓN PARA AGREGAR PRODUCTO
                BOTON CON hidden-lg no se mostrará para la edicion del detalle
                ======================================-->

                <!--<button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar producto</button>-->

                <?php 
                  If ($valor2 == "0"){
                  echo '<button type="button" class="btn btn-default btnAgregarProducto" >Agregar Actividad</button>';
                }

                  If ($valor2 == "1"){
                  echo '<button type="button" class="btn btn-default btnAgregarProducto1" >Agregar Actividad</button>';
                }
                ?>
      
              </div>

          </div>

          <div class="box-footer">

          <?php 
            If($valor2 == "0" or $valor2 == "1"){

              echo '<button type="submit" class="btn btn-primary pull-right">Guardar cambios</button>';

            }
            
          ?>

            
                <a class="btn btn-warning pull-left" href="javascript:history.back()"> Regresar</a>
          

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
MODAL AGREGAR CLIENTE
======================================-->

<div id="modalAgregarCliente" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar cliente</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevoCliente" placeholder="Ingresar nombre" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL DOCUMENTO ID -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="number" min="0" class="form-control input-lg" name="nuevoDocumentoId" placeholder="Ingresar documento" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL EMAIL -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span> 

                <input type="email" class="form-control input-lg" name="nuevoEmail" placeholder="Ingresar email" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL TELÉFONO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevoTelefono" placeholder="Ingresar teléfono" data-inputmask="'mask':'(999) 999-9999'" data-mask required>

              </div>

            </div>

            <!-- ENTRADA PARA LA DIRECCIÓN -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevaDireccion" placeholder="Ingresar dirección" required>

              </div>

            </div>

             <!-- ENTRADA PARA LA FECHA DE NACIMIENTO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevaFechaNacimiento" placeholder="Ingresar fecha nacimiento" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask required>

              </div>

            </div>
  
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar cliente</button>

        </div>

      </form>

      <?php

        $crearCliente = new ControladorClientes();
        $crearCliente -> ctrCrearCliente();

      ?>

    </div>

  </div>

</div>

<!--=====================================
MODAL HISTORIAL COTIZACION
======================================-->

  <div class="modal fade" id="historialCotizacionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header float-right">
          <h3>Historial</h3>
        </div>
        <div class="modal-body">
            
    <div>
            
            <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Cot.Relacionada</th>
        <th scope="col">Descripcion</th>
        <th scope="col">Fecha</th>
      </tr>
    </thead>
    <tbody>
    <?php
  foreach ($historial as $keyHistorial => $value) {
    echo       
    '<tr>
    <th scope="row">'.($keyHistorial+1).'</th>
    <td>'.$value["secundaria"].'</td>
    <td>'.$value["motivo_relacion"].'</td>
    <td>'.$value["fecha_motivo_relacion"].'</td>
  </tr>';
  }
  ?>         

    </tbody>
  </table>

          </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

