<?php
header('Content-Type: application/json');
include_once("../../../includes/conexiones/Base_Datos/conexion.php");

$con = conectar();
if (!$con) {
    die(json_encode(array("ALERTA" => "ERROR", "MENSAJE" => "No se pudo conectar a la base de datos.")));
}

$alerta = "";
$mensaje = "";

if ($_POST['opcion'] == 'AccionConsultar') {
    if ($_POST['accion'] == 'ConsultarTodos') {
        $data = [];
        $numero = 1;

        $consulta = "SELECT 
                        amb.id,
                        amb.descripcion,
                        bloq.id AS bloque_id,
                        bloq.descripcion AS bloque_desc,
                        amb.observacion,
                        amb.estado
                     FROM ambientes amb
                     INNER JOIN bloques bloq ON bloq.id = amb.bloque_id";
        $data_con = $con->query($consulta);
            // Add this for debugging:
    error_log("Query executed for ConsultarTodos: " . $consulta);
    $all_data = [];
    if ($data_con && $data_con->num_rows > 0) {
        while ($row = $data_con->fetch_assoc()) {
            $all_data[] = $row;
        }
        error_log("Data fetched for ConsultarTodos: " . print_r($all_data, true));
        // ... rest of your code to format $data ...
    }


        if (!$data_con) {
            die(json_encode(array("ALERTA" => "ERROR", "MENSAJE" => "Error en la consulta: " . $con->error)));
        }

        if ($data_con->num_rows > 0) {
            foreach ($data_con as $datos) {
                $data[] = array(
                    "NUMERO" => $numero,
                    "ID" => $datos["id"],
                    "DESCRIPCION" => $datos["descripcion"],
                    "BLOQ_ID" => $datos["bloque_id"],
                    "BLOQ_DESC" => $datos["bloque_desc"],
                    "OBSERVACION" => $datos["observacion"],
                    "ESTADO" => ($datos["estado"] == 1) ? "Activo" : "Inactivo",
                    "ESTADO_INT" => $datos["estado"],
                );
                $numero++;
            }
        }

        echo json_encode(array("DATA" => $data));
        exit;
    } elseif ($_POST['accion'] == 'ConsultarBloques') {
        $data = [];
        $consulta = "SELECT id, descripcion FROM bloques WHERE estado = 1";
        $data_con = $con->query($consulta);

        if (!$data_con) {
            die(json_encode(array("ALERTA" => "ERROR", "MENSAJE" => "Error en la consulta: " . $con->error)));
        }

        if ($data_con->num_rows > 0) {
            foreach ($data_con as $datos) {
                $data[] = array(
                    "ID" => $datos["id"],
                    "DESCRIPCION" => $datos["descripcion"],
                );
            }
        }

        echo json_encode(array("DATA" => $data));
        exit;
    }
} elseif ($_POST['opcion'] == 'AccionInsertar') {
    $nombre = $_POST["nombre"];
    $bloque = $_POST["bloque"];
    $observacion = $_POST["observacion"];

    if (empty($nombre) || empty($bloque)) {
        die(json_encode(array("ALERTA" => "ERROR", "MENSAJE" => "Faltan datos requeridos.")));
    }

    $stmt = $con->prepare("SELECT * FROM ambientes WHERE descripcion = ? AND bloque_id = ?");
    $stmt->bind_param("si", $nombre, $bloque);
    $stmt->execute();
    $data_con = $stmt->get_result();

    if ($data_con->num_rows == 0) {
        $stmt = $con->prepare("INSERT INTO ambientes (descripcion, bloque_id, observacion, estado, usuario_create, usuario_act, fecha_create, fecha_act)
                               VALUES (?, ?, ?, 1, 1, NULL, CURRENT_TIMESTAMP, CURRENT_DATE)");
        $stmt->bind_param("sis", $nombre, $bloque, $observacion);

        if ($stmt->execute()) {
            $alerta = "OK";
            $mensaje = "Ambiente insertado correctamente.";
        } else {
            $alerta = "ERROR";
            $mensaje = "Error al insertar el ambiente: " . $stmt->error;
        }
    } else {
        $alerta = "ERROR";
        $mensaje = "Ya existe este Ambiente.";
    }

    echo json_encode(array("ALERTA" => $alerta, "MENSAJE" => $mensaje));
    $stmt->close();
    $con->close();
    exit;
} elseif ($_POST['opcion'] == 'AccionActualizar') {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $estado = $_POST["estado"];
    $bloque = $_POST["bloque"];
    $observacion = $_POST["observacion"];

    if ($id === "" || $nombre === "" || !isset($estado) || $bloque === "") {
        die(json_encode(array("ALERTA" => "ERROR", "MENSAJE" => "Faltan datos requeridos.")));
    }

    $stmt = $con->prepare("SELECT * FROM ambientes WHERE descripcion = ? AND bloque_id = ? AND id <> ?");
    $stmt->bind_param("sii", $nombre, $bloque, $id);
    $stmt->execute();
    $data_con = $stmt->get_result();

    if ($data_con->num_rows == 0) {
        $stmt = $con->prepare("UPDATE ambientes
                               SET descripcion = ?, 
                                   observacion = ?, 
                                   estado = ?, 
                                   bloque_id = ?, 
                                   usuario_act = 1, 
                                   fecha_act = CURRENT_TIMESTAMP
                               WHERE id = ?");
        $stmt->bind_param("ssiii", $nombre, $observacion, $estado, $bloque, $id);

        if ($stmt->execute()) {
            $alerta = "OK";
            $mensaje = "Ambiente actualizado correctamente.";
        } else {
            $alerta = "ERROR";
            $mensaje = "Error al actualizar el ambiente: " . $stmt->error;
        }
    } else {
        $alerta = "ERROR";
        $mensaje = "Ya existe este Ambiente.";
    }

    echo json_encode(array("ALERTA" => $alerta, "MENSAJE" => $mensaje));
    $stmt->close();
    $con->close();
    exit;
}