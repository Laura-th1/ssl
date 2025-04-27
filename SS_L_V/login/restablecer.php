<?php
require '../vendor/autoload.php'; // Incluir PHPMailer correctamente

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Configurar conexión a la base de datos
require_once '../includes/conexiones/Base_Datos/conexion.php';
$con = conectar(); // Llamar a la función conectar() para obtener la conexión


$correo = $_POST["correo"];
$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

// Guardar el token en la base de datos
$sql = "UPDATE usuarios SET token = ?, token_expired = ? WHERE correo = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("sss", $token_hash, $expiry, $correo);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // Verificar que el token se guardó correctamente
    $sql = "SELECT token FROM usuarios WHERE correo = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['token'] !== $token_hash) {
        die("Error: El token en la base de datos no coincide con el token generado.");
    }

    $mail = new PHPMailer(true);

    try {
        // Configuración de PHPMailer
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->Username = "sena.stock3@gmail.com";
        $mail->Password = "cdpe vrpz wxtd hbim";

        $mail->setFrom("noreply@example.com");
        $mail->addAddress($correo);
        $mail->Subject = "Restablecer contrasena";
        $mail->isHTML(true);
        $mail->Body = <<<END
        Bienvenid@... Haz clic <a href="http://localhost/ssl/SS_L_V/login/recupera_contra.php?token=$token_hash">aquí</a> para restablecer la contraseña de tu usuario.
        END;

        $mail->send();
        header("Location: http://localhost/ssl/SS_L_V/login/mensaje.php?mensaje=Correo enviado.");
        exit; // Detener la ejecución después de redirigir
    } catch (Exception $e) {
        echo "No se envió el correo: {$mail->ErrorInfo}";
    }
} else {
    header("Location: http://localhost/ssl/SS_L_V/login/?=Correo no encontrado.&tipo=error");
    exit;
}