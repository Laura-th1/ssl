<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

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
                            age.id,
                            age.fecha,
                            age.hora_ini,
                            age.hora_fin,
                            bloq.id AS bloque_id,
                            bloq.descripcion AS bloque_desc,
                            amb.id amb_id,
                            amb.descripcion amb_desc,
                            titu.id titu_id,
                            titu.descripcion titu_desc,
                            age.estado
                        FROM agenda_ambientes age
                        INNER JOIN bloques bloq ON (bloq.id = age.bloque_id)
                        INNER JOIN ambientes amb ON (amb.id = age.ambiente_id)
                        INNER JOIN titulaciones titu ON (titu.id = age.titulacion_id)";
        $data_con = $con->query($consulta);

        if ($data_con->num_rows > 0) {
            foreach ($data_con as $datos) {
                $data[] = array(
                    "NUMERO" => $numero,
                    "ID" => $datos["id"],
                    "FECHA" => $datos["fecha"],
                    "HORA_INI" => $datos["hora_ini"],
                    "HORA_FIN" => $datos["hora_fin"],
                    "BLOQ_ID" => $datos["bloque_id"],
                    "BLOQ_DESC" => $datos["bloque_desc"],
                    "AMBIENTE_ID" => $datos["amb_id"],
                    "AMBIENTE_DES" => $datos["amb_desc"],
                    "TITULACION_ID" => $datos["titu_id"],
                    "TITULACION_DESC" => $datos["titu_desc"],
                    "ESTADO" => ($datos["estado"] == 1) ? "Activo" : "Inactivo",
                    "ESTADO_INT" => $datos["estado"],
                );
                $numero++;
            }
        }
        print json_encode(array("DATA" => $data));
    } elseif ($_POST['accion'] == 'ConsultarAmbientes') {
        $data = [];
        $bloque = $_POST["Bloque"];
        error_log("Bloque seleccionado: " . $bloque); // Log para verificar el bloque

        // Consulta SQL
        $consulta = "SELECT * FROM ambientes WHERE estado = 1 AND bloque_id = " . $bloque;
        error_log("Consulta SQL: " . $consulta); // Log para verificar la consulta

        $data_con = $con->query($consulta);

        if ($data_con->num_rows > 0) {
            while ($datos = $data_con->fetch_assoc()) {
                $data[] = array(
                    "ID" => $datos["id"],
                    "DESCRIPCION" => $datos["descripcion"],
                );
            }
        } else {
            error_log("No se encontraron ambientes para el bloque: " . $bloque); // Log si no se encuentran ambientes
        }

        error_log("Datos enviados al frontend: " . json_encode($data)); // Log para verificar los datos enviados

        // Devolver los datos como JSON
        print json_encode(array("DATA" => $data));
    } elseif ($_POST['accion'] == 'ConsultarBloques') {

        $data = [];

        $consulta = "SELECT * FROM bloques WHERE estado = 1";
        $data_con = $con->query($consulta);

        if ($data_con->num_rows > 0) {
            foreach ($data_con as $datos) {
                $data[] = array(
                    "ID" => $datos["id"],
                    "DESCRIPCION" => $datos["descripcion"],
                );
            }
        }
        print json_encode(array("DATA" => $data));
    } elseif ($_POST['accion'] == 'ConsultarTitulaciones') {

        $data = [];

        $consulta = "SELECT * FROM titulaciones WHERE estado = 1";
        $data_con = $con->query($consulta);

        if ($data_con->num_rows > 0) {
            foreach ($data_con as $datos) {
                $data[] = array(
                    "ID" => $datos["id"],
                    "DESCRIPCION" => $datos["descripcion"],
                );
            }
        }
        print json_encode(array("DATA" => $data));
    } elseif ($_POST['accion'] == 'ConsultarAgendaHome') {
        $data = [];
        $bloque = $_POST["bloque"];
        $fecha_ini = $_POST["fecha_ini"];
        $fecha_fin = $_POST["fecha_fin"];
        $numero = 1;

        $consulta = "SELECT 
                            age.id,
                            age.fecha,
                            age.hora_ini,
                            age.hora_fin,
                            bloq.id bloque_id,
                            bloq.descripcion bloque_desc,
                            amb.id amb_id,
                            amb.descripcion amb_desc,
                            titu.id titu_id,
                            titu.descripcion titu_desc,
                            age.estado
                        FROM agenda_ambientes age
                        INNER JOIN bloques bloq ON (bloq.id = age.bloque_id)
                        INNER JOIN ambientes amb ON (amb.id = age.ambiente_id)
                        INNER JOIN titulaciones titu ON (titu.id = age.titulacion_id)
                        WHERE bloq.id = " . $bloque . "
                        AND fecha BETWEEN '" . $fecha_ini . "' AND '" . $fecha_fin . "'
                        ORDER BY fecha DESC";
        $data_con = $con->query($consulta);

        if ($data_con->num_rows > 0) {
            foreach ($data_con as $datos) {
                $data[] = array(
                    "NUMERO" => $numero,
                    "ID" => $datos["id"],
                    "FECHA" => $datos["fecha"],
                    "HORA_INI" => $datos["hora_ini"],
                    "HORA_FIN" => $datos["hora_fin"],
                    "BLOQ_ID" => $datos["bloque_id"],
                    "BLOQ_DESC" => $datos["bloque_desc"],
                    "AMBIENTE_ID" => $datos["amb_id"],
                    "AMBIENTE_DES" => $datos["amb_desc"],
                    "TITULACION_ID" => $datos["titu_id"],
                    "TITULACION_DESC" => $datos["titu_desc"],
                    "ESTADO" => ($datos["estado"] == 1) ? "Activo" : "Inactivo",
                    "ESTADO_INT" => $datos["estado"],
                );
                $numero++;
            }
        }
        print json_encode(array("DATA" => $data));
    }
} elseif ($_POST['opcion'] == 'AccionInsertar') {
    $fecha = $_POST["fecha"];
    $hora_ini = $_POST["hora_ini"];
    $hora_fin = $_POST["hora_fin"];
    $bloque = $_POST["bloque"];
    $ambiente = $_POST["ambiente"];
    $titulacion = $_POST["titulacion"];

    $consulta = "SELECT *
                        FROM agenda_ambientes
                        WHERE fecha = '" . $fecha . "'
                        AND hora_ini >= '" . $hora_ini . "'
                        AND hora_fin <= '" . $hora_fin . "'
                        AND bloque_id = " . $bloque . "
                        AND ambiente_id = " . $ambiente . "";
    $data_con = $con->query($consulta);

    if ($data_con->num_rows == 0) {
        $alerta = "OK";
        $mensaje = "";

        $consulta = "INSERT INTO agenda_ambientes (fecha, hora_ini, hora_fin, bloque_id, ambiente_id, titulacion_id, estado, usuario_create, usuario_act, fecha_create, fecha_act)
                            VALUES ('" . $fecha . "',  '" . $hora_ini . "', '" . $hora_fin . "', " . $bloque . ", " . $ambiente . ", " . $titulacion . ", 1, 1, NULL, CURRENT_TIMESTAMP, CURRENT_DATE)";
        $data = $con->query($consulta);
    } else {
        $alerta = "ERROR";
        $mensaje = "Ya está ocupado a esta hora el ambiente.";
    }

    print json_encode(array("ALERTA" => $alerta, "MENSAJE" => $mensaje));
} elseif ($_POST['opcion'] == 'AccionActualizar') {
    error_log("Entrando a AccionActualizar");

    if (isset($_POST["id"], $_POST["estado"], $_POST["fecha"], $_POST["hora_ini"], $_POST["hora_fin"], $_POST["bloque"], $_POST["ambiente"], $_POST["titulacion"])) {
        // Asignar valores recibidos
        $id = $_POST["id"];
        $estado = $_POST["estado"];
        $fecha = $_POST["fecha"];
        $hora_ini = $_POST["hora_ini"];
        $hora_fin = $_POST["hora_fin"];
        $bloque = $_POST["bloque"];
        $ambiente = $_POST["ambiente"];
        $titulacion = $_POST["titulacion"];

        $consulta = $con->prepare("SELECT * FROM agenda_ambientes
            WHERE fecha = ? AND hora_ini >= ? AND hora_fin <= ? AND bloque_id = ? AND ambiente_id = ? AND id <> ?");
        $consulta->bind_param("ssssii", $fecha, $hora_ini, $hora_fin, $bloque, $ambiente, $id);
        $consulta->execute();
        $resultado = $consulta->get_result();

        if ($resultado->num_rows == 0) {
            // Si no hay conflictos de horarios, proceder con la actualización
            $alerta = "OK";
            $mensaje = "";

            $consulta_update = $con->prepare("UPDATE agenda_ambientes
                SET fecha = ?, hora_ini = ?, hora_fin = ?, ambiente_id = ?, titulacion_id = ?, estado = ?, bloque_id = ?, usuario_act = 1, fecha_act = CURRENT_TIMESTAMP
                WHERE id = ?");
            $consulta_update->bind_param("ssssiiii", $fecha, $hora_ini, $hora_fin, $ambiente, $titulacion, $estado, $bloque, $id);
            $consulta_update->execute();

            if ($consulta_update->affected_rows > 0) {
                $mensaje = "Actualización exitosa.";
            } else {
                $alerta = "ERROR";
                $mensaje = "No se pudo actualizar, verifique los datos.";
            }
        } else {
            $alerta = "ERROR";
            $mensaje = "Ya está ocupado a esta hora el ambiente.";
        }

        print json_encode(array("ALERTA" => $alerta, "MENSAJE" => $mensaje));
    } else {
        $alerta = "ERROR";
        $mensaje = "Faltan datos necesarios para procesar la solicitud.";
        print json_encode(array("ALERTA" => $alerta, "MENSAJE" => $mensaje));
    }
}
?>
