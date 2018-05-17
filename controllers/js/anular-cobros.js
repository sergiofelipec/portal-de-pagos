$(document).ready();
$(function(){
    $('#an-orden').on('keyup',function(){
        var dato = $('#an-orden').val();
        var tipo = $('#an-tipo').val();
        var url = '../models/anular-cobros.php';
        $('#an-resultados').html('<h2><img src="../img/Eclipse-1s-200px.gif" width="20" alt="" /> Cargando</h2>');
        $.ajax({
            type:'POST',
            url:url,
            data:{dato:dato,tipo:tipo},
            success: function(datos){
                $('#an-agrega-registros').html(datos);
                if(datos!=""){
                    $('#an-resultados').html('');
                }
            }
        });
        return false;
    });
});


