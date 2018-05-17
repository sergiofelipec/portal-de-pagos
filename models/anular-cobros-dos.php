<?php
require_once('../db/connection.php');
if ($_POST) {
    $mensaje = [];
    $anulados   = json_decode($_POST['anulados']);
    $usuario    = $_POST['usuario'];
    $cuenta = count($anulados);
    for ($i = 0 ; $i < $cuenta ; $i++) {
        $actualiza_con_sql = "UPDATE t_pagos SET fecha_pago='".date('d-m-Y H:i:s')."', status='ANULADO', forma_pago='ANULADO', modificado='".$usuario."' WHERE numero_pago = '".$anulados[$i]."'";
        $actualiza_con_qry = $con->query($actualiza_con_sql);
        if (!$actualiza_con_qry) {
            array_push($mensaje,"Ocurrió un error al anular pago: ".$con->error."<br>");
        } else {
            array_push($mensaje,"Anulado: ".$anulados[$i]."<br>");
        }
    }
    $output = json_encode(array('type'=>'message', 'text' => $mensaje));
    die($output);
} else {
    $output = json_encode(array('type'=>'error', 'text' => 'Ocurrió un error, favor contactar a administrador de sistema.'));
    die($output);
}
?>