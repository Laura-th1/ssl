<?php
require_once("../../../includes/conexiones/Base_Datos/conexion.php");
header("Content-Type: application/json");

// Configuración de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
$con = conectar();
if (!$con) {
    echo json_encode(["status" => "error", "message" => "Error de conexión: " . mysqli_connect_error()]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
    $file = $_FILES['csv_file'];

    // Validaciones del archivo
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(["status" => "error", "message" => "Error en el archivo: " . $file['error']]);
        exit;
    }

    // Procesar CSV
    $handle = fopen($file['tmp_name'], "r");
    if ($handle === FALSE) {
        echo json_encode(["status" => "error", "message" => "No se pudo leer el archivo"]);
        exit;
    }

    // Configuración
    $usuario_id = 1; // ID del usuario que importa (ajustar según tu sistema)
    $estado_default = 1; // Estado activo

    // Contadores
    $resultados = [
        'insertados' => 0,
        'actualizados' => 0,
        'omitidos' => 0,
        'errores' => []
    ];

    // Iniciar transacción
    mysqli_begin_transaction($con);

    try {
        $row_number = 0;
        while (($data = fgetcsv($handle)) !== FALSE) {
            $row_number++;
            
            // Saltar encabezado (fila 1)
            if ($row_number === 1) continue;

            // Validar datos mínimos (id, producto_id, cantidad, observacion)
            if (count($data) < 4) {
                $resultados['omitidos']++;
                $resultados['errores'][] = "Fila $row_number: No tiene suficientes columnas (se esperaban al menos 4)";
                continue;
            }

            // Obtener y validar datos
            $id = intval($data[0]);
            $producto_id = intval($data[1]);
            $cantidad = intval($data[2]);
            $observacion = trim($data[3]);
           

            // Validación básica de datos
            if ($producto_id <= 0 || $cantidad < 0) {
                $resultados['omitidos']++;
                $resultados['errores'][] = "Fila $row_number: Datos inválidos (producto_id o cantidad)";
                continue;
            }

            // Verificar si el producto existe
            $query = "SELECT id FROM productos WHERE id = $producto_id LIMIT 1";
            $res = mysqli_query($con, $query);

            if (!$res || mysqli_num_rows($res) === 0) {
                $resultados['omitidos']++;
                $resultados['errores'][] = "Fila $row_number: Producto con ID $producto_id no encontrado";
                continue;
            }

            // Verificar si el producto ya existe en el inventario
            $query = "SELECT id FROM datos_inventario WHERE producto_id = $producto_id LIMIT 1";
            $res = mysqli_query($con, $query);

            if ($res && mysqli_num_rows($res) > 0) {
                // Producto duplicado encontrado
                $duplicado = mysqli_fetch_assoc($res);
                $duplicado_id = $duplicado['id'];

                // Enviar respuesta al frontend para mostrar la alerta de confirmación
                echo json_encode([
                    "status" => "duplicado",
                    "message" => "El producto con ID $producto_id ya existe en el inventario. ¿Desea actualizarlo?",
                    "duplicado_id" => $duplicado_id
                ]);
                exit;
            }

            // Escapar valores
            $observacion_esc = mysqli_real_escape_string($con, $observacion);
            
            $fecha = date('Y-m-d H:i:s');

            

            // Determinar si es actualización o inserción
            if ($duplicado_id) {
                // ACTUALIZAR registro existente
                $sql = "UPDATE datos_inventario SET
                        producto_id = $producto_id,
                        cantidad = $cantidad,
                        observacion = '$observacion_esc',
                        usuario_act = $usuario_id,
                        fecha_act = '$fecha'
                    WHERE id = $id";

                if (!mysqli_query($con, $sql)) {
                    throw new Exception("Error al actualizar fila $row_number: " . mysqli_error($con));
                }
                $resultados['actualizados']++;
            } else {
                // INSERTAR nuevo registro
                $sql = "INSERT INTO datos_inventario (inventario_id,
                    producto_id, cantidad, observacion, 
                    estado, usuario_create, fecha_create
                ) VALUES (
                    $id, $producto_id, $cantidad, '$observacion_esc', 
                    $estado_default, $usuario_id, '$fecha'
                )";

                if (!mysqli_query($con, $sql)) {
                    throw new Exception("Error al insertar fila $row_number: " . mysqli_error($con));
                }
                $resultados['insertados']++;
            }
        }

        // Confirmar cambios si todo fue bien
        mysqli_commit($con);
        fclose($handle);

        // Respuesta exitosa
        $response = [
            "status" => "success",
            "message" => "Importación completada",
            "resultados" => $resultados
        ];

    } catch (Exception $e) {
        // Revertir en caso de error
        mysqli_rollback($con);
        fclose($handle);

        $response = [
            "status" => "error",
            "message" => $e->getMessage(),
            "resultados" => $resultados,
            "ultima_fila" => $row_number
        ];
    }

    echo json_encode($response);

} else {
    echo json_encode(["status" => "error", "message" => "Solicitud inválida"]);
}
?>