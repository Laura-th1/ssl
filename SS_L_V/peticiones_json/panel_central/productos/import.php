<?php
// Desactivar la visualización de errores
error_reporting(0);
ini_set('display_errors', 0);
// Initialize database connection
$con = conectar();
if (!$con) {
    echo json_encode(["status" => "error", "message" => "Error de conexión a la base de datos"]);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
    $file = $_FILES['csv_file'];
// Verificar errores de carga
if ($file['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(["status" => "error", "message" => "Error al cargar el archivo"]);
    exit;
}
    // ... existing code ...

    if (($handle = fopen($file['tmp_name'], "r")) !== FALSE) {
        $insertados = 0;
        $actualizados = 0;
        $omitidos = 0;
        $row_number = 0;

        while (($row_data = fgetcsv($handle)) !== FALSE) {
            $row_number++;

            if ($row_number === 1) {
                continue;
            }

            // Modificado para productos: id, descripcion, observacion, estado
            if (count($row_data) < 5) {
                echo json_encode(["status" => "error", "message" => "Número incorrecto de columnas en la fila " . $row_number . "."]);
                fclose($handle);
                exit;
            }

            $id = intval($row_data[0]);
            $descripcion = $con->real_escape_string($row_data[1]);
            $observacion = $con->real_escape_string($row_data[2]);
            $estado = intval($row_data[3]);
            $usuario_id = intval($row_data[4]);
            $fecha_actual = date('Y-m-d H:i:s');

            // Verificar duplicado lógico
            $sql_duplicado = "
                SELECT id FROM productos 
                WHERE descripcion = '$descripcion'
                AND id != $id
            ";
            $res_duplicado = mysqli_query($con, $sql_duplicado);

            if (mysqli_num_rows($res_duplicado)) {
                $omitidos++;
                continue;
            }

            // Verificar si el ID existe
            $sql_existencia = "SELECT id FROM productos WHERE id = $id";
            $result = mysqli_query($con, $sql_existencia);

            if (mysqli_num_rows($result)) {
                // Actualizar
                $sql_update = "
                    UPDATE productos SET
                        descripcion = '$descripcion',
                        observacion = '$observacion',
                        estado = $estado,
                        usuario_id = '$usuario_id',
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
                    INSERT INTO productos
                        (id, descripcion, observacion, estado, usuario_id, usuario_create, usuario_act, fecha_create, fecha_act)
                    VALUES
                        ($id, '$descripcion', '$observacion', $estado, $usuario_id, 1, 1, '$fecha_actual', '$fecha_actual')
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

        // Al finalizar siempre devolver JSON válido
die(json_encode([
    "status" => "success",
    "message" => "Proceso completado",
    "data" => [
        "insertados" => $insertados,
        "actualizados" => $actualizados,
        "omitidos" => $omitidos
    ]
]));
    }
}


?>