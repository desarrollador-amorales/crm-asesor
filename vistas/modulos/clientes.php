<?php



if($_SESSION["perfil"] == "Especial"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}




?>

<div class="content-wrapper">

    <section class="content-header">

        <h1>

            Administrar Clientes

        </h1>

        <ol class="breadcrumb">

            <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

            <li class="active">Administrar clientes</li>

        </ol>

    </section>

    <section class="content">

        <div class="box">

            <div class="box-header with-border">

                <?php
        if($_SESSION["perfil"] == "Administrador"){
         echo '
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCliente">
          
          Agregar cliente

        </button> ';
        }
        ?>

            </div>

            <div class="box-body">

                <table class="table table-bordered table-striped dt-responsive tablas" width="100%">

                    <thead>

                        <tr>

                            <th style="width:10px">#</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Asesor</th>
                            <th>Fecha Creacion</th>
                            <th>Acciones</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php

        if($_SESSION["perfil"] == "Administrador"){
          $item = 'pasado';
          $valor = '1';
        }else{
          $item = 'id_asesor';
          $valor = $_SESSION["usuario"];

        }

          $clientes = ControladorClientes::ctrMostrarClientes($item, $valor);

          foreach ($clientes as $key => $value) {
            

            echo '<tr>

                    <td>'.($key+1).'</td>

                    <td>'.$value["nombre"].'</td>

                    <td>'.$value["email"].'</td>

                    <td>'.$value["telefono"].'</td>

                    <td>'.$value["direccion"].'</td>

                    <td>'.$value["id_asesor"].'</td>

                    <td>'.$value["fecha_nacimiento"].'</td>             

                    <td>

                      <div class="btn-group">
                          
                        <button class="btn btn-warning btnEditarCliente" data-toggle="modal" data-target="#modalEditarCliente" idCliente="'.$value["id"].'"><i class="fa fa-pencil"></i></button>';

                      if($_SESSION["perfil"] == "Administrador"){

                          echo '<button class="btn btn-danger btnEliminarCliente" idCliente="'.$value["id"].'"><i class="fa fa-times"></i></button>';

                      }

                      echo '</div>  

                    </td>

                  </tr>';
          
            }
        ?>

                    </tbody>

                </table>

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

                    <h4 class="modal-title">Agregar Cliente</h4>

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

                                <input type="text" class="form-control input-lg" name="nuevoCliente"
                                    placeholder="Ingresar nombre" required>

                                <!-- ENTRADA PARA LA CEDULA -->

                                <span class="input-group-addon"><i class="fa fa-key"></i></span>

                                <input type="text" class="form-control input-lg" name="nuevaCedula"
                                    placeholder="Ingresar cedula" required>

                            </div>

                        </div>

                        <!-- ENTRADA PARA EL EMAIL -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>

                                <input type="email" class="form-control input-lg" name="nuevoEmail"
                                    placeholder="Ingresar email" required>

                                <!-- ENTRADA PARA LA NUM. TELEFONO -->

                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                                <input type="text" class="form-control input-lg" name="nuevoTelefono"
                                    placeholder="Ingresar teléfono" data-inputmask="'mask':'(999) 999-9999'" data-mask
                                    required>


                            </div>

                        </div>


                        <!-- ENTRADA PARA LA DIRECCIÓN -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>

                                <input type="text" class="form-control input-lg" name="nuevaDireccion"
                                    placeholder="Ingresar dirección" required>

                            </div>

                        </div>

                        <!-- ENTRADA PARA LA FECHA -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                                <input type="date" class="form-control input-lg" name="nuevaFechaNacimiento"
                                    placeholder="Ingresar fecha" onfocus="(this.type='date')" required>

                                <!-- ENTRADA PARA EL ESTADO -->

                                <span class="input-group-addon"><i class="fa fa-check"></i></span>

                                <select name="estado" class="form-control input-lg">
                                    <option selected value="">--ESTADO--</option>
                                    <option value="Primer Contacto">Primer Contacto</option>
                                    <option value="Recorrido">Recorrido</option>
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Proformado">Proformado</option>
                                    <option value="Contrato">Contrato</option>
                                    <option value="Facturado">Facturado</option>
                                    <option value="Cuenta Caida">Cuenta Caida</option>
                                    <option value="Seguimiento">Seguimiento</option>
                                </select>

                            </div>

                        </div>

                        <!-- ENTRADA PARA COTIZACION -->
                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-file-o"></i></span>

                                <input type="text" class="form-control input-lg" name="nuevaCotizacion"
                                    placeholder="Ingresar Cotizacion">

                                <!-- ENTRADA PARA EL INTERES -->
                                <span class="input-group-addon"><i class="fa fa-eye"></i></span>

                                <select name="interes" class="form-control input-lg">
                                    <option selected value="">--INTERES--</option>
                                    <option value="Frio">Frío</option>
                                    <option value="Tibio">Tibio</option>
                                    <option value="Pendiente">Caliente</option>
                                    <option value="Proformado">Caliente a Futuro</option>
                                </select>

                            </div>

                        </div>

                        <!--ENTRADA PARA TIPO DE CLIENTE -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-users"></i></span>

                                <select name="tipo_cliente" id="tipo_cliente" class="form-control input-lg">
                                    <option selected value="">--TIPO CLIENTE--</option>
                                    <option value="Consumidor Final">Consumidor Final</option>
                                    <option value="Distribuidores">Distribuidores</option>
                                    <option value="Constructores">Constructores</option>
                                    <option value="Diseñadores">Diseñadores</option>
                                </select>
                            </div>
                        </div>

                        <!--ENTRADA PARA ALMACEN -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-users"></i></span>

                                <select name="nuevoAlmacen" id="nuevoAlmacen" class="form-control input-lg">
                                    <option selected value="">--ALMACEN--</option>
                                    <option value="DURAMAS CIA LTDA">DURAMAS CIA LTDA</option>
                                    <option value="ALM. CUENCA REMIGIO">ALM. CUENCA REMIGIO</option>
                                    <option value="ALM. GUAYAQUIL">ALM. GUAYAQUIL</option>
                                    <option value="ALM. QUITO">ALM. QUITO</option>
                                    <option value="ALM. AMBATO<">ALM. AMBATO</option>
                                    <option value="ALM. FABRICA DURAMAS">ALM. FABRICA DURAMAS</option>
                                    <option value="ALM. GUAY.DICENTRO">ALM. GUAY.DICENTRO</option>
                                    <option value="ALM. JUAN TANCA MARENGO">ALM. JUAN TANCA MARENGO</option>
                                    <option value="BODEGA SANGOLQUI">BODEGA SANGOLQUI</option>
                                    <option value="ALM. CUMBAYA">ALM. CUMBAYA</option>
                                    <option value="ALM. ORDOÑEZ LASSO">ALM. ORDOÑEZ LASSO</option>
                                    <option value="ALM. PLAZA PROYECTA">ALM. PLAZA PROYECTA</option>
                                </select>

                            </div>
                        </div>

                        <!-- ENTRADA PARA PRODUCTO COTIZADO -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-ticket"></i></span>

                                <input type="text" class="form-control input-lg" name="nuevoProductoCotizado"
                                    placeholder="Producto Cotizado" required>

                            </div>

                        </div>

                        <!-- ENTRADA PARA VALOR DE COTIZACION -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-money"></i></span>

                                <input type="text" class="form-control input-lg" name="nuevoValorCotizado"
                                    placeholder="Valor Cotizado" required>

                            </div>

                        </div>

                        <!-- ENTRADA PARA SEGUIMIENTO -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                                <input type="date" class="form-control input-lg" name="nuevaFechaSeguimiento"
                                    placeholder="Fecha Seguimiento" required>

                                <span class="input-group-addon"><i class="fa fa-check-square-o"></i></span>

                                <input type="number" class="form-control input-lg" name="nuevoContrato"
                                    placeholder="Contrato" required>

                                <span class="input-group-addon"><i class="fa fa-usd"></i></span>

                                <input type="text" class="form-control input-lg" name="nuevoFacturacion"
                                    placeholder="Facturacion" required>

                            </div>

                        </div>

                        <!-- ENTRADA PARA FECHA DE CIERRE -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                                <input type="date" class="form-control input-lg" name="nuevaFechaCierre"
                                    id="nuevaFechaCierre" placeholder="Fecha Cierre" required>

                            </div>

                        </div>

                        <!-- ENTRADA PARA OBSERVACIONES -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-file-o"></i></span>

                                <textarea type="text" class="form-control input-lg" name="nuevoObservaciones"
                                    placeholder="Observaciones" required></textarea>

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
MODAL EDITAR CLIENTE
======================================-->

