<?php
session_start();

if (!isset($_SESSION['USUARIO'])) {
    header("Location: ../../login/");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Agendamiento | Sena Stock</title>
        <link rel="icon" type="image/x-icon" href="../../includes/img/logos/favicon.png" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
        <link href="../../includes/css/home/styles.css" rel="stylesheet" />
        <link href="../../includes/css/panel_administrativo/spinners.css" id="theme" rel="stylesheet">
        <link href="../../includes/librerias/jquery-confirm/css/jquery-confirm.min.css" rel="stylesheet">
    </head>
    <body id="page-top">
        

        <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="../../">Sena Stock</a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto my-2 my-lg-0">
                        <li class="nav-item"><a class="nav-link" href="../agenda_ambientes">Agenda de Ambientes</a></li>
                        <li class="nav-item"><a class="nav-link" href="../panel_administrativo">Panel Administrativo</a></li>
                        <li class="nav-item"><a class="nav-link" href="../panel_central">Panel Central</a></li>
                        <?php
                            if(!isset($_SESSION["USUARIO"])){
                        ?>
                            <li class="nav-item"><a class="nav-link" href="../../login/">Iniciar Sesion</a></li>
                        <?php
                            }else{
                        ?>
                            <li class="nav-item dropdown"> 
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> 
                                    <?php echo($_SESSION["NOMBRE_COMPLETO"]); ?>
                                </a>
                                <ul class="dropdown-menu no-scroll" id="menu_dropdown" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="cerrarSesion();">
                                            Cerrar Sesion
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

        <!-- <section class="page-section">
            
        </section> -->

        <header class="masthead">
            <div class="slider">
                <div class="slide" style="background-image: url('../../includes/img/home/home1.jpeg');"></div>
                <div class="slide" style="background-image: url('../../includes/img/home/home2.jpg');"></div>
                <div class="slide" style="background-image: url('../../includes/img/home/home3.jpg');"></div>
                <div class="slide" style="background-image: url('../../includes/img/home/home4.jpg');"></div>
            </div>
            <div class="container px-4 px-lg-5 h-100">
                <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-12 align-self-end">
                        <h1 class="text-white font-weight-bold">Agendamiento de Ambientes</h1>
                        <hr class="divider" />
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="sede" class="text-white">Bloque:</label>
                            <select class="form-control text-dark bg-white" id="bloque" name="bloque">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fecha_ini" class="text-white">Fecha Inicio:</label>
                            <input type="date" class="form-control text-dark bg-white" id="fecha_ini" name="fecha_ini">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fecha_fin" class="text-white">Fecha Fin:</label>
                            <input type="date" class="form-control text-dark bg-white" id="fecha_fin" name="fecha_fin">
                        </div>
                    </div>
                    <a class="btn btn-sena btn-sm" href="#" onclick="consultar('Agenda');">Consultar</a>

                </div>
            </div>
        </header>
        <section class="page-section" id="about">
            <div class="container px-4 px-lg-5 h-100">
                <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center">
                    
                </div>
            </div>
        </section>

        


        <footer class="bg-sena py-5">
            <div class="container px-4 px-lg-5">
                <div class="small text-center text-white">
                    Copyright &copy; 2025 - Sena Stock
                </div>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
        <script src="../../includes/librerias/jquery_3.7.1/jquery.min.js"></script>
        <script src="../../includes/librerias/jquery-confirm/js/jquery-confirm.min.js"></script>
        <script src="../../includes/js/global/scripts.js"></script>
        <script>
			$(document).ready(function() {
                consultar("Bloques");
        
                $(".preloader").fadeOut();
                function checkScroll() {
                    if ($(window).scrollTop() > 50) {
                        $('#mainNav').addClass('scrolled');
                    } else {
                        $('#mainNav').removeClass('scrolled');
                    }
                }
                $(window).scroll(function() {
                    checkScroll();
                });
                checkScroll();
            });

            function cerrarSesion() {
                requisitos( "POST", 
                            "../../peticiones_json/login/login_json.php", 
                            "opcion=AccionCerrar&jsonp=?",
                            function(data){
                                if(data["ALERTA"] == 'OK'){
                                    ModalNotifi('col-md-4 col-md-offset-4', 'Notificacion', 'Gracias Por Visitarnos, vuelve pronto.' , '');
                                    // setTimeout(function() {
                                        window.location.replace("./");
                                    // }, 2000);
                                }
                            }, 
                            "",  
                            Array()
                        );
            }

            function consultar(accion) {
                if (accion == 'Bloques') {
                    requisitos("POST",
                        "../../peticiones_json/panel_central/agenda/agenda_json.php",
                        "opcion=AccionConsultar&accion=ConsultarBloques&jsonp=?",
                        function(data) {
                            $.each(data["DATA"], function(index, option) {
                                $('#bloque').append($('<option></option>').val(option.ID).text(option.DESCRIPCION));
                            });
                        },
                        "",
                        Array()
                    );
                }else if(accion == 'Agenda'){
                    var bloque = $("#bloque").val();
                    var fecha_ini = $("#fecha_ini").val();
                    var fecha_fin = $("#fecha_fin").val();
                    if(bloque != '' && fecha_ini != '' && fecha_fin != ''){
                        requisitos("POST",
                            "../../peticiones_json/panel_central/agenda/agenda_json.php",
                            "opcion=AccionConsultar&accion=ConsultarAgendaHome&bloque=" + bloque + "&fecha_ini=" + fecha_ini + "&fecha_fin=" + fecha_fin + "&jsonp=?",

                            function(data) {
                                var container = $('#about .row');
                                container.empty();

                                $.each(data["DATA"], function(index, option) {
                                    var card = `
                                        <div class="col-lg-4 col-md-6 mb-4">
                                            <div class="d-flex">
                                                <img class="img-fluid me-3 border" src="https://images.pexels.com/photos/256395/pexels-photo-256395.jpeg?cs=srgb&dl=pexels-pixabay-256395.jpg&fm=jpg" alt="Imagen de la sesión 3" style="width: 100px; height: auto;">
                                                <div class="text-start" style="font-size: 12px;">
                                                    <h4 class="card-title">${option.BLOQ_DESC}</h4>
                                                    <p class="card-text">Fecha: ${option.FECHA}</p>
                                                    <p class="card-text">Hora Ini: ${option.HORA_INI}</p>
                                                    <p class="card-text">Hora Ini: ${option.HORA_FIN}</p>
                                                    <p class="card-text">Ambiente: ${option.AMBIENTE_DES}</p>
                                                    <p class="card-text">Titulacion: ${option.TITULACION_DESC}</p>
                                                </div>
                                            </div>
                                        </div>
                                    `;

                                    container.append(card);
                                });
                            },
                            "",
                            Array()
                        );
                    }else{
                        ModalNotifi('col-md-4 col-md-offset-4', 'ERROR', 'Faltan Datos de consulta', '');
                    }
                    
                }
            }
		</script>
    </body>
</html>