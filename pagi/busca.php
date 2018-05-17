<?php
include('conex.php');
$dato = $_POST['dato'];
//EJECUTAMOS LA CONSULTA DE BUSQUEDA
$registro_sql = "SELECT * FROM t_pagos WHERE (numero_pago LIKE '%".trim($dato)."%' OR user_rut LIKE '%".trim($dato)."%' OR status LIKE '%".trim($dato)."%') ORDER BY numero_pago ASC";
$registro_qry = $con->query($registro_sql);
$registro_cnt = $registro_qry->num_rows;
//$registro = mysql_query("SELECT * FROM productos WHERE nomb_prod LIKE '%$dato%' OR tipo_prod LIKE '%$dato%' ORDER BY id_prod ASC");
//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX
echo '<table class="table table-striped table-condensed table-hover">
        	<tr>
            	<th width="300">NUMERO PAGO</th>
                <th width="200">USER RUT</th>
                <th width="150">DETALLE PAGO</th>
                <th width="150">MONTO</th>
                <th width="150">FECHA ENVIO</th>
                <th width="50">STATUS</th>
            </tr>';
//if(mysql_num_rows($registro)>0){
if($registro_cnt > 0){
	//while($registro2 = mysql_fetch_array($registro)){
    while($registro_row = $registro_qry->fetch_assoc()){
		echo '<tr>
				<td>'.$registro_row['numero_pago'].'</td>
				<td>'.$registro_row['user_rut'].'</td>
				<td>S/. '.$registro_row['detalle_pago'].'</td>
				<td>S/. '.$registro_row['monto'].'</td>
				<td>'.fechaNormal($registro_row['fecha_envio']).'</td>
				<td>'.$registro_row['status'].'</td>
				</tr>';
	}
}else{
	echo '<tr>
				<td colspan="6">No se encontraron resultados</td>
			</tr>';
}
echo '</table>';
?>