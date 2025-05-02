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
$rolPermitido = in_array($_SESSION['ROL'], ['Cuentadante', 'Apoyo Tecnológico', 'Administrador']);
$rolPermitido1 = in_array($_SESSION['ROL'], [ 'Apoyo Tecnológico', 'Administrador']);

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
    <title>Articulos | Sena Stock</title>
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
<script>
    var rolPermitido = <?php echo json_encode($rolPermitido); ?>;
    var rolPermitido1 = <?php echo json_encode($rolPermitido1); ?>;

</script>
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
        <a class=" dropdown-item bi-person-badge" href="../perfil/perfil.php">Perfil</a></li>
         <li>
        <a class="dropdown-item" href="#" onclick="cerrarSesion(event);"> Cerrar sesión
        <i class="fa fa-sign-out" aria-hidden="true"></i>
        </a>
        </li>
    </ul> 
            
            </nav>
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
                        <?php if ($rolPermitido1): ?>

                        <li>
                            <a class="waves-effect waves-dark" href="../../../modulos/panel_administrativo/" aria-expanded="false">
                                <i class="fa fa-globe"></i>
                                <span class="hide-menu">Panel Administrativo</span>
                            </a>
                        </li>
                        <?php endif; ?>

                        <hr>
                        <li>
                            <a class="waves-effect waves-dark" href="../" aria-expanded="false">
                                <i class="fa fa-home"></i>
                                <span class="hide-menu">Panel central</span>
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
                            <a class="waves-effect waves-dark active" href="./" aria-expanded="false">
                                <i class="fa fa-smile-o"></i>
                                <span class="hide-menu">Articulos</span>
                            </a>
                        </li>
                        <?php if ($rolPermitido1): ?>

<li>
    <a class="waves-effect waves-dark" href="../bloques" aria-expanded="false">
        <i class="fa fa-smile-o"></i>
        <span class="hide-menu">Bloques</span>
    </a>
</li>
<li>
    <a class="waves-effect waves-dark" href="../titulaciones" aria-expanded="false">
        <i class="fa fa-smile-o"></i>
        <span class="hide-menu">Titulaciones</span>
    </a>
</li>
<?php endif; ?>
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-themecolor">Articulos</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="../">Home</a></li>
                            <li class="breadcrumb-item active">Articulos</li>
                        </ol>
                        <br>
                        <div class="btn-wrapper">
                        <?php if ($rolPermitido1): ?>

                            <a href="#" class="btn text-white me-0" style="background-color: #39a900; color: #ffffff;" onclick="CrearNueva();"><i class="icon-download"></i> Crear Nuevo Articulo</a>
                            <?php endif; ?>

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
                                                <div id="tablaProductos"></div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.4.1/papaparse.min.js"></script>

    <script type="text/javascript">
    var crear;
var editar;
var tabla_datos_productos;

$(document).ready(function() {
    consultas("Productos");
});

