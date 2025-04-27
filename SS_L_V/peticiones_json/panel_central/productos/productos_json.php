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
                    "OBSERVACION"       => $datos["observacion"],
                    "ESTADO"            => ($datos["estado"] == 1) ? "Activo" : "Inactivo",
                    "ESTADO_INT"        => $datos["estado"],
                    "USUARIO"           => $datos["nombre_usuario"] ?? "Sin asignar"
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
    $observacion = $_POST["observacion"];
    $usuario_id = $_POST["usuario_id"];  // ID del usuario que crea el producto

    $consulta = "SELECT * FROM productos WHERE descripcion = '".$nombre."'";
    $data_con = $con->query($consulta);

    if ($data_con->num_rows == 0) {
        $alerta = "OK";
        $mensaje = "";

        $consulta = "INSERT INTO productos (descripcion, observacion, estado, usuario_create, usuario_id, usuario_act, fecha_create, fecha_act)
                        VALUES ('".$nombre."', '".$observacion."', 1, 1, '".$usuario_id."', NULL, CURRENT_TIMESTAMP, CURRENT_DATE)";
        $data = $con->query($consulta);
    } else {
        $alerta = "ERROR";
        $mensaje = "Ya existe este producto.";
    }

    print json_encode(array("ALERTA" => $alerta, "MENSAJE" => $mensaje));
}

// Actualizar producto
elseif ($_POST['opcion'] == 'AccionActualizar') {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $observacion = $_POST["observacion"];
    $estado = $_POST["estado"];
    $usuario_id = $_POST["usuario_id"];  // ID del usuario que actualiza el producto

    $consulta = "SELECT * FROM productos WHERE descripcion = '".$nombre."' AND id <> '".$id."'";
    $data_con = $con->query($consulta);

    if ($data_con->num_rows == 0) {
        $alerta = "OK";
        $mensaje = "";

        $consulta = "UPDATE productos
                        SET descripcion = '".$nombre."',
                            observacion = '".$observacion."',
                            estado = '".$estado."',
                            usuario_id = '".$usuario_id."',
                            usuario_act = 1, 
                            fecha_act = CURRENT_TIMESTAMP
                        WHERE id = '".$id."';";
        $data = $con->query($consulta);
    } else {
        $alerta = "ERROR";
        $mensaje = "Ya existe este producto.";
    }

    print json_encode(array("ALERTA" => $alerta, "MENSAJE" => $mensaje));
}
