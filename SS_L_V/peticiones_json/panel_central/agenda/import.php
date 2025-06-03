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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
    $file = $_FILES['csv_file'];

    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(["status" => "error", "message" => "Error al cargar el archivo."]);
        exit;
    }

    // Elimina la validación estricta de tipo MIME, ya que muchos navegadores suben CSV como text/plain
    // Open the uploaded CSV file
    if (($handle = fopen($file['tmp_name'], "r")) !== FALSE) {
        $insertados = 0;
        $actualizados = 0;
        $omitidos = 0;
        $row_number = 0;

        if (ob_get_length()) ob_end_clean();

        // Esperado: id, fecha, fecha_fin, hora_ini, hora_fin, bloque_id, ambiente_id, titulacion_id, estado
        while (($row_data = fgetcsv($handle)) !== FALSE) {
            $row_number++;

            // Saltar encabezado
            if ($row_number === 1) {
                continue;
            }

            if (count($row_data) !== 9) {
                echo json_encode(["status" => "error", "message" => "Número incorrecto de columnas en la fila " . $row_number . "."]);
                fclose($handle);
                exit;
            }

            $id = intval($row_data[0]);

            // Adaptar fechas de dd/mm/yyyy a yyyy-mm-dd
            function convertir_fecha($fecha) {
                $fecha = trim($fecha);
                if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $fecha)) {
                    $partes = explode('/', $fecha);
                    return $partes[2] . '-' . $partes[1] . '-' . $partes[0];
                }
                return $fecha; // Si ya está en formato yyyy-mm-dd o vacío
            }

            $fecha = $con->real_escape_string(convertir_fecha($row_data[1]));
            $fecha_fin = $con->real_escape_string(convertir_fecha($row_data[2]));
            $hora_ini = $con->real_escape_string($row_data[3]);
            $hora_fin = $con->real_escape_string($row_data[4]);
            $bloque_id = intval($row_data[5]);
            $ambiente_id = intval($row_data[6]);
            $titulacion_id = intval($row_data[7]);
            $estado = intval($row_data[8]);
            $fecha_actual = date('Y-m-d H:i:s');

            // Verificar duplicado lógico (misma fecha, hora_ini, hora_fin, bloque, ambiente, pero distinto id)
            $sql_duplicado = "
                SELECT id FROM agenda_ambientes
                WHERE fecha = '$fecha'
                  AND fecha_fin = '$fecha_fin'
                  AND hora_ini = '$hora_ini'
                  AND hora_fin = '$hora_fin'
                  AND bloque_id = $bloque_id
                  AND ambiente_id = $ambiente_id
                  AND id != $id
            ";
            $res_duplicado = mysqli_query($con, $sql_duplicado);

            if ($res_duplicado && mysqli_num_rows($res_duplicado)) {
                $omitidos++;
                continue;
            }

            // Verificar si el ID existe
            $sql_existencia = "SELECT id FROM agenda_ambientes WHERE id = $id";
            $result = mysqli_query($con, $sql_existencia);

            if ($result && mysqli_num_rows($result)) {
                // Actualizar
                $sql_update = "
                    UPDATE agenda_ambientes SET
                        fecha = '$fecha',
                        fecha_fin = '$fecha_fin',
                        hora_ini = '$hora_ini',
                        hora_fin = '$hora_fin',
                        bloque_id = $bloque_id,
                        ambiente_id = $ambiente_id,
                        titulacion_id = $titulacion_id,
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
                    INSERT INTO agenda_ambientes
                        (id, fecha, fecha_fin, hora_ini, hora_fin, bloque_id, ambiente_id, titulacion_id, estado, usuario_create, usuario_act, fecha_create, fecha_act)
                    VALUES
                        ($id, '$fecha', '$fecha_fin', '$hora_ini', '$hora_fin', $bloque_id, $ambiente_id, $titulacion_id, $estado, 1, 1, '$fecha_actual', '$fecha_actual')
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

        // Asegura que solo se imprima JSON y nada más
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            "status" => "success",
            "message" => "Datos procesados correctamente.",
            "insertados" => $insertados,
            "actualizados" => $actualizados,
            "omitidos" => $omitidos
        ]);
        exit;
    } else {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(["status" => "error", "message" => "Error al abrir el archivo CSV."]);
        exit;
    }
} else {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(["status" => "error", "message" => "Método no permitido o archivo no recibido."]);
    exit;
}
?>