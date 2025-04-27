<?php
require_once '../includes/conexiones/Base_Datos/conexion.php';
$con = conectar(); // Llamar a la función conectar() para obtener la conexión

if (!isset($_GET["token"])) {
    die("No se recibió ningún token.");
}

$token_hash = $_GET["token"]; // Usar directamente el hash recibido en la URL

// Depuración
// echo "Token hash recibido: " . htmlspecialchars($token_hash) . "<br>";

// Verificar el token en la base de datos
$sql = "SELECT token, token_expired FROM usuarios WHERE token = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $token_hash);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("No se encontró el token en la base de datos.");
}

// // Depuración
// echo "Token hash en la base de datos: " . $user["token"] . "<br>";
// echo "Hora de expiración del token: " . $user["token_expired"] . "<br>";
// echo "Hora actual del servidor: " . date("Y-m-d H:i:s") . "<br>";

// // Verificar si el token ha expirado
// if (strtotime($user["token_expired"]) <= time()) {
//     die("El token ha expirado.");
// }
// ?>

<html lang="es">
<title>Cambiar Contraseña</title>
<link rel="stylesheet" href="../includes/css/login/recupera_contra.css"></link>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="../includes/css/login/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="../includes/img/logos/favicon.png" />
    <link href="../includes/css/panel_administrativo/spinners.css" id="theme" rel="stylesheet">
    <link href="../includes/librerias/jquery-confirm/css/jquery-confirm.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<body>
<div class="container">
    <div class="img"></div>
    <form class="FormRecCon" action="procesar_cambio.php" method="POST">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token_hash) ?>"> 
        <h2>Ingrese su nueva contraseña</h2>
        <div class="input-container">
            <input type="password" name="password" id="password" placeholder="Nueva contraseña" required>
            <i class="fa fa-eye" id="togglePassword"></i>
        </div>
        <button class="btn" type="submit">Enviar</button>
    </form>
</div>
</body>

<script>
    document.getElementById("togglePassword").addEventListener("click", function () {
        var passwordInput = document.getElementById("password");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            this.classList.remove("fa-eye");
            this.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            this.classList.remove("fa-eye-slash");
            this.classList.add("fa-eye");
        }
    });
</script>
</html>