
function cerrarSesion() {
    requisitos( "POST", 
                "../../../peticiones_json/login/login_json.php", 
                "opcion=AccionIniciarSesion&accion=Cerrar&jsonp=?",
                function(data){
                    if(data["ALERTA"] == 'OK'){
                        ModalNotifi('col-md-4 col-md-offset-4', 'Notificacion', 'Gracias Por Visitarnos, vuelve pronto.' , '');
                        setTimeout(function() {
                            window.location.replace("../../index.php");
                        }, 2000);
                    }
                }, 
                "",  
                Array()
            );
}

function ModalNotifi(style, titulo, contenido, funcionAccion){
    // xlarge/ xlequivalente a col-md-12
    // large/ lequivalente a col-md-8 col-md-offset-2
    // medium/ mequivalente a col-md-6 col-md-offset-3
    // small/ sequivalente a col-md-4 col-md-offset-4
    // xsmall/ xsequivalente acol-md-2 col-md-offset-5
    ModalNotifi = $.confirm({
        title: titulo,
        backgroundDismiss: false,
        closeIcon: true,
        // columnClass: 'col-md-offset-2 col-md-8',
        columnClass: style,
        content: function() {
            return `<div class="modal-body" id="MensajeModal" style="color: black; font-size: 17px;">${contenido}</div>`;
        },
        buttons: {
            guardar: {
                text: 'Aceptar',
                btnClass: 'btn btn-guardar',
                action: function() {
                    if (typeof funcionAccion === 'function') {
                        funcionAccion();
                    }
                }
            }
        }
    });
}

function requisitos(method, url, data, successCallback, errorCallback, headers) {
    $.ajax({
      type: method,
      url: url,
      data: data,
      success: successCallback,
      error: errorCallback,
      headers: headers
    });
}

function ToatsAlertaAccion(color_header, titulo, mensaje, accion){
    if(accion == 'abrir'){
        var header = $(`<div id="HeaderToast" class="toast-header" style=" background-color: ${color_header}">
                            <img src="https://static.vecteezy.com/system/resources/previews/023/636/516/original/cute-cartoon-dinosaur-free-png.png" class="rounded me-2" alt="..." width="20px" height="20px">
                            <strong class="me-auto" id="TituloToats" style="color: white;">${titulo}</strong>
                            <button type="button" class="btn-close"style="color: white;" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>`);
        $("#HeaderToast").replaceWith(header);
        var body = $(`  <div class="toast-body" id="bodyToast" style="color: black;">
                            ${mensaje}
                        </div>`);
        $("#bodyToast").replaceWith(body);
        const toastTrigger = document.getElementById('myToast');
        const toast = new bootstrap.Toast(toastTrigger);
        toast.show();
    }
}