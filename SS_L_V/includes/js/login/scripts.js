document.addEventListener("DOMContentLoaded", function() {
    var forgotPasswordLink = document.getElementById("forgot-password-link");
    var backToLoginLink = document.getElementById("back-to-login-link");
    var formContainer = document.getElementById("form-container");
    var loginForm = document.getElementById("login-form");
    var forgotPasswordForm = document.getElementById("forgot-password-form");

    // Verificar si los elementos existen
    if (formContainer && loginForm && forgotPasswordForm) {
        // Mostrar formulario de recuperación de contraseña
        if (forgotPasswordLink) {
            forgotPasswordLink.addEventListener("click", function(e) {
                e.preventDefault();
                formContainer.classList.add("slide-up");
                setTimeout(function() {
                    loginForm.style.display = "none";
                    forgotPasswordForm.style.display = "block";
                    formContainer.classList.add("slide-down");
                }, 500);
            });
        }

        // Volver al formulario de inicio de sesión
        if (backToLoginLink) {
            backToLoginLink.addEventListener("click", function(e) {
                e.preventDefault();
                formContainer.classList.remove("slide-down");
                setTimeout(function() {
                    forgotPasswordForm.style.display = "none";
                    loginForm.style.display = "block";
                    formContainer.classList.remove("slide-up");
                }, 500);
            });
        }
    } else {
        console.error("Algunos elementos necesarios no están presentes en el DOM.");
    }
});
