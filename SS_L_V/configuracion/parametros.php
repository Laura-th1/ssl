<?php
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/FyreGroup/Intranet/');
// define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/');
define('BASE_PATH', __DIR__ . '/../');

function title($modulo)
{
    ?>
        <title><?php echo $modulo; ?> | Intranet - Fyre Group</title>
    <?php
}

function obtenerMAC()
{
    $MAC = exec('getmac'); 
    $MAC = strtok($MAC, ' '); 
    return $MAC;
}

function favicon()
{
    ?>
        <link rel="icon" type="image/x-icon" href="<?php echo BASE_URL; ?>includes/img/logos/favicon.webp" />
    <?php
}

function fuentes($tipografia)
{
    if($tipografia == 'Roboto'){
        ?>
            <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
        <?php
    }
    
}

function cargar_css($css)
{
    if (isset($css)) {
        if ($css["BOOSTRAP"] == 'S') {
        ?>
            <link href="<?php echo BASE_URL; ?>includes/librerias/bootstrap_5.3.0/css/bootstrap.min.css" rel="stylesheet">
        <?php
        }
        if ($css["SPLASH"] == 'S') {
            include(BASE_PATH . "includes/splash/index.php");
        ?>
            <link href="<?php echo BASE_URL; ?>includes/css/splash/styles.css" id="theme" rel="stylesheet">
        <?php
        }
        if ($css["J-CONFIRM"] == 'S') {
        ?>
            <link href="<?php echo BASE_URL; ?>includes/librerias/jquery-confirm/css/jquery-confirm.min.css" rel="stylesheet" />
        <?php
        }
        if ($css["BOOSTRAP_VALIDATOR"] == 'S') {
            ?>
                <link href="<?php echo BASE_URL; ?>includes/librerias/bootstrap_validator/css/bootstrapValidator.css" rel="stylesheet"/>
            <?php
        }
        if ($css["BOOSTRAP_ICONS"] == 'S') {
            ?>
                <link href="<?php echo BASE_URL; ?>includes/librerias/bootstrap_icons/css/bootstrap-icons.css" rel="stylesheet"/>
            <?php
        }
    } else {
        header("Location: " . BASE_URL . "modulos/page_errores/css_js.php");
    }
}

function cargar_js($js)
{
    if (isset($js)) {
        if ($js["BOOSTRAP"] == 'S') {
            ?>
                <script src="<?php echo BASE_URL; ?>includes/librerias/bootstrap_5.3.0/js/bootstrap.min.js"></script>
            <?php
        }
        if ($js["BOOSTRAP_BUNDLE"] == 'S') {
        ?>
            <script src="<?php echo BASE_URL; ?>includes/librerias/bootstrap_5.3.0/js/bootstrap.bundle.min.js"></script>
        <?php
        }
        if ($js["JQUERY"] == 'S') {
        ?>
            <script src="<?php echo BASE_URL; ?>includes/librerias/jquery_3.7.1/jquery.min.js"></script>
        <?php
        }
        if ($js["BOOSTRAP_VALIDATOR"] == 'S') {
        ?>
            <script src="<?php echo BASE_URL; ?>includes/librerias/bootstrap_validator/js/bootstrapValidator.min.js"></script>
        <?php
        }
        if ($js["J-CONFIRM"] == 'S') {
            ?>
                <script src="<?php echo BASE_URL; ?>includes/librerias/jquery-confirm/js/jquery-confirm.min.js"></script>
            <?php
            }
        if ($js["SPLASH"] == 'S') {
        ?>
            <script>
                $(document).ready(function() {
                    $(".preloader").fadeOut();
                });
            </script>
        <?php
        }
        ?>
            <script src="<?php echo BASE_URL; ?>includes/js/global/scripts.js"></script>
        <?php
    } else {
        header("Location: " . BASE_URL . "modulos/page_errores/css_js.php");
    }
}

function BarraNav($modulo)
{
    if ($modulo == 'HOME') {
        include(BASE_PATH . "includes/nav/home/nav.php");
    }
}

?>