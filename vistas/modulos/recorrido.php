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
                            <th>Arquitecto</th>
                            <th>Celular</th>
                            <th>Dueño Obra</th>
                            <th>Celular</th>
                            <th>Maestro Obra</th>
                            <th>Celular</th>
                            <th>Ciudad</th>
                            <?php
                            if($_SESSION["perfil"] == "Administrador"){
                                echo '<th>Asesor</th>';
                                }
                            ?>
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

                    <td>'.$value["nombre_arq"].' '.$value["apellido_arq"].'</td>  
                    
                    <td>'.$value["celular_arq"].'</td>  
                    
                    <td>'.$value["nombre_obra"].' '.$value["apellido_obra"].'</td>  

                    <td>'.$value["celular_obra"].'</td> 
                    
                    <td>'.$value["nombre_maes_obr"].' '.$value["apellido_maes_obr"].'</td>

                    <td>'.$value["celular_maes_obr"].'</td>
                    
                    <td>'.$value["ciudad"].'</td>';


                    if($_SESSION["perfil"] == "Administrador"){
                        $tablaVendedor = "usuarios";
			            $item = "usuario";
			            $valor = $value["asesor"];

			            $traerVendedor = ModeloUsuarios::mdlMostrarUsuarios($tablaVendedor, $item, $valor);

                        echo '<td>'.$traerVendedor["nombre"].'</td>';
                    }


                    echo ' <td>

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
                                
                                <select name="nuevoObra" class="form-control input-lg" required>
                                    <option selected value="">--Obra--</option>
                                    <option value="Casa">Casa</option>
                                    <option value="Edificio">Edificio</option>
                                    <option value="Urbanizacion">Urbanizacion</option>
                                    <option value="Local Comercial">Local Comercial</option>
                                </select>

                            </div>

                        </div>

                        <!-- ENTRADA PARA LA CALLE PRINCIPAL -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-address-card"></i></span>

                                <input type="text" class="form-control input-lg" name="nuevoCallePrincipal"
                                    placeholder="Ingresar Nombre Obra">

                            </div>

                        </div>

                        
                        <!-- ENTRADA PARA LA CALLE SECUNDARIA -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-address-card"></i></span>

                                <input type="text" class="form-control input-lg" name="nuevoCalleSecundaria"
                                    placeholder="Ingresar Direccion" required>

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

                                <select name="nuevaCiudad" class="form-control input-lg" required>
                                    <option selected value="">--Ingresar Ciudad--</option>
                                    <?php  
                                    if ($_SESSION["ubicacion"] == 'Quito-6 Diciembre' || $_SESSION["ubicacion"] == 'Quito-Sangolqui' || $_SESSION["ubicacion"] == 'Quito-Cumbaya' ){

                                    echo 
                                    '<option value="Quito">Quito</option>
                                    <option value="Quito Sur">Quito Sur</option>
                                    <option value="Quito Centro">Quito Centro</option>
                                    <option value="Quito Norte">Quito Norte</option>
                                    <option value="Alangasi">Alangasi</option>
                                    <option value="Amaguaña">Amaguaña</option>
                                    <option value="Calacalí">Calacalí</option>
                                    <option value="Calderon">Calderon</option>
                                    <option value="Conocoto">Conocoto</option>
                                    <option value="Cumbayá">Cumbayá</option>
                                    <option value="Checa">Checa</option>
                                    <option value="El Quinche">El Quinche</option>
                                    <option value="Gualea">Gualea</option>
                                    <option value="Guagopolo">Guagopolo</option>
                                    <option value="Guayllabamba">Guayllabamba</option>
                                    <option value="La Merced">La Merced</option>
                                    <option value="Llano Chico">Llano Chico</option>
                                    <option value="Llano Grande">Llano Grande</option>
                                    <option value="Tumbaco">Tumbaco</option>
                                    <option value="Pifo">Pifo</option>
                                    <option value="Puembo">Puembo</option>
                                    <option value="Pintag">Pintag</option>
                                    <option value="Tabacundo">Tabacundo</option>
                                    <option value="Los Bancos">Los Bancos</option>
                                    <option value="Pedro Vicente Maldonado">Pedro Vicente Maldonado</option>
                                    <option value="Puerto Quito">Puerto Quito</option>
                                    <option value="Ibarra">Ibarra</option>
                                    <option value="Otavalo">Otavalo</option>
                                    <option value="San Pablo">San Pablo</option>
                                    <option value="Sto Domingo">Sto Domingo</option>
                                    <option value="Tonsupa">Tonsupa</option>
                                    <option value="Esmeraldas">Esmeraldas</option>
                                    <option value="Atacames">Atacames</option>
                                    <option value="Otros">Otros</option>';

                                    }else{
                                    echo 
                                    '<option value="Cuenca">Cuenca</option>
                                    <option value="Azogues">Azogues</option>
                                    <option value="Gualaceo">Gualaceo</option>
                                    <option value="Paute">Paute</option>
                                    <option value="Chordeleg">Chordeleg</option>
                                    <option value="Loja">Loja</option>
                                    <option value="Canar">Cañar</option>
                                    <option value="Machala">Machala</option>
                                    <option value="Otros">Otros</option>';
                                    }
                                    
                                    ?>
                                    
                                </select>

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

                                <select name="etapa" class="form-control input-lg" required>
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

                        <!-- ENTRADA PARA CONTACTO1 -->

                        <div class="form-group">

                        <div class="input-group">

                            <span class="input-group-addon"><i class="fa fa-check"></i></span>

                            <select name="contacto1" class="form-control input-lg">
                                <option selected value="">--CONTACTO--</option>
                                <option value="Profesional">Profesional</option>
                                <option value="Dueno">Dueño</option>
                                <option value="Maestro">Maestro</option>
                            </select>

                        </div>

                        </div>

                       <!-- ENTRADA PARA NOMBRE DEL CONTACTO1 -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                <input type="text" class="form-control input-lg" name="nuevaNom1"
                                    placeholder="Ingresar Nombre">

                            </div>

                        </div>

                      <!-- ENTRADA PARA APELLIDO DEL CONTACTO1 -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                <input type="text" class="form-control input-lg" name="nuevaApe1"
                                    placeholder="Ingresar Apellido">

                            </div>

                        </div>

                     <!-- ENTRADA PARA EL NUMERO TELF CONTACTO1 -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                                <input type="text" class="form-control input-lg" name="nuevoTelefono1"
                                    placeholder="Ingresar Nro Celular.">


                            </div>

                        </div>

                        <br>


                        <!-- ENTRADA PARA CONTACTO2 -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-check"></i></span>

                                <select name="contacto2" class="form-control input-lg">
                                    <option selected value="">--CONTACTO--</option>
                                    <option value="Profesional">Profesional</option>
                                    <option value="Dueno">Dueño</option>
                                    <option value="Maestro">Maestro</option>
                                </select>

                            </div>

                        </div>

                         <!-- ENTRADA PARA NOMBRE DEL CONTACTO2 -->

                         <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                <input type="text" class="form-control input-lg" name="nuevaNom2"
                                    placeholder="Ingresar Nombre">

                            </div>

                          </div>

                            <!-- ENTRADA PARA APELLIDO DEL CONTACTO2 -->

                            <div class="form-group">

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                    <input type="text" class="form-control input-lg" name="nuevaApe2"
                                        placeholder="Ingresar Apellido">

                                </div>

                            </div>

                            <!-- ENTRADA PARA EL NUMERO TELF CONTACTO2 -->

                            <div class="form-group">

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                                    <input type="text" class="form-control input-lg" name="nuevoTelefono2"
                                        placeholder="Ingresar Nro Celular">

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
        
                            <select name="editarObra" id="editarObra" class="form-control input-lg" required>
                            <option selected value="">--Obra--</option>
                            <option value="Casa">Casa</option>
                            <option value="Edificio">Edificio</option>
                            <option value="Urbanizacion">Urbanizacion</option>
                            <option value="Local Comercial">Local Comercial</option>
                        </select>

                            </div>

                        </div>

                <!-- ENTRADA NOMBRE OBRA -->

                   <div class="form-group">

                    <div class="input-group">

                        <span class="input-group-addon"><i class="fa fa-address-card"></i></span>

                        <input type="text" class="form-control input-lg" name="editarCallePrincipal" id="editarCallePrincipal"
                            placeholder="Ingresar Nombre Obra">

                    </div>

                    </div>


                    <!-- ENTRADA PARA LA DIRECCION -->

                    <div class="form-group">

                    <div class="input-group">

                        <span class="input-group-addon"><i class="fa fa-address-card"></i></span>

                        <input type="text" class="form-control input-lg" name="editarCalleSecundaria" id="editarCalleSecundaria"
                            placeholder="Ingresar Direccion" required>

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

                        <select name="editarCiudad" id="editarCiudad" class="form-control input-lg" required>
                                <option selected value="">--Ingresar Ciudad--</option>
                                <?php  
                                    if ($_SESSION["ubicacion"] == 'Quito-6 Diciembre' || $_SESSION["ubicacion"] == 'Quito-Sangolqui' || $_SESSION["ubicacion"] == 'Quito-Cumbaya' ){

                                    echo 
                                    '<option value="Quito">Quito</option>
                                    <option value="Quito Sur">Quito Sur</option>
                                    <option value="Quito Centro">Quito Centro</option>
                                    <option value="Quito Norte">Quito Norte</option>
                                    <option value="Alangasi">Alangasi</option>
                                    <option value="Amaguaña">Amaguaña</option>
                                    <option value="Calacalí">Calacalí</option>
                                    <option value="Calderon">Calderon</option>
                                    <option value="Conocoto">Conocoto</option>
                                    <option value="Cumbayá">Cumbayá</option>
                                    <option value="Checa">Checa</option>
                                    <option value="El Quinche">El Quinche</option>
                                    <option value="Gualea">Gualea</option>
                                    <option value="Guagopolo">Guagopolo</option>
                                    <option value="Guayllabamba">Guayllabamba</option>
                                    <option value="La Merced">La Merced</option>
                                    <option value="Llano Chico">Llano Chico</option>
                                    <option value="Llano Grande">Llano Grande</option>
                                    <option value="Tumbaco">Tumbaco</option>
                                    <option value="Pifo">Pifo</option>
                                    <option value="Puembo">Puembo</option>
                                    <option value="Pintag">Pintag</option>
                                    <option value="Tabacundo">Tabacundo</option>
                                    <option value="Los Bancos">Los Bancos</option>
                                    <option value="Pedro Vicente Maldonado">Pedro Vicente Maldonado</option>
                                    <option value="Puerto Quito">Puerto Quito</option>
                                    <option value="Ibarra">Ibarra</option>
                                    <option value="Otavalo">Otavalo</option>
                                    <option value="San Pablo">San Pablo</option>
                                    <option value="Sto Domingo">Sto Domingo</option>
                                    <option value="Tonsupa">Tonsupa</option>
                                    <option value="Esmeraldas">Esmeraldas</option>
                                    <option value="Atacames">Atacames</option>
                                    <option value="Otros">Otros</option>';

                                    }else{
                                    echo 
                                    '<option value="Cuenca">Cuenca</option>
                                    <option value="Azogues">Azogues</option>
                                    <option value="Gualaceo">Gualaceo</option>
                                    <option value="Paute">Paute</option>
                                    <option value="Chordeleg">Chordeleg</option>
                                    <option value="Loja">Loja</option>
                                    <option value="Canar">Cañar</option>
                                    <option value="Machala">Machala</option>
                                    <option value="Otros">Otros</option>';
                                    }
                                    
                                    ?>
                        </select>

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

                        <select name="editarEtapa" id="editarEtapa" class="form-control input-lg" required>
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

                    <!-- ENTRADA PARA ESCOGER CONTACTO1 -->

                    <div class="form-group">

                    <div class="input-group">

                        <span class="input-group-addon"><i class="fa fa-check"></i></span>

                        <select name="editarcontacto1" id="editarcontacto1" class="form-control input-lg">
                            <option selected value="">--CONTACTO--</option>
                            <option value="Profesional">Profesional</option>
                            <option value="Dueno">Dueño</option>
                            <option value="Maestro">Maestro</option>
                        </select>

                    </div>

                    </div>

                    <!-- ENTRADA PARA NOMBRE DEL CONTACTO1 -->

                    <div class="form-group">

                    <div class="input-group">

                        <span class="input-group-addon"><i class="fa fa-user"></i></span>

                        <input type="text" class="form-control input-lg" name="editarNom1" id="editarNom1"
                            placeholder="Ingresar Nombre">

                    </div>

                    </div>

                    <!-- ENTRADA PARA APELLIDO DEL CONTACTO1 -->

                    <div class="form-group">

                    <div class="input-group">

                        <span class="input-group-addon"><i class="fa fa-user"></i></span>

                        <input type="text" class="form-control input-lg" name="editarApe1" id="editarApe1"
                            placeholder="Ingresar Apellido">

                    </div>

                    </div>

                    <!-- ENTRADA PARA EL NUMERO TELF1 -->

                    <div class="form-group">

                    <div class="input-group">

                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                        <input type="text" class="form-control input-lg" name="editarTelefono1" id="editarTelefono1"
                            placeholder="Ingresar Nro Celular.">


                    </div>

                    </div>

                    <br>

                <!-- ENTRADA PARA ESCOGER CONTACTO2 -->

                <div class="form-group">

                    <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-check"></i></span>

                    <select name="editarcontacto2" id="editarcontacto2" class="form-control input-lg">
                        <option selected value="">--CONTACTO--</option>
                        <option value="Profesional">Profesional</option>
                        <option value="Dueno">Dueño</option>
                        <option value="Maestro">Maestro</option>
                    </select>

                    </div>

                </div>

                    <!-- ENTRADA PARA NOMBRE DEL CONTACTO2 -->

                    <div class="form-group">

                    <div class="input-group">

                        <span class="input-group-addon"><i class="fa fa-user"></i></span>

                        <input type="text" class="form-control input-lg" name="editarNom2" id="editarNom2"
                            placeholder="Ingresar Nombre">

                    </div>

                    </div>

                    <!-- ENTRADA PARA APELLIDO DEL CONTACTO2 -->

                    <div class="form-group">

                        <div class="input-group">

                            <span class="input-group-addon"><i class="fa fa-user"></i></span>

                            <input type="text" class="form-control input-lg" name="editarApe2" id="editarApe2"
                                placeholder="Ingresar Apellido">

                        </div>

                    </div>

                    <!-- ENTRADA PARA EL NUMERO DEL CONTACTO2 -->

                    <div class="form-group">

                        <div class="input-group">

                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                            <input type="text" class="form-control input-lg" name="editarTelefono2" id="editarTelefono2"
                                placeholder="Ingresar Nro Celular">

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