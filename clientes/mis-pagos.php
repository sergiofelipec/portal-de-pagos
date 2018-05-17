<div class="breadcrumb">
    <div class="wrapper cf">
        <p>
            <a href="<?php echo $inicio; ?>">Inicio</a> 
            &nbsp;/&nbsp; Mis Pagos
        </p>
    </div>
</div>
<div class="wrapper info">
    <div class="titulo">
        <h1>Mis Pagos</h1>
        <p>
            Estos son los pagos que has realizado en nuestro portal.
        </p>
    </div>
    <div class="txt">
        <table width="100%">
            <tr>
                <th>Número de pago</th>
                <th>Código de autorización</th>
                <th>Fecha de pago</th>
                <th>Detalle</th> 
                <th>Total</th>
            </tr>
            <?php
            $busca_dato_sql = "SELECT * FROM t_pagos WHERE user_rut = '".$cliente_row['user_rut']."' AND status = 'PAGADO'";
            $busca_dato_qry = $con->query($busca_dato_sql);
            while ($busca_dato_row = $busca_dato_qry->fetch_assoc()) {
                $busca_tbk_sql = "SELECT * FROM bp_respuesta WHERE idOrder = '".$busca_dato_row['numero_pago']."'";
                $busca_tbk_qry = $con->query($busca_tbk_sql);
                $busca_tbk_row = $busca_tbk_qry->fetch_assoc();
                echo '<tr>
                        <td style="text-align:center">'.$busca_dato_row['numero_pago'].'</td>
                        <td style="text-align:center">'.$busca_tbk_row['TBK_CODIGO_AUTORIZACION'].'</td>
                        <td style="text-align:center">'.$busca_dato_row['fecha_pago'].'</td>
                        <td style="text-align:justify">'.$busca_dato_row['detalle_pago'].'</td>
                        <td style="text-align:right"> $'.number_format($busca_dato_row['monto'],0,',','.').'</td>
                    </tr>';
            }
            ?>
        </table>
    </div>
</div>
