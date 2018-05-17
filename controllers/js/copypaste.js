/******** Bloquear copiar y pegar correos ********/
$(document).ready(function(){
    $("#envio_confir_email").on('paste', function(e){
        e.preventDefault();
        alert('Esta acción está prohibida');
    });
    $("#envio_confir_email").on('copy', function(e){
        e.preventDefault();
        alert('Esta acción está prohibida');
    });
});