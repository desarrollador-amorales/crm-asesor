<?php

class Cconexion{

    static public function ConexionBD(){

        $host='192.168.16.75';
        $dbname='AdmDura';
        $username='sa';
        $pasword ='AngJua1289';
        $puerto=1433;
        $field=' ';
        $crmactivo=1; //actualizacion de crmactivo en 1 para controlar que no se vuelva a insertar en la base


        try{
            $conn = new PDO ("sqlsrv:Server=$host,$puerto;Database=$dbname",$username,$pasword);
            $sql = 'SELECT * FROM Clientes Where Pasado = 1 and CrmActivo = 0';
            
            foreach ($conn->query($sql) as $row) {

                $tabla = "clientes";

                $datos = array("nombre"=>$row['CliNom']. " ".$row['CliApe'],
                            "cedula"=> $row['CliRUC'],
                            "email"=>$row['CliEmail'],
                            "telefono"=>$row['CliCelular'],
                            "direccion"=>$row['CliDire'],
                            "fecha_nacimiento"=>$row['Creacion'],
                            "estado"=>$field,
                            "cotizacion"=>$field,
                            "interes"=>$field,
                            "tipo_cliente"=>$field,
                            "producto_cotizado"=>$field,
                            "fecha_seguimiento"=>$field,
                            "contrato"=>$field,								
                            "facturacion"=>$field,
                            "observaciones"=>$field,
                            "almacen"=>$field,
                            "fechacierre"=> $field,
                            "valorCotizado"=> $field,
                            "id_asesor"=> $row['Vendedor'],
                            "pasado"=> $row['Pasado']							   
                         );


                ModeloClientes::mdlIngresarCliente($tabla, $datos);
                $data = [
                    'crmactivo' => $crmactivo,
                    'Clicod' => $row['CliCod']
                ];
                $sql_update ='UPDATE CLIENTES SET CrmActivo =:crmactivo where CliCod =:Clicod ';

                $stmt= $conn->prepare($sql_update);
                $stmt->execute($data);
            
            }
            
            
            $conn->exec("set names utf8");

        }
        catch(PDOException $exp){
            echo ("No se logró conectar correctamente con la base de datos: $dbname, error: $exp");
        }

        return $conn;
    }

}

?>