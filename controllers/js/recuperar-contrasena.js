/** VALIDA RUT **/
$(function(){
    $("input#rec-rut").rut({formatOn: 'keyup'}).on('rutInvalido', function(){
        $(this).css({"border":"1px solid #931C17"});
        $("#rec-pass").attr("disabled",true).css("background-color","#BA6F6D");
        $("#rec-msj").html("<b>Ingrese un rut valido</b>").css({"color":"#931C17","font":"400 14px/21px 'Open Sans', sans-serif","text-align": "center"});
    })
        .on('rutValido', function(){
        $(this).css("border", "1px solid #ddd");
        $("#rec-pass").removeAttr("disabled").css("background-color","#931C17");
        $("#rec-msj").html("");
    });
});
(function(e){function n(e){return e.replace(/[\.\-]/g,"")}function r(e){rutAndDv=f(e);var t=rutAndDv[0];var n=rutAndDv[1];if(!(t&&n))return t||e;var r="";while(t.length>3){r="."+t.substr(t.length-3)+r;t=t.substring(0,t.length-3)}return t+r+"-"+n}function i(e){return e.type&&e.type.match(/^key(up|down|press)/)&&(e.keyCode==8||e.keyCode==16||e.keyCode==17||e.keyCode==18||e.keyCode==20||e.keyCode==27||e.keyCode==37||e.keyCode==38||e.keyCode==39||e.keyCode==40||e.keyCode==91)}function s(e){if(typeof e!=="string")return false;var t=n(e);if(t.length<2)return false;var r=t.charAt(t.length-1).toUpperCase();var i=parseInt(t.substr(0,t.length-1));if(i===NaN)return false;return o(i).toString().toUpperCase()===r}function o(e){var t=0;var n=2;if(typeof e!=="number")return;e=e.toString();for(var r=e.length-1;r>=0;r--){t=t+e.charAt(r)*n;n=(n+1)%8||2}switch(t%11){case 1:return"k";case 0:return 0;default:return 11-t%11}}function u(e,t){e.val(r(e.val()))}function a(e,t){if(s(e.val())){e.trigger("rutValido",f(e.val()))}else{e.trigger("rutInvalido")}}function f(e){var t=n(e);if(t.length==0)return[null,null];if(t.length==1)return[t,null];var r=t.charAt(t.length-1);var i=t.substring(0,t.length-1);return[i,r]}var t={validateOn:"blur",formatOn:"blur",ignoreControlKeys:true};var l={init:function(n){if(this.length>1){for(var r=0;r<this.length;r++){console.log(this[r]);e(this[r]).rut(n)}}else{var s=this;s.opts=e.extend({},t,n);s.opts.formatOn&&s.on(s.opts.formatOn,function(e){if(s.opts.ignoreControlKeys&&i(e))return;u(s,e)});s.opts.validateOn&&s.on(s.opts.validateOn,function(e){a(s,e)})}return this}};e.fn.rut=function(t){if(l[t]){return l[t].apply(this,Array.prototype.slice.call(arguments,1))}else if(typeof t==="object"||!t){return l.init.apply(this,arguments)}else{e.error("El método "+t+" no existe en jQuery.rut")}};e.formatRut=function(e){return r(e)};e.validateRut=function(t,n){if(s(t)){var r=f(t);e.isFunction(n)&&n(r[0],r[1]);return true}else{return false}}})(jQuery)
/*** Recupera Contraseña***/
$(document).ready(function(){
    $('#rec-form').submit(function(event){
        event.preventDefault();
        var cambiacon = true;
        $('#rec-form input[required=true]').each(function(){
            $(this).css('border-color','');
            if(!$.trim($(this).val())){ 
                $(this).css('border-color','#931C17');   
                cambiacon = false;
            }
        });
        if(cambiacon){
            var user_rut = $('#rec-rut').val();
            $.ajax({
                url:'../models/recuperar-contrasena.php', 
                method:'POST', 
                data:{user_rut:user_rut},
                cache:false,
                beforeSend:function(){
                    $('#rec-pass').val('Cambiando...');
                },
                dataType:'json',
                success:function(response){
                    $('#rec-pass').val('Recuperar Contraseña');
                    if(response.type == 'error'){
                        output = '<div style="color:#931C17;font:400 14px/21px \'Open Sans\', sans-serif;text-align:center"><b>'+response.text+'</b></div>';
                        $('#rec-msj').html(output);
                        $('#rec-rut').css('border-color','#931C17');
                    }else if (response.type == 'message'){
                        output = '<div style="color:#003d79;font:400 14px/21px \'Open Sans\', sans-serif;text-align:center"><b>'+response.text+'</b></div>';
                        $('#rec-msj').html('<h2 style="text-align:center"><img src="../img/Eclipse-1s-200px.gif" width="20" alt="" />'+output+'</h2>');

                        $('#rec-form input[required=true]').val('');
                        setTimeout(function(){
                            $(location).attr('href','../index.php');
                        },5000);
                    }
                }
            });
        }
    });
});
