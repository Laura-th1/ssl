<?php
session_start();
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
    <title>Panel Administrativo | Sena Stock</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../../includes/img/logos/favicon.png">
    <link href="../../includes/librerias/bootstrap_5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../includes/librerias/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="../../includes/librerias/morrisjs/morris.css" rel="stylesheet">
    <link href="../../includes/librerias/c3-master/c3.min.css" rel="stylesheet">
    <link href="../../includes/css/panel_administrativo/styles.css" rel="stylesheet">
    <link href="../../includes/css/panel_administrativo/dashboard.css" rel="stylesheet">
    <link href="../../includes/css/panel_administrativo/colors/styles.css" id="theme" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
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
    <!-- Botón menú hamburguesa -->
<button class="custom-navbar-toggler" type="button" onclick="document.body.classList.toggle('show-sidebar')" aria-label="Menú">
    <img src="../../includes/img/logos/favicon.png" width="40" height="40" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M2.5 12.5a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10a.5.5 0 0 1-.5-.5z"/>
    </img>
</button>
<style>
        .custom-navbar-toggler {
            position: fixed;
            top: 8px;
            left: 8px;
            z-index: 2000;
            background: #fff;
            border: none;
            border-radius: 25%;
            padding: 6px 8px;
            color: #39a900;
            font-size: 1.7rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            display: none;
            transition: background 0.2s;
        }
        .custom-navbar-toggler:active,
        .custom-navbar-toggler:focus {
            background: #e6ffe6;
            outline: none;
        }
        @media (max-width: 768px) {
            .custom-navbar-toggler {
                display: block;
            }
            .navbar-header {
                margin-left: 40px !important;
            }
            .topbar {
                position: relative;
                min-height: 56px;
            }
            .navbar-brand {
                display: none !important;
            }
        }
        @media (max-width: 800px) {
            .navbar-header {
                padding-left: 40px;
            }
        }
    </style>

    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
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
        <aside class="left-sidebar">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li>
                            <a class="waves-effect waves-dark" href="../../" aria-expanded="false">
                                <i class="fa fa-home"></i>
                                <span class="hide-menu">Inicio</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="../../modulos/panel_central/" aria-expanded="false">
                                <i class="fa fa-globe"></i>
                                <span class="hide-menu">Panel Central</span>
                            </a>
                        </li>
                        <hr>
                        <li>
                            <a class="waves-effect waves-dark" href="./" aria-expanded="false">
                                <i class="fa fa-home"></i>
                                <span class="hide-menu">Panel de control</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="./generos" aria-expanded="false">
                                <i class="fa fa-smile-o"></i>
                                <span class="hide-menu">Generos</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="./roles" aria-expanded="false">
                                <i class="fa fa-smile-o"></i>
                                <span class="hide-menu">Roles</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="./tipo_titulaciones" aria-expanded="false">
                                <i class="fa fa-smile-o"></i>
                                <span class="hide-menu">Tipos de Titulaciones</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="./usuarios" aria-expanded="false">
                                <i class="fa fa-user-circle-o"></i>
                                <span class="hide-menu">Usuarios</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-themecolor">Panel Administrativo</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active">Panel Administrativo</li>
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
                         <a  class="saludo"><span>👋</span> Bienvenid@, <?php echo $_SESSION['NOMBRE_COMPLETO']; ?> <span>👋</span></a>
                        </body>
                    </div>
                </div>
                <div class="row">
                </div>
            </div>
            <footer class="footer"> © 2021 Adminwrap by <a href="https://www.wrappixel.com/">wrappixel.com</a> </footer>
        </div>
    </div>
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

</html>
?>