<?php
require_once '../includes/conexiones/Base_Datos/conexion.php';
$con = conectar(); // Llamar a la función conectar() para obtener la conexión

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["token"]) || !isset($_POST["password"])) {
        $mensaje = "Datos incompletos.";
    } else {
        $token_hash = $_POST["token"];
        $password = $_POST["password"];

        // Verificar el token en la base de datos
        $sql = "SELECT * FROM usuarios WHERE token = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $token_hash);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!$user) {
            $mensaje = "No se encontró el token.";
        } elseif (strtotime($user["token_expired"]) <= time()) {
            $mensaje = "El token ha expirado.";
        } else {
            // Aplicar hash a la nueva contraseña
            $password_hash = password_hash($password, PASSWORD_BCRYPT);

            // Actualizar la contraseña en la base de datos
            $sql = "UPDATE usuarios SET password = ?, token = NULL, token_expired = NULL WHERE id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("si", $password_hash, $user["id"]);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                header("Location: RecuperaCon.php?mensaje=Contraseña Cambiada.");
                exit; // Detener la ejecución después de redirigir
            } else {
                header("Location: RecuperaCon.php?mensaje=No se cambió la contraseña.");
                exit; // Detener la ejecución después de redirigir
            }
        }
    }
}
?>