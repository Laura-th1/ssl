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
    <title>Inventarios | Sena Stock</title>
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
      function CrearNueva() {
    crear = $.confirm({
        title: 'Crear Nuevo Inventario',
        backgroundDismiss: false,
        closeIcon: false,
        columnClass: 'col-md-offset-2 col-md-8',
        content: `<div class="panel panel-body">
                    <form>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" class="form-control text-dark bg-white" id="nombre" name="nombre" placeholder=""/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="bloque">Bloque:</label>
                                    <select class="form-control text-dark bg-white" name="bloque" id="bloque"></select>
                                </div>
                            </div>  
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="observacion">Observación:</label>
                                    <textarea class="form-control text-dark bg-white" id="observacion" name="observacion" placeholder=""></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                  </div>`,
        buttons: {
            cancelar: {
                text: 'Cancelar',
                btnClass: 'btn btn-danger'
            },
            guardar: {
                text: 'Guardar',
                btnClass: 'btn btn-green',
                action: function() {
                    var nombre = $("#nombre").val().trim();
                    var observacion = $("#observacion").val().trim();
                    var bloque = $("#bloque").val();

                    console.log("Datos enviados:", { nombre, observacion, bloque });

                    if (!nombre || !bloque) {
                        ModalNotifi('col-md-4 col-md-offset-4', 'Error', 'Todos los campos requeridos deben estar completos.', '');
                        return false;
                    }

                    requisitos("POST",
                        "../../../peticiones_json/panel_central/inventarios/inventarios_json.php",
                        "opcion=AccionInsertar&nombre=" + encodeURIComponent(nombre) +
                        "&observacion=" + encodeURIComponent(observacion) +
                        "&bloque=" + encodeURIComponent(bloque), // CORREGIDO: "bloque", no "Bloque"
                        function(data) {
                            console.log("Respuesta del servidor:", data);
                            if (data["ALERTA"] == 'OK') {
                                consultas("Inventarios");
                                ModalNotifi('col-md-4 col-md-offset-4', 'Notificación', 'Dato insertado con éxito.', '');
                                crear.close(); // Cierra el modal si todo fue bien
                            } else {
                                ModalNotifi('col-md-4 col-md-offset-4', 'ERROR', data["MENSAJE"], '');
                            }
                        },
                        function(error) {
                            console.error("Error en la petición:", error);
                            ModalNotifi('col-md-4 col-md-offset-4', 'ERROR', 'Error al enviar los datos.', '');
                        },
                        []
                    );

                    return false; // Previene el cierre automático del modal por jQuery Confirm
                }
            }
        },
        onContentReady: function () {
            consultas('Bloques'); // Llenar los bloques
        }
    });
}


</script>
<script>
    var rolPermitido = <?php echo json_encode($rolPermitido); ?>;
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
                        <?php if ($rolPermitido): ?>

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
                                <span class="hide-menu">Panel Central</span>
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
                            <a class="waves-effect waves-dark active" href="./" aria-expanded="false">
                                <i class="fa fa-globe"></i>
                                <span class="hide-menu">Inventarios</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="../productos/" aria-expanded="false">
                                <i class="fa fa-smile-o"></i>
                                <span class="hide-menu">Articulos</span>
                            </a>
                        </li>
                        <?php if ($rolPermitido): ?>

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
                        <h3 class="text-themecolor">Inventario</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="../">Home</a></li>
                            <li class="breadcrumb-item active">Inventario</li>
                        </ol>
                        <br>
                        <div class="btn-wrapper">
                        <?php if ($rolPermitido): ?>

                            <a href="#" class="btn text-white me-0" style="background-color: #39a900; color: #ffffff;" onclick="CrearNueva();"><i class="icon-download"></i> Crear Nuevo Inventario</a>
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
                                                <div id="tablaInventarios"></div>
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

<!-- jQuery -->
<script src="../../../includes/librerias/jquery_3.7.1/jquery.min.js"></script>

