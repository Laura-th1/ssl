<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión | Sena Stock</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="../includes/css/login/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="../includes/img/logos/favicon.png" />
    <link href="../includes/css/panel_administrativo/spinners.css" id="theme" rel="stylesheet">
    <link href="../includes/librerias/jquery-confirm/css/jquery-confirm.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- <link href="../includes/librerias/bootstrap_5.3.0/css/bootstrap.min.css" rel="stylesheet"> -->
</head>
<div class="slider">
                <div class="slide" style="background-image: url('./includes/img/home/home1.jpeg');"></div>
                <div class="slide" style="background-image: url('./includes/img/home/home2.jpg');"></div>
                <div class="slide" style="background-image: url('./includes/img/home/home3.jpg');"></div>
                <div class="slide" style="background-image: url('./includes/img/home/home4.jpg');"></div>
            </div>
<body>
    <div class="preloader"> <!-- splash -->
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Sena Stock</p>
        </div>
    </div>
    <div class="login-container">
        <div class="logo">
            <img src="../includes/img/logos/logo.png" alt="Logo">
        </div>
        <h2>Iniciar Sesión</h2>
        <div class="form-container" id="form-container">
            <!-- Formulario de inicio de sesión -->
            <form id="login-form" action="#" method="POST">
    <div class="form-group">
        <label for="username">Nombre de usuario</label>
        <input type="text" id="usuario_o_correo" name="usuario_o_correo" placeholder="Introduce tu nombre de usuario" required>
    </div>

    <div class="form-group">
        <label for="password">Contraseña</label>
        <div class="input-container">
        <input type="password" id="password" name="password" placeholder="Introduce tu contraseña" required>
        <i class="fa fa-eye" id="togglePassword"></i>
        </div>
    </div>

    <button type="button" class="btn" onclick="iniciarsesion();">Ingresar</button>
    <div class="text-center">
        <p><a href="RecuperaCon.php" id="forgot-password-link">¿Olvidó su contraseña?</a></p>
    </div>

</form>  
    </div>

    <script src="../includes/librerias/jquery_3.7.1/jquery.min.js"></script>
    <script src="../includes/js/global/scripts.js"></script>
    <script src="../includes/librerias/jquery-confirm/js/jquery-confirm.min.js"></script>
    <script>
    // Función para mostrar/ocultar la contraseña
    document.getElementById("togglePassword").addEventListener("click", function () {
        var passwordInput = document.getElementById("password");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";  // Mostrar la contraseña
            this.classList.remove("fa-eye");  // Cambiar ícono de ojo cerrado
            this.classList.add("fa-eye-slash");  // Cambiar ícono de ojo abierto
        } else {
            passwordInput.type = "password";  // Ocultar la contraseña
            this.classList.remove("fa-eye-slash");  // Cambiar ícono de ojo abierto
            this.classList.add("fa-eye");  // Cambiar ícono de ojo cerrado
        }
    });

    // Función para mostrar el preloader y ocultarlo después de 2 segundos
    $(window).on('load', function() {
        setTimeout(function() {
            $(".preloader").fadeOut("slow");  // Desaparece el preloader
        }, 2000); // El preloader se oculta después de 2 segundos
    });

    $(document).ready(function() {
        $(".preloader").fadeOut();  // Ocultar preloader cuando la página esté lista
        var input = document.querySelector('input[name="usuario_o_correo"]');
        if (input) {
            // Convierte el texto del campo en mayúsculas automáticamente
            input.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
        }
    });

    // Función para iniciar sesión
    function iniciarsesion(){
        var usu = $("#usuario_o_correo").val(); 
        var pass = $("#password").val();
        if(usu != '' && pass != '') {
            requisitos("POST", 
                "../peticiones_json/login/login_json.php", 
                "opcion=AccionIniciarSesion&accion=Iniciar&usuario_correo=" + usu + "&password=" + pass + "&jsonp=?",
                function(data) {
                    if (data["ALERTA"] == 'OK') {
                        ModalNotifi('col-md-6 col-md-offset-3', 'Bienvenido', data["MENSAJE"], '');
                        setTimeout(function() {
                            window.location.replace("../index.php");  // Redirige a la página principal después de 2 segundos
                        }, 2000);
                    } else if (data["ALERTA"] == 'ERROR') {
                        ModalNotifi('col-md-4 col-md-offset-4', 'Notificación', data["MENSAJE"], '');
                        setTimeout(function() {
                            location.reload();  // Recarga la página si la contraseña es incorrecta
                        }, 2000);
                    } else if (data["ALERTA"] == 'ALERTA') {
                        ModalNotifi('col-md-4 col-md-offset-4', 'Notificación', data["MENSAJE"], '');
                    }
                }, 
                "",  
                Array()
            );
        } else {
            // Si los campos están vacíos, muestra un mensaje de advertencia
            ModalNotifi('col-md-4 col-md-offset-4', 'Notificación', 'Datos Vacíos', '');
        }
    }
</script>

        <!-- <script src="../includes/js/login/scripts.js"></script> -->

</body>
</html>
