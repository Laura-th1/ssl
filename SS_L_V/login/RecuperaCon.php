<title>Restablecer Contraseña</title>
<link rel="stylesheet" href="../includes/css/login/recuperaCon.css">

<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="../includes/css/login/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="../includes/img/logos/favicon.png" />
    <link href="../includes/css/panel_administrativo/spinners.css" id="theme" rel="stylesheet">
    <link href="../includes/librerias/jquery-confirm/css/jquery-confirm.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<body>
<!-- Recuperar contraseña comienzo -->
<div class="container" id="contenedor" data-aos="fade-up" data-aos-duration="1500">


    <form action="restablecer.php" method="POST">
        <div class="mb-3">
        <h2>Restablecer contraseña</h2>
            <label for="email" class="form-label">Ingrese el correo electrónico con el que se registró:</label><br><br>
            <input type="email" class="form-control" id="correo" name="correo" aria-describedby="emailHelp">
        </div>
        <br><button type="submit" class="btn">Enviar</button>
    </form>
</div>
</body>
<!-- Recuperar contraseña final -->
<script>
    // Validar el formulario antes de enviarlo
    document.querySelector('form').addEventListener('submit', function(event) {
        const correoInput = document.getElementById('correo');
        if (!correoInput.value.trim()) {
            event.preventDefault(); // Evitar que el formulario se envíe
            alert('Por favor, ingrese un correo electrónico valido.');
        }
    });

    <!-- Mostrar mensaje si existe -->
    <?php if (isset($_GET['mensaje'])): ?>
        <div class="mensaje-alerta <?php echo isset($_GET['tipo']) && $_GET['tipo'] == 'error' ? 'error' : ''; ?>">
            <?php echo htmlspecialchars($_GET['mensaje']); ?>
        </div>
    <?php endif; ?>

    // Eliminar los parámetros 'mensaje' y 'tipo' de la URL después de mostrar el mensaje
    if (window.location.search.includes('mensaje')) {
        const url = new URL(window.location);
        url.searchParams.delete('mensaje');
        url.searchParams.delete('tipo');
        window.history.replaceState({}, document.title, url);
    }
</script>
