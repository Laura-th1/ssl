<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('Location: ../');
}
session_start();

if (!isset($_SESSION['USUARIO'])) {
    header("Location: ../../../../login/");
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
    <title>Ver Inventario | Sena Stock</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../../../../includes/img/logos/favicon.png">
    <link href="../../../../includes/librerias/bootstrap_5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../../../includes/librerias/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="../../../../includes/librerias/morrisjs/morris.css" rel="stylesheet">
    <link href="../../../../includes/librerias/c3-master/c3.min.css" rel="stylesheet">
    <link href="../../../../includes/css/panel_administrativo/styles.css" rel="stylesheet">
    <link href="../../../../includes/css/panel_administrativo/dashboard.css" rel="stylesheet">
    <link href="../../../../includes/css/panel_administrativo/colors/styles.css" id="theme" rel="stylesheet">
    <link href="../../../../includes/librerias/jquery-confirm/css/jquery-confirm.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/21.2.3/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/21.2.3/css/dx.light.css">

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
       <!-- Botón menú hamburguesa -->
<button class="custom-navbar-toggler" type="button" onclick="document.body.classList.toggle('show-sidebar')" aria-label="Menú">
    <img src="../../../../includes/img/logos/favicon.png" width="40" height="40" alt="Menú">
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
                    <a class="navbar-brand" href="../../../../" style="font-size: 19px;">
                        <img src="../../../../includes/img/logos/favicon.png" width="60px" height="60px" class="logo-img">
                        <span class="brand-text">Sena Stock</span>
                    </a>
                </div>

            </nav>
        </header>
        <aside class="left-sidebar">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li>
                            <a class="waves-effect waves-dark" href="../../../../" aria-expanded="false">
                                <i class="fa fa-home"></i>
                                <span class="hide-menu">Inicio</span>
                            </a>
                        </li>
                        <?php if ($rolPermitido): ?>

<li>
    <a class="waves-effect waves-dark" href="../../../panel_administrativo/" aria-expanded="false">
        <i class="fa fa-globe"></i>
        <span class="hide-menu">Panel Administrativo</span>
    </a>
</li>
<?php endif; ?>
                        <hr>
                        <li>
                            <a class="waves-effect waves-dark" href="../../" aria-expanded="false">
                                <i class="fa fa-home"></i>
                                <span class="hide-menu">Panel central</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="../../agenda" aria-expanded="false">
                                <i class="fa fa-globe"></i>
                                <span class="hide-menu">Agenda</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="../../ambientes" aria-expanded="false">
                                <i class="fa fa-globe"></i>
                                <span class="hide-menu">Ambientes</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark active" href="../" aria-expanded="false">
                                <i class="fa fa-globe"></i>
                                <span class="hide-menu">Inventarios</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="../../productos/" aria-expanded="false">
                                <i class="fa fa-smile-o"></i>
                                <span class="hide-menu">Articulos</span>
                            </a>
                        </li>
                        <?php if ($rolPermitido): ?>

<li>
    <a class="waves-effect waves-dark" href="../../bloques" aria-expanded="false">
        <i class="fa fa-smile-o"></i>
        <span class="hide-menu">Bloques</span>
    </a>
</li>
<li>
    <a class="waves-effect waves-dark" href="../../titulaciones/" aria-expanded="false">
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
                            <li class="breadcrumb-item"><a href="../../">Home</a></li>
                            <li class="breadcrumb-item active"><a href="../">Inventario</a></li>
                            <li class="breadcrumb-item active">Ver Inventario</li>
                        </ol>
                        <br>
                        <div class="btn-wrapper">
                        <?php if ($rolPermitido): ?>

                            <a href="#" class="btn text-white me-0" style="background-color: #39a900; color: #ffffff;" onclick="CrearNueva();"><i class="icon-download"></i> Asignar Articulos</a>
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
                                            
                                                <div id="tablaInventario"></div>
                                               <div id="totalProductos" class="conteo-productos mt-4 mb-4"></div>

                                         
        </div>
        
         <style>  
.conteo-productos {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    padding: 16px;
    border-radius: 12px;
    background-color: #f8f9fa;
    font-family: 'Segoe UI', sans-serif;
}

.conteo-productos .producto {
    color: #39a900;
    padding: 10px 14px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 16px;
    font-family: 'Segoe UI', sans-serif;
}
</style> 
                                        
            <footer class="footer"> © <?php echo date('Y'); ?> - Sena Stock </footer>
        </div>
    </div>

    <script src="../../../../includes/librerias/jquery_3.7.1/jquery.min.js"></script>
    <script src="../../../../includes/librerias/bootstrap_5.3.0/js/bootstrap.min.js"></script>
    <script src="../../../../includes/librerias/bootstrap_5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="../../../../includes/librerias/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js"></script>
    <script src="../../../../includes/librerias/raphael/raphael-min.js"></script>
    <script src="../../../../includes/librerias/morrisjs/morris.min.js"></script>
    <script src="../../../../includes/librerias/d3/d3.min.js"></script>
    <script src="../../../../includes/librerias/c3-master/c3.min.js"></script>
    <script src="../../../../includes/js/panel_administrativo/waves.js"></script>
    <script src="../../../../includes/js/panel_administrativo/sidebarmenu.js"></script>
    <script src="../../../../includes/js/panel_administrativo/custom.js"></script>
    <!-- <script src="../../../../includes/js/panel_administrativo/dashboard.js"></script> -->
    <script src="../../../../includes/librerias/jquery-confirm/js/jquery-confirm.min.js"></script>
    <script src="https://cdn3.devexpress.com/jslib/21.2.3/js/dx.all.js"></script>
    <!-- <script src="https://cdn3.devexpress.com/jslib/21.2.3/js/dx.exporter.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.2.1/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <script src="../../../../includes/js/global/scripts.js"></script>

    <script type="text/javascript">
        var crear;
        var editar;
        var tabla_datos_inventario;
        var id_inventario = <?php echo($id); ?>;
        
        $(document).ready(function() {
            consultas("Inventario");
        });
        
        function CrearNueva() {
            crear = $.confirm({
                title: 'Asignar Nuevo Articulo',
                backgroundDismiss: false,
                closeIcon: false,
                columnClass: 'col-md-offset-2 col-md-8',
                content: `<div class="panel panel-body">
                                <form>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="producto">Articulos:</label>
                                                <select class="form-control text-dark bg-white" id="producto" name="producto">
                                                </select>
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
                        btnClass: 'btn btn-danger',
                        action: function(ModalCerrar){
                        }
                    },
            guardar: {
                text: 'Guardar',
                btnClass: 'btn btn-green',
                action: function(saveButton){
                    var observacion = $("#observacion").val();
                    var productoId = $("#producto").val();
                    
                    if (!productoId) {
                        $.alert('Debe seleccionar un producto');
                        return false;
                    }
                    
                    $.ajax({
                        url: "../../../../peticiones_json/panel_central/inventarios/inventarios_json.php",
                        type: "POST",
                        dataType: "json",
                        data: {
                            opcion: "AccionInsertarInv",
                            id_inv: id_inventario,
                            observacion: observacion,
                            producto: productoId
                        },
                        success: function(response) {
                            if (response.ALERTA === "OK") {
                                // Mostrar mensaje con información del producto
                                var mensaje = `Producto registrado:<br>
                                              <strong>${response.PRODUCTO.display}</strong>`;
                                
                                ModalNotifi(
                                    'col-md-4 col-md-offset-4', 
                                    'Éxito', 
                                    mensaje, 
                                    'green'
                                );
                                
                                consultas("Inventario");
                                crear.close();
                            } else {
                                // Mostrar error con detalles del producto
                                var mensajeError = `${response.MENSAJE}:<br>
                                                  <strong>${response.PRODUCTO.display}</strong>`;
                                
                                ModalNotifi(
                                    'col-md-4 col-md-offset-4', 
                                    'Error', 
                                    mensajeError, 
                                    'red'
                                );
                            }
                        },
                        error: function() {
                            ModalNotifi(
                                'col-md-4 col-md-offset-4', 
                                'Error', 
                                'Error de conexión con el servidor', 
                                'red'
                            );
                        }
                    });
                    return false; // Evitar cierre automático
                }
            }
        },
        onContentReady: function() {
            // Cargar productos con placas
            $.ajax({
                url: "../../../../peticiones_json/panel_central/inventarios/inventarios_json.php",
                type: "POST",
                data: { opcion: "ObtenerProductosParaInventario" },
                dataType: "json",
                success: function(data) {
                    var $select = $("#producto");
                    $select.empty().append('<option value="">Seleccione un producto</option>');
                    
                    if (data.ALERTA === "OK") {
                        $.each(data.PRODUCTOS, function(i, producto) {
                            var texto = producto.descripcion;
                            if (producto.numero_placa) {
                                texto += " (Placa: " + producto.numero_placa + ")";
                            }
                            
                            $select.append(
                                $('<option>', {
                                    value: producto.id,
                                    text: texto,
                                    'data-placa': producto.numero_placa || ''
                                })
                            );
                        });
                    }
                }
            });
        }
    });
}

        function Editar(id, observacion) {
            editar = $.confirm({
                title: 'Editar Inventario',
                backgroundDismiss: false,
                closeIcon: false,
                columnClass: 'col-md-offset-2 col-md-8',
                content: `<div class="panel panel-body">
                                <form>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="observacion">Observación:</label>
                                                <textarea class="form-control text-dark bg-white" id="observacion" name="observacion" placeholder="">${observacion}</textarea>
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
                    actualizar: {
                        text: 'Actualizar',
                        btnClass: 'btn btn-green',
                        action: function(saveButton){

                            
                            var observacion = $("#observacion").val();

                            requisitos("POST",
                                "../../../../peticiones_json/panel_central/inventarios/inventarios_json.php",
                                "opcion=AccionActualizarInv&id="+id+ "&observacion="+observacion+"&jsonp=?",
                                function(data) {
                                    if (data["ALERTA"] == 'OK') {
                                        consultas("Inventario");
                                        ModalNotifi('col-md-4 col-md-offset-4', 'Notificacion', 'Dato Actualizo Con Exito', '');
                                        return true;
                                    } else if (data["ALERTA"] == 'ERROR') {
                                        editar.close();
                                        ModalNotifi('col-md-4 col-md-offset-4', 'ERROR', data["MENSAJE"], '');
                                        return false;
                                        editar(id,  observacion);
                                    }
                                },
                                "",
                                Array()
                            );
                        }
                    }
                },
                onContentReady: function (){
                }
            });
        }

            function TBInventario(data) {
                tabla_datos_inventario = $("#tablaInventario").dxDataGrid({
                    dataSource: data["DATA"],
                    keyExpr: "ID", // Mantener el ID de datos_inventario como clave principal
                    columns: [{
                        caption: 'N°',
                            dataField: 'NUMERO',
                            width: 100
                        },
                        {
                            caption: 'Articulo',
                            dataField: 'PROD_DES',
                        },
                        {
                            caption: 'Observacion',
                            dataField: 'OBSERVACION',
                        },{
                            caption: 'Nº de Placa', 
                            dataField: 'NUM_PLAC', 
                        },
                        {
                            caption: 'Cuentadante', 
                            dataField: 'USUARIO', 
                        },{
                            dataField: '',
                            caption: 'Acciones',
                            cellTemplate: function(container, options) {
        if (rolPermitido) {
            $('<button class="btn text-white me-0 btn-sm" style="background-color: #39a900; color: #ffffff;">Editar</button>')
                .on('click', function() {
                    Editar(options.data.ID, options.data.OBSERVACION);
                }).appendTo(container);

            $('<button class="btn text-white me-0 btn-sm" style="background-color: #FF0000; color: #ffffff;">Eliminar</button>')
                .on('click', function() {
                    Eliminar(options.data.ID);
                }).appendTo(container);
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
                        fileName: 'Inventarios',
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
                        mode: 'row',
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
                                        const grid = $("#tablaInventario").dxDataGrid("instance");
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
                                        const grid = $("#tablaInventario").dxDataGrid("instance");
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
                        fetch("../../../../peticiones_json/panel_central/inventarios/import.php", {
                            method: "POST",
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log("Respuesta del servidor:", data); // Depuración
                            if (data.status === "success") {
                                alert("Datos importados correctamente.");
                                consultas("Inventarios"); // Actualizar la tabla
                                
                                return true;
                            } else {
                                alert("Error al importar los datos: " + data.message);
                                return false;

                            }
                        })
                        .catch(error => {
                            console.error("Error al enviar datos:", error);
                            location.reload(); // Recargar la página
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
            function contarArticulosFiltrados(dataArray) {
        const conteo = {};

        dataArray.forEach(row => {
            const nombre = row.PROD_DES;
            if (nombre) {
                conteo[nombre] = (conteo[nombre] || 0) + 1;
            }
        });

        const totalContainer = document.getElementById("totalProductos");
        if (totalContainer) {
            totalContainer.innerHTML = ""; // Limpiar antes de agregar

            for (const [producto, cantidad] of Object.entries(conteo)) {
                const item = document.createElement("div");
                item.className = "producto";
                item.innerHTML = `<strong>${producto}</strong>: ${cantidad}` + " articulo(s)";
                item.style.backgroundColor = "#f0f0f0"; // Color de fondo claro
                totalContainer.appendChild(item);
            }

            if (Object.keys(conteo).length === 0) {
                totalContainer.innerHTML = `<div class="producto">No hay articulos registrados</div>`;
            }
        }
    }



        function consultas(accion) {
    if (accion == 'Inventario') {
        requisitos("POST",
            "../../../../peticiones_json/panel_central/inventarios/inventarios_json.php",
            "opcion=AccionConsultar&accion=ConsultarUno&id_inv=" + id_inventario + "&jsonp=?",
            function(data) {
                TBInventario(data); // Pintar la tabla

                // Ejecutar conteo de artículos por nombre
                contarArticulosFiltrados(data["DATA"]);
            },
            "",
            Array()
        );
    } else if (accion == 'productos') {
        requisitos("POST",
            "../../../../peticiones_json/panel_central/inventarios/inventarios_json.php",
            "opcion=AccionConsultar&accion=ConsultarProductos&jsonp=?",
            function(data) {
                $.each(data["DATA"], function(index, option) {
                    $('#producto').append($('<option></option>').val(option.ID).text(option.DESCRIPCION));
                });
            },
            "",
            Array()
        );
    }
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
                fetch("../../../../peticiones_json/panel_central/inventarios/import.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Respuesta del servidor:", data); // Depuración
                    if (data.status === "success") {
                        alert("Datos importados correctamente.");
                        consultas("Inventarios"); // Actualizar la tabla by calling the existing function
                        location.reload(); // Recargar la página
                    } else {
                        alert("Error al importar los datos: " + data.message);
                    }
                })
                .catch(error => {
                    console.error("Error al enviar datos:", error);
                    
                });
            } else {
                alert("No se seleccionó ningún archivo.");
            }
        });

        // Simular un clic para abrir el selector de archivos
        input.click();
    }
};

        function Eliminar(id){
            requisitos("POST",
                        "../../../../peticiones_json/panel_central/inventarios/inventarios_json.php",
                        "opcion=AccionEliminar&id="+id+"&jsonp=?",
                        function(data) {
                            if(data["ALERTA"] == 'OK'){
                                consultas("Inventario");
                            }
                        },
                        "",
                        Array()
                    );
        }


    </script>
</body>

</html>