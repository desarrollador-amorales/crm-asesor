<?php

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
      
    Cotizaciones Perdidas
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Cotizaciones Perdidas</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

         <button type="button" class="btn btn-default" id="daterange3-btn">
           
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
           <th>Asesor</th>
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

          $valor2 = 3;

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

          foreach ($respuesta as $key => $value) {
           
           echo '<tr>

                  <td>'.($key+1).'</td>

                  <td class="td_cotizacion">'.$value["cotizacion"].'</td>';

                  $itemCliente = "id";
                  $valorCliente = $value["id_cliente"];

                  $respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

                  echo '<td>'.$respuestaCliente["nombre"].'</td>';

                  echo '<td>'.$value["nombre_almacen"].'</td>

                  <td>'.$value["nombre"].'</td>

                  <td>'.$value["fecha_cotizacion"].'</td>

                  <td>

                    <div class="btn-group">



                      <!--<button class="btn btn-success btnImprimirTicket" codigoVenta="'.$value["cotizacion"].'">

                        <i class="fa fa-print">Ticket</i>

                      </button>
                        
                      <button class="btn btn-info btnImprimirFactura" codigoVenta="'.$value["cotizacion"].'">

                        <i class="fa fa-print"></i>PDF

                      </button> -->' ; 

                      if($_SESSION["perfil"] == "Vendedor" ){

                        echo '<button class="btn btn-warning btnEditarVenta" id_session = "'.$_SESSION["id"].'" id_vendedor = "'.$value["id_asesor_interno"].'" idVenta="'.$value["id_actividad"].'" actividadRealizada="'.$valor2.'" numeroCotizacion="'.$value["cotizacion"].'" idAlmacen="'.$value["id_almacen"].'"><i class="fa fa-pencil"></i></button>';                     
  
                      }


                      if($_SESSION["perfil"] == "Administrador" ){

                      echo '<button class="btn btn-warning btnEditarVenta" id_session = "0" id_vendedor = "0" idVenta="'.$value["id_actividad"].'" actividadRealizada="'.$valor2.'" numeroCotizacion="'.$value["cotizacion"].'" idAlmacen="'.$value["id_almacen"].'"><i class="fa fa-pencil"></i></button>';

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



