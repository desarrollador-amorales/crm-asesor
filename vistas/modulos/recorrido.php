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

            Recorridos

        </h1>

        <ol class="breadcrumb">

            <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

            <li class="active">Recorridos</li>

        </ol>

    </section>

    <section class="content">

        <div class="box">

            <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCliente">
          
          Agregar Cliente Recorrido

        </button>
        
        

            </div>

            <div class="box-body">

                <table class="table table-bordered table-striped dt-responsive tablas" width="100%">

                    <thead>

                        <tr>

                            <th style="width:10px">#</th>
                            <th>Obra</th>
                            <th>Calle Principal</th>
                            <th>Ciudad</th>
                            <th>Etapa</th>
                            <th>Arquitecto</th>
                            <th>Dueño Obra</th>
                            <th>Maestro Obra</th>
                            <th>Acciones</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php

        if($_SESSION["perfil"] == "Administrador"){
          $item = null;
          $valor = null;
        }else{
          $item = 'asesor';
          $valor = $_SESSION["usuario"];

        }

          $clientes = ControladorClientes::ctrMostrarClientesRecorrido($item, $valor);

          foreach ($clientes as $key => $value) {
            

            echo '<tr>

                    <td>'.($key+1).'</td>

                    <td>'.$value["obra"].'</td>

                    <td>'.$value["calle_principal"].'</td>

                    <td>'.$value["ciudad"].'</td>

                    <td>'.$value["etapa"].'</td>

                    <td>'.$value["nombre_arq"].' '.$value["apellido_arq"].'</td>   
                    
                    <td>'.$value["nombre_obra"].' '.$value["apellido_obra"].'</td>  
                    
                    <td>'.$value["nombre_maes_obr"].' '.$value["apellido_maes_obr"].'</td>  

                    <td>

                      <div class="btn-group">
                          
                        <button class="btn btn-warning btnEditarClienteRecorrido" data-toggle="modal" data-target="#modalEditarCliente" idCliente="'.$value["id"].'"><i class="fa fa-pencil"></i></button>';

                      if($_SESSION["perfil"] == "Administrador"){

                          echo '<button class="btn btn-danger btnEliminarClienteRecorrido" idCliente="'.$value["id"].'"><i class="fa fa-times"></i></button>';

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

                <h4 class="modal-title">Agregar Cliente Recorrido</h4>

            </div>

                <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

                <div class="modal-body">

                    <div class="box-body">

                        <!-- ENTRADA PARA LA OBRA -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-check-circle-o"></i></span>

                                <input type="text" class="form-control input-lg" name="nuevoObra"
                                    placeholder="Obra" required>

                            </div>

                        </div>

                        <!-- ENTRADA PARA LA CALLE PRINCIPAL -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-address-card"></i></span>

                                <input type="text" class="form-control input-lg" name="nuevoCallePrincipal"
                                    placeholder="Ingresar Calle Principal" required>

                            </div>

                        </div>

                        
                        <!-- ENTRADA PARA LA CALLE SECUNDARIA -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-address-card"></i></span>

                                <input type="text" class="form-control input-lg" name="nuevoCalleSecundaria"
                                    placeholder="Ingresar Calle Secundaria" required>

                            </div>

                        </div>


                        <!-- ENTRADA PARA EL SECTOR -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>

                                <input type="text" class="form-control input-lg" name="nuevaSector"
                                    placeholder="Ingresar Sector" required>

                            </div>

                        </div>

                        <!-- ENTRADA PARA LA CIUDAD -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-globe"></i></span>

                                <input type="text" class="form-control input-lg" name="nuevaCiudad"
                                    placeholder="Ingresar Ciudad" required>

                            </div>

                        </div>

                        <!-- ENTRADA PARA LA OBSERVACION -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-comment"></i></span>

                                <textarea type="text" class="form-control input-lg" name="nuevaObservacion"
                                    placeholder="Ingresar Observacion" required></textarea>

                            </div>

                        </div>


                        <!-- ENTRADA PARA ETAPA -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-check"></i></span>

                                <select name="etapa" class="form-control input-lg">
                                    <option selected value="">--ETAPA--</option>
                                    <option value="Cimientos">Cimientos</option>
                                    <option value="Obra Gris">Obra Gris</option>
                                    <option value="Acabados">Acabados</option>
                                </select>

                            </div>

                        </div>

                        <!-- ENTRADA PARA LA UBICACION -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>

                                <input type="text" class="form-control input-lg" name="nuevaUbicacion"
                                    placeholder="Ingresar Ubicacion" required>

                            </div>

                        </div>

                        <br>

                       <!-- ENTRADA PARA NOMBRE DEL ARQ -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                <input type="text" class="form-control input-lg" name="nuevaNomArq"
                                    placeholder="Ingresar Nombre Arquitecto">

                            </div>

                        </div>

                      <!-- ENTRADA PARA APELLIDO DEL ARQ -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                <input type="text" class="form-control input-lg" name="nuevaApeArq"
                                    placeholder="Ingresar Apellido Arquitecto">

                            </div>

                        </div>

                     <!-- ENTRADA PARA EL NUMERO TELF ARQ -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                                <input type="text" class="form-control input-lg" name="nuevoTelefonoArq"
                                    placeholder="Ingresar Nro Celular Arq." data-inputmask="'mask':'(999) 999-9999'" data-mask>


                            </div>

                        </div>

                        <br>

                         <!-- ENTRADA PARA NOMBRE DEL DUENO OBRA -->

                         <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                <input type="text" class="form-control input-lg" name="nuevaNomObra"
                                    placeholder="Ingresar Nombre Dueño Obra">

                            </div>

                          </div>

                            <!-- ENTRADA PARA APELLIDO DEL DUENO OBRA -->

                            <div class="form-group">

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                    <input type="text" class="form-control input-lg" name="nuevaApeObra"
                                        placeholder="Ingresar Apellido Dueño Obra">

                                </div>

                            </div>

                            <!-- ENTRADA PARA EL NUMERO TELF DUENO OBRA -->

                            <div class="form-group">

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                                    <input type="text" class="form-control input-lg" name="nuevoTelefonoObra"
                                        placeholder="Ingresar Nro Celular Dueño Obra" data-inputmask="'mask':'(999) 999-9999'" data-mask>

                                </div>

                            </div>
                     <br>

                               <!-- ENTRADA PARA NOMBRE DEL MAESTRO OBRA -->

                                <div class="form-group">

                                    <div class="input-group">

                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                        <input type="text" class="form-control input-lg" name="nuevaNomMaes"
                                            placeholder="Ingresar Maestro Obra">

                                    </div>

                                </div>

                                <!-- ENTRADA PARA APELLIDO DEL MAESTRO OBRA -->

                                <div class="form-group">

                                    <div class="input-group">

                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                        <input type="text" class="form-control input-lg" name="nuevaApeMaes"
                                            placeholder="Ingresar Apellido Maestro Obra">

                                    </div>

                                </div>

                                <!-- ENTRADA PARA EL NUMERO TELF MAESTRO OBRA -->

                                <div class="form-group">

                                    <div class="input-group">

                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                                        <input type="text" class="form-control input-lg" name="nuevoTelefonoMaes"
                                            placeholder="Ingresar Nro Celular Maestro Obra" data-inputmask="'mask':'(999) 999-9999'" data-mask>

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
        $crearCliente -> ctrCrearClienteRecorrido();

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

                        <!-- ENTRADA PARA LA OBRA -->

                        <div class="form-group">

                            <div class="input-group">

                            <input type="hidden" id="idCliente" name="idCliente">

                            <span class="input-group-addon"><i class="fa fa-check-circle-o"></i></span> 
                            <input type="text" class="form-control input-lg" name="editarObra" id="editarObra">

                            </div>

                        </div>

                <!-- ENTRADA PARA LA CALLE PRINCIPAL -->

                   <div class="form-group">

                    <div class="input-group">

                        <span class="input-group-addon"><i class="fa fa-address-card"></i></span>

                        <input type="text" class="form-control input-lg" name="editarCallePrincipal" id="editarCallePrincipal"
                            placeholder="Ingresar Calle Principal" required>

                    </div>

                    </div>


                    <!-- ENTRADA PARA LA CALLE SECUNDARIA -->

                    <div class="form-group">

                    <div class="input-group">

                        <span class="input-group-addon"><i class="fa fa-address-card"></i></span>

                        <input type="text" class="form-control input-lg" name="editarCalleSecundaria" id="editarCalleSecundaria"
                            placeholder="Ingresar Calle Secundaria" required>

                    </div>

                    </div>


                    <!-- ENTRADA PARA EL SECTOR -->

                    <div class="form-group">

                    <div class="input-group">

                        <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>

                        <input type="text" class="form-control input-lg" name="editarSector" id="editarSector"
                            placeholder="Ingresar Sector" required>

                    </div>

                    </div>

                    <!-- ENTRADA PARA LA CIUDAD -->

                    <div class="form-group">

                    <div class="input-group">

                        <span class="input-group-addon"><i class="fa fa-globe"></i></span>

                        <input type="text" class="form-control input-lg" name="editarCiudad" id="editarCiudad"
                            placeholder="Ingresar Ciudad" required>

                    </div>

                    </div>

                    <!-- ENTRADA PARA LA OBSERVACION -->

                    <div class="form-group">

                    <div class="input-group">

                        <span class="input-group-addon"><i class="fa fa-comment"></i></span>

                        <textarea type="text" class="form-control input-lg" name="editarObservacion" id="editarObservacion"
                            placeholder="Ingresar Observacion" required></textarea>

                    </div>

                    </div>


                    <!-- ENTRADA PARA ETAPA -->

                    <div class="form-group">

                    <div class="input-group">

                        <span class="input-group-addon"><i class="fa fa-check"></i></span>

                        <select name="editarEtapa" id="editarEtapa" class="form-control input-lg">
                            <option selected value="">--ETAPA--</option>
                            <option value="Cimientos">Cimientos</option>
                            <option value="Obra Gris">Obra Gris</option>
                            <option value="Acabados">Acabados</option>
                        </select>

                    </div>

                    </div>

                    <!-- ENTRADA PARA LA UBICACION -->

                    <div class="form-group">

                    <div class="input-group">

                        <span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>

                        <input type="text" class="form-control input-lg" name="editarUbicacion" id="editarUbicacion"
                            placeholder="Ingresar Ubicacion" required>

                    </div>

                    </div>

                    <br>

                    <!-- ENTRADA PARA NOMBRE DEL ARQ -->

                    <div class="form-group">

                    <div class="input-group">

                        <span class="input-group-addon"><i class="fa fa-user"></i></span>

                        <input type="text" class="form-control input-lg" name="editarNomArq" id="editarNomArq"
                            placeholder="Ingresar Nombre Arquitecto">

                    </div>

                    </div>

                    <!-- ENTRADA PARA APELLIDO DEL ARQ -->

                    <div class="form-group">

                    <div class="input-group">

                        <span class="input-group-addon"><i class="fa fa-user"></i></span>

                        <input type="text" class="form-control input-lg" name="editarApeArq" id="editarApeArq"
                            placeholder="Ingresar Apellido Arquitecto">

                    </div>

                    </div>

                    <!-- ENTRADA PARA EL NUMERO TELF ARQ -->

                    <div class="form-group">

                    <div class="input-group">

                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                        <input type="text" class="form-control input-lg" name="editarTelefonoArq" id="editarTelefonoArq"
                            placeholder="Ingresar Nro Celular Arq." data-inputmask="'mask':'(999) 999-9999'" data-mask>


                    </div>

                    </div>

                    <br>

                    <!-- ENTRADA PARA NOMBRE DEL DUENO OBRA -->

                    <div class="form-group">

                    <div class="input-group">

                        <span class="input-group-addon"><i class="fa fa-user"></i></span>

                        <input type="text" class="form-control input-lg" name="editarNomObra" id="editarNomObra"
                            placeholder="Ingresar Nombre Dueño Obra">

                    </div>

                    </div>

                    <!-- ENTRADA PARA APELLIDO DEL DUENO OBRA -->

                    <div class="form-group">

                        <div class="input-group">

                            <span class="input-group-addon"><i class="fa fa-user"></i></span>

                            <input type="text" class="form-control input-lg" name="editarApeObra" id="editarApeObra"
                                placeholder="Ingresar Apellido Dueño Obra">

                        </div>

                    </div>

                    <!-- ENTRADA PARA EL NUMERO TELF DUENO OBRA -->

                    <div class="form-group">

                        <div class="input-group">

                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                            <input type="text" class="form-control input-lg" name="editarTelefonoObra" id="editarTelefonoObra"
                                placeholder="Ingresar Nro Celular Dueño Obra" data-inputmask="'mask':'(999) 999-9999'" data-mask>

                        </div>

                    </div>
                    <br>

                    <!-- ENTRADA PARA NOMBRE DEL MAESTRO OBRA -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                <input type="text" class="form-control input-lg" name="editarNomMaes" id="editarNomMaes"
                                    placeholder="Ingresar Maestro Obra">

                            </div>

                        </div>

                        <!-- ENTRADA PARA APELLIDO DEL MAESTRO OBRA -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                <input type="text" class="form-control input-lg" name="editarApeMaes" id="editarApeMaes"
                                    placeholder="Ingresar Apellido Maestro Obra">

                            </div>

                        </div>

                        <!-- ENTRADA PARA EL NUMERO TELF MAESTRO OBRA -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                                <input type="text" class="form-control input-lg" name="editarTelefonoMaes"  id="editarTelefonoMaes"

                                    placeholder="Ingresar Nro Celular Maestro Obra" data-inputmask="'mask':'(999) 999-9999'" data-mask>

                            </div>

                        </div>



                    </div>

                </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

                <div class="modal-footer">

                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

                <button type="submit" class="btn btn-primary">Guardar cambios</button>

                </div>

            </form>

            <?php

        $editarCliente = new ControladorClientes();
        $editarCliente -> ctrEditarClienteRecorrido();


      ?>



        </div>

    </div>

</div>

<?php

  $eliminarCliente = new ControladorClientes();
  $eliminarCliente -> ctrEliminarClienteRecorrido();

?>