<!-- Bootstrap (dependencias de jQuery) -->
<script src="../../../includes/librerias/bootstrap_5.3.0/js/bootstrap.bundle.min.js"></script> <!-- bootstrap.bundle incluye popper.js, necesario para Bootstrap -->
<script src="../../../includes/librerias/bootstrap_5.3.0/js/bootstrap.min.js"></script>

<!-- Librerías de terceros (para funcionalidad específica) -->
<script src="../../../includes/librerias/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js"></script>
<script src="../../../includes/librerias/raphael/raphael-min.js"></script>
<script src="../../../includes/librerias/morrisjs/morris.min.js"></script>
<script src="../../../includes/librerias/d3/d3.min.js"></script>
<script src="../../../includes/librerias/c3-master/c3.min.js"></script>

<!-- Librerías para Confirmación (Dependencia de jQuery) -->
<script src="../../../includes/librerias/jquery-confirm/js/jquery-confirm.min.js"></script>

<!-- DevExpress (Requiere jQuery) -->
<script src="https://cdn3.devexpress.com/jslib/21.2.3/js/dx.all.js"></script>
<script src="https://cdn3.devexpress.com/jslib/21.2.3/js/dx.exporter.js"></script>

<!-- Librerías para exportación y archivo -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.2.1/exceljs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

<!-- Scripts personalizados del panel administrativo -->
<script src="../../../includes/js/panel_administrativo/waves.js"></script>
<script src="../../../includes/js/panel_administrativo/sidebarmenu.js"></script>
<script src="../../../includes/js/panel_administrativo/custom.js"></script>
<!-- <script src="../../../includes/js/panel_administrativo/dashboard.js"></script> -->

