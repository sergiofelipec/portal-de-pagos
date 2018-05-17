<?php
require_once('../db/connection.php');
require_once('../lib/PHPMailer/PHPMailerAutoload.php');
require_once('../mails/mail.php');
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
if($_POST){
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
        $output = json_encode(array(
            'type' => 'error', 
            'text' => 'Perdón, existe un error'
        ));
        die($output);
    }
    $user_rut   = $_POST['user_rut'];
    $rut = substr($user_rut,0,-2);
    $dv = substr($user_rut,strlen($user_rut)-1,1);
    $formato_rut = str_replace(".","",$rut);
    $nuevo_rut = $formato_rut.'-'.$dv;
    $busca_con_sql = "SELECT * FROM t_clientes WHERE user_rut='".$nuevo_rut."'";
    $busca_con_qry = $con -> query($busca_con_sql);
    $busca_con_cnt = $busca_con_qry->num_rows;
    if ($busca_con_cnt > 0) {
        $new_pass = generaPass();
        $new_pass = base64_encode($new_pass);
        $actualiza_con_sql = "UPDATE t_clientes SET pass='".$new_pass."', id_status='1' WHERE user_rut='".$nuevo_rut."'";
        $actualiza_con_qry = $con->query($actualiza_con_sql);
        if (!$actualiza_con_qry) {
            $output = json_encode(array('type'=>'error', 'text' => 'No se hizo el cambio de contraseña. Contactanos al (56) 2 2392 0000.'.$con->error));
            die($output);
        } else {
            $busca_con_row = $busca_con_qry->fetch_assoc();
            $cabecera_uno = "Has solicitado una nueva contraseña";
            $nombre_cliente = $busca_con_row['user_name'];
            $mail_respuesta = "callcenter@dvp.cl";
            $nombre_respuesta = "CallCenter DVP S.A.";
            $mail_cliente = $busca_con_row['email'];
            $mail_asunto = "Recupera contraseña [Portal de pagos DVP S.A.]";

            $correo = correoRecPass($cabecera_uno,$nombre_cliente,$nuevo_rut,$new_pass,$mail_respuesta,$nombre_respuesta,$mail_cliente,$mail_asunto);
            if ($correo['type'] == "error") {
                $output = json_encode(array('type'=>'error', 'text' => 'Ocurrió un problema, por favor intentalo nuevamente. '.$correo['text']));
                die($output);
            } else {
                $output = json_encode($correo);
                die($output);
            }
        }
    } else {
        $output = json_encode(array('type'=>'error', 'text' => 'Al parecer no estás registrado en nuestros sistemas.<br>Favor contáctate con nosotros al (56) 2 2392 0000.'));
        die($output);
    }
}
?>