function CrearNueva() {
    crear = $.confirm({
        title: 'Crear Nuevo Articulo',
        backgroundDismiss: false,
        closeIcon: false,
        columnClass: 'col-md-offset-2 col-md-8',
        content: `<div class="panel panel-body">
                    <form id="">
                        <div class="row">
                            <div class="col-md-12" id="div_nickname">
                                <div class="form-group">
                                    <label for="nickname">Nombre:</label>
                                    <input type="text" class="form-control text-dark bg-white" id="nombre" name="nombre" placeholder="Ingrese un nombre" required />
                                </div>
                            </div>
                            <div class="col-md-12" id="div_nickname">
                                <div class="form-group">
                                    <label for="nickname">N° de placa:</label>
                                    <input type="text" class="form-control text-dark bg-white" id="numero_placa" name="numero_placa" placeholder="Ingrese el numero de placa del articulo" required />
                                </div>
                            </div>
                            <div class="col-md-12" id="div_nickname">
                                <div class="form-group">
                                    <label for="nickname">Observacion:</label>
                                    <textarea class="form-control text-dark bg-white" id="observacion" name="observacion" placeholder="Ingrese una observacion" required ></textarea>
                                </div>
                            </div>
                            <div class="col-md-12" id="div_nickname">
                                <div class="form-group">
                                    <label for="documento">Número de Documento:</label>
                                    <input type="text" class="form-control text-dark bg-white" id="documento" name="documento" placeholder="Ingrese el número de documento" required />
                                </div>
                            </div>
                            <div class="col-md-12" id="div_nombre_usuario">
                                <div class="form-group">
                                    <label for="nombre_usuario">Nombre del Usuario:</label>
                                    <input type="text" class="form-control text-dark bg-white" id="nombre_usuario" name="nombre_usuario" placeholder="Nombre del usuario" readonly required />
                                    <input type="hidden" id="usuario_id" name="usuario_id" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>`,
        buttons: {
            cancelar: {
                text: 'Cancelar',
                btnClass: 'btn btn-danger',
                action: function() {}
            },
            guardar: {
                text: 'Guardar',
                btnClass: 'btn btn-green',
                action: function(saveButton) {
                    var nombre = $("#nombre").val();
                    var numero_placa = $("#numero_placa").val();
                    var observacion = $("#observacion").val();
                    var documento = $("#documento").val();
                    var nombre_usuario = $("#nombre_usuario").val();
                    var usuario_id = $("#usuario_id").val();
                    
                    console.log("Usuario ID a enviar:", usuario_id); // Para depuración
                    
                    if (!documento || !nombre_usuario || !usuario_id) {
                        ModalNotifi('col-md-4 col-md-offset-4', 'ERROR', 'Debe ingresar un número de documento válido y seleccionar un usuario', '');
                        return false;
                    }

                    requisitos("POST",
                        "../../../peticiones_json/panel_central/productos/productos_json.php",
                        "opcion=AccionInsertar&nombre=" + nombre +"&numero_placa=" + numero_placa + "&observacion=" + observacion + "&documento=" + documento + "&usuario_id=" + usuario_id + "&jsonp=?",
                        function(data) {
                            if (data["ALERTA"] == 'OK') {
                                consultas("Productos");
                                ModalNotifi('col-md-4 col-md-offset-4', 'Notificacion', 'Dato Insertado Con Exito', '');
                                return true;
                            } else if (data["ALERTA"] == 'ERROR') {
                                crear.close();
                                CrearNueva();
                                ModalNotifi('col-md-4 col-md-offset-4', 'ERROR', data["MENSAJE"], '');
                                return false;
                            }
                        },
                        "",
                        []
                    );
                }
            }
        },
        onContentReady: function() {
            // Aquí registramos el evento para buscar el nombre del usuario
            $("#documento").on("blur", function() {
                var documento = $(this).val();

                if (documento) {
                    $.ajax({
                        url: "../../../peticiones_json/panel_central/productos/productos_json.php",
                        method: "POST",
                        data: {
                            opcion: "ObtenerUsuarioPorDocumento",
                            documento: documento
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.ALERTA === "OK") {
                                $("#nombre_usuario").val(response.NOMBRE);
                                $("#usuario_id").val(response.ID);
                                console.log("ID de usuario encontrado:", response.ID); // Para depuración
                            } else {
                                $("#nombre_usuario").val("");
                                $("#usuario_id").val("");
                                ModalNotifi('col-md-4 col-md-offset-4', 'ERROR', response.MENSAJE, '');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error en la petición AJAX:", error);
                            ModalNotifi('col-md-4 col-md-offset-4', 'ERROR', 'Error al buscar el usuario', '');
                        }
                    });
                }
            });
        }
    });
}

