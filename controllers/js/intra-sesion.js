$(document).ready(function(){
    $('#form_user').submit(function(event){
        event.preventDefault();
        var email = $('#email').val();
        var password = $('#password').val();
        if($.trim(email).length > 0 && $.trim(password).length > 0) {
            $.ajax({
                url:'../models/intra-sesion.php',
                method:'POST',
                data:{email:email,password:password},
                cache:false,
                beforeSend:function(){
                    $('#login-submit').val('Conectando...');
                },
                success:function(response){
                    $('#login-submit').val('Iniciar Sesión');
                    if (response == 1 || response == 2) {
                        $(location).attr('href','inicio.php?pant=inicio');
                    } else {
                        $('#result').html(response).css({"font":"400 14px/21px 'Open Sans', sans-serif","color":"#931C17","text-align": "center"});
                    }
                }
            });
        } else {
            $('#result').html('<b>Debe ingresar usuario y contraseña.</b>').css({"font":"400 14px/21px 'Open Sans', sans-serif","color":"#931C17","text-align": "center"});
        };
    });
});