<?php
require_once("../../../includes/conexiones/Base_Datos/conexion.php");
header("Content-Type: application/json");

// Habilitar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
$con = conectar();
if (!$con) {
    echo json_encode(["status" => "error", "message" => "Error al conectar con la base de datos."]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) { // Verificar si se cargó un archivo CSV
    $file = $_FILES['csv_file'];

    // Verificar errores en la carga del archivo
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(["status" => "error", "message" => "Error al cargar el archivo."]);
        exit;
    }

    // Verificar el tipo de archivo (opcional, pero recomendado)
    if ($file['type'] !== 'text/csv' && $file['type'] !== 'application/vnd.ms-excel') {
        echo json_encode(["status" => "error", "message" => "Formato de archivo no válido. Se esperaba un archivo CSV."]);
        exit;
    }

    // Abrir el archivo CSV cargado
    if (($handle = fopen($file['tmp_name'], "r")) !== FALSE) {
        $insertados = 0;
        $actualizados = 0;
        $omitidos = 0;
        $row_number = 0;

        // Leer el archivo CSV línea por línea
        while (($row_data = fgetcsv($handle)) !== FALSE) {
            $row_number++;

            // Saltar la fila de encabezado (si existe)
            if ($row_number === 1) {
                continue;
            }

            // Suponiendo que las columnas del CSV están en el siguiente orden:
            // id, descripcion, tipo_titulacion_id, estado
            if (count($row_data) !== 4) {
                echo json_encode(["status" => "error", "message" => "Número incorrecto de columnas en la fila " . $row_number . "."]);
                fclose($handle);
                exit;
            }

            $id = intval($row_data[0]);
            $descripcion = $con->real_escape_string($row_data[1]);
            $tipo_titulacion_id = intval($row_data[2]);
            $estado = intval($row_data[3]);
            $fecha_actual = date('Y-m-d H:i:s');

            // Verificar duplicado lógico
            $sql_duplicado = "
                SELECT id FROM titulaciones
                WHERE descripcion = '$descripcion'
                  AND tipo_titulacion_id = $tipo_titulacion_id
                  AND id != $id
            ";
            $res_duplicado = mysqli_query($con, $sql_duplicado);

            if (mysqli_num_rows($res_duplicado)) {
                $omitidos++;
                continue; // Saltar inserción o actualización
            }

            // Verificar si el ID existe
            $sql_existencia = "SELECT id FROM titulaciones WHERE id = $id";
            $result = mysqli_query($con, $sql_existencia);

            if (mysqli_num_rows($result)) {
                // Actualizar
                $sql_update = "
                    UPDATE titulaciones SET
                        descripcion = '$descripcion',
                        tipo_titulacion_id = $tipo_titulacion_id,
                        estado = $estado,
                        usuario_act = 1,
                        fecha_act = '$fecha_actual'
                    WHERE id = $id
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
                    INSERT INTO titulaciones
                        (descripcion, tipo_titulacion_id, estado, usuario_create, usuario_act, fecha_create, fecha_act)
                    VALUES
                        ('$descripcion', $tipo_titulacion_id, $estado, 1, 1, '$fecha_actual', '$fecha_actual')
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