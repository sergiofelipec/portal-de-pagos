
$(document).ready(function(){
    $('#envio_id').autocomplete({
        source: function(request,response){
            var url = '../models/busca-cliente.php';
            $.ajax({
                url:url,
                dataType:'json',
                data:{id_qad:request.term},
                success:function(data){
                    response(data);
                }
            });
        },
        minLength: 2,
        select:function(event,ui){
            $('#envio_rut').val(ui.item.rut);
            $('#envio_cliente').val(ui.item.nombre);
            $('#envio_email').val(ui.item.correo);
        }
    });
});