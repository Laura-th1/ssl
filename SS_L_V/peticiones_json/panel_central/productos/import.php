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
            // id, descripcion, numero_placa, observacion, estado, usuario_id
            if (count($row_data) !== 6) {
                echo json_encode(["status" => "error", "message" => "Número incorrecto de columnas en la fila " . $row_number . "."]);
                fclose($handle);
                exit;
            }

            $id = intval($row_data[0]);
            $descripcion = $con->real_escape_string($row_data[1]);
            $numero_placa = $con->real_escape_string($row_data[2]);
            $observacion = $con->real_escape_string($row_data[3]);
            $estado = intval($row_data[4]);
            $usuario_id = intval($row_data[5]);
            $fecha_actual = date('Y-m-d H:i:s');

            // Verificar duplicado lógico
            $sql_duplicado = "
                SELECT id FROM productos 
                WHERE descripcion = '$descripcion'
                AND numero_placa = '$numero_placa'
                AND id != $id
            ";
            $res_duplicado = mysqli_query($con, $sql_duplicado);

            if (mysqli_num_rows($res_duplicado)) {
                $omitidos++;
                continue; // Saltar inserción o actualización
            }

            // Verificar si el ID existe
            $sql_existencia = "SELECT id FROM productos WHERE id = $id";
            $result = mysqli_query($con, $sql_existencia);

            if (mysqli_num_rows($result)) {
                // Actualizar
                $sql_update = "
                    UPDATE productos SET
                        descripcion = '$descripcion',
                        numero_placa = '$numero_placa',
                        observacion = '$observacion',
                        estado = $estado,
                        usuario_id = $usuario_id,
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
                        (descripcion, numero_placa, observacion, estado, usuario_id, usuario_create, usuario_act, fecha_create, fecha_act)
                    VALUES
                        ('$descripcion', '$numero_placa', '$observacion', $estado, $usuario_id, 1, 1, '$fecha_actual', '$fecha_actual')
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

        // Respuesta JSON con el resumen del proceso
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