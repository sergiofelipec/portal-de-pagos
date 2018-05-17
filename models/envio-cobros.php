<?php
include('../db/connection.php');
include('../lib/PHPMailer/PHPMailerAutoload.php');
include('../mails/mail.php');
function generaPass() {
    //Se define una cadena de caractares.
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    //Obtenemos la longitud de la cadena de caracteres
    $longitudCadena=strlen($cadena);
    //Se define la variable que va a contener la contraseña
    $pass = "";
    //Se define la longitud de la contraseña
    $longitudPass=10;
    //Creamos la contraseña
    for($i=1 ; $i<=$longitudPass ; $i++) {
        //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
        $pos=rand(0,$longitudCadena-1);
        //Vamos formando la contraseña en cada iteraccion del bucle
        $pass .= substr($cadena,$pos,1);
    }
    //retorna pass
    return $pass;
}
if($_POST) {
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
        $output = json_encode(array(
            'type' => 'error', 
            'text' => 'Perdón, ocurrió un problema.'
        ));
        die($output);
    }
    $tipo           = filter_var($_POST["tipo"],FILTER_SANITIZE_STRING);
    $usuario        = filter_var($_POST["usuario"],FILTER_SANITIZE_STRING);
    $cliente        = filter_var($_POST["cliente"], FILTER_SANITIZE_STRING);
    $rut            = filter_var($_POST["rut"], FILTER_SANITIZE_STRING);
    $correo         = filter_var($_POST["correo"],FILTER_SANITIZE_STRING);
    $detalle_pago   = filter_var($_POST["detalle_pago"],FILTER_SANITIZE_STRING);
    $monto          = filter_var($_POST["monto"],FILTER_SANITIZE_STRING);
    $monto          = str_replace(".","",$monto);
    if(strlen($cliente) < 4) {
        $output = json_encode(array('type'=>'error', 'text' => 'El nombre es demasiado corto o está vacío!'));
        die($output);
    }
    if(strlen($rut) < 9) {
        $output = json_encode(array('type'=>'error', 'text' => 'El RUT es demasiado corto o está vacío!'));
        die($output);
    }
    if(!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $output = json_encode(array('type'=>'error', 'text' => 'Por favor ingrese un email válido!'));
        die($output);
    }
    if(strlen($detalle_pago) < 3) {
        $output = json_encode(array('type'=>'error', 'text' => 'Detalle de pago demasiado corto! Por favor, introduzca algo más.'));
        die($output);
    }
    if(strlen($monto) < 1 or strlen($monto) == '') {
        $output = json_encode(array('type'=>'error', 'text' => 'No se puede enviar valores en cero o vacios.'));
        die($output);
    }
    $busca_clie_sql = "SELECT * FROM t_clientes WHERE user_rut='".$rut."'";
    $busca_clie_qry = $con->query($busca_clie_sql);
    if (!$busca_clie_qry) {
        $output = json_encode(array('type'=>'error', 'text' => printf("%s\n", $con->error)));
        die($output);
    } else {
        $busca_clie_con = $busca_clie_qry-> num_rows;
    }
    if ($busca_clie_con > 0) {
        $busca_clie_row = $busca_clie_qry->fetch_assoc();
        if ($busca_clie_row['user_name'] != $cliente) {
            $actualiza_name_sql = "UPDATE t_clientes SET user_name='".$cliente."' WHERE user_rut='".$rut."'";
            $actualiza_name_qry = $con->query($actualiza_name_sql);
        }
        if ($busca_clie_row['email'] != $correo) {
            $actualiza_mail_sql = "UPDATE t_clientes SET email='".$correo."' WHERE user_rut='".$rut."'";
            $actualiza_mail_qry = $con->query($actualiza_mail_sql);
        }
        $insert_cobro_sql = "INSERT INTO t_pagos (user_rut, detalle_pago, monto, fecha_envio, status,forma_pago,area,creado) VALUES ('".$rut."','".$detalle_pago."','".$monto."','".date('d-m-Y H:i:s')."','ENVIADO','','".$tipo."','".$usuario."')";
        $insert_cobro_qry = $con->query($insert_cobro_sql);
        if ($insert_cobro_qry === true) {
            $num_pago = $con->insert_id;
            if ($tipo == 1) {
                $mail_respuesta = "callcenter@dvp.cl";
                $nombre_respuesta = "CallCenter DVP S.A.";
            } else {
                $mail_respuesta = "cobranzas@dvp.cl";
                $nombre_respuesta = "Cobranzas DVP S.A.";
            }
            /************ Datos de cobro **************/
            $cabecera_uno_cobr = "Estimado (a) ".$cliente;
            $cabecera_dos_cobr = "Su cuenta ya se encuentra disponible";
            $mail_asunto_cobr = "Tu cuenta DVP se encuentra disponible";
            $envia_cobro = correoCobro($cabecera_uno_cobr,$cabecera_dos_cobr,$num_pago,$monto,$cliente,$rut,$mail_respuesta,$nombre_respuesta,$correo,$mail_asunto_cobr,$detalle_pago);
            if ($envia_cobro['type'] == "error") {
                $output = json_encode(array('type'=>'error', 'text' => $envia_cobro['text']));
                die($output);
            } else {
                $output = json_encode(array('type'=>'message', 'text' => $envia_cobro['text']));
                die($output);
            }
        } else {
            $output = json_encode(array('type'=>'error', 'text' => 'Ocurrió un error al generar el número de pago, intente nuevamente.'));
            die($output);
        }
    } else {
        $new_pass = generaPass();
        $new_pass = base64_encode($new_pass);
        $graba_clie_sql = "INSERT INTO t_clientes (user_rut, user_name, email, pass, id_status) VALUES ('".$rut."','".$cliente."','".$correo."','".$new_pass."','1')";
        $graba_clie_qry = $con->query($graba_clie_sql);
        $insert_cobro_sql = "INSERT INTO t_pagos (user_rut, detalle_pago, monto, fecha_envio, status,forma_pago,area,creado) VALUES ('".$rut."','".$detalle_pago."','".$monto."','".date('d-m-Y H:i:s')."','ENVIADO','','".$tipo."','".$usuario."')";
        $insert_cobro_qry = $con->query($insert_cobro_sql);
        if ($insert_cobro_qry === true) {
            $num_pago = $con->insert_id;
            /************* Generales Correo **************************/
            if ($tipo == 1) {
                $mail_respuesta = "callcenter@dvp.cl";
                $nombre_respuesta = "CallCenter DVP S.A.";
            } else {
                $mail_respuesta = "cobranzas@dvp.cl";
                $nombre_respuesta = "Cobranzas DVP S.A.";
            }
            /************* Datos correo de bienvenida ****************/
            $cabecera_uno_clie = "";
            $cabecera_dos_clie = "";
            $mail_asunto_bvd = "Bienvenido a Portal de pagos DVP S.A.";
            $envia_cliente = correoBienvenida($cabecera_uno_clie,$cabecera_dos_clie,$rut,$new_pass,$mail_respuesta,$nombre_respuesta,$correo,$cliente,$mail_asunto_bvd);
            /************ Datos de cobro **************/
            $cabecera_uno_cobr = "Estimado (a) ".$cliente;
            $cabecera_dos_cobr = "Su cuenta ya se encuentra disponible";
            $mail_asunto_cobr = "Tu cuenta DVP se encuentra disponible";
            $envia_cobro = correoCobro($cabecera_uno_cobr,$cabecera_dos_cobr,$num_pago,$monto,$cliente,$rut,$mail_respuesta,$nombre_respuesta,$correo,$mail_asunto_cobr,$detalle_pago);
            if ($envia_cliente['type'] == "error" && $envia_cobro['type'] == "error") {
                $output = json_encode(array('type'=>'error', 'text' => 'Ocurrió un error al enviar los correos, favor comunicarse con administrador de sistema.'));
                die($output);
            } elseif ($envia_cliente['type'] == "message" && $envia_cobro['type'] == "error") {
                $output = json_encode(array('type'=>'error', 'text' => 'Se envió correo de bienvenida a cliente '.$cliente.', pero no correo de cobro, favor comunicarse con administrador de sistema.'));
                die($output);
            } elseif ($envia_cliente['type'] == "error" && $envia_cobro['type'] == "message") {
                $output = json_encode(array('type'=>'error', 'text' => 'No se envió correo de bienvenida a cliente '.$cliente.', pero sí correo de cobro. RUT: '.$rut.', numero de pago: '.$num_pago.'.<br> Favor comunicarse con administrador de sistema.'));
                die($output);
            } else {
                $output = json_encode(array('type'=>'message', 'text' => $envia_cliente['text'].'<br>'.$envia_cobro['text']));
                die($output);
            }
        } else {
            $output = json_encode(array('type'=>'error', 'text' => 'Ocurrió un error al generar el número de pago, intente nuevamente.'));
            die($output);
        }
    }
    $con -> close();
}
?>