function Editar(id, nombre, numero_placa, observacion, estado, documento, nombre_usuario, usuario_id) {
    crear = $.confirm({
        title: 'Editar Articulo',
        backgroundDismiss: false,
        closeIcon: false,
        columnClass: 'col-md-offset-2 col-md-8',
        content: `<div class="panel panel-body">
                    <form id="formRestPassw">
                        <div class="row">
                            <div class="col-md-12" id="div_nickname">
                                <div class="form-group">
                                    <label for="nickname">Nombre:</label>
                                    <input type="text" class="form-control text-dark bg-white" id="nombre" name="nombre" placeholder="" value="${nombre}" required />
                                </div>
                            
                            <div class="col-md-12" id="div_nickname">
                                <div class="form-group">
                                    <label for="nickname">N° de placa:</label>
                                    <input type="text" class="form-control text-dark bg-white" id="numero_placa" name="numero_placa" placeholder="" value="${numero_placa}" required />
                                </div>
                            </div>
                            <div class="col-md-12" id="div_nickname">
                                <div class="form-group">
                                    <label for="nickname">Observacion:</label>
                                    <textarea class="form-control text-dark bg-white" id="observacion" name="observacion" placeholder="" required>${observacion}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12" id="div_nickname">
                                <div class="form-group">
                                    <label for="documento">Número de Documento:</label>
                                    <input type="text" class="form-control text-dark bg-white" id="documento" name="documento" value="${documento}" placeholder="Ingrese el número de documento" required />
                                </div>
                            </div>
                            <div class="col-md-12" id="div_nombre_usuario">
                                <div class="form-group">
                                    <label for="nombre_usuario">Nombre del Usuario:</label>
                                    <input type="text" class="form-control text-dark bg-white" id="nombre_usuario" name="nombre_usuario" value="${nombre_usuario}" readonly required />
                                    <input type="hidden" id="usuario_id" name="usuario_id" value="${usuario_id || ''}" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="d-block">Opciones</label>
                                    <div class="form-check form-check-inline" style="margin-top: 15px;">
                                        <input class="form-check-input" type="radio" id="estado_ac" name="estado" value="1">
                                        <label class="form-check-label" for="estado_ac">Activo</label>
                                    </div>
                                    <div class="form-check form-check-inline" style="margin-top: 15px;">
                                        <input class="form-check-input" type="radio" id="estado_ina" name="estado" value="0">
                                        <label class="form-check-label" for="estado_ina">Inactivo</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>`,
        buttons: {
            cancelar: {
                text: 'Cancelar',
                btnClass: 'btn btn-danger',
                action: function() {}
            },
            actualizar: {
                text: 'Actualizar',
                btnClass: 'btn btn-green',
                action: function(saveButton) {
                    var nombre = $("#nombre").val();
                    var numero_placa = $("#numero_placa").val();
                    var observacion = $("#observacion").val();
                    var estado_new = $('input[name="estado"]:checked').val();
                    var documento = $("#documento").val();
                    var nombre_usuario = $("#nombre_usuario").val();
                    var usuario_id = $("#usuario_id").val();
                    
                    console.log("Usuario ID a actualizar:", usuario_id); // Para depuración
                    
                    if (!documento || !nombre_usuario || !usuario_id) {
                        ModalNotifi('col-md-4 col-md-offset-4', 'ERROR', 'Debe ingresar un número de documento válido y seleccionar un usuario', '');
                        return false;
                    }

                    requisitos("POST",
                        "../../../peticiones_json/panel_central/productos/productos_json.php",
                        "opcion=AccionActualizar&id=" + id + "&nombre=" + nombre +"&numero_placa=" + numero_placa + "&observacion=" + observacion + "&estado=" + estado_new + "&documento=" + documento + "&usuario_id=" + usuario_id + "&jsonp=?",
                        function(data) {
                            if (data["ALERTA"] == 'OK') {
                                consultas("Productos");
                                ModalNotifi('col-md-4 col-md-offset-4', 'Notificacion', 'Dato Actualizado Con Exito', '');
                                return true;
                            } else if (data["ALERTA"] == 'ERROR') {
                                editar.close();
                                ModalNotifi('col-md-4 col-md-offset-4', 'ERROR', data["MENSAJE"], '');
                                return false;
                            }
                        },
                        "",
                        []
                    );
                }
            }
        },
        onContentReady: function() {
            if (estado === 1) {
                $('#estado_ac').prop('checked', true);
                $('#estado_ina').prop('checked', false);
            } else if (estado === 0) {
                $('#estado_ac').prop('checked', false);
                $('#estado_ina').prop('checked', true);
            }

            // Set the values when editing
            $("#documento").val(documento);
            $("#nombre_usuario").val(nombre_usuario);
            
            // También debes registrar el evento para buscar el usuario al cambiar el documento
            $("#documento").on("blur", function() {
                var documento = $(this).val();

                if (documento) {
                    $.ajax({
                        url: "../../../peticiones_json/panel_central/productos/productos_json.php",
                        method: "POST",
                        data: {
                            opcion: "ObtenerUsuarioPorDocumento",
                            documento: documento
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.ALERTA === "OK") {
                                $("#nombre_usuario").val(response.NOMBRE);
                                $("#usuario_id").val(response.ID);
                                console.log("ID de usuario actualizado:", response.ID); // Para depuración
                            } else {
                                $("#nombre_usuario").val("");
                                $("#usuario_id").val("");
                                ModalNotifi('col-md-4 col-md-offset-4', 'ERROR', response.MENSAJE, '');
                            }
                        }
                    });
                }
            });
        }
    });
}


