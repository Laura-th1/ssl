<?php 
session_start();

require_once '../../../includes/conexiones/Base_Datos/conexion.php';
$con = conectar(); // Llamar a la función conectar() para obtener la conexión

// Verificar si los datos del formulario fueron enviados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener el ID del usuario desde el formulario
    $id = $_POST['id_usuario'];
    if (empty($id) || !is_numeric($id)) {
        die("El ID del usuario no fue enviado o no es válido.");
    }

    // Obtener los demás datos del formulario
    $nombre_completo = trim($_POST['nombre']);
    $email = trim($_POST['correo']);
    $usuario = trim($_POST['usuario']);
    $foto = $_FILES['foto'] ?? null;

    // Separar el nombre y el apellido
    $nombres = explode(" ", $nombre_completo, 2); // Divide el nombre en dos partes
    $nombre = $nombres[0]; // Primer nombre
    $apellido = isset($nombres[1]) ? $nombres[1] : ''; // Resto del nombre como apellido si existe

    // Depuración: Verificar los valores obtenidos
    echo "Nombre: " . htmlspecialchars($nombre) . "<br>";
    echo "Apellido: " . htmlspecialchars($apellido) . "<br>";
    echo "Correo: " . htmlspecialchars($email) . "<br>";
    echo "Usuario: " . htmlspecialchars($usuario) . "<br>";

    // Validar los datos
    $errores = [];
    if (empty($nombre_completo)) {
        $errores[] = "El nombre es obligatorio.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El correo electrónico no es válido.";
    }

    // Si no hay errores, proceder con la actualización
    if (empty($errores)) {
        // Si hay una nueva foto, se sube
        if ($foto && $foto['tmp_name']) {
            $target_dir = "../../../includes/img/usuarios/";
            $target_file = $target_dir . basename($foto['name']);
            if (move_uploaded_file($foto['tmp_name'], $target_file)) {
                echo "Foto subida correctamente: " . htmlspecialchars($target_file) . "<br>";
            } else {
                echo "Error al subir la foto.<br>";
            }
        } else {
            // Si no se sube foto, se mantiene la actual
            $target_file = $_SESSION['FOTO'];
            echo "No se subió una nueva foto. Se mantiene la actual: " . htmlspecialchars($target_file) . "<br>";
        }

        // Depuración: Verificar los valores antes de la consulta
        echo "Valores para la consulta SQL:<br>";
        echo "Nombre: " . htmlspecialchars($nombre) . "<br>";
        echo "Apellido: " . htmlspecialchars($apellido) . "<br>";
        echo "Correo: " . htmlspecialchars($email) . "<br>";
        echo "Usuario: " . htmlspecialchars($usuario) . "<br>";
        echo "Foto: " . htmlspecialchars($target_file) . "<br>";
        echo "ID: " . htmlspecialchars($id) . "<br>";

        // Actualizar los datos en la base de datos
        $sql = "UPDATE usuarios SET nombre = ?, apellido = ?, correo = ?, usuario = ?, foto = ? WHERE id = ?";
        $stmt = $con->prepare($sql);

        if (!$stmt) {
            die("Error al preparar la consulta: " . $con->error);
        }

        $stmt->bind_param("sssssi", $nombre, $apellido, $email, $usuario, $target_file, $id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "Perfil actualizado correctamente en la base de datos.<br>";

                // Actualizar los datos en la sesión
                $_SESSION['NOMBRE_COMPLETO'] = trim($nombre . " " . $apellido);
                $_SESSION['CORREO_PERSONAL'] = $email;
                $_SESSION['FOTO'] = $target_file;

                // Redirigir al perfil con un mensaje de éxito
                header("Location: perfil.php?status=success");
                exit();
            } else {
                echo "No se realizaron cambios en la base de datos.<br>";
            }
        } else {
            echo "Error al ejecutar la consulta: " . $stmt->error . "<br>";
        }

        $stmt->close();
    } else {
        // Mostrar errores de validación
        foreach ($errores as $error) {
            echo "Error: " . htmlspecialchars($error) . "<br>";
        }
    }
}

// Cerrar la conexión
$con->close();
?>
