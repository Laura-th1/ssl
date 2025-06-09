<?php
header('Content-Type: application/json');
include_once("../../../includes/conexiones/Base_Datos/conexion.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../../vendor/phpmailer/phpmailer/src/Exception.php';
require '../../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../../vendor/phpmailer/phpmailer/src/SMTP.php';
$function_name                 =                     $_POST['jsonp'];
$con                        =                   conectar();
$alerta                     =                   "";
$mensaje                    =                   "";




// Función para cambiar el estado del usuario
if ($_POST['opcion'] == 'AccionCambiarEstado') {
    $id = intval($_POST['id']);
    $estado = intval($_POST['estado']);

    // Prepara la consulta SQL de forma segura usando placeholders (?)
    $consulta = "UPDATE usuarios SET estado = ? WHERE id = ?";

    // Crea una sentencia preparada
    $stmt = $con->prepare($consulta);

    // Verifica si la preparación de la sentencia falló
    if ($stmt === false) {
        // Registra el error para depuración (no muestres errores internos directamente al usuario en producción)
        error_log("Error al preparar la consulta para AccionCambiarEstado: " . $con->error);
        print json_encode(array("ALERTA" => "ERROR", "MENSAJE" => "Error interno del servidor al procesar la solicitud."));
    } else {
        // Vincula los parámetros a los placeholders
        // "ii" significa que ambos parámetros son enteros (integer)
        $stmt->bind_param("ii", $estado, $id);

        // Ejecuta la sentencia preparada
        $data = $stmt->execute();

        if ($data) {
            print json_encode(array("ALERTA" => "OK"));
        } else {
            // Obtiene el error de la ejecución de la sentencia
            error_log("Error al ejecutar la consulta para AccionCambiarEstado: " . $stmt->error);
            print json_encode(array("ALERTA" => "ERROR", "MENSAJE" => "Error al actualizar el estado del usuario: " . $stmt->error));
        }

        // Cierra la sentencia
        $stmt->close();
    }
}

if ($_POST['opcion'] == 'AccionConsultar') {
    if ($_POST['accion'] == 'ConsultarTodos') {

        $data               =                   [];
        $numero             =                   1;

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
                        INNER JOIN roles rol ON rol.id = usu.rol_id;";
        $data_con                 =                                $con->query($consulta);

        if ($data_con->num_rows > 0) {
            foreach ($data_con as $datos) {

                $data[] = array(
                    "NUMERO"             => $numero,
                    "ID"                 => $datos["id"],
                    "IDENTIFICACION"     => $datos["tpd_desc"]."-".$datos["numero_documento"],
                    "TIPO_DOCUMENTO_ID"  => $datos["tpd_id"],
                    "TIPO_DOCUMENTO_DESC"=> $datos["tpd_desc"],
                    "ROL_ID"             => $datos["rol_id"],
                    "ROL_DESC"           => $datos["rol_desc"],
                    "SEXO_ID"            => $datos["sex_id"],
                    "SEXO_DESC"          => $datos["sex_desc"],
                    "NUMERO_DOCUMENTO"   => $datos["numero_documento"],
                    "NOMBRE_COMPLETO"    => $datos["nombre"]." ".$datos["apellido"],
                    "NOMBRE"             => $datos["nombre"],
                    "APELLIDO"           => $datos["apellido"],
                    "FECHA_NACIMIENTO"   => $datos["fecha_nacimiento"],
                    "CORREO"             => $datos["correo"],
                    "FOTO"               => $datos["foto"],
                    "USUARIO"            => $datos["usuario"],
                    "PASSWORD"           => $datos["password"],
                    "TELEFONO"           => $datos["telefono"],
                    "ESTADO"             => ($datos["estado"] == 1) ? "Activo" : "Inactivo",
                    "ESTADO_INT"         =>          $datos["estado"],
                );                
                $numero++;
            }
        }
        print json_encode(array("DATA" => $data));
    } elseif ($_POST['accion'] == 'ConsultarTPdocumentos') {

        $data               =                   [];

        $consulta = "SELECT 
                            *
                        FROM tp_documentos
                        WHERE estado = 1";
        $data_con                 =                                $con->query($consulta);

        if ($data_con->num_rows > 0) {
            foreach ($data_con as $datos) {
                $data[] = array(
                    "ID"                =>          $datos["id"],
                    "DESCRIPCION"       =>          $datos["descripcion"],
                );
            }
        }
        print json_encode(array("DATA" => $data));
    } elseif ($_POST['accion'] == 'ConsultarSexos') {

        $data               =                   [];

        $consulta = "SELECT 
                            *
                        FROM sexos
                        WHERE estado = 1";
        $data_con                 =                                $con->query($consulta);

        if ($data_con->num_rows > 0) {
            foreach ($data_con as $datos) {
                $data[] = array(
                    "ID"                =>          $datos["id"],
                    "DESCRIPCION"       =>          $datos["descripcion"],
                );
            }
        }
        print json_encode(array("DATA" => $data));
    } elseif ($_POST['accion'] == 'ConsultarRoles') {

        $data               =                   [];

        $consulta = "SELECT 
                            *
                        FROM roles
                        WHERE estado = 1";
        $data_con                 =                                $con->query($consulta);

        if ($data_con->num_rows > 0) {
            foreach ($data_con as $datos) {
                $data[] = array(
                    "ID"                =>          $datos["id"],
                    "DESCRIPCION"       =>          $datos["descripcion"],
                );
            }
        }
        print json_encode(array("DATA" => $data));
    }
} elseif ($_POST['opcion'] == 'AccionInsertar') {
    error_log("Datos recibidos en AccionInsertar: " . print_r($_POST, true));
    $tipo_documento_id = $_POST['tp_documento'];
    $numero_documento = $_POST['numero_documento'];
    $nombre = $_POST['nombres'];
    $apellido = $_POST['apellidos'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $sexo_id = $_POST['sexo'];
    $rol_id = $_POST['rol'];
    $correo = $_POST['email'];
    $usuario = strtoupper($_POST['usuario']);
    $password_original = $_POST['password']; // Contraseña original
    $password = password_hash($password_original, PASSWORD_BCRYPT); // Contraseña hasheada
    $telefono = $_POST['telefono'];

    $consulta = "SELECT * FROM usuarios WHERE numero_documento = '" . $numero_documento . "'";
    $data_con = $con->query($consulta);

    if ($data_con->num_rows == 0) {
        $consulta = "SELECT * FROM usuarios WHERE usuario = '" . $usuario . "' AND correo = '" . $correo . "'";
        $data_con = $con->query($consulta);

        if ($data_con->num_rows == 0) {
            $targetDir = "../../../includes/img/usuarios/" . $usuario . "/";

            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $targetFile = $targetDir . basename($_FILES["foto"]["name"]);
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFile)) {
                error_log("Archivo subido correctamente: " . $targetFile);
                $foto = $targetFile;
            } else {
                error_log("Error al subir el archivo.");
                $alerta = "ERROR";
                $mensaje = "No se pudo subir el archivo.";
                print json_encode(array("ALERTA" => $alerta, "MENSAJE" => $mensaje));
                exit;
            }
            $consulta = "INSERT INTO usuarios (tipo_documento_id, numero_documento, nombre, apellido, fecha_nacimiento, sexo_id, rol_id, correo, foto, usuario, password, telefono, estado, usuario_create) 
                                VALUES ('$tipo_documento_id', '$numero_documento', '$nombre', '$apellido', '$fecha_nacimiento', '$sexo_id', '$rol_id', '$correo', '$foto', '$usuario', '$password', '$telefono', 1, 1)";

            // Agrega un registro para depurar la consulta
            error_log("Consulta de inserción ejecutada: " . $consulta);

            $data = $con->query($consulta);

            // Verifica si la consulta se ejecutó correctamente
            if (!$data) {
                $alerta = "ERROR";
                $mensaje = "Error al ejecutar la consulta: " . $con->error;
                error_log("Error en la consulta de inserción: " . $con->error);
            } else {
                $alerta = "OK";
                $mensaje = "Usuario creado correctamente.";
            }
//inicio 
            if ($data) {
                // Enviar correo con PHPMailer
                $mail = new PHPMailer(true);
                try {
                    // Configuración del servidor SMTP
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'sena.stock3@gmail.com';;
                    $mail->Password =  'cdpe vrpz wxtd hbim';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;
                    $mail->SMTPDebug = 2; // Cambia a 0 para deshabilitar la depuración

                    // Configuración del correo
                    $mail->setFrom('sena.stock3@gmail.com', 'SENA STOCK');
                    $mail->addAddress($correo, $nombre . ' ' . $apellido);

                    $mail->isHTML(true);
                    $mail->Subject = 'Bienvenido a SENA STOCK';
                    $mail->Body = "
                        <h1>Bienvenido $nombre $apellido, ya puedes acceder al sistema.</h1>
                        <p>Su usuario ha sido registrado exitosamente. A continuación, le compartimos sus credenciales de acceso:</p>
                        <ul>
                            <li><strong>Usuario:</strong> $usuario</li>
                            <li><strong>Contraseña:</strong> $password_original</li>
                        </ul>
                          <p>Ya puede iniciar sesión en nuestro sistema http://localhost/ssl/SS_L_V</p>
                    ";

                    $mail->send();
                    error_log("Correo enviado correctamente a: " . $correo);
                    $alerta = "OK";
                    $mensaje = "Usuario creado y correo enviado correctamente.";
                } catch (Exception $e) {
                    error_log("Error al enviar el correo: " . $mail->ErrorInfo);
                    // No detengas el flujo si el correo falla
                    $alerta = "ERROR";
                    $mensaje = "Usuario creado, pero no se pudo enviar el correo. Error: " . $mail->ErrorInfo;
                }
            } else {
                $alerta = "ERROR";
                $mensaje = "Error al insertar el usuario en la base de datos.";
            }
        } else {
            $alerta = "ERROR";
            $mensaje = "Ya existe este usuario.";
        }
    } else {
        $alerta = "ERROR";
        $mensaje = "Ya existe este usuario.";
    }

    print json_encode(array("ALERTA" => $alerta, "MENSAJE" => $mensaje));
}elseif ($_POST['opcion'] == 'AccionEliminar') {
$consulta = "DELETE FROM usuarios WHERE id =".$_POST["id"];
$data                 =               $con->query($consulta);
$alerta                     =                   "OK";
$mensaje                    =                   "";
print json_encode(array("ALERTA" => $alerta, "MENSAJE" => $mensaje));
}


//fin 

?>