function TBProductos(data) {
    tabla_datos_productos = $("#tablaProductos").dxDataGrid({
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
                dataField: 'NUMERO_PLACA',
                caption: 'N° de Placa'
            },
            
            {
                dataField: 'OBSERVACION',
                caption: 'Observacion'
            },
            {
                dataField: 'ESTADO',
                caption: 'Estado'
            },
            {
                dataField: 'USUARIO', // Columna con el nombre del usuario
                caption: 'Usuario'
            },
            { dataField: '',
                caption: 'Acciones',
                cellTemplate: function(container, options) {
                    if (rolPermitido) {
                        $(`<td>
                            <button class="btn text-white me-0 btn-sm" style="background-color: #39a900; color: #ffffff;" onclick="Editar(${options.data.ID}, '${options.data.DESCRIPCION}', '${options.data.NUMERO_PLACA}', '${options.data.OBSERVACION}', ${options.data.ESTADO_INT}, '${options.data.DOCUMENTO || ''}', '${options.data.USUARIO}', ${options.data.USUARIO_ID || 0});"> 
                                Editar
                            </button>
                        </td>`).appendTo(container);
                    }
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
            visible: false
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
            fileName: 'Productos',
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
                                    const grid = $("#tablaProductos").dxDataGrid("instance");
                                    const workbook = new ExcelJS.Workbook();
                                    const worksheet = workbook.addWorksheet('Productos');

                                    DevExpress.excelExporter.exportDataGrid({
                                        component: grid,
                                        worksheet: worksheet
                                    }).then(() => {
                                        workbook.xlsx.writeBuffer().then(buffer => {
                                            saveAs(new Blob([buffer], {
                                                type: 'application/octet-stream'
                                            }), 'Articulos.xlsx');
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
                                    const grid = $("#tablaProductos").dxDataGrid("instance");
                                    const workbook = new ExcelJS.Workbook();
                                    const worksheet = workbook.addWorksheet('Productos');

                                    DevExpress.excelExporter.exportDataGrid({
                                        component: grid,
                                        worksheet: worksheet
                                    }).then(() => {
                                        workbook.csv.writeBuffer().then(buffer => {
                                            saveAs(new Blob([buffer], {
                                                type: 'text/csv'
                                            }), 'Articulos.csv');
                                        });
                                    });
                                }
                            },
                            location: 'after'
                        },{
    widget: 'dxButton',
    options: {
        icon: 'upload',
        text: 'Importar CSV',
        onClick: function() {
            // Crear un input para seleccionar el archivo CSV
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = '.csv';

            // Evento para manejar el archivo seleccionado
            input.addEventListener('change', function(event) {
                const file = event.target.files[0]; // Obtener el archivo seleccionado

                if (file) {
                    const formData = new FormData();
                    formData.append('csv_file', file); // Use 'csv_file' here
                    formData.append('import_data', true);

                    // Enviar el archivo al servidor
                    fetch("../../../peticiones_json/panel_central/productos/import.php", {
                        method: "POST",
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log("Respuesta del servidor:", data); // Depuración
                        if (data.status === "success") {
                            alert("Datos importados correctamente.");
                            consultas("Productos"); // Actualizar la tabla
                        } else {
                            alert("Error al importar los datos: " + data.message);
                        }
                    })
                    .catch(error => {
                        console.error("Error al enviar datos:", error);
                        alert("Error al importar los datos.");
                    });
                } else {
                    alert("No se seleccionó ningún archivo.");
                }
            });

            // Simular un clic para abrir el selector de archivos
            input.click();
        }
    },
    location: 'after'
}
                    ]
                }
            });
        }

function consultas(opc) {
    requisitos("POST",
        "../../../peticiones_json/panel_central/productos/productos_json.php",
        "opcion=AccionConsultar&accion=ConsultarTodos&jsonp=?",
        function(data) {
            if (data["DATA"].length > 0) {
                if (opc == "Productos") {
                    TBProductos(data);
                }
            }
        },
        "",
        []
    );
}

// Button configuration for CSV import
var importCsvOption = {
    icon: 'import',
    text: 'Importar CSV',
    onClick: function() {
        // Crear un input para seleccionar el archivo CSV
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = '.csv';

        // Evento para manejar el archivo seleccionado
        input.addEventListener('change', function(event) {
            const file = event.target.files[0]; // Obtener el archivo seleccionado

            if (file) {
                const formData = new FormData();
                formData.append('csv_file', file); // Use 'csv_file' here
                formData.append('import_data', true);

                // Enviar el archivo al servidor
                fetch("../../../peticiones_json/panel_central/productos/import.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Respuesta del servidor:", data); // Depuración
                    if (data.status === "success") {
                        alert("Datos importados correctamente.");
                        consultas("Productos"); // Actualizar la tabla by calling the existing function
                    } else {
                        alert("Error al importar los datos: " + data.message);
                    }
                })
                .catch(error => {
                    console.error("Error al enviar datos:", error);
                    alert("Error al importar los datos.");
                });
            } else {
                alert("No se seleccionó ningún archivo.");
            }
        });

        // Simular un clic para abrir el selector de archivos
        input.click();
    }
};

function cerrarSesion(event) {
    event.preventDefault();

    fetch('../perfil/logout.php')
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