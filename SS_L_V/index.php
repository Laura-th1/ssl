
<?php
session_start();

if (!isset($_SESSION['USUARIO'])) {
    header("Location: ../SS_L_V/login/index");
    exit;
}

// Verifica si el rol ya está en la sesión
if (!isset($_SESSION['ROL'])) {
    // Si no está definido, obtén el rol del usuario desde la base de datos
    include_once("../../../includes/conexiones/Base_Datos/conexion.php");
    $con = conectar();

    if (!$con) {
        die("Error al conectar con la base de datos.");
    }

    $usuario = $_SESSION['USUARIO']; // Asegúrate de que el usuario esté en la sesión
    $consulta = $con->prepare("SELECT rol_id FROM usuarios WHERE usuario = ?");
    $consulta->bind_param("s", $usuario);
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $_SESSION['ROL'] = $fila['rol_id'];
    } else {
        die("No se pudo obtener el rol del usuario.");
    }
}

// Verifica si el rol del usuario está permitido
$rolPermitido = in_array($_SESSION['ROL'], [ 'Apoyo Tecnológico', 'Administrador']);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Inicio | Sena Stock</title>
        <link rel="icon" type="image/x-icon" href="./includes/img/logos/favicon.png" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
        <link href="./includes/css/home/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link href="./includes/css/panel_administrativo/spinners.css" id="theme" rel="stylesheet">
    </head>
    <!-- <body id="page-top">
        <div class="preloader">
            <div class="loader">
                <div class="loader__figure"></div>
                <p class="loader__label">Sena Stock</p>
            </div>
        </div> -->

        <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="./">Sena Stock</a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto my-2 my-lg-0">

                        <?php
                            if(!isset($_SESSION["USUARIO"])){
                        ?>
                            <li class="nav-item"><a class="nav-link" href="./login/">Iniciar Sesion</a></li>
                        <?php
                            }else{
                        ?>   
                            <li class="nav-item"><a class="nav-link" href="./modulos/agenda_ambientes">Agenda de Ambientes</a></li>
                    <?php 
                    if($rolPermitido):?>
                            <li class="nav-item"><a class="nav-link" href="./modulos/panel_administrativo">Panel Administrativo</a></li>
                            <?php endif;?>
                            <li class="nav-item"><a class="nav-link" href="./modulos/panel_central">Panel Central</a></li>
                            <li class="nav-item dropdown"> 
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> 
                                 <?php echo($_SESSION["NOMBRE_COMPLETO"]); ?>
                                   </a>
                                <ul class="dropdown-menu no-scroll" id="menu_dropdown" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="../SS_L_V/modulos/panel_central/perfil/perfil.php">
                                        <i class="bi-person "></i> Perfil
                                        </a>
                                        <a class="dropdown-item" href="#" onclick="cerrarSesion();">
                                           <i class="fa fa-sign-out-alt"></i> Cerrar sesión
                                               </a>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>

        <header class="masthead">
            <div class="slider">
                <div class="slide" style="background-image: url('./includes/img/home/home1.jpeg');"></div>
                <div class="slide" style="background-image: url('./includes/img/home/home2.jpg');"></div>
                <div class="slide" style="background-image: url('./includes/img/home/home3.jpg');"></div>
                <div class="slide" style="background-image: url('./includes/img/home/home4.jpg');"></div>
            </div>
            <div class="container px-4 px-lg-5 h-100">
                <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-8 align-self-end">
                        <h1 class="text-white font-weight-bold">Sena Stock</h1>
                        <hr class="divider" />
                    </div>
                    <div class="col-lg-8 align-self-baseline">
                        <p class="text-white-75 mb-5">Este portal está diseñado para facilitar el control, seguimiento y administración de los recursos y equipos de los ambientes del centro de comercio y servicios. A través de esta plataforma, los usuarios pueden gestionar entradas, salidas, actualizaciones y reportes de inventario de manera eficiente, garantizando la transparencia y optimización de los activos de los ambientes del centro.</p>
                        <a class="btn btn-sena btn-xl" href="./login/index.php">Iniciar Proceso</a>
                    </div>
                </div>
            </div>
        </header>
        
        <section class="page-section" id="services">
            <div class="container px-4 px-lg-5">
                <h2 class="text-center mt-0">Servicios que ofrecemos</h2>
                <hr class="divider" />
                <div class="row gx-4 gx-lg-5">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <div class="mb-2"><i class="bi-box-seam fs-1 text-Sena"></i></div>
                        <h3 class="h4 mb-2">Gestión de Inventarios</h3>
                        <p class="text-muted mb-0">Controla, organiza y actualiza el inventario de la institución de manera eficiente.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <div class="mb-2"><i class="bi-bar-chart-line fs-1 text-Sena"></i></div>
                        <h3 class="h4 mb-2">Reportes Detallados</h3>
                        <p class="text-muted mb-0">Genera reportes personalizados para una mejor toma de decisiones.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <div class="mb-2"><i class="bi-file-earmark-bar-graph fs-1 text-Sena"></i></div>
                        <h3 class="h4 mb-2">Análisis de Inventario</h3>
                        <p class="text-muted mb-0">Obtén análisis avanzados del estado y movimiento del inventario.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <div class="mb-2"><i class="bi-clipboard-check fs-1 text-Sena"></i></div>
                        <h3 class="h4 mb-2">Control de Calidad</h3>
                        <p class="text-muted mb-0">Asegura que todos los recursos cumplan con los estándares establecidos.</p>
                    </div>
                </div>

                </div>
            </div>
        </section>
        <section class="page-section bg-sena-contact" id="contact">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-lg-8 col-xl-6 text-center">
                        <h2 class="mt-0">Contáctenos</h2>
                        <hr class="divider" />
                        <p class="text-muted mb-5">¿Tienes alguna duda o inquietud? Envíanos un mensaje y te responderemos lo antes posible.</p>
                    </div>
                </div>
                <div class="row gx-4 gx-lg-5 justify-content-center mb-5">
                    <div class="col-lg-5 d-none d-lg-flex bg-image-left"></div>

                    <div class="col-lg-6">
                        <form id="contactForm">
                            <div class="form-floating mb-3">
                                <input class="form-control" id="name" name="name" type="text" placeholder="Ingrese su nombre completo..." data-sb-validations="required" />
                                <label for="name">Nombre completo</label>
                                <div class="invalid-feedback" data-sb-feedback="name:required">Se requiere un nombre.</div>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="email" name="email" type="email" placeholder="nombre@ejemplo.com" data-sb-validations="required,email" />
                                <label for="email">Correo electrónico</label>
                                <div class="invalid-feedback" data-sb-feedback="email:required">Se requiere un correo electrónico.</div>
                                <div class="invalid-feedback" data-sb-feedback="email:email">El correo no es válido.</div>
                            </div>
                            <!-- Phone number input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="phone" name="phone" type="tel" placeholder="(123) 456-7890" data-sb-validations="required" />
                                <label for="phone">Número de teléfono</label>
                                <div class="invalid-feedback" data-sb-feedback="phone:required">Se requiere un número de teléfono.</div>
                            </div>
                             <!-- Message input -->
                            <div class="form-floating mb-3">
                                <textarea class="form-control" id="message" name="message" placeholder="Escribe tu mensaje aquí..." style="height: 10rem" data-sb-validations="required"></textarea>
                                <label for="message">Mensaje</label>
                                <div class="invalid-feedback" data-sb-feedback="message:required">Se requiere un mensaje.</div>
                            </div>
                             <div class="d-none" id="submitSuccessMessage">
                                <div class="text-center mb-3">
                                    <div class="fw-bolder">¡Mensaje enviado exitosamente!</div>
                                </div>
                            </div>
                            <div class="d-none" id="submitErrorMessage"><div class="text-center text-danger mb-3">¡Error al enviar el mensaje!</div></div>
                            
                            <!-- Submit Button -->
                             <div class="d-grid">
                                <button class="btn btn-sena btn-xl" id="submitButton" type="submit" value="Enviar">Enviar</button>
                             </div>  
                        </form>
                    </div>
                </div>
            </div>
        </section>


        <section class="page-section" id="about">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-lg-6">
                        <div class="video-container shadow-lg rounded-3">
                            <video autoplay loop muted class="w-100 rounded-3" poster="./includes/img/home/video.jpg">
                                <source src="./includes/videos/home/SS1.mp4" type="video/mp4">
                                Tu navegador no soporta la reproducción de videos.
                            </video>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h2 class="mt-0  text-center">Acerca de SENA Stock</h2>
                        <hr class="divider" />
                        <p class="text-muted mb-4">
                            A través de SENA Stock, los usuarios tienen acceso a funcionalidades como el registro de entradas y salidas, actualización de inventarios y generación de reportes detallados. Esto ayuda a garantizar la transparencia en la administración de los recursos y permite una toma de decisiones informada sobre la reposición, mantenimiento y distribución de los activos.
                        </p>
                        <p class="text-muted mb-4">
                            Nuestro objetivo es facilitar una experiencia de gestión intuitiva, rápida y eficiente, alineada con los valores de sostenibilidad y responsabilidad del SENA. Con SENA Stock, buscamos que los ambientes de formación estén siempre preparados para proporcionar una educación de calidad, con recursos bien gestionados y disponibles para quienes más los necesitan.
                        </p>
                    </div>
                </div>
            </div>
        </section>


        <!-- Footer-->
        <footer class="bg-sena py-5">
            <div class="container px-4 px-lg-5">
                <div class="small text-center text-white">
                    Copyright &copy; 2024 - Sena Stock
                </div>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
     <script src="./includes/librerias/jquery_3.7.1/jquery.min.js"></script>
        <script src="./includes/js/global/scripts.js"></script>
        <script src="./includes/librerias/jquery-confirm/js/jquery-confirm.min.js"></script>
        
<script type="text/javascript"
  src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>

<script type="text/javascript">
  emailjs.init('kLtMWNCJwbYzL1-PZ')
</script>

        <script>
          document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("contactForm");
    const btn = document.getElementById("submitButton");
    const messageInput = document.getElementById("message");
    const successMessage = document.getElementById("submitSuccessMessage");
    const errorMessage = document.getElementById("submitErrorMessage");
    const invalidFeedback = messageInput.nextElementSibling; // Mensaje de error del campo

    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Evita el envío normal del formulario

        const messageValue = messageInput.value.trim(); // Obtiene el texto sin espacios al inicio y final

        if (messageValue === "") {
            // Si el campo está vacío, mostrar el mensaje de error
            messageInput.classList.add("is-invalid");
            invalidFeedback.style.display = "block";    
            successMessage.classList.add("d-none");
            errorMessage.classList.remove("d-none");
            return; // Detener el proceso si el mensaje está vacío
        }

        // Si el mensaje es válido, ocultar errores
        messageInput.classList.remove("is-invalid");
        invalidFeedback.style.display = "none";
        successMessage.classList.add("d-none");
        errorMessage.classList.add("d-none");

        // Cambiar el estado del botón
        btn.textContent = "Enviando...";
        btn.disabled = true;

        // Configuración de EmailJS
        const serviceID = "service_9ymwfyj";
        const templateID = "template_4m2zfei";

        emailjs.sendForm(serviceID, templateID, form)
            .then(() => {
                btn.textContent = "Enviar";
                btn.disabled = false;
                successMessage.classList.remove("d-none");
                errorMessage.classList.add("d-none");
                alert("¡Su mensaje ha sido enviado!");
                form.reset(); // Limpiar el formulario
            })
            .catch((err) => {
                btn.textContent = "Enviar";
                btn.disabled = false;
                errorMessage.classList.remove("d-none");
                successMessage.classList.add("d-none");
                alert("Error al enviar el mensaje: " + JSON.stringify(err));
            });
    });

    // Ocultar mensaje de error cuando el usuario empiece a escribir
    messageInput.addEventListener("input", function () {
        if (messageInput.value.trim() !== "") {
            messageInput.classList.remove("is-invalid");
            invalidFeedback.style.display = "none";
        }
    });
});



			// $(document).ready(function() {
            //     $(".preloader").fadeOut();
            //     function checkScroll() {
            //         if ($(window).scrollTop() > 50) {
            //             $('#mainNav').addClass('scrolled');
            //         } else {
            //             $('#mainNav').removeClass('scrolled');
            //         }
            //     }

            //     // Detecta el evento de scroll en la ventana
            //     $(window).scroll(function() {
            //         checkScroll();
            //     });

            //     // Llama a la función al cargar la página para verificar la posición inicial del scroll
            //     checkScroll();
            // });

            
function cerrarSesion() {
    if (confirm("¿Estás seguro de que deseas cerrar sesión?")) {
        // Enviar la solicitud para cerrar sesión
        fetch("./modulos/panel_central/perfil/logout.php", { // Enviar la solicitud a la misma página
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "cerrar_sesion=1"
        })
        .then(() => {
            window.location.href = "../SS_L_V/index.php"; // Redirigir al login
        })
        .catch(error => console.error("Error:", error));
    }
}



		</script>
    </body>
</html>