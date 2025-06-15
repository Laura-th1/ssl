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
                            titu.id,
                            titu.descripcion,
                            tp_titu.id          tp_titulaciones_id,
                            tp_titu.descripcion tp_titulaciones_desc,
                            titu.estado
                        FROM titulaciones titu
                        INNER JOIN tp_titulacion tp_titu ON (tp_titu.id = titu.tipo_titulacion_id)";
        $data_con 				=								$con->query($consulta);

            if($data_con->num_rows > 0){
                foreach($data_con as $datos){
                    $data[] = array(
                                        "NUMERO"            =>          $numero,
                                        "ID"                =>          $datos["id"],
                                        "DESCRIPCION"       =>          $datos["descripcion"],
                                        "TP_TITU_ID"        =>          $datos["tp_titulaciones_id"],
                                        "TP_TITU_DESC"      =>          $datos["tp_titulaciones_desc"],
                                        "ESTADO"            =>          ($datos["estado"] == 1)? "Activo" : "Inactivo",
                                        "ESTADO_INT"        =>          $datos["estado"],
                                    );
                    $numero++;
                }
            }
        print json_encode(array("DATA" => $data));
    }elseif($_POST['accion'] == 'ConsultarTp_titulaciones'){

        $data               =                   [];

        $consulta = "SELECT 
                            *
                        FROM tp_titulacion
                        WHERE estado = 1";
        $data_con 				=								$con->query($consulta);

            if($data_con->num_rows > 0){
                foreach($data_con as $datos){
                    $data[] = array(
                                        "ID"                =>          $datos["id"],
                                        "DESCRIPCION"       =>          $datos["descripcion"],
                                    );
                }
            }
        print json_encode(array("DATA" => $data));
    }
}elseif($_POST['opcion'] == 'AccionInsertar'){
    $nombre = $_POST["nombre"];
    $tp_titulaciones = $_POST["tp_titulaciones"];

    $consulta = "SELECT 
                            *
                        FROM titulaciones
                        where descripcion = '".$nombre."'
                        and tipo_titulacion_id = ".$tp_titulaciones."";
    $data_con 				=								$con->query($consulta);

    if($data_con->num_rows == 0){
        $alerta                     =                   "OK";
        $mensaje                    =                   "";

        $consulta = "INSERT INTO titulaciones (descripcion, tipo_titulacion_id, estado, usuario_create, usuario_act, fecha_create, fecha_act)
                            VALUES ('".$nombre."',  ".$tp_titulaciones.", 1, 1, NULL, CURRENT_TIMESTAMP, CURRENT_DATE)";
        $data                 =               $con->query($consulta);
    }else{
        $alerta                     =                   "ERROR";
        $mensaje                    =                   "Ya existe esta Titulacion.";
    }

    print json_encode(array("ALERTA" => $alerta, "MENSAJE" => $mensaje));
}elseif($_POST['opcion'] == 'AccionActualizar'){
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $tp_titulaciones = $_POST["tp_titulaciones"];
    $estado = $_POST["estado"];

    $consulta = "SELECT 
                            *
                        FROM titulaciones
                        where descripcion = '".$_POST["nombre"]."'
                        and tipo_titulacion_id = ".$tp_titulaciones."
                        and id <> '".$id."'";
    $data_con 				=								$con->query($consulta);

    if($data_con->num_rows == 0){
        $alerta                     =                   "OK";
        $mensaje                    =                   "";

        $consulta = "UPDATE titulaciones
                        SET descripcion = '".$nombre."',
                            estado = '".$estado."', 
                            tipo_titulacion_id = ".$tp_titulaciones.",
                            usuario_act = 1, 
                            fecha_act = CURRENT_TIMESTAMP
                        WHERE id = '".$id."';";
        $data                 =               $con->query($consulta);
    }else{
        $alerta                     =                   "ERROR";
        $mensaje                    =                   "Ya existe esta titulacion.";
    }

    print json_encode(array("ALERTA" => $alerta, "MENSAJE" => $mensaje));

    
}

if ($_POST['opcion'] == "AccionEliminar") {
    $id = intval($_POST["id"]);
    $alerta = "OK";
    $mensaje = "";

    // Corregir la tabla y la consulta: 
    $consulta = $con->prepare("DELETE FROM titulaciones WHERE id = ?");
    if ($consulta) {
        $consulta->bind_param("i", $id);
        if ($consulta->execute()) {
            if ($consulta->affected_rows > 0) {
                $mensaje = "Eliminado correctamente.";
            } else {
                $alerta = "ERROR";
                $mensaje = "No se encontró la titulación para eliminar.";
            }
        } else {
            $alerta = "ERROR";
            $mensaje = "Error al ejecutar la eliminación.";
        }
        $consulta->close();
    } else {
        $alerta = "ERROR";
        $mensaje = "Error en la preparación de la consulta.";
    }

    print json_encode(array("ALERTA" => $alerta, "MENSAJE" => $mensaje));
} 