<!-- Script global -->
<script src="../../../includes/js/global/scripts.js"></script>


    <script type="text/javascript">
        var crear;
        var editar;

        var tabla_datos_productos;
        
        $(document).ready(function() {
            consultas("Inventarios");
        });
        
      
        function Editar(id, nombre, Bloque, observacion, estado) {
    console.log("Editar llamado con:", { id, nombre, Bloque, observacion, estado });

    // Asegurarnos de que estado tenga un valor por defecto si es undefined
    if (estado === undefined) {
        estado = 1; // Valor por defecto (activo)
    }

    editar = $.confirm({
        title: 'Editar Inventario',
        backgroundDismiss: false,
        closeIcon: false,
        columnClass: 'col-md-offset-2 col-md-8',
        content: function() {
            var html = `<div class="panel panel-body">
                            <form>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="nombre">Nombre:</label>
                                            <input type="text" class="form-control text-dark bg-white" id="nombre" name="nombre" placeholder="Ingresar el nombre" value="${nombre}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="bloque">Bloque:</label>
                                            <select class="form-control text-dark bg-white" name="bloque" id="bloque">
                                                <!-- Se llenará dinámicamente -->
                                            </select>
                                        </div>
                                    </div>  
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="observacion">Observación:</label>
                                            <textarea class="form-control text-dark bg-white" id="observacion" name="observacion" placeholder="">${observacion}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Estado:</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="estado" id="estado_ac" value="1" ${estado === 1 ? 'checked' : ''}>
                                                <label class="form-check-label" for="estado_ac">Activo</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="estado" id="estado_ina" value="0" ${estado === 0 ? 'checked' : ''}>
                                                <label class="form-check-label" for="estado_ina">Inactivo</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>`;
            return html;
        },
        buttons: {
            cancelar: {
                text: 'Cancelar',
                btnClass: 'btn btn-danger',
                action: function() {
                    // Acción al cancelar
                    console.log("Modal cancelado.");
                }
            },
            actualizar: {
                text: 'Actualizar',
                btnClass: 'btn btn-green',
                action: function() {
                    // Acción al actualizar
                    console.log("Actualizando inventario...");
                    var nombre = $("#nombre").val();
                    var bloque = $("#bloque").val();
                    var observacion = $("#observacion").val();
                    var estado_new = $('input[name="estado"]:checked').val();

                    if (!nombre || !bloque) {
                        $.alert({
                            title: 'Error',
                            content: 'El nombre y el bloque son obligatorios',
                            type: 'red',
                            typeAnimated: true
                        });
                        return false;
                    }

                    if (estado_new === undefined) {
                        estado_new = estado;
                    }

                    console.log("Datos a enviar:", { id, nombre, bloque, observacion, estado: estado_new });

                    $.ajax({
                        type: "POST",
                        url: "../../../peticiones_json/panel_central/inventarios/inventarios_json.php",
                        data: {
                            opcion: "AccionActualizar",
                            inventario_id: id,
                            nombre: nombre,
                            bloque: bloque,
                            observacion: observacion,
                            estado: estado_new
                        },
                        dataType: "json",
                        success: function(response) {
    console.log("Respuesta del servidor:", response);
    if (response.ALERTA === 'OK') {
        $.alert({
            title: 'Éxito',
            content: 'Inventario actualizado correctamente',
            type: 'green'
        });
        location.reload(); // Recargar la página para reflejar los cambios
    } else {
        $.alert({
            title: 'Error',
            content: 'Hubo un problema al actualizar el inventario',
            type: 'red'
        });
    }
}
,
                        error: function(xhr, status, error) {
                            console.error("Error en la solicitud AJAX:", error);
                            $.alert({
                                title: 'Error',
                                content: 'No se pudo procesar la solicitud',
                                type: 'red'
                            });
                        }
                    });

                    return true;
                }
            }
        },
        onContentReady: function() {
            console.log("onContentReady ejecutado.");

            // Cargar bloques directamente con AJAX
            $.ajax({
                type: "POST",
                url: "../../../peticiones_json/panel_central/ambientes/ambientes_json.php",
                data: {
                    opcion: "AccionConsultar",
                    accion: "ConsultarBloques"
                },
                dataType: "json",
                success: function(data) {
                    console.log("Bloques recibidos:", data);
                    if (data && data.DATA) {
                        $.each(data.DATA, function(index, option) {
                            $('#bloque').append($('<option></option>').val(option.ID).text(option.DESCRIPCION));
                        });

                        // Establecer el valor del bloque después de cargar las opciones
                        $('#bloque').val(Bloque);
                        console.log("Valor del bloque establecido:", Bloque);
                    } else {
                        console.error("No se recibieron bloques o formato incorrecto");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error al cargar bloques:", status, error);
                }
            });

            // Asegurarse de que el estado esté seleccionado
            if (estado === 1) {
                $('#estado_ac').prop('checked', true);
            } else if (estado === 0) {
                $('#estado_ina').prop('checked', true);
            } else {
                // Valor por defecto si no hay estado
                $('#estado_ac').prop('checked', true);
            }
        }
    }); // <- Aquí cierra correctamente el $.confirm
}

     // Función que renderiza la tabla con los datos
function TBInventarios(data) {
    console.log("Iniciando función TBInventarios con datos:", data); // Verificamos qué está llegando a la función
    if (data && data.DATA) {
        $("#tablaInventarios").dxDataGrid({
            dataSource: data["DATA"],   // Pasamos los datos correctamente
            columns: [
                { dataField: 'NUMERO', caption: 'N°', width: 100 },
                { dataField: 'BLOQ_DESC', caption: 'Bloque' },
                { dataField: 'NOMBRE', caption: 'Nombre' }, // Cambiado de DESCRIPCION a NOMBRE
                { dataField: 'OBSERVACION', caption: 'Observacion' },
                { dataField: 'ESTADO', caption: 'Estado' },
                {
                    caption: 'Acciones',
                    cellTemplate: function (container, options) {
                        console.log("Datos de la fila:", options.data); // Depuración
                        const verButton = $(`<button class="btn btn-sm text-white me-1" style="background-color: #39a900;">Ver</button>`);
                        verButton.on('click', () => VerInventario(options.data.ID));
                        verButton.appendTo(container);

                        if (rolPermitido) {
                            const editarButton = $(`<button class="btn btn-sm text-white" style="background-color: #39a900;">Editar</button>`);
                            editarButton.on('click', () => Editar(options.data.ID, options.data.NOMBRE, options.data.BLOQ_ID, options.data.OBSERVACION, options.data.ESTADO_INT));
                            editarButton.appendTo(container);
                        }
                    }
                }
            ],
            showBorders: true,
            paging: {
                enabled: true,
                pageSize: 10
            },
            searchPanel: {
                visible: true,
                width: 240,
                placeholder: 'Buscar...'
            },
            headerFilter: { visible: true },
            groupPanel: { visible: false },
            loadPanel: { enabled: true },
            filterRow: { visible: true, applyFilter: 'auto' },
            selection: {
                mode: 'multiple',
                showCheckBoxesMode: 'always'
            },
            export: {
                enabled: true,
                fileName: 'Inventarios',
                allowExportSelectedData: true,
                texts: {
                    exportAll: 'Exportar todo',
                    exportSelectedRows: 'Exportar filas seleccionadas'
                }
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
                                    const grid = $("#tablaInventarios").dxDataGrid("instance");
                                    const workbook = new ExcelJS.Workbook();
                                    const worksheet = workbook.addWorksheet('Inventarios');

                                    DevExpress.excelExporter.exportDataGrid({
                                        component: grid,
                                        worksheet: worksheet
                                    }).then(() => {
                                        workbook.xlsx.writeBuffer().then(buffer => {
                                            saveAs(new Blob([buffer], {
                                                type: 'application/octet-stream'
                                            }), 'Inventarios.xlsx');
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
                                    const grid = $("#tablaInventarios").dxDataGrid("instance");
                                    const workbook = new ExcelJS.Workbook();
                                    const worksheet = workbook.addWorksheet('Inventarios');

                                    DevExpress.excelExporter.exportDataGrid({
                                        component: grid,
                                        worksheet: worksheet
                                    }).then(() => {
                                        workbook.csv.writeBuffer().then(buffer => {
                                            saveAs(new Blob([buffer], {
                                                type: 'text/csv'
                                            }), 'Inventarios.csv');
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
                    fetch("../../../peticiones_json/panel_central/inventarios/importinv.php", {
                        method: "POST",
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log("Respuesta del servidor:", data); // Depuración
                        if (data.status === "success") {
                            alert("Datos importados correctamente.");
                            consultas("Inventarios"); // Actualizar la tabla
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
        }}
    

// Función para cargar la tabla con los datos de la API
$(document).ready(() => {
    consultas('Inventarios'); // Llamamos a la función para cargar los datos al inicio
});

function consultas(accion) {
    if (accion == 'Inventarios') {
        requisitos("POST",
            "../../../peticiones_json/panel_central/inventarios/inventarios_json.php",
            "opcion=AccionConsultar&accion=ConsultarTodos&jsonp=?",
            function(data) {
                console.log("Datos recibidos de la API:", data);  // Aquí vemos la respuesta completa
                if (data && data.DATA) {
                    console.log("Datos de INVENTARIOS:", data.DATA);  // Verificamos que DATA esté presente
                    TBInventarios(data);
                } else {
                    console.error("La respuesta no contiene 'DATA' o está vacía.");
                }
            },
            function(error) {
                console.error("Error en la solicitud AJAX:", error);
            },
            []
        );
    } else if (accion == 'Bloques') {
        console.log("Consultando bloques...");
        requisitos("POST",
            "../../../peticiones_json/panel_central/ambientes/ambientes_json.php",
            "opcion=AccionConsultar&accion=ConsultarBloques&jsonp=?",
            function(data) {
                console.log("Datos recibidos de Bloques:", data);
                $.each(data["DATA"], function(index, option) {
                    $('#bloque').append($('<option></option>').val(option.ID).text(option.DESCRIPCION));
                });
            },
            "",
        );
    }
}


// Función para ver inventario
function VerInventario(id) {
    var url = './ver_inventario/?id=' + id;
    window.location.href = url;
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
                fetch("../../../peticiones_json/panel_central/inventarios/importinv.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Respuesta del servidor:", data); // Depuración
                    if (data.status === "success") {
                        alert("Datos importados correctamente.");
                        consultas("Inventarios"); // Actualizar la tabla by calling the existing function
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