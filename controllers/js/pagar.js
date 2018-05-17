$(document).ready(function(){
    $("#btn-pagar").click(function(event) {
        event.preventDefault();
        if($('input:checkbox[name=accept_check]:checked').val() == 'on'){
            $(location).attr('href','inicio.php?pant=pago');
        } else {
            alert('Debe leer y aceptar los términos y condiciones ');
        }
    });
});