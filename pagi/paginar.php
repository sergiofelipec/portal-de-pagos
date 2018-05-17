<?php
include('conex.php');
$paginaActual = $_POST['partida'];
$nroProductos_sql = "SELECT * FROM t_pagos";
$nroProductos_qry = $con->query($nroProductos_sql);
$nroProductos_cnt = $nroProductos_qry->num_rows;
//$nroProductos = mysql_num_rows(mysql_query("SELECT * FROM productos"));
$nroLotes = 2;
//$nroPaginas = ceil($nroProductos/$nroLotes);
$nroPaginas = ceil($nroProductos_cnt/$nroLotes);
$lista = '';
$tabla = '';
if ($paginaActual > 1) {
    $lista = $lista.'<li><a href="javascript:pagination('.($paginaActual-1).');">Anterior</a></li>';
}
for ($i=1; $i<=$nroPaginas; $i++) {
    if ($i == $paginaActual) {
        $lista = $lista.'<li class="active"><a href="javascript:pagination('.$i.');">'.$i.'</a></li>';
    } else {
        $lista = $lista.'<li><a href="javascript:pagination('.$i.');">'.$i.'</a></li>';
    }
}
if ($paginaActual < $nroPaginas) {
    $lista = $lista.'<li><a href="javascript:pagination('.($paginaActual+1).');">Siguiente</a></li>';
}
if ($paginaActual <= 1) {
    $limit = 0;
} else {
    $limit = $nroLotes*($paginaActual-1);
}
$registro_sql = "SELECT * FROM t_pagos LIMIT ".$limit.", ".$nroLotes;
$registro_qry = $con->query($registro_sql);
//$registro = mysql_query("SELECT * FROM productos LIMIT $limit, $nroLotes ");
$tabla = $tabla.'<table class="table table-striped table-condensed table-hover">
			            <tr>
			                <th width="300">NUMERO PAGO</th>
                <th width="200">USER RUT</th>
                <th width="150">DETALLE PAGO</th>
                <th width="150">MONTO</th>
                <th width="150">FECHA ENVIO</th>
                <th width="50">STATUS</th>
			            </tr>';
//while($registro2 = mysql_fetch_array($registro)){
while ($registro_row = $registro_qry->fetch_assoc()) {
    $tabla = $tabla.'<tr>
							<td>'.$registro_row['numero_pago'].'</td>
							<td>'.$registro_row['user_rut'].'</td>
							<td>S/. '.$registro_row['detalle_pago'].'</td>
							<td>S/. '.$registro_row['monto'].'</td>
							<td>'.fechaNormal($registro_row['fecha_envio']).'</td>
							<td>$registro_row['status']</td>
						  </tr>';		
}
$tabla = $tabla.'</table>';
$array = array(0 => $tabla,
               1 => $lista);
echo json_encode($array);
?>