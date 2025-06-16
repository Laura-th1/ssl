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
    <title>Usuarios | Sena Stock</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../../../includes/img/logos/favicon.png">
    <link href="../../../includes/librerias/bootstrap_5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../../includes/librerias/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="../../../includes/librerias/morrisjs/morris.css" rel="stylesheet">
    <link href="../../../includes/librerias/c3-master/c3.min.css" rel="stylesheet">
    <link href="../../../includes/css/panel_administrativo/styles.css" rel="stylesheet">
    <link href="../../../includes/css/panel_administrativo/dashboard.css" rel="stylesheet">
    <link href="../../../includes/css/panel_administrativo/colors/styles.css" id="theme" rel="stylesheet">
    <link href="../../../includes/librerias/jquery-confirm/css/jquery-confirm.min.css" rel="stylesheet">

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
   <!-- Botón menú hamburguesa -->
<button class="custom-navbar-toggler" type="button" onclick="document.body.classList.toggle('show-sidebar')" aria-label="Menú">
    <img src="../../../includes/img/logos/favicon.png" width="40" height="40" alt="Menú">
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
                            <a class="waves-effect waves-dark" href="../tipo_titulaciones" aria-expanded="false">
                                <i class="fa fa-smile-o"></i>
                                <span class="hide-menu">Tipos de Titulaciones</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark active" href="../usuarios" aria-expanded="false">
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
                        <h3 class="text-themecolor">Usuarios</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="../">Home</a></li>
                            <li class="breadcrumb-item active">Usuarios</li>
                        </ol>
                        <br>
                        <div class="btn-wrapper">
                            <a href="#" class="btn text-white me-0" style="background-color: #39a900; color: #ffffff;" onclick="CrearNueva();"><i class="icon-download"></i> Crear Nuevo Usuario</a>
                        </div>
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
                                                 
                                                <div id="tablaUsuarios"></div>
                                                
                                                
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
    <script src="../../../includes/js/panel_administrativo/waves.js"></script>
    <script src="../../../includes/js/panel_administrativo/sidebarmenu.js"></script>
    <script src="../../../includes/js/panel_administrativo/custom.js"></script>
    <!-- <script src="../../../includes/js/panel_administrativo/dashboard.js"></script> -->
    <script src="../../../includes/librerias/jquery-confirm/js/jquery-confirm.min.js"></script>
    <script src="https://cdn3.devexpress.com/jslib/21.2.3/js/dx.all.js"></script>
    <!-- <script src="https://cdn3.devexpress.com/jslib/21.2.3/js/dx.exporter.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.2.1/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <script src="../../../includes/js/global/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script> 


