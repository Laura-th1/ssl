<?php
header('Content-Type: application/json');   
include_once("../../../includes/conexiones/Base_Datos/conexion.php");

$function_name = $_POST['jsonp'];
$con = conectar();
$alerta = "";
$mensaje = "";

if ($_POST['opcion'] == 'AccionConsultar') {
    if ($_POST['accion'] == 'ConsultarTodos') {
        $data = [];
        $numero = 1;

        $consulta = "SELECT 
                        bloq.id,
                        bloq.descripcion,
                        bloq.estado
                    FROM Bloques bloq";
        $data_con = $con->query($consulta);

        if ($data_con->num_rows > 0) {
            foreach ($data_con as $datos) {
                $data[] = array(
                    "NUMERO" => $numero,
                    "ID" => $datos["id"],
                    "DESCRIPCION" => $datos["descripcion"],
                    "ESTADO" => ($datos["estado"] == 1) ? "Activo" : "Inactivo",
                    "ESTADO_INT" => $datos["estado"],
                );
                $numero++;
            }
        }
        print json_encode(array("DATA" => $data));
    }
} else if ($_POST['opcion'] == 'AccionInsertar') {
    $nombre = $_POST["nombre"];
    if (empty($nombre)) {
        print json_encode(array("ALERTA" => "ERROR", "MENSAJE" => "El nombre no puede estar vacío."));
        exit;
    }

    // Verificar si el bloque ya existe
    $consulta = "SELECT * FROM Bloques WHERE descripcion = '" . $nombre . "'";
    $data_con = $con->query($consulta);

    if (!$data_con) {
        print json_encode(array("ALERTA" => "ERROR", "MENSAJE" => "Error en la consulta: " . $con->error));
        exit;
    }

    if ($data_con->num_rows == 0) {
        $alerta = "OK";
        $mensaje = "";

        // Intentar insertar el nuevo bloque
        $consulta = "INSERT INTO Bloques (descripcion, estado, usuario_create, usuario_act, fecha_create, fecha_act)
                     VALUES ('" . $nombre . "', 1, 1, NULL, CURRENT_TIMESTAMP, CURRENT_DATE)";
        $data = $con->query($consulta);

        if (!$data) {
            $alerta = "ERROR";
            $mensaje = "Error al insertar el bloque: " . $con->error;
        }
    } else {
        $alerta = "ERROR";
        $mensaje = "Ya existe este Bloque.";
    }

    print json_encode(array("ALERTA" => $alerta, "MENSAJE" => $mensaje));
}

elseif ($_POST['opcion'] == 'AccionActualizar') {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $estado = $_POST["estado"];

    $consulta = "SELECT 
                    *
                FROM Bloques
                WHERE descripcion = '" . $nombre . "'
                AND id <> '" . $id . "'";
    $data_con = $con->query($consulta);

    if ($data_con->num_rows == 0) {
        $alerta = "OK";
        $mensaje = "";

        $consulta = "UPDATE Bloques
                     SET descripcion = '" . $nombre . "',
                         estado = '" . $estado . "', 
                         usuario_act = 1, 
                         fecha_act = CURRENT_TIMESTAMP
                     WHERE id = '" . $id . "'";
        $data = $con->query($consulta);
    } else {
        $alerta = "ERROR";
        $mensaje = "Ya existe este Bloque.";
    }

    print json_encode(array("ALERTA" => $alerta, "MENSAJE" => $mensaje));
}