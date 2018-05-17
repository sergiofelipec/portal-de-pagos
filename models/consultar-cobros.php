<?php
error_reporting(-1);
include('../db/connection.php');
$dato = $_POST['dato'];
$tipo = $_POST['tipo'];
//EJECUTAMOS LA CONSULTA DE BUSQUEDA
$registro = "SELECT * FROM t_pagos WHERE (numero_pago LIKE '%".trim($dato)."%' OR user_rut LIKE '%".trim($dato)."%' OR status LIKE '%".trim($dato)."%') AND area = '".$tipo."' ORDER BY numero_pago ASC";
$registro_qry = $con->query($registro);
if (!$registro_qry) {
    trigger_error('Invalid query: ' . $con->error);
}
$cuenta_row		= $registro_qry -> num_rows;
if($cuenta_row > 0 ) {
    //CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX
    echo '<div class="table-responsive">          
        <table width="100%">
            <tr>
                <th>N&deg; Orden</th>
                <th>Cliente</th>
                <th>Fecha envío</th>
                <th>Monto</th>
                <th>Estado</th>
                <th>Detalle</th>
            </tr>';
    while($registro = $registro_qry -> fetch_array()) {
        $busca_numero_orden	= $registro['numero_pago'];
        $busca_cliente		= $registro['user_rut'];
        $busca_fecha_envio	= $registro['fecha_envio'];
        $busca_monto	    = $registro['monto'];
        $busca_estado		= $registro['status'];
        $busca_forma_pago	= $registro['detalle_pago'];
        echo '
                <tr>
				    <td>'.$busca_numero_orden.'</td>
				    <td>'.strtoupper($busca_cliente).'</td>
				    <td>'.strtoupper($busca_fecha_envio).'</td>
				    <td> $'.strtoupper(number_format($busca_monto,0,',','.')).'</td>
                    <td>'.strtoupper($busca_estado).'</td>
                    <td>'.$busca_forma_pago.'</td>
                </tr>
            ';
    }
} else {
    echo '<strong style="color:#931C17;font:400 14px/21px \'Open Sans\', sans-serif;text-align: center;">No se encontraron resultados.</strong>';
}
echo '</table>
</div>';
?>