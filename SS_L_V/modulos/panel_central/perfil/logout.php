<?php
/**
 * logout.php - Cierre de sesión de usuario | Sena Stock
 * -----------------------------------------------------
 * Este archivo destruye la sesión activa del usuario,
 * eliminando todas las variables de sesión y devolviendo
 * una respuesta JSON de éxito para el frontend.
 * 
 * Salida:
 *   - JSON: { "status": "success" }
 * 
 * Autor: [Tu Nombre o Equipo]
 * Fecha: [Fecha de creación o última modificación]
 */

session_start();         // Inicia la sesión para poder destruirla
session_unset();         // Elimina todas las variables de sesión
session_destroy();       // Destruye la sesión actual
echo json_encode(["status" => "success"]); // Devuelve respuesta de éxito en formato JSON
exit();                 // Finaliza el script
?>
