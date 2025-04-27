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
                        FROM sexos";
        $data_con = $con->query($consulta);

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
}elseif($_POST['opcion'] == 'AccionInsertar'){
    $nombre = $_POST["nombre"];

    if (empty($nombre)) {
        print json_encode(array("ALERTA" => "ERROR", "MENSAJE" => "El espacio no puede estar vacío."));
        exit;
    } // Verificar si el genero ya existe
    $consulta = "SELECT 
                            *
                        FROM sexos
                        where descripcion = '" . $nombre . "'";
    $data_con 				=								$con->query($consulta);

    if($data_con->num_rows == 0){
        $alerta                     =                   "OK";
        $mensaje                    =                   "";
// Intentar insertar el nuevo genero
        $consulta = "INSERT INTO sexos (descripcion, estado, usuario_create, usuario_act, fecha_create, fecha_act)
                            VALUES ('".$nombre."', 1, 1, NULL, CURRENT_TIMESTAMP, CURRENT_DATE);";
        $data                 =               $con->query($consulta);
    }else{
        $alerta                     =                   "ERROR";
        $mensaje                    =                   "Ya existe este genero.";
    }

    print json_encode(array("ALERTA" => $alerta, "MENSAJE" => $mensaje));
}elseif($_POST['opcion'] == 'AccionActualizar'){
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $estado = $_POST["estado"];

    $consulta = "SELECT 
                            *
                        FROM sexos
                        where descripcion = '" . $nombre . "'
                        and id <> '".$id."'";
    $data_con 				=								$con->query($consulta);

    if($data_con->num_rows == 0){
        $alerta                     =                   "OK";
        $mensaje                    =                   "";

        $consulta = "UPDATE sexos
                        SET descripcion = '".$nombre."',
                            estado = '".$estado."', 
                            usuario_act = 1, 
                            fecha_act = CURRENT_TIMESTAMP
                        WHERE id = '".$id."';";
        $data                 =               $con->query($consulta);
    }else{
        $alerta                     =                   "ERROR";
        $mensaje                    =                   "Ya existe este genero.";
    }

    print json_encode(array("ALERTA" => $alerta, "MENSAJE" => $mensaje));
}

header("Content-Type: application/json");

// // Conectar a la base de datos
// $conn = new mysqli("localhost", "root", "password", "bd_sena_stock");

// if ($conn->connect_error) {
//     die(json_encode(["success" => false, "message" => "Error de conexión"]));
// }

// // Leer los datos JSON enviados desde el frontend
// $data = json_decode(file_get_contents("php://input"), true);

// if (!isset($data["data"]) || count($data["data"]) === 0) {
//     echo json_encode(["success" => false, "message" => "No hay datos para guardar."]);
//     exit;
// }

// $sql = "INSERT INTO sexos (id , nombre, estado) VALUES ";

// $values = [];
// foreach ($data["data"] as $row) {
//     $values[] = "('" . $conn->real_escape_string($row["id"]) . "', '" . $conn->real_escape_string($row["nombre"]) . "', '" . $conn->real_escape_string($row["estado"]) . "')";
// }

// $sql .= implode(",", $values);

// if ($conn->query($sql) === TRUE) {
//     echo json_encode(["success" => true, "message" => "Datos guardados correctamente"]);
// } else {
//     echo json_encode(["success" => false, "message" => "Error al guardar datos"]);
// }

// $conn->close();
?>
