<?php
session_start();
require '../db/connection.php';
if (isset($_POST['user_rut']) && isset($_POST['password'])) {
    $user_rut = $con->real_escape_string($_POST['user_rut']);
    $rut = substr($user_rut,0,-2);
    $dv = substr($user_rut,strlen($user_rut)-1,1);
    $formato_rut = str_replace(".","",$rut);
    $nuevo_rut = $formato_rut.'-'.$dv;
    $password = $con->real_escape_string($_POST['password']);
    $password = base64_encode($password);
    $valida_usr_sql = "SELECT * FROM t_clientes WHERE user_rut = '".$nuevo_rut."' AND pass = '".$password."'";
    $valida_usr_qry = $con->query($valida_usr_sql);
    $valida_usr_cnt = $valida_usr_qry->num_rows;
    if ($valida_usr_cnt > 0) {
        $valida_usr_row = $valida_usr_qry->fetch_assoc();
        $_SESSION['user_rut'] = $valida_usr_row['user_rut'];
        $_SESSION['user_name'] = $valida_usr_row['user_name'];
        $_SESSION['email'] = $valida_usr_row['email'];
        $_SESSION['id_status'] = $valida_usr_row['id_status'];
        echo $valida_usr_row['id_status'];
    } else {
        echo "<b>Error de usuario o contraseña, intente nuevamente.</b>";
    }
} else {
    echo "Debe ingresar un usuario y contraseña, favor intente nuevamente.";
}
?>