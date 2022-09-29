<?php
$condition = "ventas_cre";

if($_SESSION["perfil"] == "Especial"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

$xml = ControladorVentas::ctrDescargarXML();

if($xml){

  rename($_GET["xml"].".xml", "xml/".$_GET["xml"].".xml");

  echo '<a class="btn btn-block btn-success abrirXML" archivo="xml/'.$_GET["xml"].'.xml" href="ventas">Se ha creado correctamente el archivo XML <span class="fa fa-times pull-right"></span></a>';

}

?>
<div class="content-wrapper">

  <section class="content-header"> 
    
    <h1>
      
      Creacion Actividades
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Creacion Actividades</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

         <button type="button" class="btn btn-default" id="daterange1-btn">
           
            <span>
              <i class="fa fa-calendar"></i> 

              <?php

                if(isset($_GET["fechaInicial"])){

                  echo $_GET["fechaInicial"]." - ".$_GET["fechaFinal"];
                
                }else{
                 
                  echo 'Rango de fecha';

                }

              ?>
            </span>

            <i class="fa fa-caret-down"></i>

         </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Cotizacion</th>
           <th>Cliente</th>
           <th>Almacen</th>
           <?php
            if($_SESSION["perfil"] == "Administrador"){
              echo '<th>Asesor</th>';
            }
           ?>
           <th>Realizada Por</th>
           <th>Fecha Cotizacion</th>
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

          if(isset($_GET["fechaInicial"])){

            $fechaInicial = $_GET["fechaInicial"];
            $fechaFinal = $_GET["fechaFinal"];

          }else{

            $fechaInicial = null;
            $fechaFinal = null;

          }

          $valor2 = 0;

          if($_SESSION["perfil"] == "Administrador"){
            $item = null;
            $valor = null;
          }
          if($_SESSION["perfil"] == "Vendedor"){
            $item = 'id';
            $valor= $_SESSION["id"];
          }


          $respuesta = ControladorVentas::ctrRangoFechasCotizacionCliente($fechaInicial, $fechaFinal, $item, $valor,$valor2);
          $id_actividad= null;
          $cliente_id=null;

          $stmt= Conexion::conectar()->prepare("TRUNCATE TABLE clientes_excluidos");
          $stmt->execute();

          foreach ($respuesta as $key => $value) {
           
           echo '<tr>

                  <td>'.($key+1).'</td>

                  <td class="td_cotizacion">'.$value["cotizacion"].'</td>';

                  $itemCliente = "cedula";
                  $valorCliente = $value["ced_cliente"];

                  $respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

                  $condicion_recorrido =substr($value['cotizacion'],0,3);
                  $idRecorrido=substr($value['cotizacion'],3,strlen($value['cotizacion']));

                  if ($condicion_recorrido == 'EXT'){

                    echo '<td>'.$value["ced_cliente"].'</td>';

                  }else {

                    if ($respuestaCliente["nombre"] == "" or $respuestaCliente["nombre"] == null){

                      $stmt=Conexion::conectar()->prepare("INSERT INTO clientes_excluidos(cedula) VALUES (:cedula)");
  
                      $stmt->bindParam(":cedula", $valorCliente, PDO::PARAM_STR);
  
                      $stmt->execute();
                    
                    }

                    echo '<td>'.$respuestaCliente["nombre"].'</td>';

                  }
                

                  echo '<td>'.$value["nombre_almacen"].'</td>';

                  if($_SESSION["perfil"] == "Administrador"){

                    echo '<td>'.$value["nombre"].'</td>';
 
                   }

                  echo '<td>'.$value["UsuIde"].'</td>';

                  echo '<td>'.$value["fecha_cotizacion"].'</td>

                  <td>

                    <div class="btn-group">



                      <!--<button class="btn btn-success btnImprimirTicket" codigoVenta="'.$value["cotizacion"].'">

                        <i class="fa fa-print">Ticket</i>

                      </button>
                        
                      <button class="btn btn-info btnImprimirFactura" codigoVenta="'.$value["cotizacion"].'">

                        <i class="fa fa-print"></i>PDF

                      </button> -->' ;

                      if($_SESSION["perfil"] == "Vendedor" ){

                        if ($value["id_actividad"] == 0 or $value["id_actividad"] == null){

                        $tabla = "ventas";

                        $campo_vacio= "[]";

                        $item = null;
                        $valor = null;
    
                        $ventas = ControladorVentas::ctrMostrarVentas($item, $valor);
    
                          foreach ($ventas as $key => $valueCode) {
                                                     
                          }
    
                        $codigo = $valueCode["codigo"]  + 1;
                          
                        if ($condicion_recorrido == 'EXT'){
                            $cliente_id= '0';
                        }else{
                            $cliente_id=$respuestaCliente["id"];
                        }

                        $datos = array("id_vendedor"=>$value["id_asesor_interno"],
						                           "id_cliente"=>$cliente_id,
						                           "codigo"=>$codigo,
						                           "productos"=>$campo_vacio);

			                  $ultimoIdInsertado = ModeloVentas::mdlIngresarVenta1($tabla, $datos);

                        

                        $tabla_editar1="cliente_proforma";


                        $datos_editar = array("id_cliente_proforma"=>$value["id"],
						                                  "id_actividad"=>$ultimoIdInsertado);

			                  $respuesta = ModeloVentas::mdlEditarVenta1($tabla_editar1, $datos_editar);

                        $id_actividad= $ultimoIdInsertado;

                        }else{

                          $id_actividad= $value["id_actividad"];
                        }                       
                        
                        $numCotizaciones = ControladorVentas::ctrCotizacionesCliente($_SESSION["usuario"],$respuestaCliente["cedula"] );

                        if ($condicion_recorrido == 'EXT'){

                          echo '<button class="btn btn-warning btnEditarRecorrido" idVenta="'.$id_actividad.'" actividadRealizada="'.$valor2.'" numeroCotizacion="'.$value["cotizacion"].'" idRecorrido="'.$idRecorrido.'"><i class="fa fa-pencil"></i></button>';

                        }else{

                          echo '<button class="btn btn-warning btnEditarVenta" id_session = "'.$_SESSION["id"].'" id_vendedor = "'.$value["id_asesor_interno"].'" idVenta="'.$id_actividad.'" actividadRealizada="'.$valor2.'" numeroCotizacion="'.$value["cotizacion"].'" idAlmacen="'.$value["id_almacen"].'"numCotizaciones="'.$numCotizaciones["num"].'" cotizaciones="'.$numCotizaciones["cotizaciones"].'"><i class="fa fa-pencil"></i></button>';

                          echo '<span class="input-group-addon"><button class="btnLeerDatos" data-toggle="modal" data-target="#modalRelacionarCotizacion" idCliProforma="'.$value["id"].'" idAlmacen="'.$value["id_almacen"].'"></i> Relacionar</button></span>';                   

                        }

                      }


                      if($_SESSION["perfil"] == "Administrador" ){
                        
                        if ($condicion_recorrido == 'EXT'){

                          echo '<button class="btn btn-warning btnEditarRecorrido" idVenta="'.$value["id_actividad"].'" actividadRealizada="'.$valor2.'" numeroCotizacion="'.$value["cotizacion"].'" idRecorrido="'.$idRecorrido.'"><i class="fa fa-pencil"></i></button>';

                        }else{

                          echo '<button class="btn btn-warning btnEditarVenta" id_session = "0" id_vendedor = "0" idVenta="'.$value["id_actividad"].'" actividadRealizada="'.$valor2.'" numeroCotizacion="'.$value["cotizacion"].'" idAlmacen="'.$value["id_almacen"].'"><i class="fa fa-pencil"></i></button>

                          <button class="btn btn-danger btnEliminarVenta" idVenta="'.$value["id_actividad"].'"><i class="fa fa-times"></i></button>';

                        }

                    }

                    echo '</div>  

                  </td>

                </tr>';   
            }

        ?>
               
        </tbody>

       </table>

       <?php

      $eliminarVenta = new ControladorVentas();
      $eliminarVenta -> ctrEliminarVenta();

      ?>
       

      </div>

    </div>

  </section>


</div>


<div id="modalRelacionarCotizacion" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Relacionar Cotización</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-usd"></i></span> 

                <input type="text" class="form-control input-lg" name="cotizacionRelacion" placeholder="Cotizacion a Relacionar" required>

                <input type="hidden" class="form-control input-lg" name="idCotizacion" id="idCotizacion">

                <input type="hidden" class="form-control input-lg" name="idAlmacen" id="idAlmacen">

                <input type="hidden" class="form-control input-lg" name="actividadRealizada" id="actividadRealizada" value="<?php echo $valor2 ?>">

              </div>

              <div class="input-group">
              
              <span class="input-group-addon"><i class="fa fa-ticket"></i></span> 

              <textarea class="form-control input-lg" name="motivoRelacion" placeholder="Motivo Relacion" rows="5" required></textarea>

            </div>

            </div>

  
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Relacionar</button>

        </div>

      </form>
        <?php

        $crearCliente = new ControladorClientes();
        $crearCliente -> ctrRelacionarCotizacion();

        ?>

    </div>

  </div>

</div>
