<?php
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
    <title>Tipo de Titulaciones | Sena Stock</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../../../includes/img/logos/favicon.png">
    <link href="../../../includes/librerias/bootstrap_5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../../includes/librerias/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="../../../includes/librerias/morrisjs/morris.css" rel="stylesheet">
    <link href="../../../includes/librerias/c3-master/c3.min.css" rel="stylesheet">
    <link href="../../../includes/librerias/jquery-confirm/css/jquery-confirm.min.css" rel="stylesheet">
    <link href="../../../includes/css/panel_administrativo/styles.css" rel="stylesheet">
    <link href="../../../includes/css/panel_administrativo/dashboard.css" rel="stylesheet">
    <link href="../../../includes/css/panel_administrativo/colors/styles.css" id="theme" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/21.2.3/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/21.2.3/css/dx.light.css">
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


    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <a class="navbar-brand" href="../../../" style="font-size: 19px;">
                        <img src="../../../includes/img/logos/favicon.png" width="60px" height="60px" class="logo-img">
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
        <img src="../../../includes/icons/descargar.jpg" alt="user" class="" />
        <i class="bi bi-chevron-down"></i>
    </a>
    <ul class="dropdown-menu no-scroll dropdown-menu-end" aria-labelledby="navbarDropdown">
        <li>
        <a class=" dropdown-item bi-person-badge" href="../../panel_central/perfil/perfil.php">Perfil</a></li>
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
                            <a class="waves-effect waves-dark" href="../../../" aria-expanded="false">
                                <i class="fa fa-home"></i>
                                <span class="hide-menu">Inicio</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="../../panel_central/" aria-expanded="false">
                                <i class="fa fa-globe"></i>
                                <span class="hide-menu">Panel Central</span>
                            </a>
                        </li>
                        <hr>
                        <li>
                            <a class="waves-effect waves-dark" href="../" aria-expanded="false">
                                <i class="fa fa-home"></i>
                                <span class="hide-menu">Panel de control</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="../generos" aria-expanded="false">
                                <i class="fa fa-smile-o"></i>
                                <span class="hide-menu">Generos</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="../roles" aria-expanded="false">
                                <i class="fa fa-smile-o"></i>
                                <span class="hide-menu">Roles</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark active" href="./" aria-expanded="false">
                                <i class="fa fa-smile-o"></i>
                                <span class="hide-menu">Tipos de Titulaciones</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="../usuarios" aria-expanded="false">
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
                        <h3 class="text-themecolor">Tipo de Titulaciones</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="../">Home</a></li>
                            <li class="breadcrumb-item active">Tipo de Titulaciones</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="home-tab">
                            <div class="tab-content tab-content-basic">
                                <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <div id="tablatp_titulacion"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer"> © <?php echo date('Y'); ?> - Sena Stock </footer>
        </div>
    </div>

    <script src="../../../includes/librerias/jquery_3.7.1/jquery.min.js"></script>
    <script src="../../../includes/librerias/bootstrap_5.3.0/js/bootstrap.min.js"></script>
    <script src="../../../includes/librerias/bootstrap_5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="../../../includes/librerias/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js"></script>
    <script src="../../../includes/librerias/raphael/raphael-min.js"></script>
    <script src="../../../includes/librerias/morrisjs/morris.min.js"></script>
    <script src="../../../includes/librerias/d3/d3.min.js"></script>
    <script src="../../../includes/librerias/c3-master/c3.min.js"></script>
    <script src="../../../includes/librerias/jquery-confirm/js/jquery-confirm.min.js"></script>
    <script src="../../../includes/js/panel_administrativo/waves.js"></script>
    <script src="../../../includes/js/panel_administrativo/sidebarmenu.js"></script>
    <script src="../../../includes/js/panel_administrativo/custom.js"></script>
    <!-- <script src="../../../includes/js/panel_administrativo/dashboard.js"></script> -->
    <script src="https://cdn3.devexpress.com/jslib/21.2.3/js/dx.all.js"></script>
    <script src="https://cdn3.devexpress.com/jslib/21.2.3/js/dx.exporter.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.2.1/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <script src="../../../includes/js/global/scripts.js"></script>

    <script type="text/javascript">
        var crear;
        var editar;

        var tabla_datos_tp_titulacion;
        
        $(document).ready(function() {
            consultas("TP_titulacion");
        });

        function TBTitulacion(data) {
            tabla_datos_tp_titulacion = $("#tablatp_titulacion").dxDataGrid({
                dataSource: data["DATA"],
                columns: [{
                        dataField: 'NUMERO',
                        caption: 'N°',
                        width: 100
                    },
                    {
                        dataField: 'DESCRIPCION',
                        caption: 'Nombre'
                    },
                    {
                        dataField: 'ESTADO',
                        caption: 'Estado'
                    }
                ],
                showBorders: true,
                paging: {
                    enabled: true,
                    pageSize: 20
                },
                searchPanel: {
                    visible: true,
                    width: 240,
                    placeholder: 'Buscar...'
                },
                headerFilter: {
                    visible: true
                },
                groupPanel: {
                    visible: true
                },
                loadPanel: {
                    enabled: true
                },
                filterRow: {
                    visible: true,
                    applyFilter: 'auto'
                },
                export: {
                    enabled: true,
                    fileName: 'tablatp_titulacion',
                    allowExportSelectedData: true,
                    texts: {
                        exportAll: 'Exportar todo',
                        exportSelectedRows: 'Exportar filas seleccionadas'
                    }
                },
                selection: {
                    mode: 'multiple',
                    showCheckBoxesMode: 'always'
                },
                editing: {
                    mode: 'cell',
                    allowUpdating: false,
                    allowAdding: false,
                    allowDeleting: false
                },
                toolbar: {
                    items: [{
                            widget: 'dxButton',
                            options: {
                                icon: 'exportxlsx',
                                text: 'Exportar a Excel',
                                onClick: function() {
                                    const grid = $("#tablatablatp_titulacion").dxDataGrid("instance");
                                    const workbook = new ExcelJS.Workbook();
                                    const worksheet = workbook.addWorksheet('tablatp_titulacion');

                                    DevExpress.excelExporter.exportDataGrid({
                                        component: grid,
                                        worksheet: worksheet
                                    }).then(() => {
                                        workbook.xlsx.writeBuffer().then(buffer => {
                                            saveAs(new Blob([buffer], {
                                                type: 'application/octet-stream'
                                            }), 'tablatp_titulacion.xlsx');
                                        });
                                    });
                                }
                            },
                            location: 'after'
                        },
                        {
                            widget: 'dxButton',
                            options: {
                                icon: 'export',
                                text: 'Exportar a CSV',
                                onClick: function() {
                                    const grid = $("#tablatablatp_titulacion").dxDataGrid("instance");
                                    const workbook = new ExcelJS.Workbook();
                                    const worksheet = workbook.addWorksheet('tablatp_titulacion');

                                    DevExpress.excelExporter.exportDataGrid({
                                        component: grid,
                                        worksheet: worksheet
                                    }).then(() => {
                                        workbook.csv.writeBuffer().then(buffer => {
                                            saveAs(new Blob([buffer], {
                                                type: 'text/csv'
                                            }), 'tablatp_titulacion.csv');
                                        });
                                    });
                                }
                            },
                            location: 'after'
                        }
                    ]
                }
            });
        }

        function consultas(accion) {
            if (accion == 'TP_titulacion') {
                requisitos("POST",
                    "../../../peticiones_json/panel_administrativo/tp_titulacion/tp_titulacion_json.php",
                    "opcion=AccionConsultar&accion=ConsultarTodos&jsonp=?",
                    function(data) {
                        TBTitulacion(data);
                    },
                    "",
                    Array()
                );
            }
        }
          
    function cerrarSesion(event) {
    event.preventDefault();

    fetch('../../panel_central/perfil/logout.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                window.location.href = "../../../index.php"; // Redirigir después de cerrar sesión
            }
        })
        .catch(error => console.error("Error cerrando sesión:", error));
}
    </script>
</body>

</html>