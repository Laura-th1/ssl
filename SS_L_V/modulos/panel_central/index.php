<?php
session_start();

if (!isset($_SESSION['USUARIO'])) {
    header("Location: ../../../login/");
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
$rolPermitido = in_array($_SESSION['ROL'], ['Coordinador', 'Apoyo Tecnológico', 'Administrador']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, AdminWrap lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, AdminWrap lite design, AdminWrap lite dashboard bootstrap 5 dashboard template">
    <meta name="description" content="AdminWrap Lite is powerful and clean admin dashboard template, inpired from Bootstrap Framework">
    <meta name="robots" content="noindex,nofollow">
    <title>Panel de Control | Sena Stock</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../../includes/img/logos/favicon.png">
    <link href="../../includes/librerias/bootstrap_5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../includes/librerias/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="../../includes/librerias/morrisjs/morris.css" rel="stylesheet">
    <link href="../../includes/librerias/c3-master/c3.min.css" rel="stylesheet">
    <link href="../../includes/css/panel_administrativo/styles.css" rel="stylesheet">
    <link href="../../includes/css/panel_administrativo/dashboard.css" rel="stylesheet">
    <link href="../../includes/css/panel_administrativo/colors/styles.css" id="theme" rel="stylesheet">

<!-- Agregar Bootstrap JS y Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    
    
</head>

<body class="fix-header fix-sidebar card-no-border">
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Sena Stock</p>
        </div>
    </div>


    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header d-flex align-items-center">
                    <a class="navbar-brand" href="../../" style="font-size: 19px;">
                        <img src="../../includes/img/logos/favicon.png" width="60px" height="60px" class="logo-img">
                        <span class="brand-text">Sena Stock</span>
                    </a>
                </div>
                <div class="navbar-collapse">
                    <div class="navbar-nav me-auto"></div>
                    <ul class="navbar-nav my-lg-0">
            <!-- ACCESO AL PERFIL & CERRAR SESIÓN-->

            <li class="nav-item dropdown u-pro">
                
    <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="#" id="navbarDropdown"
        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img src="../../includes/icons/descargar.jpg" alt="user" class="" />
        <i class="bi bi-chevron-down"></i>
    </a>
    <ul class="dropdown-menu no-scroll dropdown-menu-end" aria-labelledby="navbarDropdown">
        <li>
        <a class=" dropdown-item bi-person-badge" href="../panel_central/perfil/perfil.php">Perfil</a></li>
        <li>
        <a class="dropdown-item" href="#" onclick="cerrarSesion(event);"> Cerrar sesión
        <i class="fa fa-sign-out" aria-hidden="true"></i>
        </a>
        </li>
        
    </ul> 
 </nav>
        </header>
                
<aside class="left-sidebar" id="sidebarMenu">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <!-- Botón hamburguesa solo visible en móvil -->
                     <button class="btn btn-outline-secondary d-lg-none m-2" id="sidebarToggle" style="position:fixed;z-index:1100;top:10px;left:10px;;border:none;">
                        <img src="../../includes/img/logos/favicon.png" width="60px" height="60px" class="logo-img">
                        <span class="brand-text">Sena Stock</span>
                    </button>
            <ul id="sidebarnav">
                <li>
                    <a class="waves-effect waves-dark" href="../../" aria-expanded="false">
                        <i class="fa fa-home"></i>
                        <span class="hide-menu">Inicio</span>
                    </a>
                </li>
                <?php if ($rolPermitido): ?>
                <li>
                    <a class="waves-effect waves-dark" href="../../modulos/panel_administrativo/" aria-expanded="false">
                        <i class="fa fa-globe"></i>
                        <span class="hide-menu">Panel Administrativo</span>
                    </a>
                </li>
                <?php endif; ?>
                <hr>
                <li>
                    <a class="waves-effect waves-dark active" href="./" aria-expanded="false">
                        <i class="fa fa-home"></i>
                        <span class="hide-menu">Panel central</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="./agenda" aria-expanded="false">
                        <i class="fa fa-globe"></i>
                        <span class="hide-menu">Agenda</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="./ambientes" aria-expanded="false">
                        <i class="fa fa-globe"></i>
                        <span class="hide-menu">Ambientes</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="./inventarios" aria-expanded="false">
                        <i class="fa fa-globe"></i>
                        <span class="hide-menu">Inventarios</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="./productos" aria-expanded="false">
                        <i class="fa fa-smile-o"></i>
                        <span class="hide-menu">Articulos</span>
                    </a>
                </li>
                <?php if ($rolPermitido): ?>
                <li>
                    <a class="waves-effect waves-dark" href="./bloques" aria-expanded="false">
                        <i class="fa fa-smile-o"></i>
                        <span class="hide-menu">Bloques</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="./titulaciones" aria-expanded="false">
                        <i class="fa fa-smile-o"></i>
                        <span class="hide-menu">Titulaciones</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</aside>

<style>
    @media (max-width: 991.98px) {
    .navbar-brand {
        display: none !important;
    }
}
/* Responsive sidebar */
@media (max-width: 991.98px) {
    .left-sidebar {
        position: fixed;
        left: -260px;
        top: 0;
        width: 250px;
        height: 100%;
        background: #fff;
        z-index: 1050;
        border: none;
        transition: left 0.3s;
        box-shadow: 2px 0 8px rgba(0,0,0,0.1);
    }
    .left-sidebar.active {
        left: 0;
    }
    .page-wrapper {
        margin-left: 0 !important;
    }
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var sidebar = document.getElementById('sidebarMenu');
    var toggle = document.getElementById('sidebarToggle');
    var isSidebarOpen = false;

    if(toggle && sidebar){
        toggle.addEventListener('click', function(e) {
            e.stopPropagation(); // Evita que el click cierre el menú inmediatamente
            sidebar.classList.toggle('active');
            isSidebarOpen = sidebar.classList.contains('active');
        });

        // Cierra el sidebar al hacer clic fuera en móvil
        document.addEventListener('click', function(e) {
            if(window.innerWidth < 992 && sidebar.classList.contains('active')) {
                // Si el click NO es dentro del sidebar ni en el botón
                if(!sidebar.contains(e.target) && e.target !== toggle) {
                    sidebar.classList.remove('active');
                    isSidebarOpen = false;
                }
            }
        });

        // Evita que los clicks dentro del sidebar cierren el menú
        sidebar.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
});
</script>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-themecolor">Panel Central</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active">Panel Central</li>
                        </ol>
                        <style>
        .saludo {
            font-size: 15px;
            display: inline-flex; 
            text-decoration: none;
            align-items: center;
            color: #39a900;
            font-weight: arial bold;
        }

        .saludo span {
            display: inline-block;
            animation: wave 1s infinite alternate;
            font-size: 30px;
        }

        @keyframes wave {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(50deg); }
        }
    </style>
                        <body>
                         <a  class="saludo"><span>👋</span> BIENVENID@, <?php echo $_SESSION['NOMBRE_COMPLETO']; ?> <span>👋</span></a>
                        </body>
                    </div>
                </div>
                <div class="row">
                </div>
            </div>
            <footer class="footer"> © <?php echo date('Y'); ?> - Sena Stock </footer>
        </div>
    </div>

    <script src="../../includes/librerias/jquery_3.7.1/jquery.min.js"></script>
    <script src="../../includes/librerias/bootstrap_5.3.0/js/bootstrap.min.js"></script>
    <script src="../../includes/librerias/bootstrap_5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="../../includes/librerias/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js"></script>
    <script src="../../includes/librerias/raphael/raphael-min.js"></script>
    <script src="../../includes/librerias/morrisjs/morris.min.js"></script>
    <script src="../../includes/librerias/d3/d3.min.js"></script>
    <script src="../../includes/librerias/c3-master/c3.min.js"></script>
    <script src="../../includes/js/panel_administrativo/waves.js"></script>
    <script src="../../includes/js/panel_administrativo/sidebarmenu.js"></script>
    <script src="../../includes/js/panel_administrativo/custom.js"></script>
    <!-- <script src="../../includes/js/panel_administrativo/dashboard.js"></script> -->
</body>

<script>
      
      function cerrarSesion(event) {
    event.preventDefault();

    fetch('../panel_central/perfil/logout.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                window.location.href = "../../index.php"; // Redirigir después de cerrar sesión
            }
        })
        .catch(error => console.error("Error cerrando sesión:", error));
}
</script>
</html>