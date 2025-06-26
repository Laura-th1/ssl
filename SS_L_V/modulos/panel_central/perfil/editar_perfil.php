<?php
/**
 * editar_perfil.php - Edición de Perfil de Usuario | Sena Stock
 * ---------------------------------------------------------------
 * Este archivo muestra el formulario para editar los datos del perfil del usuario autenticado,
 * incluyendo nombre, correo, usuario y foto de perfil.
 * El usuario debe estar autenticado para acceder a esta página.
 * Al enviar el formulario, los datos se procesan en guardar_perfil.php.
 * 
 * Tecnologías: PHP, Bootstrap, jQuery, HTML5.
 * 
 * Autor: [Tu Nombre o Equipo]
 * Fecha: [Fecha de creación o última modificación]
 */

session_start();

if (!isset($_SESSION['USUARIO'])) {
    header("Location: ../../../login/");
}
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
    <title>Perfil | Sena Stock</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../../../includes/img/logos/favicon.png">
    <link href="../../../includes/librerias/bootstrap_5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../../includes/librerias/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="../../../includes/librerias/morrisjs/morris.css" rel="stylesheet">
    <link href="../../../includes/librerias/c3-master/c3.min.css" rel="stylesheet">
    <link href="../../../includes/css/panel_administrativo/styles.css" rel="stylesheet">
    <link href="../../../includes/css/panel_administrativo/dashboard.css" rel="stylesheet">
    <link href="../../../includes/css/panel_administrativo/colors/styles.css" id="theme" rel="stylesheet">
    <link href="../../../includes/librerias/jquery-confirm/css/jquery-confirm.min.css" rel="stylesheet">
    <link href="../../../includes/css/perfil/perfil.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/21.2.3/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/21.2.3/css/dx.light.css">
</head>

<body class="fix-header fix-sidebar card-no-border">
    <!-- Preloader animado mientras carga la página -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Sena Stock</p>
        </div>
    </div>
     <!-- Botón menú hamburguesa -->
<button class="custom-navbar-toggler" type="button" onclick="document.body.classList.toggle('show-sidebar')" aria-label="Menú">
    <img src="../../../includes/img/logos/favicon.png" width="40" height="40" alt="Menú">
