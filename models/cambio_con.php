<?php
session_start();
include('../db/connection.php');
if($_POST){
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
        $output = json_encode(array(
            'type' => 'error', 
            'text' => 'Perdón, existe un error'
        ));
        die($output);
    }
    $user_rut   = $_POST['user_rut'];
    $old_con    = $_POST['old_con'];
    $new_con    = $_POST['new_con'];
    $rep_con    = $_POST['rep_con'];
    $busca_con_sql = "SELECT * FROM t_clientes WHERE user_rut='".$user_rut."'";
    $busca_con_qry = $con -> query($busca_con_sql);
    $busca_con_row = $busca_con_qry -> fetch_array();
    if (base64_decode($busca_con_row['pass']) === $new_con) {
        $output = json_encode(array('type'=>'error', 'text' => 'Su nueva contraseña debe ser distinta a la ya registrada.'));
        die($output);
    } elseif ($new_con != $rep_con) {
        $output = json_encode(array('type'=>'error', 'text' => 'No coincide su nueva contraseña, favor revise he intente nuevamente.'));
        die($output);
    } elseif ($new_con == $rep_con && strlen($new_con) < 6) {
        $output = json_encode(array('type'=>'error', 'text' => 'La clave debe tener al menos 6 caracteres.'));
        die($output);
    } elseif ($new_con == $rep_con && strlen($new_con) > 16) {
        $output = json_encode(array('type'=>'error', 'text' => 'La clave no puede tener más de 16 caracteres.'));
        die($output);
    } elseif ($new_con == $rep_con && !preg_match('`[a-z]`',$new_con)) {
        $output = json_encode(array('type'=>'error', 'text' => 'La clave debe tener al menos una letra minúscula.'));
        die($output);
    } elseif ($new_con == $rep_con && !preg_match('`[A-Z]`',$new_con)) {
        $output = json_encode(array('type'=>'error', 'text' => 'La clave debe tener al menos una letra mayúscula.'));
        die($output);
    } elseif ($new_con == $rep_con && !preg_match('`[0-9]`',$new_con)) {
        $output = json_encode(array('type'=>'error', 'text' => 'La clave debe tener al menos un caracter numérico.'));
        die($output);
    } elseif ($new_con == $rep_con) {
        $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        for ($i=0; $i<strlen($new_con); $i++){ 
            if (strpos($permitidos, substr($new_con,$i,1)) === false){ 
                $output = json_encode(array('type'=>'error', 'text' => 'Debe ocupar solamente letras mayúsculuas, letras minúsculas o números, caracteres especiales no están permitidos.'));
                die($output);
            } else {
                $actualiza_con_sql = "UPDATE t_clientes SET pass='".base64_encode($new_con)."', id_status='2' WHERE user_rut='".$user_rut."'";
                $actualiza_con_qry = $con->query($actualiza_con_sql);
                if (!$actualiza_con_qry) {
                    $output = json_encode(array('type'=>'error', 'text' => 'No se hizo el cambio de contraseña.'.$con->error));
                    die($output);
                } else {
                    $output = json_encode(array('type'=>'message', 'text' => 'Su contraseña ha sido cambiada con exito, espere unos segundos...'));
                    die($output);
                }
            }
        }
    }
}
?>