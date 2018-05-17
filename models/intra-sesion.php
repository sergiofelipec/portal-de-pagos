<?php
session_start();
require '../db/connection.php';
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $con->real_escape_string($_POST['email']);
    $password = $con->real_escape_string($_POST['password']);
    $valida_usr_sql = "SELECT * FROM t_user WHERE email = '".$email."' AND pass = '".$password."'";
    $valida_usr_qry = $con->query($valida_usr_sql);
    $valida_usr_cnt = $valida_usr_qry->num_rows;
    if ($valida_usr_cnt > 0) {
        $valida_usr_row = $valida_usr_qry->fetch_assoc();
        $_SESSION['id_user'] = $valida_usr_row['id_user'];
        $_SESSION['user_name'] = $valida_usr_row['user_name'];
        $_SESSION['email'] = $valida_usr_row['email'];
        $_SESSION['id_tipo_user'] = $valida_usr_row['id_tipo_user'];
        echo $valida_usr_row['id_tipo_user'];
    } else {
        echo "<b>Error de usuario o contraseña, intente nuevamente.</b>";
    }
} else {
    echo "<b>Debe ingresar un usuario y contraseña, favor intente nuevamente.</b>";
}
?>