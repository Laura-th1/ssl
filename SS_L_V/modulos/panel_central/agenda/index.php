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
    <title>Agendamientos Ambientes | Sena Stock</title>
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
        title: 'Crear Nuevo Agendamiento de Ambiente',
        backgroundDismiss: false,
        closeIcon: false,
        columnClass: 'col-md-offset-2 col-md-8',
        content: `<div class="panel panel-body">
                        <form>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nombre">Fecha Inicial:</label>
                                        <input type="date" class="form-control text-dark bg-white" id="fecha" name="fecha"/>
                                    </div>
                                </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nombre">Fecha Final:</label>
                                        <input type="date" class="form-control text-dark bg-white" id="fecha_fin" name="fecha_fin"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Bloque">Hora Inicio:</label>
                                        <input type="time" class="form-control text-dark bg-white" id="hora_ini" name="hora_ini"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="observacion">Hora Fin:</label>
                                         <input type="time" class="form-control text-dark bg-white" id="hora_fin" name="hora_fin"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Bloque">Bloque:</label>
                                        <select class="form-control text-dark bg-white" id="bloque" name="bloque">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bloque">Ambiente:</label>
                                        <select class="form-control text-dark bg-white" id="ambiente" name="ambiente">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Bloque">Titulacion:</label>
                                        <select class="form-control text-dark bg-white" id="titulacion" name="titulacion">
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>`,
        buttons: {
            cancelar: {
                text: 'Cancelar',
                btnClass: 'btn btn-danger',
                action: function() {
                    // No es necesario hacer nada más aquí
                }
            },
            guardar: {
                text: 'Guardar',
                btnClass: 'btn btn-green',
                action: function(saveButton) {
                    var fecha = $("#fecha").val();
                    var fecha_fin = $("#fecha_fin").val();
                    var hora_ini = $("#hora_ini").val();
                    var hora_fin = $("#hora_fin").val();

                    // Validación antes de enviar los datos
                    if (!fecha || !fecha_fin|| !hora_ini || !hora_fin || !$("#bloque").val() || !$("#ambiente").val() || !$("#titulacion").val()) {
                        ModalNotifi('col-md-4 col-md-offset-4', 'ERROR', 'Por favor complete todos los campos.', '');
                        return false;
                    }

                    console.log({
                        fecha: $('#fecha').val(),
                        fecha_fin: $('#fecha_fin').val(),
                        hora_ini: $('#hora_ini').val(),
                        hora_fin: $('#hora_fin').val(),
                        bloque: $('#bloque').val(),
                        ambiente: $('#ambiente').val(),
                        titulacion: $('#titulacion').val()
                    });

                    // Realizar la petición AJAX directamente aquí
                    $.ajax({
                        type: "POST",
                        url: "../../../peticiones_json/panel_central/agenda/agenda_json.php",
                        data: {
                            opcion: "AccionInsertar",
                            fecha: fecha,
                            fecha_fin: fecha_fin,
                            hora_ini: hora_ini,
                            hora_fin: hora_fin,
                            bloque: $("#bloque").val(),
                            ambiente: $("#ambiente").val(),
                            titulacion: $("#titulacion").val()
                        },
                        dataType: "json",
                        success: function(data) {
                            console.log(data);
                            if (data["ALERTA"] === 'OK') {
                                crear.close();
                                ModalNotifi('col-md-4 col-md-offset-4', 'Notificacion', 'Dato Insertado Con Exito', '');
                                setTimeout(function() {
                                    location.reload();
                                }, 1200); // Espera 1.2 segundos antes de recargar para mostrar el mensaje
                            } else if (data["ALERTA"] === 'ERROR') {
                                // Mostrar alerta personalizada si el ambiente está ocupado
                                ModalNotifi('col-md-4 col-md-offset-4', 'ERROR', data["MENSAJE"] || 'El ambiente no está disponible en el rango seleccionado.', '');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error en la petición AJAX:", error);
                            console.log("Respuesta del servidor:", xhr.responseText); // Verifica la respuesta
                            ModalNotifi('col-md-4 col-md-offset-4', 'ERROR', 'Hubo un problema al procesar la solicitud.', '');
                        }
                    });
          


                }
            }
        },
        onContentReady: function () {
    consultas('Bloques');
    consultas('titulaciones');
    $("#bloque").change(function() {
        var valor = $(this).val();
        if (valor) {
            form_Bloque = valor;
            consultas("ambientes");
        } else {
            $('#ambiente').empty();
        }
    });
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
                                <span class="hide-menu">Panel central</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark active" href="./" aria-expanded="false">
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
                        <?php if ($rolPermitido): ?>

<li>
    <a class="waves-effect waves-dark " href="../bloques" aria-expanded="false">
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
                <div class="row page-tides">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-themecolor">Agenda de Ambientes</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="../">Home</a></li>
                            <li class="breadcrumb-item active">Agenda de Ambientes</li>
                        </ol>
                        <br>
                        <div class="btn-wrapper">
                            <?php if ($rolPermitido): ?>
                                <a href="#" class="btn text-white me-0" style="background-color: #39a900; color: #ffffff;" onclick="CrearNueva();">
                                    <i class="icon-download"></i> Crear Nuevo Agendamiento
                                </a>
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
                                                <div id="tablaAgendamientos"></div>
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
    <script src="https://cdn3.devexpress.com/jslib/21.2.3/js/dx.exporter.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.2.1/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <script src="../../../includes/js/global/scripts.js"></script>
    <script type="text/javascript">
        var crear;
        var editar;
        var form_Bloque;

        var tabla_datos_agenda;

        $(document).ready(function() {
            consultas("Agenda");
        });



        function Editar(id, fecha, fecha_fin, hora_ini, hora_fin, Bloque, ambiente, titulacion, estado) {
    editar = $.confirm({
        title: 'Editar Ambiente',
        backgroundDismiss: false,
        closeIcon: false,
        columnClass: 'col-md-offset-2 col-md-8',
        content: `<div class="panel panel-body">
            <form>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fecha">Fecha Inicio:</label>
                            <input type="date" class="form-control text-dark bg-white" id="fecha" name="fecha"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fecha">Fecha Final:</label>
                            <input type="date" class="form-control text-dark bg-white" id="fecha_fin" name="fecha_fin"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="hora_ini">Hora Inicio:</label>
                            <input type="time" class="form-control text-dark bg-white" id="hora_ini" name="hora_ini"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="hora_fin">Hora Fin:</label>
                            <input type="time" class="form-control text-dark bg-white" id="hora_fin" name="hora_fin"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bloque">Bloque:</label>
                            <select class="form-control text-dark bg-white" id="bloque" name="bloque"></select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ambiente">Ambiente:</label>
                            <select class="form-control text-dark bg-white" id="ambiente" name="ambiente"></select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="titulacion">Titulación:</label>
                            <select class="form-control text-dark bg-white" id="titulacion" name="titulacion"></select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="d-block">Estado:</label>
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
                action: function () {}
            },
            actualizar: {
                text: 'Actualizar',
                btnClass: 'btn btn-green',
                action: function () {
                    $.ajax({
                        url: "../../../peticiones_json/panel_central/agenda/agenda_json.php",
                        method: "POST",
                        data: {
                            opcion: "AccionActualizar",
                            id: id,
                            fecha: $("#fecha").val(),
                            fecha_fin: $("#fecha_fin").val(),
                            hora_ini: $("#hora_ini").val(),
                            hora_fin: $("#hora_fin").val(),
                            bloque: $("#bloque").val(),
                            ambiente: $("#ambiente").val(),
                            titulacion: $("#titulacion").val(),
                            estado: $('input[name="estado"]:checked').val()
                        },
                        dataType: "json",
                        success: function (response) {
                            console.log("Respuesta del servidor:", response);
                            if (response.ALERTA === "OK") {
                                consultas("Agenda");
                                ModalNotifi('col-md-4 col-md-offset-4', 'Notificación', 'Dato actualizado con éxito', '');
                            } else {
                                editar.close();
                                ModalNotifi('col-md-4 col-md-offset-4', 'ERROR', response.MENSAJE, '');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error("Error en la petición:", status, error);
                            console.log("Respuesta del servidor:", xhr.responseText); // Inspecciona la respuesta
                            editar.close();
                            ModalNotifi('col-md-4 col-md-offset-4', 'ERROR', 'Ocurrió un error al actualizar.', '');
                        }
                    });
                }
            }
        },
        onContentReady: function () {
            $('#fecha').val(fecha);
            $('#fecha_fin').val(fecha_fin);
            $('#hora_ini').val(hora_ini);
            $('#hora_fin').val(hora_fin);

            consultas('Bloques');
            setTimeout(function () {
                $('#bloque').val(Bloque);
                form_Bloque = Bloque;

                consultas('ambientes');
                setTimeout(function () {
                    $('#ambiente').val(ambiente);
                }, 100);
            }, 100);

            consultas('titulaciones');
            setTimeout(function () {
                $('#titulacion').val(titulacion);
            }, 100);

            if (estado == 1) {
                $('#estado_ac').prop('checked', true);
            } else {
                $('#estado_ina').prop('checked', true);
            }

            $("#bloque").change(function () {
                var valor = $(this).val();
                if (valor) {
                    form_Bloque = valor;
                    consultas("ambientes");
                } else {
                    $('#ambiente').empty();
                }
            });
        }
    });
}

        function TBAmbientes(data) {
            tabla_datos_agenda = $("#tablaAgendamientos").dxDataGrid({
                dataSource: data["DATA"],
                columns: [{
                        dataField: 'NUMERO',
                        caption: 'N°',
                    },
                    {
                        dataField: 'FECHA',
                        caption: 'Fecha Inicio',
                        dataType: 'date',
                    },
                    {
                        dataField: 'FECHA_FIN',
                        caption: 'Fecha Fin',
                        dataType: 'date',
                    },
                    {
                        dataField: 'HORA_INI',
                        caption: 'Hora Inicio'
                    },
                    {
                        dataField: 'HORA_FIN',
                        caption: 'Hora Fin'
                    },
                    {
                        dataField: 'AMBIENTE_DES',
                        caption: 'Ambiente'
                    },{
                        dataField: 'BLOQ_DESC',
                        caption: 'Bloque'
                    },
                    {
                        dataField: 'TITULACION_DESC',
                        caption: 'Titulacion'
                    },
                    {
                        dataField: 'ESTADO',
                        caption: 'Estado'
                    },
                    {
                        dataField: '',
                        caption: 'Acciones',
                        cellTemplate: function(container, options) {
                            if (rolPermitido) {
                                $(`<td>
                                    <button class="btn text-white me-0 btn-sm" style="background-color: #39a900; color: #ffffff;" onclick="Editar(${options.data.ID}, '${options.data.FECHA}','${options.data.FECHA_FIN}', '${options.data.HORA_INI}', '${options.data.HORA_FIN}', ${options.data.BLOQ_ID}, ${options.data.AMBIENTE_ID}, ${options.data.TITULACION_ID}, ${options.data.ESTADO_INT});">
                                        Editar
                                    </button>
                                </td>`).appendTo(container);
                            }
                             $('<button class="btn text-white me-0 btn-sm" style="background-color: #FF0000; color: #ffffff;">Eliminar</button>')
                .on('click', function() {
                    Eliminar(options.data.ID);
                }).appendTo(container);
        
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
                    fileName: 'Agendamientos',
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
                    items: [
                        {
                            widget: 'dxButton',
                            options: {
                                icon: 'exportxlsx',
                                text: 'Exportar a Excel',
                                onClick: function() {
                                    const grid = $("#tablaAgendamientos").dxDataGrid("instance");
                                    const workbook = new ExcelJS.Workbook();
                                    const worksheet = workbook.addWorksheet('Agenda');

                                    DevExpress.excelExporter.exportDataGrid({
                                        component: grid,
                                        worksheet: worksheet
                                    }).then(() => {
                                        workbook.xlsx.writeBuffer().then(buffer => {
                                            saveAs(new Blob([buffer], {
                                                type: 'application/octet-stream'
                                            }), 'Agendamientos.xlsx');
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
                                    const grid = $("#tablaAgendamientos").dxDataGrid("instance");
                                    const workbook = new ExcelJS.Workbook();
                                    const worksheet = workbook.addWorksheet('Agenda');

                                    DevExpress.excelExporter.exportDataGrid({
                                        component: grid,
                                        worksheet: worksheet
                                    }).then(() => {
                                        workbook.csv.writeBuffer().then(buffer => {
                                            saveAs(new Blob([buffer], {
                                                type: 'text/csv'
                                            }), 'Agendamientos.csv');
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
                    fetch("../../../peticiones_json/panel_central/agenda/import.php", {
                        method: "POST",
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log("Respuesta del servidor:", data); // Depuración
                        if (data.status === "success") {
                            alert("Datos importados correctamente.");
                            setTimeout(function() {
                                location.reload();
                            }, 1000); // Recarga la página después de 1 segundo
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


        function consultas(accion) {
    if (accion == 'Agenda') {
        requisitos("POST",
            "../../../peticiones_json/panel_central/agenda/agenda_json.php",
            "opcion=AccionConsultar&accion=ConsultarTodos&jsonp=?",
            function(data) {
                TBAmbientes(data);
            },
            "",
            Array()
        );
    }else if (accion == 'ambientes') {
    var form_Bloque = $('#bloque').val();
    console.log("Valor del Bloque seleccionado:", form_Bloque);

    if (!form_Bloque) {
        console.warn("No se seleccionó un bloque válido.");
        $('#ambiente').empty();
        $('#ambiente').append($('<option></option>').text('Por favor, seleccione un bloque primero.'));
        return;
    }

    requisitos("POST",
        "../../../peticiones_json/panel_central/agenda/agenda_json.php",
        "opcion=AccionConsultar&accion=ConsultarAmbientes&Bloque=" + form_Bloque + "&jsonp=?",
        function(data) {
            console.log("Respuesta de la consulta de ambientes:", data); // Ver respuesta completa
            $('#ambiente').empty(); // Limpiar los ambientes previos

            // Verifica si 'DATA' es un array y contiene elementos
            if (Array.isArray(data["DATA"]) && data["DATA"].length > 0) {
                $.each(data["DATA"], function(index, ambiente) {
                    // Verificar si los datos del ambiente son correctos
                    if (ambiente.ID && ambiente.DESCRIPCION) {
                        console.log("Agregando ambiente:", ambiente); // Verificando los datos del ambiente
                        $('#ambiente').append($('<option></option>').val(ambiente.ID).text(ambiente.DESCRIPCION));
                    } else {
                        console.warn("Ambiente con datos inválidos: ", ambiente);
                    }
                });
            } else {
                // Si no hay ambientes disponibles
                console.warn("No hay ambientes disponibles para el bloque seleccionado.");
                $('#ambiente').append($('<option></option>').text('No hay ambientes disponibles.'));
            }
        },
        "",
        Array()
    );


    } else if (accion == 'Bloques') {
        requisitos("POST",
            "../../../peticiones_json/panel_central/agenda/agenda_json.php",
            "opcion=AccionConsultar&accion=ConsultarBloques&jsonp=?",
            function(data) {
                $('#bloque').empty();
                $('#bloque').append($('<option></option>').val('').text('Seleccione un Bloque'));

                if (data && data["DATA"] && data["DATA"].length > 0) {
                    $.each(data["DATA"], function(index, option) {
                        $('#bloque').append($('<option></option>').val(option.ID).text(option.DESCRIPCION));
                    });
                } else {
                    // Si no hay bloques, mostrar mensaje
                    $('#bloque').append($('<option></option>').text('No hay bloques disponibles.'));
                }
            },
            "",
            Array()
        );
    } else if (accion == 'titulaciones') {
        requisitos("POST",
            "../../../peticiones_json/panel_central/agenda/agenda_json.php",
            "opcion=AccionConsultar&accion=ConsultarTitulaciones&jsonp=?",
            function(data) {
                if (data && data["DATA"] && data["DATA"].length > 0) {
                    $.each(data["DATA"], function(index, option) {
                        $('#titulacion').append($('<option></option>').val(option.ID).text(option.DESCRIPCION));
                    });
                } else {
                    // Si no hay titulaciones, mostrar mensaje
                    $('#titulacion').append($('<option></option>').text('No hay titulaciones disponibles.'));
                }
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
                fetch("../../../peticiones_json/panel_central/agenda/import.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Respuesta del servidor:", data); // Depuración
                    if (data.status === "success") {
                        alert("Datos importados correctamente.");
                        consultas("Agendamientos"); // Actualizar la tabla by calling the existing function
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
        
         function Eliminar(id){
            requisitos("POST",
                        "../../../peticiones_json/panel_central/agenda/agenda_json.php",
                        "opcion=AccionEliminar&id="+id+"&jsonp=?",
                        function(data) {
                            if(data["ALERTA"] == 'OK'){
                                consultas("Agenda");
                            }
                        },
                        "",
                        Array()
                    );
        }     
      
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