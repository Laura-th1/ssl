<?php
header('Content-Type: application/json');   
include_once("../../../includes/conexiones/Base_Datos/conexion.php");

$con = conectar();
$alerta = "";
$mensaje = "";

if ($_POST['opcion'] == 'AccionConsultar') {
    if ($_POST['accion'] == 'ConsultarTodos') {
        $data = [];
        $numero = 1;

        $consulta = "SELECT 
                        inv.inventario_id,
                        inv.nombre,
                        bloq.id AS bloque_id,
                        bloq.descripcion AS bloque_desc,
                        inv.observacion,
                        inv.estado
                    FROM inventarios inv
                    INNER JOIN bloques bloq ON (bloq.id = inv.bloque_id)";
        $data_con = $con->query($consulta);

        if ($data_con->num_rows > 0) {
            foreach ($data_con as $datos) {
                $data[] = array(
                    "NUMERO" => $numero,
                    "ID" => $datos["inventario_id"], // Cambiado a inventario_id
                    "NOMBRE" => $datos["nombre"],
                    "BLOQ_ID" => $datos["bloque_id"],
                    "BLOQ_DESC" => $datos["bloque_desc"],
                    "OBSERVACION" => $datos["observacion"],
                    "ESTADO" => ($datos["estado"] == 1) ? "Activo" : "Inactivo",
                    "ESTADO_INT" => $datos["estado"],
                );
                $numero++;
            }
        }

        print json_encode(array("DATA" => $data));
    } elseif ($_POST['accion'] == 'ConsultarBloques') {
        $data = [];

        $consulta = "SELECT 
                        *
                    FROM bloques
                    WHERE estado = 1";
        $data_con = $con->query($consulta);

        if ($data_con->num_rows > 0) {
            foreach ($data_con as $datos) {
                $data[] = array(
                    "ID" => $datos["id"],
                    "DESCRIPCION" => $datos["descripcion"],
                );
            }
        }
        print json_encode(array("DATA" => $data));
    } elseif ($_POST['accion'] == 'ConsultarUno') {

        
        $data = [];
        $id_inv = $_POST["id_inv"];
        $numero = 1;

        $consulta = "SELECT
                            dat_inv.id,
                            dat_inv.producto_id,
                            prod.descripcion prod_desc,
                            dat_inv.observacion,
                            dat_inv.estado,
                            prod.numero_placa num_placs,
                            us.nombre,
                            us.apellido
                         FROM datos_inventario dat_inv
                         INNER JOIN productos prod ON (prod.id = dat_inv.producto_id)
                         INNER JOIN usuarios us ON (us.id = prod.usuario_id)
                         WHERE dat_inv.inventario_id = ".$id_inv;
        $data_con = $con->query($consulta);

        if($data_con->num_rows > 0){
            foreach($data_con as $datos){
                $data[] = array(
                    "NUMERO" => $numero,
                    "ID" => $datos["id"],
                    "PRODUC_ID" => $datos["producto_id"],
                    "PROD_DES" => $datos["prod_desc"],
                    "OBSERVACION" => $datos["observacion"],
                    "ESTADO" => ($datos["estado"] == 1)? "Activo" : "Inactivo",
                    "ESTADO_INT" => $datos["estado"],
                    "NUM_PLAC" => $datos["num_placs"],
                    "USUARIO" => $datos["nombre"] . " " . $datos["apellido"]
                );
                $numero++;
            }
        }

        print json_encode(array("DATA" => $data));
    } elseif ($_POST['accion'] == 'ConsultarProductos') {

        $data               =                   [];

        $consulta = "SELECT 
                            *
                        FROM productos
                        WHERE estado = 1";
        $data_con 				=								$con->query($consulta);

            if($data_con->num_rows > 0){
                foreach($data_con as $datos){
                    $data[] = array(
                                        "ID"                =>          $datos["id"],
                                        "DESCRIPCION"       =>          $datos["descripcion"],
                                    );
                }
            }
        print json_encode(array("DATA" => $data));
    }
} elseif ($_POST['opcion'] == 'AccionInsertar') {
    $nombre = $_POST["nombre"];
    $bloque = $_POST["bloque"];
    $observacion = $_POST["observacion"];

    $consulta = "SELECT 
                            *
                        FROM inventarios
                        where nombre = '".$nombre."'
                        and bloque_id = ".$bloque."";
    $data_con 				=								$con->query($consulta);

    if($data_con->num_rows == 0){
        $alerta                     =                   "OK";
        $mensaje                    =                   "";

        $consulta = "INSERT INTO inventarios (nombre, bloque_id, observacion, estado, usuario_create, usuario_act, fecha_create, fecha_act)
                            VALUES ('".$nombre."', ".$bloque.", '".$observacion."', 1, 1, NULL, CURRENT_TIMESTAMP, CURRENT_DATE)";
        $data                 =               $con->query($consulta);
    }else{
        $alerta                     =                   "ERROR";
        $mensaje                    =                   "Ya existe este inventario.";
    }

    print json_encode(array("ALERTA" => $alerta, "MENSAJE" => $mensaje));
} elseif ($_POST['opcion'] == 'AccionInsertarInv') {
    $observacion = $_POST["observacion"];
    $producto = $_POST["producto"];
    $id_inv = $_POST["id_inv"];
    


    $consulta = "SELECT 
                            *
                        FROM datos_inventario
                        where producto_id = '".$producto."'
                        and inventario_id = ".$id_inv."";
    $data_con 				=								$con->query($consulta);

    if($data_con->num_rows == 0){
        $alerta                     =                   "OK";
        $mensaje                    =                   "";

        $consulta = "INSERT INTO datos_inventario (inventario_id, producto_id,  observacion, estado, usuario_create, usuario_act, fecha_create, fecha_act)
                            VALUES (".$id_inv.", ".$producto.",  '".$observacion."', 1, 1, NULL, CURRENT_TIMESTAMP, CURRENT_DATE)";
        $data                 =               $con->query($consulta);
    }else{
        $alerta                     =                   "ERROR";
        $mensaje                    =                   "Ya existe este elemento en el inventario.";
    }

    print json_encode(array("ALERTA" => $alerta, "MENSAJE" => $mensaje));
} elseif ($_POST['opcion'] == 'AccionActualizar') {
    $id = $_POST["inventario_id"];
    $nombre = $_POST["nombre"];
    $estado = $_POST["estado"];
    $bloque = $_POST["bloque"];
    $observacion = $_POST["observacion"];

    $consulta = "SELECT 
                    *
                FROM inventarios
                WHERE nombre = '".$nombre."'
                AND bloque_id = ".$bloque."
                AND inventario_id <> '".$id."'";
    $data_con = $con->query($consulta);

    if ($data_con->num_rows == 0) {
        $alerta = "OK";
        $mensaje = "";

        $consulta = "UPDATE inventarios
                        SET nombre = '".$nombre."',
                            observacion = '".$observacion."', 
                            estado = '".$estado."', 
                            bloque_id = ".$bloque.",
                            usuario_act = 1, 
                            fecha_act = CURRENT_TIMESTAMP
                        WHERE inventario_id = '".$id."';";
        
        // Agrega un registro para depurar la consulta
        error_log("Consulta de actualización ejecutada: " . $consulta);

        $data = $con->query($consulta);

        // Verifica si la consulta se ejecutó correctamente
        if (!$data) {
            $alerta = "ERROR";
            $mensaje = "Error al ejecutar la consulta: " . $con->error;
            error_log("Error en la consulta de actualización: " . $con->error);
        }
    } else {
        $alerta = "ERROR";
        $mensaje = "Ya existe este Inventario.";
    }

    print json_encode(array("ALERTA" => $alerta, "MENSAJE" => $mensaje));
} elseif ($_POST['opcion'] == 'AccionActualizarInv') {
    $id = $_POST["id"];
    
    $observacion = $_POST["observacion"];

    $alerta                     =                   "OK";
    $mensaje                    =                   "";

    $consulta = "UPDATE datos_inventario
                    SET 
                        observacion = '".$observacion."', 
                        usuario_act = 1, 
                        fecha_act = CURRENT_TIMESTAMP
                    WHERE id = '".$id."';";
    $data                 =               $con->query($consulta);

    print json_encode(array("ALERTA" => $alerta, "MENSAJE" => $mensaje));
} elseif ($_POST['opcion'] == "AccionEliminar") {
    $id = $_POST["id"];
    $consulta = "DELETE FROM datos_inventario WHERE id = ".$id;
    $data                 =               $con->query($consulta);

    print json_encode(array("ALERTA" => "OK"));
}
