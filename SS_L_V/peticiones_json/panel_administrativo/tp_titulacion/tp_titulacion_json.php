<?php
header('Content-Type: application/json');   
include_once("../../../includes/conexiones/Base_Datos/conexion.php");

$function_name 			    = 					$_POST['jsonp'];
$con                        =                   conectar();
$alerta                     =                   "";
$mensaje                    =                   "";

if($_POST['opcion'] == 'AccionConsultar'){
	if($_POST['accion'] == 'ConsultarTodos'){

        $data               =                   [];
        $numero             =                   1;

        $consulta = "SELECT 
                            *
                        FROM tp_titulacion";
        $data_con 				=								$con->query($consulta);

            if($data_con->num_rows > 0){
                foreach($data_con as $datos){
                    $data[] = array(
                                        "NUMERO"            =>          $numero,
                                        "ID"                =>          $datos["id"],
                                        "DESCRIPCION"       =>          $datos["descripcion"],
                                        "ESTADO"            =>          ($datos["estado"] == 1)? "Activo" : "Inactivo",
                                        "ESTADO_INT"        =>          $datos["estado"],
                                    );
                    $numero++;
                }
            }
        print json_encode(array("DATA" => $data));
    }
}
