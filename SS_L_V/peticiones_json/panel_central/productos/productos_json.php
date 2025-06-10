<?php
header('Content-Type: application/json');   
include_once("../../../includes/conexiones/Base_Datos/conexion.php");

$con = conectar();
$alerta = "";
$mensaje = "";

// Obtener usuario por número de documento
if ($_POST['opcion'] == 'ObtenerUsuarioPorDocumento') {
    $documento = $_POST['documento'];
    
    $consulta = "SELECT id, nombre FROM usuarios WHERE numero_documento = '".$documento."'";
    $data_con = $con->query($consulta);
    
    if ($data_con->num_rows > 0) {
        $usuario = $data_con->fetch_assoc();
        print json_encode(array("ALERTA" => "OK", "NOMBRE" => $usuario['nombre'], "ID" => $usuario['id']));
    } else {
        print json_encode(array("ALERTA" => "ERROR", "MENSAJE" => "Usuario no encontrado"));
    }
}

// Consultar todos los productos
elseif ($_POST['opcion'] == 'AccionConsultar') {
    if ($_POST['accion'] == 'ConsultarTodos') {
        $data = [];
        $numero = 1;

        $consulta = "SELECT 
                        p.*, 
                        CONCAT(u.nombre, ' ', u.apellido) AS nombre_usuario
                     FROM productos p
                     LEFT JOIN usuarios u ON p.usuario_id = u.id";

        $data_con = $con->query($consulta);

        if ($data_con->num_rows > 0) {
            foreach ($data_con as $datos) {
                $data[] = array(
                    "NUMERO"            => $numero,
                    "ID"                => $datos["id"],
                    "DESCRIPCION"       => $datos["descripcion"],
                    "NUMERO_PLACA"      => $datos["numero_placa"],
                    "OBSERVACION"       => $datos["observacion"],
                    "ESTADO"            => ($datos["estado"] == 1) ? "Activo" : "Inactivo",
                    "ESTADO_INT"        => $datos["estado"],
                    "USUARIO"           => $datos["nombre_usuario"] ?? "Sin asignar",
                    "IMAGEN"            => $datos["imagen"] ?? "Sin imagen" // Nuevo campo
                );
                $numero++;
            }
        }
        print json_encode(array("DATA" => $data));
    }
}
// Insertar producto
elseif ($_POST['opcion'] == 'AccionInsertar') {
    $nombre = $_POST["nombre"];
    $numero_placa = $_POST["numero_placa"];
    $observacion = $_POST["observacion"];
    $usuario_id = $_POST["usuario_id"];
    $imagen = guardarImagen('imagen');

    $consulta = "SELECT * FROM productos WHERE descripcion = '".$nombre."'";
    $data_con = $con->query($consulta);

    if ($data_con->num_rows == 0) {
        $alerta = "OK";
        $mensaje = "";

        $consulta = "INSERT INTO productos (descripcion, numero_placa, observacion, estado, usuario_create, usuario_id, usuario_act, fecha_create, fecha_act, imagen)
                        VALUES ('".$nombre."','".$numero_placa."', '".$observacion."', 1, 1, '".$usuario_id."', NULL, CURRENT_TIMESTAMP, CURRENT_DATE, ".($imagen ? "'".$con->real_escape_string($imagen)."'" : "NULL").")";
        $data = $con->query($consulta);
    } else {
        $alerta = "ERROR";
        $mensaje = "Ya existe este producto.";
    }

    print json_encode(array("ALERTA" => $alerta, "MENSAJE" => $mensaje));
}

elseif ($_POST['opcion'] == 'AccionActualizar') {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $numero_placa = $_POST["numero_placa"];
    $observacion = $_POST["observacion"];
    $estado = $_POST["estado"];
    $usuario_id = $_POST["usuario_id"];
    $imagen = guardarImagen('imagen');

    $consulta = "SELECT * FROM productos WHERE descripcion = '".$nombre."' AND id <> '".$id."'";
    $data_con = $con->query($consulta);

    if ($data_con->num_rows == 0) {
        $alerta = "OK";
        $mensaje = "";

        $setImagen = $imagen ? ", imagen = '".$con->real_escape_string($imagen)."'" : "";

        $consulta = "UPDATE productos
                        SET descripcion = '".$nombre."',
                            numero_placa = '".$numero_placa."',
                            observacion = '".$observacion."',
                            estado = '".$estado."',
                            usuario_id = '".$usuario_id."',
                            usuario_act = 1, 
                            fecha_act = CURRENT_TIMESTAMP
                            $setImagen
                        WHERE id = '".$id."';";
        $data = $con->query($consulta);
    } else {
        $alerta = "ERROR";
        $mensaje = "Ya existe este producto.";
    }

    print json_encode(array("ALERTA" => $alerta, "MENSAJE" => $mensaje));
}


function guardarImagen($inputName = 'imagen') {
    $rutaFinal = null;
    if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] == UPLOAD_ERR_OK) {
        // Ruta absoluta en el servidor
        $dir = dirname(__DIR__, 3) . '/uploads/productos/';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $nombreArchivo = uniqid('prod_') . '_' . basename($_FILES[$inputName]['name']);
        $ruta = $dir . $nombreArchivo;
        if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $ruta)) {
            // Ruta relativa para guardar en la BD (accesible por el navegador)
            $rutaFinal = '/ssl/SS_L_V/uploads/productos/' . $nombreArchivo;
        }
    }
    return $rutaFinal;
}

?>
