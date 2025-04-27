<title>SENA STOCK</title>
<link rel="stylesheet" href="../includes/css/login/recuperaCon.css">

<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="../includes/css/login/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="../includes/img/logos/favicon.png" />
    <link href="../includes/css/panel_administrativo/spinners.css" id="theme" rel="stylesheet">
    <link href="../includes/librerias/jquery-confirm/css/jquery-confirm.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<body>
<!-- MENSAJE ENVIO -->
<div class="container" id="contenedor" data-aos="fade-up" data-aos-duration="1500">

    <!-- Mostrar mensaje si existe -->
    <?php if (isset($_GET['mensaje'])): ?>
        <div class="mensaje-alerta <?php echo isset($_GET['tipo']) && $_GET['tipo'] == 'error' ? 'error' : ''; ?>">
            <?php echo htmlspecialchars($_GET['mensaje']); ?>
        </div>
    <?php endif; ?>

    <form>
        <div class="mb-3">
        <label for="email" class="form-label">Se ha enviado un enlace a su correo para restablecer la contraseña.</label> <br>
        <div class="text-center">
        <p><a href="../login/" id="back-to-login-link">Iniciar Sesión</a></p>
    </div>
        </div>
        
    </form>
</div>
</body>
