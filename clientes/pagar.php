<?php
$select_nuevo_sql = "SELECT * FROM t_pagos WHERE user_rut = '".$cliente_row['user_rut']."' AND status = 'ENVIADO'";
$select_nuevo_qry = $con->query($select_nuevo_sql);
$select_nuevo_cnt = $select_nuevo_qry->num_rows;
if ($select_nuevo_cnt > 0) {
    $select_nuevo_row = $select_nuevo_qry->fetch_assoc();
    $orden_pago = $select_nuevo_row['numero_pago'];
    $detalle_pago = $select_nuevo_row['detalle_pago'];
    $monto_pagar = number_format($select_nuevo_row['monto'],0,',','.');
    $fecha_envio = $select_nuevo_row['fecha_envio'];
    $mensaje_pago = "Este es el detalle de tu pago, presiona continuar para realizar el pago. Si tienes dudas, contactanos.";
} else {
    $mensaje_pago = "No tienes pagos pendientes.";
    $orden_pago = "";
    $detalle_pago = "";
    $monto_pagar = "";
    $fecha_envio = "";
}
?>
<div class="breadcrumb">
    <div class="wrapper cf">
        <p>
            <a href="<?php echo $inicio; ?>">Inicio</a>
            &nbsp;/&nbsp; Pagar
        </p>
    </div>
</div>
<div class="wrapper info">
    <div class="titulo">
        <h1>Finalizar pago</h1>
        <p>
            <?php echo $mensaje_pago;?>
        </p>
    </div>
    <div class="txt">
        <table width="400">
            <tr>
                <td>Orden de pago:</td>
                <td><?php echo $orden_pago;?></td>
            </tr>
            <tr>
                <td>Detalle de pago:</td>
                <td><?php echo $detalle_pago;?></td>
            </tr>
            <tr>
                <td>Monto a pagar:</td>
                <td>$<?php echo $monto_pagar;?></td>
            </tr>
            <tr>
                <td>Fecha de envío:</td>
                <td><?php echo $fecha_envio;?></td>
            </tr>
        </table>
        <?php if ($select_nuevo_cnt > 0) { ?>
        <p class="forma-pago">
            <strong>Forma de pago:</strong>
            <br>
            Sistema Webpay Plus
        </p>
        <div>
            <img src="https://www.transbank.cl/public/img/Logo_Webpay3-01-50x50.png" alt="">
        </div>
        <p class="condiciones">
            <input type="checkbox" id="accept_check" name="accept_check"> 
            He leído y acepto los 
            <a href="http://dvp.cl/terminos-condiciones-venta-linea/" target="_blank">términos y condiciones</a>
        </p>
        <a class="cta" id="btn-pagar">Continuar</a>
        <?php } else { ?>
        <p class="forma-pago">
            <strong>Forma de pago:</strong>
            <br>
            Sistema Webpay Plus
        </p>
        <div>
            <img src="https://www.transbank.cl/public/img/Logo_Webpay3-01-50x50.png" alt="">
        </div>
        <?php } ?>
    </div>
</div>