<div id="modalEditarCliente" class="modal fade" role="dialog">

    <div class="modal-dialog">

        <div class="modal-content">

            <form role="form" method="post">

                <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

                <div class="modal-header" style="background:#3c8dbc; color:white">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                    <h4 class="modal-title">Informacion Cliente</h4>

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

                                <input type="text" class="form-control input-lg" name="editarCliente" id="editarCliente"
                                    required>
                                <input type="hidden" id="idCliente" name="idCliente">

                                <!-- ENTRADA PARA LA CEDULA -->
                                <?php
                    if($_SESSION["perfil"] == "Administrador"){
                            echo '<span class="input-group-addon"><i class="fa fa-key"></i></span> 
                            <input type="text" class="form-control input-lg" name="editarCedula" id="editarCedula">';      
                    }
                 ?>

                            </div>

                        </div>

                        <!-- ENTRADA PARA EL EMAIL -->

                        <div class="form-group">

                            <div class="input-group">

                                <?php
              if($_SESSION["perfil"] == "Administrador"){
                echo '
              
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span> 

                <input type="email" class="form-control input-lg" name="editarEmail" id="editarEmail">
                ';
              }
                ?>

                                <!-- ENTRADA PARA EL TELÉFONO -->

                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                                <input type="text" class="form-control input-lg" name="editarTelefono"
                                    id="editarTelefono" data-inputmask="'mask':'(999) 999-9999'" data-mask required>

                            </div>

                        </div>



                        <!-- ENTRADA PARA LA DIRECCIÓN -->

                        <?php
        if($_SESSION["perfil"] == "Administrador"){
         echo '            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 

                <input type="text" class="form-control input-lg" name="editarDireccion" id="editarDireccion" >

              </div>

            </div>
            ';
        }
            ?>

                        <!-- ENTRADA PARA LA FECHA  -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                                <input type="date" class="form-control input-lg" name="editarFechaNacimiento"
                                    id="editarFechaNacimiento" required>

                                <!-- ENTRADA PARA EL ESTADO -->

                                <span class="input-group-addon"><i class="fa fa-check"></i></span>

                                <select name="estado" id="estado" class="form-control input-lg">
                                    <option value="">ESTADO</option>
                                    <option value="Primer Contacto">Primer Contacto</option>
                                    <option value="Recorrido">Recorrido</option>
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Proformado">Proformado</option>
                                    <option value="Contrato">Contrato</option>
                                    <option value="Facturado">Facturado</option>
                                    <option value="Cuenta Caida">Cuenta Caida</option>
                                    <option value="Seguimiento">Seguimiento</option>
                                </select>

                            </div>

                        </div>

                        <!-- ENTRADA PARA COTIZACION -->
                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-file-o"></i></span>

                                <input type="text" class="form-control input-lg" name="editarCotizacion"
                                    id="editarCotizacion" placeholder="Ingresar Cotizacion">

                                <!-- ENTRADA PARA EL INTERES -->

                                <span class="input-group-addon"><i class="fa fa-eye"></i></span>

                                <select name="interes" id="interes" class="form-control input-lg">
                                    <option selected value="">INTERES</option>
                                    <option value="Frio">Frío</option>
                                    <option value="Tibio">Tibio</option>
                                    <option value="Caliente">Caliente</option>
                                    <option value="Caliente a Futuro">Caliente a Futuro</option>
                                </select>

                            </div>

                        </div>

                        <!--ENTRADA PARA TIPO DE CLIENTE -->


                        <?php
        if($_SESSION["perfil"] == "Administrador"){
         echo ' 
          <div class="form-group">

            <div class="input-group">

            <span class="input-group-addon"><i class="fa fa-users"></i></span> 

              <select name="tipoCliente" id="tipoCliente" class="form-control input-lg" > 
                <option selected value="">TIPO CLIENTE</option>
                <option value="Consumidor Final">Consumidor Final</option>
                <option value="Distribuidores">Distribuidores</option>
                <option value="Constructores">Constructores</option>
                <option value="Diseñadores">Diseñadores</option>
              </select>

              </div>
          </div> ' ;

        }
        ?>

                        <!--ENTRADA PARA ALMACEN -->

                        <?php
        if($_SESSION["perfil"] == "Administrador"){
         echo ' 
        <div class="form-group">

          <div class="input-group">

          <span class="input-group-addon"><i class="fa fa-users"></i></span> 

            <select name="editarAlmacen" id="editarAlmacen" class="form-control input-lg" > 
              <option selected value="">--ALMACEN--</option>
              <option value="DURAMAS CIA LTDA">DURAMAS CIA LTDA</option>
              <option value="ALM. CUENCA REMIGIO">ALM. CUENCA REMIGIO</option>
              <option value="ALM. GUAYAQUIL">ALM. GUAYAQUIL</option>
              <option value="ALM. QUITO">ALM. QUITO</option>
              <option value="ALM. AMBATO<">ALM. AMBATO</option>
              <option value="ALM. FABRICA DURAMAS">ALM. FABRICA DURAMAS</option>
              <option value="ALM. GUAY.DICENTRO">ALM. GUAY.DICENTRO</option>
              <option value="ALM. JUAN TANCA MARENGO">ALM. JUAN TANCA MARENGO</option>
              <option value="BODEGA SANGOLQUI">BODEGA SANGOLQUI</option>
              <option value="ALM. CUMBAYA">ALM. CUMBAYA</option>
              <option value="ALM. ORDOÑEZ LASSO">ALM. ORDOÑEZ LASSO</option>
              <option value="ALM. PLAZA PROYECTA">ALM. PLAZA PROYECTA</option>
            </select>
            </div>
      </div>';
        }
        ?>

                        <!-- ENTRADA PARA PRODUCTO COTIZADO -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-ticket"></i></span>

                                <input type="text" class="form-control input-lg" name="editarProductoCotizado"
                                    id="editarProductoCotizado" placeholder="Producto Cotizado" required>

                            </div>

                        </div>

                        <!-- ENTRADA PARA VALOR COTIZADO -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-money"></i></span>

                                <input type="text" class="form-control input-lg" name="editarValorCotizado"
                                    id="editarValorCotizado" placeholder="Valor Cotizado" required>

                            </div>

                        </div>

                        <!-- ENTRADA PARA SEGUIMIENTO -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                                <input type="date" class="form-control input-lg" name="editarFechaSeguimiento"
                                    id="editarFechaSeguimiento" placeholder="Fecha Seguimiento" required>

                                <span class="input-group-addon"><i class="fa fa-check-square-o"></i></span>

                                <input type="number" class="form-control input-lg" name="editarContrato"
                                    id="editarContrato" placeholder="Contrato" required>

                                <span class="input-group-addon"><i class="fa fa-usd"></i></span>

                                <input type="text" class="form-control input-lg" name="editarFacturacion"
                                    id="editarFacturacion" placeholder="Facturacion" required>

                            </div>

                        </div>


                        <?php
        if($_SESSION["perfil"] == "Administrador"){
         echo ' 
            <!-- ENTRADA PARA FECHA DE CIERRE -->

            <div class="form-group">
              
              <div class="input-group">
              
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 

              <input type="date" class="form-control input-lg" name="editarFechaCierre" id="editarFechaCierre" placeholder="Fecha Cierre" >
              
              </div>

            </div> ';
        }
        ?>
                        <!-- ENTRADA PARA OBSERVACIONES -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-file-o"></i></span>

                                <textarea type="text" class="form-control input-lg" name="editarObservaciones"
                                    id="editarObservaciones" placeholder="Observaciones" required></textarea>

                            </div>

                        </div>



                    </div>

                </div>

                <!--=====================================
        PIE DEL MODAL
        ======================================-->

                <div class="modal-footer">

                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

                <?php

            if($_SESSION["perfil"] == "Administrador"){
                    echo '

                    <button type="submit" class="btn btn-primary">Guardar cambios</button>

                </div>

            </form>';

            }

            ?>

            <?php

        $editarCliente = new ControladorClientes();
        $editarCliente -> ctrEditarCliente();


      ?>



        </div>

    </div>

</div>

<?php

  $eliminarCliente = new ControladorClientes();
  $eliminarCliente -> ctrEliminarCliente();

?>