</script>


    <script type="text/javascript">
        var crear;
        var editar;

        var tabla_datos_usuarios;

        $(document).ready(function() {
            consultas("Usuarios");
        });

       
        function CrearNueva() {
            crear = $.confirm({
                    title: 'Crear Nuevo Usuario',
                    backgroundDismiss: false,
                    closeIcon: false,
                    columnClass: 'col-md-offset-2 col-md-8',
                    content: `<div class="panel panel-body">
                                    <form id="registroForm">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tp_documentos">Tipo de Documento:</label>
                                                    <select class="form-control text-dark bg-white" id="tp_documentos" name="tp_documentos">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="numeroDocumento">Número de Documento:</label>
                                                    <input type="number" class="form-control text-dark bg-white" id="numero_documento" name="numero_documento" placeholder=""/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nombresApellidos">Nombres:</label>
                                                    <input type="text" class="form-control text-dark bg-white" id="nombres" name="nombres" placeholder=""/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nombresApellidos">Apellidos:</label>
                                                    <input type="text" class="form-control text-dark bg-white" id="apellidos" name="apellidos" placeholder=""/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="rol">Rol:</label>
                                                    <select class="form-control text-dark bg-white" id="roles" name="roles">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="rol">Sexo:</label>
                                                    <select class="form-control text-dark bg-white" id="sexos" name="sexos">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fechaNacimiento">Fecha de Nacimiento:</label>
                                                    <input type="date" class="form-control text-dark bg-white" id="fecha_nacimiento" name="fecha_nacimiento" placeholder=""/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fechaNacimiento">Correo Electronico:</label>
                                                    <input type="text" class="form-control text-dark bg-white" id="email" name="email" placeholder=""/>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="fechaNacimiento">Usuario:</label>
                                                    <input type="text" class="form-control text-dark bg-white" id="usuario" name="usuario" placeholder=""/>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="fechaNacimiento">Contraseña:</label>
                                                    <input type="text" class="form-control text-dark bg-white" id="password" name="password" placeholder=""/>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="fechaNacimiento">Telefono:</label>
                                                    <input type="number" class="form-control text-dark bg-white" id="telefono" name="telefono" placeholder=""/>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="foto">Foto:</label>
                                                    <input type="file" class="form-control text-dark bg-white" id="foto" name="foto" accept="image/*"/>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>`,
                    buttons: {
                        cancelar: {
                            text: 'Cancelar',
                            btnClass: 'btn btn-danger',
                            action: function(ModalCerrar){
                            }
                        },
                        guardar: {
                                    text: 'Guardar',
                                    btnClass: 'btn btn-green',
                                    
                                    action: function(saveButton){
                                        var numero_documento = $("#numero_documento").val();
                                        var nombres = $("#nombres").val();
                                        var apellidos = $("#apellidos").val();
                                        var fecha_nacimiento = $("#fecha_nacimiento").val();
                                        var email = $("#email").val();
                                        var usuario = $("#usuario").val();
                                        var password = $("#password").val();
                                        var telefono = $("#telefono").val();
                                        
                                        
                                        var formData = new FormData();
                                        formData.append('foto', $('#foto')[0].files[0]);
                                        formData.append('tp_documento', $("#tp_documentos").val());
                                        formData.append('numero_documento', numero_documento);
                                        formData.append('nombres', nombres);
                                        formData.append('apellidos', apellidos);
                                        formData.append('rol', $("#roles").val());
                                        formData.append('sexo', $("#sexos").val());
                                        formData.append('fecha_nacimiento', fecha_nacimiento);
                                        formData.append('email', email);
                                        formData.append('usuario', usuario);
                                        formData.append('password', password);
                                        formData.append('telefono', telefono);
                                        formData.append('opcion', 'AccionInsertar');
                                        formData.append('jsonp', '?');

                                        $.ajax({
                                            url: "../../../peticiones_json/panel_administrativo/usuarios/usuarios_json.php",
                                            type: 'POST',
                                            data: formData,
                                            contentType: false,
                                            processData: false,
                                            success: function(data) {
                                                if (data["ALERTA"] === 'OK') {
                                                    consultas("Usuarios");
                                                    ModalNotifi('col-md-4 col-md-offset-4', 'Notificacion', 'Usuario Insertado Con Exito', '');
                                                    return true;
                                                    location.reload();
                                                } else if (data["ALERTA"] === 'ERROR') {
                                                    crear.close();
                                                    CrearNueva();
                                                    ModalNotifi('col-md-4 col-md-offset-4', 'ERROR', data["MENSAJE"], '');
                                                    return false;
                                                }
                                            }
                                        });
                                    }
                                }
                    },
                    onContentReady: function (){
                        consultas("tipo_documentos");
                        consultas("sexos");
                        consultas("roles");
                    }
                    
            });
        }

        function Eliminar(id) {
            requisitos("POST",
                    "../../../peticiones_json/panel_administrativo/usuarios/usuarios_json.php",
                    "opcion=AccionEliminar&id="+id+"&jsonp=?",
                    function(data) {
                        if (data["ALERTA"] === 'OK') {
                            consultas("Usuarios");
                            ModalNotifi('col-md-4 col-md-offset-4', 'Notificacion', 'Dato Eliminado Con Exito', '');
                            return true;
                        } else if (data["ALERTA"] === 'ERROR') {
                            crear.close();
                            CrearNueva();
                            ModalNotifi('col-md-4 col-md-offset-4', 'ERROR', data["MENSAJE"], '');
                            return false;
                        }
                    },
                    "",
                    Array()
                );
        }

        function TBUsuarios(data) {
            tabla_datos_usuarios = $("#tablaUsuarios").dxDataGrid({
                dataSource: data["DATA"],
                columns: [{
                        dataField: 'ID',
                        caption: 'ID',
                        width: 100
                    },
                    {
                        dataField: 'NUMERO_DOCUMENTO',
                        caption: 'Numero de Documento',
                    },
                    {
                        dataField: 'NOMBRE_COMPLETO',
                        caption: 'Nombres y Apellidos',
                    },
                    {
                        dataField: 'ROL_DESC',
                        caption: 'Rol'
                    },
                    {
                        dataField: 'CORREO',
                        caption: 'Correo Electronico'
                    },
                    {
                        dataField: 'USUARIO',
                        caption: 'Usuario'
                    },
                    {
                        dataField: 'FOTO',
                        caption: 'Foto',
                        cellTemplate: function(container, options) {
                            if (options.data.FOTO) {
                                $('<img>').attr({
                                    src: options.data.FOTO,
                                    alt: 'Foto de Usuario',
                                    style: 'width: 50px; height: 50px; border-radius: 50%;'
                                }).appendTo(container);
                            } else {
                                $('<span>').text('No disponible').appendTo(container);
                            }
                        }
                    },
                    {
                        dataField: 'ESTADO',
                        caption: 'Estado'
                    },
                    {
    dataField: '',
    caption: 'Acciones',
    cellTemplate: function(container, options) {
        // Suponiendo que ESTADO es 1 (activo) o 0 (inactivo)
        let esActivo = options.data.ESTADO == 1 || options.data.ESTADO === "Activo";
        let texto = esActivo ? 'Deshabilitar' : 'Habilitar';
        let color = esActivo ? '#67757c' : '#39a900';

        // Botón para cambiar estado
        $('<button>')
            .addClass('btn text-white me-2 btn-sm')
            .css('background-color', color)
            .text(texto)
            .on('click', function () {
                cambiarEstado(options.data.ID, esActivo ? 0 : 1);
            })
            .appendTo(container);

        // Botón de eliminar 
        $('<button>')
            .addClass('btn text-white btn-sm')
            .css('background-color', '#ff0000')
            .text('Eliminar')
            .on('click', function () {
                Eliminar(options.data.ID);
            })
            .appendTo(container);
    }
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
                    fileName: 'Usuarios',
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
                                    const grid = $("#tablaUsuarios").dxDataGrid("instance");
                                    const workbook = new ExcelJS.Workbook();
                                    const worksheet = workbook.addWorksheet('Usuarios');

                                    DevExpress.excelExporter.exportDataGrid({
                                        component: grid,
                                        worksheet: worksheet
                                    }).then(() => {
                                        workbook.xlsx.writeBuffer().then(buffer => {
                                            saveAs(new Blob([buffer], {
                                                type: 'application/octet-stream'
                                            }), 'Usuarios.xlsx');
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
                                    const grid = $("#tablaUsuarios").dxDataGrid("instance");
                                    const workbook = new ExcelJS.Workbook();
                                    const worksheet = workbook.addWorksheet('Usuarios');

                                    DevExpress.excelExporter.exportDataGrid({
                                        component: grid,
                                        worksheet: worksheet
                                    }).then(() => {
                                        workbook.csv.writeBuffer().then(buffer => {
                                            saveAs(new Blob([buffer], {
                                                type: 'text/csv'
                                            }), 'Usuarios.csv');
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
            if (accion == 'Usuarios') {
                requisitos("POST",
                    "../../../peticiones_json/panel_administrativo/usuarios/usuarios_json.php",
                    "opcion=AccionConsultar&accion=ConsultarTodos&jsonp=?",
                    function(data) {
                        TBUsuarios(data)
                    },
                    "",
                    Array()
                );
            }else if (accion == 'tipo_documentos') {
                requisitos("POST",
                    "../../../peticiones_json/panel_administrativo/usuarios/usuarios_json.php",
                    "opcion=AccionConsultar&accion=ConsultarTPdocumentos&jsonp=?",
                    function(data) {
                        $.each(data["DATA"], function(index, option) {
                            $('#tp_documentos').append($('<option></option>').val(option.ID).text(option.DESCRIPCION));
                        });
                    },
                    "",
                    Array()
                );
            }else if (accion == 'sexos') {
                requisitos("POST",
                    "../../../peticiones_json/panel_administrativo/usuarios/usuarios_json.php",
                    "opcion=AccionConsultar&accion=ConsultarSexos&jsonp=?",
                    function(data) {
                        $.each(data["DATA"], function(index, option) {
                            $('#sexos').append($('<option></option>').val(option.ID).text(option.DESCRIPCION));
                        });
                    },
                    "",
                    Array()
                );
            }else if (accion == 'roles') {
                requisitos("POST",
                    "../../../peticiones_json/panel_administrativo/usuarios/usuarios_json.php",
                    "opcion=AccionConsultar&accion=ConsultarRoles&jsonp=?",
                    function(data) {
                        $.each(data["DATA"], function(index, option) {
                            $('#roles').append($('<option></option>').val(option.ID).text(option.DESCRIPCION));
                        });
                    },
                    "",
                    Array()
                );
            }
        }
        // La función JavaScript para cambiar el estado de un usuario
function cambiarEstado(id, nuevoEstado) {
    $.ajax({
        url: "../../../peticiones_json/panel_administrativo/usuarios/usuarios_json.php", // La URL a tu script PHP
        type: "POST", // Método HTTP para enviar los datos
        data: { // Datos que se envían al servidor
            opcion: "AccionCambiarEstado", // Indica al PHP qué acción realizar
            id: id,                       // El ID del usuario
            estado: nuevoEstado           // El nuevo estado
        },
        dataType: "json", // Tipo de dato esperado en la respuesta del servidor (JSON)
        success: function(data) {
            console.log("Respuesta:", data); // Para depurar: muestra la respuesta del servidor en la consola

            if (data["ALERTA"] === 'OK') {
                // Si la operación fue exitosa en el servidor
                ModalNotifi('col-md-4 col-md-offset-4', 'Notificación', 'Estado actualizado con éxito', ''); // Muestra una notificación de éxito

                // Recarga solo la tabla DevExtreme sin refrescar toda la página
                $("#tablaUsuarios").dxDataGrid("instance").refresh();
            } else {
                // Si hubo un error reportado por el servidor
                ModalNotifi('col-md-4 col-md-offset-4', 'ERROR', data["MENSAJE"], ''); // Muestra una notificación de error con el mensaje del servidor
            }
        },
        error: function(xhr, status, error) {
            // Si la petición AJAX falla (ej. problema de red, URL incorrecta, error de servidor no capturado por el success)
            console.error("Error en la petición AJAX:", error); // Muestra el error técnico en la consola
            ModalNotifi('col-md-4 col-md-offset-4', 'ERROR', 'Hubo un problema de comunicación con el servidor.', ''); // Muestra un mensaje de error genérico al usuario
        }
    });
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