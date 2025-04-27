<?php
header('Content-Type: application/json');   
include_once("../../includes/conexiones/Base_Datos/conexion.php");

$function_name 			    = $_POST['jsonp'];
$con                        = conectar();
$alerta                     = "";
$mensaje                    = "";

if($_POST['opcion'] == 'AccionIniciarSesion'){
    if($_POST['accion'] == 'Iniciar'){
        $usuario = strtoupper(trim($_POST["usuario_correo"]));
        $consulta = "SELECT 
                        usu.id,
                        usu.tipo_documento_id,
                        usu.numero_documento,
                        usu.nombre,
                        usu.apellido,
                        usu.fecha_nacimiento,
                        usu.sexo_id,
                        usu.rol_id,
                        usu.correo,
                        usu.foto,
                        usu.usuario,
                        usu.password,
                        usu.telefono,
                        usu.estado,
                        usu.usuario_create,
                        usu.usuario_act,
                        usu.fecha_create,
                        usu.fecha_act,
                        tpd.id AS tpd_id,
                        tpd.descripcion AS tpd_desc,
                        rol.id AS rol_id,
                        rol.descripcion AS rol_desc,
                        sex.id AS sex_id,
                        sex.descripcion AS sex_desc
                    FROM usuarios usu
                    INNER JOIN tp_documentos tpd ON tpd.id = usu.tipo_documento_id
                    INNER JOIN sexos sex ON sex.id = usu.sexo_id
                    INNER JOIN roles rol ON rol.id = usu.rol_id
                    WHERE (usu.usuario = '{$usuario}' OR usu.correo = '{$usuario}')";

        $data = $con->query($consulta);

        if ($data->num_rows > 0) {
            foreach ($data as $datos) {
                if ($datos["estado"] == 1) {
                    if (password_verify(trim($_POST["password"]), $datos["password"])) {
                        session_start();

                        $_SESSION['ID']                 = $datos["id"];
                        $_SESSION['TIPO_DOCUMENTO']     = $datos["tpd_desc"];
                        $_SESSION['NUMERO_DOCUMENTO']   = $datos["numero_documento"];
                        $_SESSION['NOMBRE_COMPLETO']    = $datos["nombre"] . " " . $datos["apellido"];
                        $_SESSION['NOMBRE_CORTO']       = $datos["nombre"];
                        $_SESSION['FECHA_NACIMIENTO']   = $datos["fecha_nacimiento"];
                        $_SESSION['CORREO_PERSONAL']    = $datos["correo"];
                        $_SESSION['TELEFONO']           = $datos["telefono"];
                        $_SESSION['ROL']                = $datos["rol_desc"];
                        $_SESSION['SEXO']               = $datos["sex_desc"];
                        $_SESSION['ESTADO']             = $datos["estado"];
                        $_SESSION['USUARIO']            = $datos["usuario"];
                        $_SESSION['FOTO']               = $datos["foto"];
                        $_SESSION['ESTADO_SESSION']     = "Activo";

                        $alerta = "OK";
                        $mensaje = "Bienvenido a Sena Stock.";
                    } else {
                        $alerta = "ERROR";
                        $mensaje = "Contraseña Incorrecta.";
                    }
                } else {
                    $alerta = "ERROR";
                    $mensaje = "El Usuario existe, pero esta inactivo, porfavor contactarse con el administrador para poder activarlo.";
                }
            }
        } else {
            $alerta = "ERROR";
            $mensaje = "Usuario no encontrado.";
        }
    } else {
        $alerta = "ERROR";
        $mensaje = "El Usuario ingresado no existe.";
    }

    print json_encode(array("ALERTA" => $alerta, "MENSAJE" => $mensaje));

} else if($_POST['opcion'] == 'AccionCerrar'){
    session_start();
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    session_destroy();
    print json_encode(array("ALERTA" => "OK"));
}
?>
