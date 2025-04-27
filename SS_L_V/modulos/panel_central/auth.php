<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login/index.php'); // Redirige al login si no está autenticado
    exit();
}
?>
