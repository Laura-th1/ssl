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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) { // Assuming your file input has the name 'csv_file'
    $file = $_FILES['csv_file'];

    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(["status" => "error", "message" => "Error al cargar el archivo."]);
        exit;
    }

    // Check file type (optional, but recommended)
    if ($file['type'] !== 'text/csv' && $file['type'] !== 'application/vnd.ms-excel') {
        echo json_encode(["status" => "error", "message" => "Formato de archivo no válido. Se esperaba un archivo CSV."]);
        exit;
    }

    // Open the uploaded CSV file
    if (($handle = fopen($file['tmp_name'], "r")) !== FALSE) {
        $insertados = 0;
        $actualizados = 0;
        $omitidos = 0;
        $row_number = 0;

        // Read the CSV file line by line
        while (($row_data = fgetcsv($handle)) !== FALSE) {
            $row_number++;

            // Skip the header row (if it exists)
            if ($row_number === 1) {
                continue; // Or process it if needed
            }

            // Assuming your CSV columns are in a specific order:
            // id, bloque_id, descripcion, observacion, estado
            if (count($row_data) !== 5) {
                echo json_encode(["status" => "error", "message" => "Número incorrecto de columnas en la fila " . $row_number . "."]);
                fclose($handle);
                exit;
            }

            $id = intval($row_data[0]);
            $bloque_id = intval($row_data[1]);
            $descripcion = $con->real_escape_string($row_data[2]);
            $observacion = $con->real_escape_string($row_data[3]);
            $estado = intval($row_data[4]);
            $fecha_actual = date('Y-m-d H:i:s');

            // Verificar duplicado lógico
            $sql_duplicado = "
                SELECT id FROM ambientes
                WHERE descripcion = '$descripcion'
                  AND bloque_id = $bloque_id
                  AND id != $id
            ";
            $res_duplicado = mysqli_query($con, $sql_duplicado);

            if (mysqli_num_rows($res_duplicado)) {
                $omitidos++;
                continue; // Saltar inserción o actualización
            }

            // Verificar si el ID existe
            $sql_existencia = "SELECT id FROM ambientes WHERE id = $id";
            $result = mysqli_query($con, $sql_existencia);

            if (mysqli_num_rows($result)) {
                // Actualizar
                $sql_update = "
                    UPDATE ambientes SET
                        bloque_id = $bloque_id,
                        descripcion = '$descripcion',
                        observacion = '$observacion',
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
                    INSERT INTO ambientes
                        (id, bloque_id, descripcion, observacion, estado, usuario_create, usuario_act, fecha_create, fecha_act)
                    VALUES
                        ($id, $bloque_id, '$descripcion', '$observacion', $estado, 1, 1, '$fecha_actual', '$fecha_actual')
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