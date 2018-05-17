<?php
require_once( '../libwebpay/webpay.php' );
/**** TEST ****/
require_once( '../certificates/cert-normal-test.php' );
/**** PROD ****/
//require_once( '../certificates/cert-normal.php' );
require_once( '../lib/PHPMailer/PHPMailerAutoload.php' );
require_once( '../mails/mail.php' );
$select_orden_sql = "SELECT * FROM t_pagos WHERE (user_rut='".$cliente_row['user_rut']."' AND status='ENVIADO')";
$select_orden_qry = $con -> query($select_orden_sql);
$select_orden_row = $select_orden_qry -> fetch_array();
$orden = $select_orden_row['numero_pago'];
$monto = $select_orden_row['monto'];
function redirect($url, $data) {
    echo  "<form action='" . $url . "' method='POST' name='webpayForm'>";
    foreach ($data as $name => $value) {
        echo "<input type='hidden' name='".htmlentities($name)."' value='".htmlentities($value)."'>";
    }
    echo  "</form>"
        ."<script language='JavaScript'>"
        ."document.webpayForm.submit();"
        ."</script>";
}
/** Configuracion parametros de la clase Webpay */
$sample_baseurl = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$configuration = new Configuration();
$configuration->setEnvironment($certificate['environment']);
$configuration->setCommerceCode($certificate['commerce_code']);
$configuration->setPrivateKey($certificate['private_key']);
$configuration->setPublicCert($certificate['public_cert']);
$configuration->setWebpayCert($certificate['webpay_cert']);
/** Creacion Objeto Webpay */
$webpay = new Webpay($configuration);
$action = isset($_GET["action"]) ? $_GET["action"] : 'init';
$post_array = false;
switch ($action) {
    default:
        $tx_step = "Finalizar pago";
        /** Monto de la transacciÃ³n */
        $amount = $monto;
        /** Orden de compra de la tienda */
        $buyOrder = $orden;
        /** CÃ³digo comercio de la tienda entregado por Transbank */
        $sessionId = uniqid();
        /** URL de retorno */
        $urlReturn = $sample_baseurl."?action=getResult";
        /** URL Final */
        $urlFinal  = $sample_baseurl."?action=end";
        echo '<div class="breadcrumb">
    <div class="wrapper cf">
        <p>
            <a href="'.$inicio.'">Inicio</a> 
            &nbsp;/&nbsp; Pagar
        </p>
    </div>
</div>
<div class="wrapper info">
    <div class="titulo">
        <h1>'.$tx_step.'</h1>
    </div>
    <div class="txt">
        <h2>Revisa los datos y finaliza tu compra</h2>
        <table width="400">
            <tr>
                <td>Número de pago:</td>
                <td>'.$orden.'</td>
            </tr>
            <tr>
                <td>Fecha:</td>
                <td>'.date('d-m-Y').'</td>
            </tr>
            <tr>
                <td>Total:</td>
                <td>$'.number_format($monto,0,',','.').'</td>
            </tr>
        </table>

    ';
        $request = array(
            "amount"    => $amount,
            "buyOrder"  => $buyOrder,
            "sessionId" => $sessionId,
            "urlReturn" => $urlReturn,
            "urlFinal"  => $urlFinal,
        );
        /** Iniciamos Transaccion */
        $result = $webpay->getNormalTransaction()->initTransaction($amount, $buyOrder, $sessionId, $urlReturn, $urlFinal);
        /** Verificamos respuesta de inicio en webpay */
        if (!empty($result->token) && isset($result->token)) {
            $token = $result->token;
            $next_page = $result->url;
            $message = "<p>Gracias por preferir WebPay Plus, por favor haga clic en el botón para continuar.</p>";
            $button_name = "Pagar";
            $codigo_autorizacion = "authorizationCode";
            $monto_final = "amount";
            $orden_compra = "buyOrder";
            if (strlen($next_page) && $post_array) {
                echo '<h4>'.$message.'</h4>
              <form action="'.$next_page.'" method="post">
                <input type="hidden" name="authorizationCode" id="authorizationCode" value="">
                <input type="hidden" name="amount" id="amount" value="">
                <input type="hidden" name="buyOrder" id="buyOrder" value="<?php $buyOrder; ?>">
                <input type="submit" value="'.$button_name.'">
              </form>
              ';
                echo '<script>
                var authorizationCode = localStorage.getItem('.$codigo_autorizacion.');
                document.getElementById("authorizationCode").value = authorizationCode;

                var amount = localStorage.getItem('.$monto_final.');
                document.getElementById("amount").value = amount;

                var buyOrder = localStorage.getItem('.$orden_compra.');
                document.getElementById("buyOrder").value = buyOrder;

                localStorage.clear();
              </script>';
            } elseif (strlen($next_page)) {
                echo '<div><h5>'.$message.'</h5>';
                echo '<form action="'.$next_page.'" method="post">
                            <input type="hidden" name="token_ws" value="'.$token.'">
                            <button type="submit" class="cta">'.$button_name.'</button>
                        </form>
                    </div>
                </div>
            </div>';
            }
        } else {
            $message = "webpay no disponible";
            echo '<h1>'.$message.'</h1>';
        }
        break;
    case "getResult":
        if (!isset($_POST["token_ws"]))
            break;
        /** Token de la transacciÃ³n */
        $token = filter_input(INPUT_POST, 'token_ws');
        $request = array(
            "token" => filter_input(INPUT_POST, 'token_ws')
        );
        /* Rescatamos resultado y datos de la transaccion */
        $result = $webpay->getNormalTransaction()->getTransactionResult($token);
        /** Verificamos resultado  de transacciÃ³n */
        if ($result->detailOutput->responseCode === 0) {
            $tbk_fecha_contable         = $result->accountingDate;
            $tbk_orden_compra           = $result->buyOrder;
            $tbk_final_numero_tarjeta   = $result->cardDetail->cardNumber;
            $tbk_exp_tarjeta            = $result->cardDetail->cardExpirationDate;
            $tbk_codigo_autorizacion    = $result->detailOutput->authorizationCode;
            $tbk_tipo_pago              = $result->detailOutput->paymentTypeCode;
            $tbk_respuesta              = $result->detailOutput->responseCode;
            if (isset($result->detailOutput->sharesAmount)) {
                $tbk_valor_cuota        = $result->detailOutput->sharesAmount;
            } else {
                $tbk_valor_cuota        = "0";
            }
            $tbk_numero_cuotas          = $result->detailOutput->sharesNumber;
            $tbk_monto                  = $result->detailOutput->amount;
            $tbk_codigo_comercio        = $result->detailOutput->commerceCode;
            $tbk_orden_compra_2         = $result->detailOutput->buyOrder;
            $tbk_session_id             = $result->sessionId;
            $tbk_fecha_transaccion      = $result->transactionDate;
            $tbk_urlRefirection         = $result->urlRedirection;
            $tbk_VCI                    = $result->VCI;
            $tbk_tipo_transaccion       = "TR_NORMAL";
            $tbk_token                  = $token;
            $guarda_slq = "INSERT INTO bp_respuesta(TBK_FECHA_CONTABLE, idOrder, TBK_FINAL_NUMERO_TARJETA, TBK_FEC_EXPIRACION, TBK_CODIGO_AUTORIZACION, TBK_TIPO_PAGO, TBK_RESPUESTA, TBK_VALOR_CUOTA, TBK_NUMERO_CUOTAS, TBK_MONTO, TBK_COD_COMERCIO, TBK_ORDEN_COMPRA, TBK_SESSIONID, TBK_FECHA_TRANSACCION, TBK_URLDIRECTION, TBK_VCI, TBK_TIPO_TRANSACCION,TBK_TOKEN) VALUES ('".$tbk_fecha_contable."','".$tbk_orden_compra."','".$tbk_final_numero_tarjeta."','".$tbk_exp_tarjeta."','".$tbk_codigo_autorizacion."','".$tbk_tipo_pago."','".$tbk_respuesta."','".$tbk_valor_cuota."','".$tbk_numero_cuotas."','".$tbk_monto."','".$tbk_codigo_comercio."','".$tbk_orden_compra_2."','".$tbk_session_id."','".$tbk_fecha_transaccion."','".$tbk_urlRefirection."','".$tbk_VCI."','".$tbk_tipo_transaccion."','".$tbk_token."')";
            $guarda_qry = $con->query($guarda_slq);
            $actualiza_estado_sql = "UPDATE t_pagos SET fecha_pago='".date('d-m-Y h:m:s')."',status='PAGADO',forma_pago='WEBPAY' WHERE numero_pago='".$tbk_orden_compra."'";
            $actualiza_estado_qry = $con -> query($actualiza_estado_sql);
            /*** envio correos cliente ****/
            $cabecera_uno = "¡Tu pago ha sido realizado!";
            $nombre_cliente = $cliente_row['user_name'];
            $mail_cliente = $cliente_row['email'];
            $rut = $cliente_row['user_rut'];
            $fec_transac = date('d-m-Y');
            $hora_transac = date('H:m:s');
            $mail_asunto = "Se ha completado tu pago [Portal de pagos DVP S.A.]";
            if ($select_orden_row['area'] == 1) {
                $mail_respuesta = "callcenter@dvp.cl";
                $nombre_respuesta = "CallCenter DVP S.A.";
            } else {
                $mail_respuesta = "cobranzas@dvp.cl";
                $nombre_respuesta = "Cobranzas DVP S.A.";
            }
            $correo_cliente = correoPagoClie($cabecera_uno,$nombre_cliente,$rut,$tbk_orden_compra,$tbk_codigo_autorizacion,$fec_transac,$hora_transac,$tbk_final_numero_tarjeta,$tbk_tipo_pago,$tbk_monto,$tbk_numero_cuotas,$mail_respuesta,$nombre_respuesta,$mail_cliente,$mail_asunto);
            //Datos correo dvp
            $cabecera_area = "¡Has recibido un pago!";
            $mail_asunto_area = "[Portal de pagos] Nuevo pago (".$tbk_orden_compra.").";
            $correo_area = correoPagoClieArea($cabecera_area,$nombre_cliente,$rut,$tbk_orden_compra,$tbk_codigo_autorizacion,$fec_transac,$hora_transac,$tbk_final_numero_tarjeta,$tbk_tipo_pago,$tbk_monto,$tbk_numero_cuotas,$mail_respuesta,$nombre_respuesta,$mail_respuesta,$nombre_respuesta,$mail_asunto_area,$select_orden_row['area'],$select_orden_row['detalle_pago']);
            $redireccion = redirect($result->urlRedirection, array("token_ws" => $token));
        } else {
            $message = "Pago RECHAZADO por webpay - " . utf8_decode($result->detailOutput->responseDescription);
            $next_page = '';
            $respuesta_transaccion = "Rechazado";
            echo '<div class="breadcrumb">
                            <div class="wrapper cf">
                                <p>
                                    <a href="'.$inicio.'">Inicio</a> 
                                    &nbsp;/&nbsp; Pagar
                                </p>
                            </div>
                    </div>';
        }
        break;
    case "end":
        if (!isset($_POST['token_ws'])) {
            $respuesta_transaccion = "Anulado";
            echo '<div class="breadcrumb">
                            <div class="wrapper cf">
                                <p>
                                    <a href="'.$inicio.'">Inicio</a> 
                                    &nbsp;/&nbsp; Pagar
                                </p>
                            </div>
                    </div>';
        } else {
            //existe Post_token_ws
            $post_array = true;
            $request = "";
            $result = $_POST;
            $message = "Transacción Finalizada";
            $muestra_sql = "SELECT * FROM bp_respuesta WHERE TBK_TOKEN='".$_POST['token_ws']."'";
            $muestra_qry = $con->query($muestra_sql);
            $muestra_row = $muestra_qry->fetch_array();
            echo '<div class="breadcrumb">
    <div class="wrapper cf">
        <p>
            <a href="'.$inicio.'">Inicio</a> 
            &nbsp;/&nbsp; Pagar
        </p>
    </div>
</div>
<div class="wrapper info">
    <div class="titulo">
        <h1>Pago Finalizado</h1>
        <p>Tu pago ha sido exitoso. Revisa el detalle de tu pago, si tienes dudas llámanos al (56) 2 2392 0000.</p>
    </div>
    <div class="txt">
        <h2>Detalles del pago realizado</h2>
        <table width="400">
            <tr>
                <td>Respuesta de transacción:</td>
                <td>Aceptado</td>
            </tr>
            <tr>
                <td>Orden de Compra:</td>
                <td>'.$muestra_row['TBK_ORDEN_COMPRA'].'</td>
            </tr>
            <tr>
                <td>Código de Autorización:</td>
                <td>'.$muestra_row['TBK_CODIGO_AUTORIZACION'].'</td>
            </tr>
            <tr>
                <td>Fecha Transacción:</td>
                <td>'.date('d-m-Y').'</td>
            </tr>
            <tr>
                <td>Hora Transacción:</td>
                <td>'.date('H:m:s').'</td>
            </tr>
            <tr>
                <td>Tarjeta de Crédito:</td>
                <td>***********'.$muestra_row['TBK_FINAL_NUMERO_TARJETA'].'</td>
            </tr>
            <tr>
                <td>Tipo de Pago:</td>
                <td>'.$muestra_row['TBK_TIPO_PAGO'].'</td>
            </tr>
            <tr>
                <td>Monto Compra:</td>
                <td>'.number_format($muestra_row['TBK_MONTO'],0,',','.').'</td>
            </tr>
            <tr>
                <td>Número de Cuotas:</td>
                <td>'.$muestra_row['TBK_NUMERO_CUOTAS'].'</td>
            </tr>
        </table>
        <a href="'.$inicio.'" class="cta cta-azul">Continuar</a>
    </div>
</div>';
        }
        break;
}
if (!isset($request) || !isset($result) || !isset($message) || !isset($next_page)) {
    $result = "Ocurrió un error al procesar tu solicitud";
    echo '
<div class="wrapper info">
    <div class="titulo">
        <h1>'.$result.'</h1>
        <p>Tu pago no se ha realizado, si tienes dudas llámanos al (56) 2 2392 0000.</p>
    </div>
    <div class="txt">
        <h2>Detalles</h2>
        <table width="400">
            <tr>
                <td>Respuesta de transacción:</td>
                <td>'.$respuesta_transaccion.'</td>
            </tr>
            <tr>
                <td>Orden de Compra:</td>
                <td>'.$orden.'</td>
            </tr>
            <tr>
                <td>Fecha:</td>
                <td>'.date('d-m-Y').'</td>
            </tr>
            <tr>
                <td>Monto Compra:</td>
                <td>$'.number_format($monto,0,',','.').'</td>
            </tr>
        </table>
        <a href="'.$inicio.'" class="cta cta-azul">Continuar</a>
    </div>
</div>';
    die;
}
?>