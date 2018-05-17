<?php
require_once('headfoot.php');
/**** Correo de bienvenida *****/
function correoBienvenida($cabecera_uno,$cabecera_dos,$rut,$new_pass,$mail_respuesta,$nombre_respuesta,$mail_cliente,$nombre_cliente,$mail_asunto) {
    global $header_mail, $footer_mail, $url;
    $msg = $header_mail.'<div id="body_content_inner" style="color:#737373;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;font-size:14px;line-height:150%;text-align:left;background:#fff">
                                                                <img src="http://www.dvp.cl/mails/img/cabecera-logo.jpg" width="100%" height="100%" alt="DVP S.A." style="border:none;display:inline;font-size:14px;font-weight:bold;height:auto;line-height:100%;outline:none;text-decoration:none;text-transform:capitalize;" tabindex="0"/>
                                                                <h1 style="text-align:center;padding-top:0!important;font-size:40px;color:#003d79;display:block;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;font-weight:300;line-height:100%;margin:20px 0 0;padding:0 0 20px">Portal de pagos<br/><span style="font-size:26px">'.$cabecera_uno.'<br/>'.$cabecera_dos.'</span></h1>
                                                                <div style="padding:0 48px; width:504px">
                                                                <h2 style="border-bottom:1px solid #003d79;padding-bottom:4px;color:#003d79;font:400 18px/11px Calibri,Arial,sans-serif;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:16px 0 8px;text-align:left">
                                                                        <span style="color:#931c17">&diams;</span> Bienvenido '.$nombre_cliente.'</h2>
                                                                    <ul style="list-style:none;padding:0;margin:0!important">
                                                                        <li style="margin:0!important; text-align:justify">
                                                                            <span>Gracias por preferir nuestro portal de pagos, desde ahora te encuentras registrado en nuestro sistema para poder realizar pagos en línea de tus compras o abonos a tu cuenta. <br><br> A continuación se encuentra tu usuario y contraseña:</span>
                                                                        </li>
                                                                        <br>
                                                                        <li style="margin:0!important">
                                                                            <strong>Usuario:</strong>
                                                                            <span>'.$rut.'</span>
                                                                        </li>
                                                                        <li style="margin:0!important">
                                                                            <strong>Contraseña:</strong>
                                                                            <span>'.base64_decode($new_pass).'</span>
                                                                        </li>
                                                                        <li style="margin:0!important;color:#931C17;text-align:justify;font-size:12px">
                                                                            <span>(Deberás cambiar tu contraseña, debe contener de 6 a 16 caracteres alfanuméricos).</span>
                                                                        </li>
                                                                        <li style="margin:0!important">
                                                                            <strong>Link acceso:</strong>
                                                                            <span><a href="'.$url.'" target="_blank">Clic áca</a></span>
                                                                        </li>
                                                                        <br>
                                                                        <li style="margin:0!important">
                                                                        <span>Atentamente DVP S.A.</span>
                                                                        </li>
                                                                    </ul>
                                                                    <br>
                                                                    <br>
                                                                    <table cellspacing="0" cellpadding="0" border="0" style="width:504px;vertical-align:top">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td valign="top" width="240" style="padding:0 12px 12px 0!important">
                                                                                    <a href="http://www.dvp.cl" style="color:#003d79;font-weight:normal;text-decoration:underline" target="_blank">
                                                                                        <img src="http://www.dvp.cl/mails/img/seguir-cotizando.jpg" width="240" height="127" alt="¿Necesitas seguir cotizando? Vuelve a www.dvp.cl" style="border:none;display:inline;font-size:14px;font-weight:bold;height:auto;line-height:100%;outline:none;text-decoration:none;text-transform:capitalize">
                                                                                    </a>
                                                                                </td>
                                                                                <td valign="top" width="240" style="padding:0 0 12px 12px !important">
                                                                                    <a href="tel:+56223920000" style="color:#003d79;font-weight:normal;text-decoration:underline" target="_blank">
                                                                                        <img src="http://www.dvp.cl/mails/img/servicio-cliente.jpg" width="240" height="127" alt="¿Necesitas ayuda o más información? Llámanos a
servicio al cliente (56) 2 2392 0000" style="border:none;display:inline;font-size:14px;font-weight:bold;height:auto;line-height:100%;outline:none;text-decoration:none;text-transform:capitalize">
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>'.$footer_mail;
    $mail = new PHPMailer;
    $mail->isSMTP();
    /*** Sólo ocupar en windows ***/
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mail->SMTPDebug = 4;
    /*******************************/
    /******* Sólo produccion ***********
    $mail->SMTPDebug = 2;
    /*********/
    $mail->Debugoutput = 'error_log';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    //Cuenta de donde sale el mail
    $mail->Username = "desarrollodvp@gmail.com";
    //Contraseña de donde sale el mail
    $mail->Password = "desarrollodvp2014";
    //alternativa de respuesta
    $mail->addReplyTo($mail_respuesta,$nombre_respuesta);
    //seteo de quien envia mail 
    $mail->setFrom('desarrollodvp@gmail.com', 'Portal de pagos DVP S.A.');
    //A quien va dirijido
    $mail->addAddress($mail_cliente,$nombre_cliente);
    //Asunto
    $mail->Subject = $mail_asunto;
    //Cuerpo en HTML
    $mail->msgHTML($msg);
    //Replace the plain text body with one created manually
    //$mail->AltBody = 'mensaje de prueba';
    //Adjunta imagen
    //$mail->addAttachment('EgpSystemItemsInterface.csv');
    //Envio de mensaje con chequeo de errores
    if (!$mail->send()) {
        $respuesta = array('type' => 'error', 'text' => "Mailer Error: " . $mail->ErrorInfo);
        return $respuesta;
    } else {
        $respuesta = array('type'=>'message', 'text' => 'Correo Bienvenida Enviado.');
        return $respuesta;
    }
}
/******* Correo de Cobro *********/
function correoCobro($cabecera_uno,$cabecera_dos,$numero_cobro,$monto_cobro,$nombre_cliente,$rut,$mail_respuesta,$nombre_respuesta,$mail_cliente,$mail_asunto,$glosa) {
    global $header_mail, $footer_mail, $url;
    $msg = $header_mail.'<div id="body_content_inner" style="color:#737373;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;font-size:14px;line-height:150%;text-align:left;background:#fff">
                                                                <img src="http://www.dvp.cl/mails/img/cabecera-logo.jpg" width="100%" height="100%" alt="DVP S.A." style="border:none;display:inline;font-size:14px;font-weight:bold;height:auto;line-height:100%;outline:none;text-decoration:none;text-transform:capitalize;" tabindex="0"/>
                                                                <h1 style="text-align:center;padding-top:0!important;font-size:40px;color:#003d79;display:block;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;font-weight:300;line-height:100%;margin:20px 0 0;padding:0 0 20px">Portal de pagos<br/><span style="font-size:26px">'.$cabecera_uno.'<br/>'.$cabecera_dos.'</span></h1>
                                                                <div style="padding:0 48px; width:504px">
                                                                <h2 style="color:#003d79;font:400 18px/11px Calibri,Arial,sans-serif;display:block;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:16px 0 8px;text-align:left">
                                                                        <span style="color:#931c17">&diams;</span> Detalle:</h2>
                                                                    <table cellspacing="0" cellpadding="6" style="width: 100%; border: 1px solid #eee;" border="1" bordercolor="#eee">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td scope="col" style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word;padding:12px"><strong>Número de cobro</strong></td>
                                                                                <td style="text-align:left;vertical-align:middle;border:1px solid #eee;padding:12px">'.$numero_cobro.'</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td scope="col" style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word;padding:12px"><strong>Total a pagar</strong></td>
                                                                                <td style="text-align:left;vertical-align:middle;border:1px solid #eee;padding:12px"><span>$</span>'.number_format($monto_cobro,0,',','.').'</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td scope="col" style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word;padding:12px"><strong>Comentario</strong></td>
                                                                                <td style="text-align:left;vertical-align:middle;border:1px solid #eee;padding:12px">'.strtoupper($glosa).'</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <h2 style="border-bottom:1px solid #003d79;padding-bottom:4px;color:#003d79;font:400 18px/11px Calibri,Arial,sans-serif;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:16px 0 8px;text-align:left">
                                                                        <span style="color:#931c17">&diams;</span> Datos de cliente</h2>
                                                                    <ul style="list-style:none;padding:0;margin:0!important">
                                                                        <li style="margin:0!important">
                                                                            <strong>Nombre:</strong>
                                                                            <span>'.$nombre_cliente.'</span>
                                                                        </li>
                                                                        <li style="margin:0!important">
                                                                            <strong>Rut:</strong>
                                                                            <span>'.$rut.'</span>
                                                                        </li>
                                                                        <li style="margin:0!important">
                                                                            <strong>Fecha de envío:</strong>
                                                                            <span>'.date('d-m-Y').'</span>
                                                                        </li>
                                                                    </ul>
                                                                    <br>
                                                                    <table height="50px" width="100%">
                                                                        <tr>
                                                                            <td style="background-color: #931c17;border-bottom: 2px solid #e21f1d;text-align: center">
                                                                                <strong><a href="'.$url.'" style="color:#fff" target="_blank">Paga aquí</a></strong>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                    <br>
                                                                    <table cellspacing="0" cellpadding="0" border="0" style="width:504px;vertical-align:top">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td valign="top" width="240" style="padding:0 12px 12px 0!important">
                                                                                    <a href="http://www.dvp.cl" style="color:#003d79;font-weight:normal;text-decoration:underline" target="_blank">
                                                                                        <img src="http://www.dvp.cl/mails/img/seguir-cotizando.jpg" width="240" height="127" alt="¿Necesitas seguir cotizando? Vuelve a www.dvp.cl" style="border:none;display:inline;font-size:14px;font-weight:bold;height:auto;line-height:100%;outline:none;text-decoration:none;text-transform:capitalize">
                                                                                    </a>
                                                                                </td>
                                                                                <td valign="top" width="240" style="padding:0 0 12px 12px !important">
                                                                                    <a href="tel:+56223920000" style="color:#003d79;font-weight:normal;text-decoration:underline" target="_blank">
                                                                                        <img src="http://www.dvp.cl/mails/img/servicio-cliente.jpg" width="240" height="127" alt="¿Necesitas ayuda o más información? Llámanos a
servicio al cliente (56) 2 2392 0000" style="border:none;display:inline;font-size:14px;font-weight:bold;height:auto;line-height:100%;outline:none;text-decoration:none;text-transform:capitalize">
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>'.$footer_mail;
    $mail = new PHPMailer;
    $mail->isSMTP();
    /*** Sólo ocupar en windows ***/
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mail->SMTPDebug = 4;
    /***************/
    /***** sólo produccion *****
    $mail->SMTPDebug = 2;
    ***************/
    $mail->Debugoutput = 'error_log';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    //Cuenta de donde sale el mail
    $mail->Username = "desarrollodvp@gmail.com";
    //Contraseña de donde sale el mail
    $mail->Password = "desarrollodvp2014";
    //alternativa de respuesta
    $mail->addReplyTo($mail_respuesta,$nombre_respuesta);
    //seteo de quien envia mail 
    $mail->setFrom('desarrollodvp@gmail.com', 'Portal de pagos DVP S.A.');
    //A quien va dirijido
    $mail->addAddress($mail_cliente,$nombre_cliente);
    //Asunto
    $mail->Subject = $mail_asunto;
    //Cuerpo en HTML
    $mail->msgHTML($msg);
    //Replace the plain text body with one created manually
    //$mail->AltBody = 'mensaje de prueba';
    //Adjunta imagen
    //$mail->addAttachment('EgpSystemItemsInterface.csv');
    //Envio de mensaje con chequeo de errores
    if (!$mail->send()) {
        $respuesta = array('type' => 'error', 'text' => "Mailer Error: " . $mail->ErrorInfo);
        return $respuesta;
    } else {
        $respuesta = array('type'=>'message', 'text' => 'Se ha enviado un correo a '.$mail_cliente.', cliente '.$nombre_cliente.', RUT '.$rut.', numero de pago '.$numero_cobro.'.');
        return $respuesta;
    }
}
/******* Correo pago Cliente *********/
function correoPagoClie($cabecera_uno,$nombre_cliente,$rut,$numero_cobro,$cod_autorizacion,$fec_transac,$hora_transac,$num_tarjeta,$tipo_pago,$monto_compra,$num_cuotas,$mail_respuesta,$nombre_respuesta,$mail_cliente,$mail_asunto) {
    global $header_mail, $footer_mail, $url;
    $msg = $header_mail.'<div id="body_content_inner" style="color:#737373;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;font-size:14px;line-height:150%;text-align:left;background:#fff">
                                                                <img src="http://www.dvp.cl/mails/img/cabecera-pedido.jpg" width="100%" height="100%" alt="Pago exitoso" style="border:none;display:inline;font-size:14px;font-weight:bold;height:auto;line-height:100%;outline:none;text-decoration:none;text-transform:capitalize;" tabindex="0"/>
                                                                <h1 style="text-align:center;padding-top:0!important;font-size:40px;color:#003d79;display:block;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;font-weight:300;line-height:100%;margin:20px 0 0;padding:0 0 20px">Portal de pagos<br/><span style="font-size:26px">'.$cabecera_uno.'</span></h1>
                                                                <div style="padding:0 48px; width:504px">
                                                                    <h2 style="color:#003d79;font:400 18px/11px Calibri,Arial,sans-serif;display:block;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:16px 0 8px;text-align:left">
                                                                        <span style="color:#931c17">&diams;</span> Detalle del pago:</h2>
                                                                    <table cellspacing="0" cellpadding="6" style="width: 100%; border: 1px solid #eee;" border="1" bordercolor="#eee">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td scope="col" style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word;padding:12px">Nombre</td>
                                                                                <td style="text-align:left;vertical-align:middle;border:1px solid #eee;padding:12px">'.strtoupper($nombre_cliente).'</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td scope="col" style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word;padding:12px">RUT</td>
                                                                                <td style="text-align:left;vertical-align:middle;border:1px solid #eee;padding:12px">'.$rut.'</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td scope="col" style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word;padding:12px">Número de pago</td>
                                                                                <td style="text-align:left;vertical-align:middle;border:1px solid #eee;padding:12px">'.$numero_cobro.'</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td scope="col" style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word;padding:12px">Código de autorización</td>
                                                                                <td style="text-align:left;vertical-align:middle;border:1px solid #eee;padding:12px">'.$cod_autorizacion.'</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td scope="col" style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word;padding:12px">Fecha de transacción</td>
                                                                                <td style="text-align:left;vertical-align:middle;border:1px solid #eee;padding:12px">'.$fec_transac.'</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td scope="col" style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word;padding:12px">Hora de transacción</td>
                                                                                <td style="text-align:left;vertical-align:middle;border:1px solid #eee;padding:12px">'.$hora_transac.'</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td scope="col" style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word;padding:12px">Final número tarjeta</td>
                                                                                <td style="text-align:left;vertical-align:middle;border:1px solid #eee;padding:12px">'.$num_tarjeta.'</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td scope="col" style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word;padding:12px">Tipo de pago</td>
                                                                                <td style="text-align:left;vertical-align:middle;border:1px solid #eee;padding:12px">'.$tipo_pago.'</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td scope="col" style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word;padding:12px">Monto compra</td>
                                                                                <td style="text-align:left;vertical-align:middle;border:1px solid #eee;padding:12px"><span>$</span>'.number_format($monto_compra,0,',','.').'</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td scope="col" style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word;padding:12px">Número cuotas</td>
                                                                                <td style="text-align:left;vertical-align:middle;border:1px solid #eee;padding:12px">'.$num_cuotas.'</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <br>
                                                                    <table cellspacing="0" cellpadding="0" border="0" style="width:504px;vertical-align:top">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td valign="top" width="240" style="padding:0 12px 12px 0!important">
                                                                                    <a href="http://www.dvp.cl" style="color:#003d79;font-weight:normal;text-decoration:underline" target="_blank">
                                                                                        <img src="http://www.dvp.cl/mails/img/seguir-cotizando.jpg" width="240" height="127" alt="¿Necesitas seguir cotizando? Vuelve a www.dvp.cl" style="border:none;display:inline;font-size:14px;font-weight:bold;height:auto;line-height:100%;outline:none;text-decoration:none;text-transform:capitalize">
                                                                                    </a>
                                                                                </td>
                                                                                <td valign="top" width="240" style="padding:0 0 12px 12px !important">
                                                                                    <a href="tel:+56223920000" style="color:#003d79;font-weight:normal;text-decoration:underline" target="_blank">
                                                                                        <img src="http://www.dvp.cl/mails/img/servicio-cliente.jpg" width="240" height="127" alt="¿Necesitas ayuda o más información? Llámanos a
servicio al cliente (56) 2 2392 0000" style="border:none;display:inline;font-size:14px;font-weight:bold;height:auto;line-height:100%;outline:none;text-decoration:none;text-transform:capitalize">
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>'.$footer_mail;
    $mail = new PHPMailer;
    $mail->isSMTP();
    /*** Sólo ocupar en windows ***/
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mail->SMTPDebug = 4;
    /***************************/
    /**** SOLO produccion ********
    $mail->SMTPDebug = 2;
    ******************/
    $mail->Debugoutput = 'error_log';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    //Cuenta de donde sale el mail
    $mail->Username = "desarrollodvp@gmail.com";
    //Contraseña de donde sale el mail
    $mail->Password = "desarrollodvp2014";
    //alternativa de respuesta
    $mail->addReplyTo($mail_respuesta,$nombre_respuesta);
    //seteo de quien envia mail 
    $mail->setFrom('desarrollodvp@gmail.com', 'Portal de pagos DVP S.A.');
    //A quien va dirijido
    $mail->addAddress($mail_cliente,$nombre_cliente);
    //Asunto
    $mail->Subject = $mail_asunto;
    //Cuerpo en HTML
    $mail->msgHTML($msg);
    //Replace the plain text body with one created manually
    //$mail->AltBody = 'mensaje de prueba';
    //Adjunta imagen
    //$mail->addAttachment('EgpSystemItemsInterface.csv');
    //Envio de mensaje con chequeo de errores
    if (!$mail->send()) {
        $respuesta = array('type' => 'error', 'text' => "Mailer Error: " . $mail->ErrorInfo);
        return $respuesta;
    } else {
        $respuesta = array('type'=>'message', 'text' => 'Se ha enviado un correo a '.$nombre_cliente.', RUT '.$rut.', numero de pago '.$numero_cobro.'.');
        return $respuesta;
    }
}
/******* Correo pago para cobranza y callcenter *********/
function correoPagoClieArea($cabecera_uno,$nombre_cliente,$rut,$numero_cobro,$cod_autorizacion,$fec_transac,$hora_transac,$num_tarjeta,$tipo_pago,$monto_compra,$num_cuotas,$mail_respuesta,$nombre_respuesta,$mail_area,$nombre_area,$mail_asunto,$tipo_area,$glosa) {
    global $header_mail, $footer_mail, $url;
    $msg = $header_mail.'<div id="body_content_inner" style="color:#737373;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;font-size:14px;line-height:150%;text-align:left;background:#fff">
                                                                <img src="http://www.dvp.cl/mails/img/cabecera-logo.jpg" width="100%" height="100%" alt="Pago exitoso" style="border:none;display:inline;font-size:14px;font-weight:bold;height:auto;line-height:100%;outline:none;text-decoration:none;text-transform:capitalize;" tabindex="0"/>
                                                                <h1 style="text-align:center;padding-top:0!important;font-size:40px;color:#003d79;display:block;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;font-weight:300;line-height:100%;margin:20px 0 0;padding:0 0 20px">Portal de pagos<br/><span style="font-size:26px">'.$cabecera_uno.'</span></h1>
                                                                <div style="padding:0 48px; width:504px">
                                                                    <h2 style="color:#003d79;font:400 18px/11px Calibri,Arial,sans-serif;display:block;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:16px 0 8px;text-align:left">
                                                                        <span style="color:#931c17">&diams;</span> Detalle del pago:</h2>
                                                                    <table cellspacing="0" cellpadding="6" style="width: 100%; border: 1px solid #eee;" border="1" bordercolor="#eee">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td scope="col" style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word;padding:12px">Nombre</td>
                                                                                <td style="text-align:left;vertical-align:middle;border:1px solid #eee;padding:12px">'.strtoupper($nombre_cliente).'</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td scope="col" style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word;padding:12px">RUT</td>
                                                                                <td style="text-align:left;vertical-align:middle;border:1px solid #eee;padding:12px">'.$rut.'</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td scope="col" style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word;padding:12px">Número de pago</td>
                                                                                <td style="text-align:left;vertical-align:middle;border:1px solid #eee;padding:12px">'.$numero_cobro.'</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td scope="col" style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word;padding:12px">Código de autorización</td>
                                                                                <td style="text-align:left;vertical-align:middle;border:1px solid #eee;padding:12px">'.$cod_autorizacion.'</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td scope="col" style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word;padding:12px">Fecha de transacción</td>
                                                                                <td style="text-align:left;vertical-align:middle;border:1px solid #eee;padding:12px">'.$fec_transac.'</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td scope="col" style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word;padding:12px">Hora de transacción</td>
                                                                                <td style="text-align:left;vertical-align:middle;border:1px solid #eee;padding:12px">'.$hora_transac.'</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td scope="col" style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word;padding:12px">Final número tarjeta</td>
                                                                                <td style="text-align:left;vertical-align:middle;border:1px solid #eee;padding:12px">'.$num_tarjeta.'</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td scope="col" style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word;padding:12px">Tipo de pago</td>
                                                                                <td style="text-align:left;vertical-align:middle;border:1px solid #eee;padding:12px">'.$tipo_pago.'</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td scope="col" style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word;padding:12px">Monto compra</td>
                                                                                <td style="text-align:left;vertical-align:middle;border:1px solid #eee;padding:12px"><span>$</span>'.number_format($monto_compra,0,',','.').'</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td scope="col" style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word;padding:12px">Número cuotas</td>
                                                                                <td style="text-align:left;vertical-align:middle;border:1px solid #eee;padding:12px">'.$num_cuotas.'</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td scope="col" style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word;padding:12px">Área</td>
                                                                                <td style="text-align:left;vertical-align:middle;border:1px solid #eee;padding:12px">'.$nombre_area.'</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td scope="col" style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word;padding:12px">Comentario</td>
                                                                                <td style="text-align:left;vertical-align:middle;border:1px solid #eee;padding:12px">'.$glosa.'</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <br>
                                                                    <table cellspacing="0" cellpadding="0" border="0" style="width:504px;vertical-align:top">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td valign="top" width="240" style="padding:0 12px 12px 0!important">
                                                                                    <a href="http://www.dvp.cl" style="color:#003d79;font-weight:normal;text-decoration:underline" target="_blank">
                                                                                        <img src="http://www.dvp.cl/mails/img/seguir-cotizando.jpg" width="240" height="127" alt="¿Necesitas seguir cotizando? Vuelve a www.dvp.cl" style="border:none;display:inline;font-size:14px;font-weight:bold;height:auto;line-height:100%;outline:none;text-decoration:none;text-transform:capitalize">
                                                                                    </a>
                                                                                </td>
                                                                                <td valign="top" width="240" style="padding:0 0 12px 12px !important">
                                                                                    <a href="tel:+56223920000" style="color:#003d79;font-weight:normal;text-decoration:underline" target="_blank">
                                                                                        <img src="http://www.dvp.cl/mails/img/servicio-cliente.jpg" width="240" height="127" alt="¿Necesitas ayuda o más información? Llámanos a
servicio al cliente (56) 2 2392 0000" style="border:none;display:inline;font-size:14px;font-weight:bold;height:auto;line-height:100%;outline:none;text-decoration:none;text-transform:capitalize">
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>'.$footer_mail;
    $mail = new PHPMailer;
    $mail->isSMTP();
    /*** Sólo ocupar en windows ***/
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mail->SMTPDebug = 4;
    /********************************/
    /******** Solo produccion *********
    $mail->SMTPDebug = 2;
    ***************/
    $mail->Debugoutput = 'error_log';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    //Cuenta de donde sale el mail
    $mail->Username = "desarrollodvp@gmail.com";
    //Contraseña de donde sale el mail
    $mail->Password = "desarrollodvp2014";
    //alternativa de respuesta
    $mail->addReplyTo($mail_respuesta,$nombre_respuesta);
    //seteo de quien envia mail 
    $mail->setFrom('desarrollodvp@gmail.com', 'Portal de pagos DVP S.A.');
    if ($tipo_area == 1) {
        //A quien va dirijido
        $mail->addAddress($mail_area,$nombre_area);
        $mail->addAddress('cobranzas@dvp.cl','Cobranzas DVP S.A.');
    } else {
        $mail->addAddress($mail_area,$nombre_area);
    }
    //A quien va dirijido
    $mail->addAddress($mail_area,$nombre_area);
    //Asunto
    $mail->Subject = $mail_asunto;
    //Cuerpo en HTML
    $mail->msgHTML($msg);
    //Replace the plain text body with one created manually
    //$mail->AltBody = 'mensaje de prueba';
    //Adjunta imagen
    //$mail->addAttachment('EgpSystemItemsInterface.csv');
    //Envio de mensaje con chequeo de errores
    if (!$mail->send()) {
        $respuesta = array('type' => 'error', 'text' => "Mailer Error: " . $mail->ErrorInfo);
        return $respuesta;
    } else {
        $respuesta = array('type'=>'message', 'text' => 'Se ha enviado un correo a '.$nombre_cliente.', RUT '.$rut.', numero de pago '.$numero_cobro.'.');
        return $respuesta;
    }
}
/******************** correo recupera contraseña ********************/
function correoRecPass($cabecera_uno,$nombre_cliente,$rut,$new_pass,$mail_respuesta,$nombre_respuesta,$mail_cliente,$mail_asunto) {
    global $header_mail, $footer_mail, $url;
    $msg = $header_mail.'<div id="body_content_inner" style="color:#737373;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;font-size:14px;line-height:150%;text-align:left;background:#fff">
                                                                <img src="http://www.dvp.cl/mails/img/cabecera-logo.jpg" width="100%" height="100%" alt="Recupera contraseña" style="border:none;display:inline;font-size:14px;font-weight:bold;height:auto;line-height:100%;outline:none;text-decoration:none;text-transform:capitalize;" tabindex="0"/>
                                                                <h1 style="text-align:center;padding-top:0!important;font-size:40px;color:#003d79;display:block;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;font-weight:300;line-height:100%;margin:20px 0 0;padding:0 0 20px">Portal de pagos<br/><span style="font-size:26px">'.$cabecera_uno.'</span></h1>
                                                                <div style="padding:0 48px; width:504px">
                                                                <h2 style="border-bottom:1px solid #003d79;padding-bottom:4px;color:#003d79;font:400 18px/11px Calibri,Arial,sans-serif;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:16px 0 8px;text-align:left">
                                                                        <span style="color:#931c17">&diams;</span> Estimado (a) '.$nombre_cliente.'</h2>
                                                                    <ul style="list-style:none;padding:0;margin:0!important">
                                                                        <li style="margin:0!important; text-align:justify">
                                                                            <span>Hemos generado una nueva contraseña para que puedas acceder a nuestro portal de pagos:</span>
                                                                        </li>
                                                                        <br>
                                                                        <li style="margin:0!important">
                                                                            <strong>Usuario:</strong>
                                                                            <span>'.$rut.'</span>
                                                                        </li>
                                                                        <li style="margin:0!important">
                                                                            <strong>Contraseña:</strong>
                                                                            <span>'.base64_decode($new_pass).'</span>
                                                                        </li>
                                                                        <li style="margin:0!important;color:#931C17;text-align:justify;font-size:12px">
                                                                            <span>(Deberás cambiar tu contraseña, debe contener de 6 a 16 caracteres alfanuméricos).</span>
                                                                        </li>
                                                                        <li style="margin:0!important">
                                                                            <strong>Link acceso:</strong>
                                                                            <span><a href="'.$url.'" target="_blank">Clic áca</a></span>
                                                                        </li>
                                                                        <br>
                                                                        <li style="margin:0!important">
                                                                            <span>Ante cualquier consulta, favor contactanos al <a href="tel:+56223920000" style="color:#003d79;"target="_blank">(56) 2 2392 0000</a>.<br>
                                                                        <br>Atentamente DVP S.A.</span>
                                                                        </li>
                                                                    </ul>
                                                                    <br>
                                                                    <br>
                                                                    <table cellspacing="0" cellpadding="0" border="0" style="width:504px;vertical-align:top">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td valign="top" width="240" style="padding:0 12px 12px 0!important">
                                                                                    <a href="http://www.dvp.cl" style="color:#003d79;font-weight:normal;text-decoration:underline" target="_blank">
                                                                                        <img src="http://www.dvp.cl/mails/img/seguir-cotizando.jpg" width="240" height="127" alt="¿Necesitas seguir cotizando? Vuelve a www.dvp.cl" style="border:none;display:inline;font-size:14px;font-weight:bold;height:auto;line-height:100%;outline:none;text-decoration:none;text-transform:capitalize">
                                                                                    </a>
                                                                                </td>
                                                                                <td valign="top" width="240" style="padding:0 0 12px 12px !important">
                                                                                    <a href="tel:+56223920000" style="color:#003d79;font-weight:normal;text-decoration:underline" target="_blank">
                                                                                        <img src="http://www.dvp.cl/mails/img/servicio-cliente.jpg" width="240" height="127" alt="¿Necesitas ayuda o más información? Llámanos a
servicio al cliente (56) 2 2392 0000" style="border:none;display:inline;font-size:14px;font-weight:bold;height:auto;line-height:100%;outline:none;text-decoration:none;text-transform:capitalize">
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>'.$footer_mail;
    $mail = new PHPMailer;
    $mail->CharSet = 'UTF-8';
    $mail->isSMTP();
    /*** Sólo ocupar en windows ***/
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mail->SMTPDebug = 4;
    /***********************/
    /******* Solo produccion **********
    $mail->SMTPDebug = 2;
    *******************/
    $mail->Debugoutput = 'error_log';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    //Cuenta de donde sale el mail
    $mail->Username = "desarrollodvp@gmail.com";
    //Contraseña de donde sale el mail
    $mail->Password = "desarrollodvp2014";
    //alternativa de respuesta
    $mail->addReplyTo($mail_respuesta,$nombre_respuesta);
    //seteo de quien envia mail 
    $mail->setFrom('desarrollodvp@gmail.com', 'Portal de pagos DVP S.A.');
    //A quien va dirijido
    $mail->addAddress($mail_cliente,$nombre_cliente);
    //Asunto
    $mail->Subject = $mail_asunto;
    //Cuerpo en HTML
    $mail->msgHTML($msg);
    //Replace the plain text body with one created manually
    //$mail->AltBody = 'mensaje de prueba';
    //Adjunta imagen
    //$mail->addAttachment('EgpSystemItemsInterface.csv');
    //Envio de mensaje con chequeo de errores
    if (!$mail->send()) {
        $respuesta = array('type' => 'error', 'text' => "Mailer Error: " . $mail->ErrorInfo);
        return $respuesta;
    } else {
        $respuesta = array('type'=>'message', 'text' => 'Se ha enviado su nueva contraseña al correo electrónico registrado, espere unos segundos...');
        return $respuesta;
    }
}
?>