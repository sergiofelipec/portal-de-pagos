$(document).ready();
$(function(){
    $('#bs-orden').on('keyup',function(){
        var dato = $('#bs-orden').val();
        var tipo = $('#bs-tipo').val();
        var url = '../models/consultar-cobros.php';
        $('#resultados').html('<h2><img src="../img/Eclipse-1s-200px.gif" width="20" alt="" /> Cargando</h2>');
        $.ajax({
            type:'POST',
            url:url,
            data:{dato:dato,tipo:tipo},
            success: function(datos){
                $('#agrega-registros').html(datos);
                if(datos!=""){
                    $('#resultados').html('');
                }
            }
        });
        return false;
    });

});