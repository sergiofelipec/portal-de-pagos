$(document).ready(function() {
    $('#an-form').submit(function(event){
        event.preventDefault();
        var selected = '';
        var anulados = [];
        $('#an-form input[type=checkbox]').each(function(){
            if (this.checked) {
                selected = $(this).val();
                anulados.push(selected);
            }
        });
        if (anulados.length > 0) {
            var confirma = confirm('Va a anular los siguientes cobros: '+anulados+'. Sí desea continuar presione aceptar, si no cancelar');
            if (confirma == true) {
                $('#an-boton').prop({'disabled':'true'});
                $("#an-cargando").html('<h2><img src="../img/Eclipse-1s-200px.gif" width="20" alt="" /> Cargando</h2>');
                post_data = {
                    'anulados':JSON.stringify(anulados),
                    'usuario':$('#an-user').val()
                };
                console.log(post_data);
                $.post('../models/anular-cobros-dos.php', post_data, function(response){
                    if(response.type == 'error'){
                        output = '<div style="color:#003d79;font:400 14px/21px \'Open Sans\', sans-serif;text-align:center"><b>'+response.text+'</b></div>';
                        $("#an-cobros-body #an-cobro").slideUp();
                    }else if (response.type == 'message'){
                        output = '<div style="color:#003d79;font:400 14px/21px \'Open Sans\', sans-serif;text-align:center"><b>'+response.text+'</b></div>';
                        $("#an-cobros-body #an-cobro").slideUp();
                    }
                    $("#an-cobros-body #an-cobros-results").hide().html(output).slideDown();
                },'json');
            }
        } else {
            alert('Debes seleccionar al menos una opción.');
        }
        return false;
    });         
});    