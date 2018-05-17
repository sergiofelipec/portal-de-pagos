$(document).ready(function(){
    $('#form_con').submit(function(event){
        event.preventDefault();
        var cambiacon = true;
        $('#form_con input[required=true]').each(function(){
            $(this).css('border-color','');
            if(!$.trim($(this).val())){ 
                $(this).css('border-color','#931C17');   
                cambiacon = false;
            }
        });
        if(cambiacon){
            var user_rut = $('#user_rut').val();
            var old_con  = $('#old_con').val();
            var new_con  = $('#new_con').val();
            var rep_con  = $('#rep_con').val();
            $.ajax({
                url:'../models/cambio_con.php', 
                method:'POST', 
                data:{user_rut:user_rut,old_con:old_con,new_con:new_con,rep_con:rep_con},
                cache:false,
                beforeSend:function(){
                    $('#btn_send_pass').val('Cambiando...');
                },
                dataType:'json',
                success:function(response){
                    $('#btn_send_pass').val('Cambiar contraseña');
                    if(response.type == 'error'){
                    output = '<div style="color:#931C17;font:400 14px/21px \'Open Sans\', sans-serif;text-align:center"><b>'+response.text+'</b></div>';
                        $('#old_con').css('border-color','#931C17');
                        $('#new_con').css('border-color','#931C17');
                        $('#rep_con').css('border-color','#931C17');
                    }else if (response.type == 'message'){
                        $('#loading-result').html('<h2 style="text-align:center"><img src="../img/Eclipse-1s-200px.gif" width="20" alt="" /></h2>');
                        output = '<div style="color:#003d79;font:400 14px/21px \'Open Sans\', sans-serif;text-align:center"><b>'+response.text+'</b></div>';
                        $('#form_con input[required=true]').val('');
                        setTimeout(function(){
                            $(location).attr('href','inicio.php?pant=bienvenida');
                        },5000);
                        $('#form_con').slideUp();
                    }
                    $('#contact_results').hide().html(output).slideDown();
                }
            });
        }
    });
});