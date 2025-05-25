<?php
require_once("../../../includes/conexiones/Base_Datos/conexion.php");
header("Content-Type: application/json");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$con = conectar();
if (!$con) {
    echo json_encode(["status" => "error", "message" => "Error al conectar con la base de datos."]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
    $file = $_FILES['csv_file'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(["status" => "error", "message" => "Error al cargar el archivo."]);
        exit;
    }

    if ($file['type'] !== 'text/csv' && $file['type'] !== 'application/vnd.ms-excel') {
        echo json_encode(["status" => "error", "message" => "Formato de archivo no válido. Se esperaba un archivo CSV."]);
        exit;
    }

    if (($handle = fopen($file['tmp_name'], "r")) !== FALSE) {
        $insertados = 0;
        $actualizados = 0;
        $omitidos = 0;
        $row_number = 0;

        while (($row_data = fgetcsv($handle)) !== FALSE) {
            $row_number++;

            // Saltar encabezado
            if ($row_number === 1) {
                continue;
            }

            // inventario_id, nombre, bloque_id, observacion, estado
            if (count($row_data) !== 5) {
                echo json_encode(["status" => "error", "message" => "Número incorrecto de columnas en la fila " . $row_number . "."]);
                fclose($handle);
                exit;
            }

            $inventario_id = intval($row_data[0]);
            $nombre = $con->real_escape_string($row_data[1]);
            $bloque_id = intval($row_data[2]);
            $observacion = $con->real_escape_string($row_data[3]);
            $estado = intval($row_data[4]);
            $fecha_actual = date('Y-m-d H:i:s');

            // Verificar duplicado lógico
            $sql_duplicado = "
                SELECT inventario_id FROM inventarios
                WHERE nombre = '$nombre'
                  AND bloque_id = $bloque_id
                  AND inventario_id != $inventario_id
            ";
            $res_duplicado = mysqli_query($con, $sql_duplicado);

            if (mysqli_num_rows($res_duplicado)) {
                $omitidos++;
                continue;
            }

            // Verificar si el ID existe
            $sql_existencia = "SELECT inventario_id FROM inventarios WHERE inventario_id = $inventario_id";
            $result = mysqli_query($con, $sql_existencia);

            if (mysqli_num_rows($result)) {
                // Actualizar
                $sql_update = "
                    UPDATE inventarios SET
                        nombre = '$nombre',
                        bloque_id = $bloque_id,
                        observacion = '$observacion',
                        estado = $estado,
                        usuario_act = 1,
                        fecha_act = '$fecha_actual'
                    WHERE inventario_id = $inventario_id
                ";
                if (!mysqli_query($con, $sql_update)) {
                    echo json_encode(["status" => "error", "message" => "Error al actualizar en la fila " . $row_number . ": " . mysqli_error($con)]);
                    fclose($handle);
                    exit;
                }
                $actualizados++;
            } else {
                // Insertar
                $sql_insert = "
                    INSERT INTO inventarios
                        (inventario_id, nombre, bloque_id, observacion, estado, usuario_create, usuario_act, fecha_create, fecha_act)
                    VALUES
                        ($inventario_id, '$nombre', $bloque_id, '$observacion', $estado, 1, 1, '$fecha_actual', '$fecha_actual')
                ";
                if (!mysqli_query($con, $sql_insert)) {
                    echo json_encode(["status" => "error", "message" => "Error al insertar en la fila " . $row_number . ": " . mysqli_error($con)]);
                    fclose($handle);
                    exit;
                }
                $insertados++;
            }
        }
        fclose($handle);

        echo json_encode([
            "status" => "success",
            "message" => "Datos procesados correctamente.",
            "insertados" => $insertados,
            "actualizados" => $actualizados,
            "omitidos" => $omitidos
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al abrir el archivo CSV."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido o archivo no recibido."]);
}
?>