</button>
<style>
        /* Estilos para el botón hamburguesa y ajustes responsive */
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
        <!-- Barra superior de navegación -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <a class="navbar-brand" href="../../../" style="font-size: 19px;">
                        <img src="../../../includes/img/logos/favicon.png" width="60px" height="60px" class="logo-img">
                        <span class="brand-text">Sena Stock</span>
                    </a>
                </div>
                
            </nav>
        </header>
        <!-- Menú lateral izquierdo (sidebar) -->
        <aside class="left-sidebar">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li>
                            <a class="waves-effect waves-dark" href="../../../" aria-expanded="false">
                                <i class="fa fa-home"></i>
                                <span class="hide-menu">Inicio</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="../../../modulos/panel_administrativo/" aria-expanded="false">
                                <i class="fa fa-globe"></i>
                                <span class="hide-menu">Panel Administrativo</span>
                            </a>
                        </li>
                        <hr>
                        <li>
                            <a class="waves-effect waves-dark" href="../" aria-expanded="false">
                                <i class="fa fa-home"></i>
                                <span class="hide-menu">Panel central</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark active" href="./" aria-expanded="false">
                            <i class="fa fa-smile-o"></i>
                                <span class="hide-menu">Perfil</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="../agenda" aria-expanded="false">
                                <i class="fa fa-globe"></i>
                                <span class="hide-menu">Agenda</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="../ambientes" aria-expanded="false">
                                <i class="fa fa-globe"></i>
                                <span class="hide-menu">Ambientes</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="../inventarios" aria-expanded="false">
                                <i class="fa fa-globe"></i>
                                <span class="hide-menu">Inventarios</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="../productos" aria-expanded="false">
                                <i class="fa fa-smile-o"></i>
                                <span class="hide-menu">Articulos</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="../bloques" aria-expanded="false">
                                <i class="fa fa-smile-o"></i>
                                <span class="hide-menu">Bloques</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark " href="../Titulaciones" aria-expanded="false">
                                <i class="fa fa-smile-o"></i>
                                <span class="hide-menu">Titulaciones</span>
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
                        <h3 class="text-themecolor">Editar Perfil</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="../">Home</a></li>
                            <li class="breadcrumb-item active">EDITAR PERFIL</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="home-tab">
                            <div class="tab-content tab-content-basic">
                                <!-- Formulario para editar perfil -->
                                <div class="container">
                                    <h2 class="text-themecolor">EDITAR PERFIL</h2>
                                    <?php  
                                    $nombre_completo = isset($_SESSION['NOMBRE_COMPLETO']) ? $_SESSION['NOMBRE_COMPLETO'] : '';
                                    ?>

                                    <form action="guardar_perfil.php" method="POST" enctype="multipart/form-data">
                                        <!--
                                            Formulario de edición de perfil:
                                            - Nombre completo
                                            - Correo electrónico
                                            - Usuario (solo lectura)
                                            - Foto de perfil (opcional)
                                        -->
                                        <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($_SESSION['ID']); ?>">

                                        <!-- Nombre Completo -->
                                        <div class="profile-info">
                                            <h3 class="text-themecolor">NOMBRES:</h3>
                                            <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo htmlspecialchars($_SESSION['NOMBRE_COMPLETO']); ?>" required>
                                         </div>

                                        <!-- Correo Electrónico -->
                                        <div class="profile-info">
                                            <h3 class="text-themecolor">CORREO:</h3>
                                            <input type="email" id="correo" name="correo" class="form-control" value="<?php echo htmlspecialchars($_SESSION['CORREO_PERSONAL']); ?>" required>
                                        </div>

                                        <!-- Usuario -->
                                        <div class="profile-info">
                                            <h3 class="text-themecolor">USUARIO:</h3>
                                            <input type="text" id="usuario" name="usuario" class="form-control" value="<?php echo htmlspecialchars($_SESSION['USUARIO']); ?>" readonly>
                                        </div>

                                        <!-- Foto de Perfil -->
                                        <div class="profile-photo">
                                            <h3 class="text-themecolor">FOTO:</h3>
                                            <input type="file" id="foto" name="foto" class="form-control">
                                            <img src="<?php echo htmlspecialchars($_SESSION['FOTO']); ?>" alt="Foto de perfil" onerror="this.onerror=null; this.src='../../../includes/img/usuarios/SARUX/descargar.jpg';" width="100">
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                            <a href="perfil.php" class="btn btn-secondary">Cancelar</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="home-tab">
                            <div class="tab-content tab-content-basic">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer"> © 2025 SENA STOCK - DEV SLR </a> </footer>
        </div>
    </div>

    <!-- Inclusión de scripts JS y librerías necesarias para la funcionalidad -->
    <script src="../../../includes/librerias/jquery_3.7.1/jquery.min.js"></script>
    <script src="../../../includes/librerias/bootstrap_5.3.0/js/bootstrap.min.js"></script>
    <script src="../../../includes/librerias/bootstrap_5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="../../../includes/librerias/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js"></script>
    <script src="../../../includes/librerias/raphael/raphael-min.js"></script>
    <script src="../../../includes/librerias/morrisjs/morris.min.js"></script>
    <script src="../../../includes/librerias/d3/d3.min.js"></script>
    <script src="../../../includes/librerias/c3-master/c3.min.js"></script>
    <script src="../../../includes/js/panel_administrativo/waves.js"></script>
    <script src="../../../includes/js/panel_administrativo/sidebarmenu.js"></script>
    <script src="../../../includes/js/panel_administrativo/custom.js"></script>
    <script src="../../../includes/js/panel_administrativo/dashboard.js"></script>
    <script src="../../../includes/librerias/jquery-confirm/js/jquery-confirm.min.js"></script>

    <script src="https://cdn3.devexpress.com/jslib/21.2.3/js/dx.all.js"></script>
    <!-- <script src="https://cdn3.devexpress.com/jslib/21.2.3/js/dx.exporter.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.2.1/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <script src="../../../includes/js/global/scripts.js"></script>
    
</body>

</html>
