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


            if ($row_number === 1) {
                continue; // O procesar encabezado
            }

            if (count($row_data) !== 4) {
                echo json_encode(["status" => "error", "message" => "Número incorrecto de columnas en la fila " . $row_number . ". Se esperaban 4."]);
                fclose($handle);
                exit;
            }

            $id_datos_inventario = intval($row_data[0]);
            $articulo = $con->real_escape_string(trim($row_data[1]));
            $cantidad = intval($row_data[2]);
            $observacion = $con->real_escape_string(trim($row_data[3]));
            $fecha_actual = date('Y-m-d H:i:s');

            // Buscar producto por descripción
            $sql_producto = "SELECT id FROM productos WHERE descripcion = '$articulo'";
            $res_producto = mysqli_query($con, $sql_producto);
            $producto = mysqli_fetch_assoc($res_producto);

            if (!$producto) {
                echo json_encode(["status" => "warning", "message" => "Producto no encontrado para Artículo: '$articulo' en la fila " . $row_number . ". Fila omitida."]);
                $omitidos++;
                continue;
            }

            // Verificar si el registro en datos_inventario existe para actualizar
            if ($id_datos_inventario > 0) {
                $sql_update_inv = "
                    UPDATE datos_inventario SET
                        producto_id = {$producto['id']},
                        cantidad = $cantidad,
                        observacion = '$observacion',
                        usuario_act = 1, // Manteniendo un usuario por defecto o NULL según tu necesidad
                        fecha_act = '$fecha_actual'
                    WHERE id = $id_datos_inventario
                ";
                if (mysqli_query($con, $sql_update_inv)) {
                    $actualizados++;
                } else {
                    echo json_encode(["status" => "error", "message" => "Error al actualizar datos de inventario en la fila " . $row_number . ": " . mysqli_error($con)]);
                    fclose($handle);
                    exit;
                }

            } else {
                // Insertar nuevo registro en datos_inventario
                $inventario_id_fijo = 1; // ¡DEBES AJUSTAR ESTO!
                $sql_insert_inv = "
                    INSERT INTO datos_inventario (inventario_id, producto_id, cantidad, observacion, estado, usuario_create, fecha_create)
                    VALUES ($inventario_id_fijo, {$producto['id']}, $cantidad, '$observacion', 1, 1, '$fecha_actual') // Manteniendo un usuario por defecto o NULL
                ";
                if (mysqli_query($con, $sql_insert_inv)) {
                    $insertados++;
                } else {
                    echo json_encode(["status" => "error", "message" => "Error al insertar datos de inventario en la fila " . $row_number . ": " . mysqli_error($con)]);
                    fclose($handle);
                    exit;
                }

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