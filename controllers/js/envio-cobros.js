$(document).ready(function(){
    $('#enviar-cobro').submit(function(event){
        event.preventDefault();
        var continuar = true;
        $('#enviar-cobro input[required=true], #enviar-cobro textarea[required=true]').each(function(){
            $(this).css('border-color','');
            if(!$.trim($(this).val())){ 
                $(this).css('border-color','#931C17');   
                continuar = false;
            }
            var email_reg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/; 
            if($(this).attr('type')=='email' && !email_reg.test($.trim($(this).val()))){
                $(this).css('border-color','#931C17');
                continuar = false;
            }
            if($(this).attr('type')=='email' && ($('#envio_email').val() != $('#envio_confir_email').val())){
                $(this).css('border-color','#931C17');
                continuar = false;
            }
        });
        alert($('#envio_user').val());
        if(continuar){
            $('#envio_enviar').prop({'disabled':'true'});
            $("#envio-cargando").html('<h2><img src="../img/Eclipse-1s-200px.gif" width="20" alt="" /> Cargando</h2>');
            post_data = {
                'tipo':$('#envio_tipo').val(),
                'usuario':$('#envio_user').val(), 
                'cliente':$('#envio_cliente').val(), 
                'rut':$('#envio_rut').val(), 
                'correo':$('#envio_email').val(), 
                'detalle_pago':$('#envio_detalle').val(), 
                'monto':$('#envio_monto').val()
            };
            $.post('../models/envio-cobros.php', post_data, function(response){
                if(response.type == 'error'){
                    output = '<div style="color:#003d79;font:400 14px/21px \'Open Sans\', sans-serif;text-align:center"><b>'+response.text+'</b></div>';
                    $("#envio-cobros-body #enviar-cobro").slideUp();
                }else if (response.type == 'message'){
                    output = '<div style="color:#003d79;font:400 14px/21px \'Open Sans\', sans-serif;text-align:center"><b>'+response.text+'</b></div>';
                    $("#enviar-cobro input[required=true], #enviar-cobro textarea[required=true]").val('');
                    $("#envio-cobros-body #enviar-cobro").slideUp();
                }
                $("#envio-cobros-body #envio-cobros-results").hide().html(output).slideDown();
            },'json');
        }
    });
    $("#enviar-cobro input[required=true], #enviar-cobro textarea[required=true]").keyup(function(){
        $(this).css('border-color','');
    });
});