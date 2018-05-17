<?php
require_once('../db/connection.php');
session_start();
if (isset($_SESSION['user_rut'])) {
    $cliente_slq = "SELECT * FROM t_clientes WHERE user_rut='".$_SESSION['user_rut']."'";
    $cliente_qry = $con->query($cliente_slq) or trigger_error($con->error);
    $cliente_row = $cliente_qry->fetch_array();
} else {
    session_destroy();
    header('location: index.php');
}

if (isset($_GET['pant'])) {
    switch ($_GET['pant']) {
        case 'bienvenida':
            $title = "Inicio";
            $body_class = "bienvenido";
            break;
        case 'perfil':
            $title = "Perfil";
            $body_class = "pagar mi-perfil";
            if ($cliente_row['id_status'] == 1) {
                $inicio = "inicio.php?pant=perfil";
            } else {
                $inicio = "inicio.php?pant=bienvenida";
            }
            break;
        case 'mis_pagos':
            $title = "Mis Pagos";
            $body_class = "pagar mis-pagos";
            $inicio = "inicio.php?pant=bienvenida";
            break;
        case 'pagar':
            $title = "Pagar";
            $body_class = "pagar";
            $inicio = "inicio.php?pant=bienvenida";
            break;
        case 'pago':
            $title = "Pago";
            $body_class = "pagar";
            $inicio = "inicio.php?pant=bienvenida";
            break;
        case 'salir':
            session_destroy();
            header('Location: ../index.php');
            break;
    }
}
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'getResult':
            include 'pagar_tbk.php'; 
            break;
        case 'end':
            $title = "Pago Realizado";
            $body_class = "pagar";
            $inicio = "inicio.php?pant=bienvenida";
            break;
    }
}

?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title><?php echo $title;?> | Portal de Pagos DVP</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600" rel="stylesheet">
        <link href="../content/style.css" type="text/css" rel="stylesheet">
    </head>
    <body class="<?php echo $body_class; ?>">
        <header>
            <div class="wrapper cf">
                <?php if ($cliente_row['id_status'] == 1) {?>
                <a href="inicio.php?pant=perfil" class="logo">
                    <img src="../img/logo.jpg" width="185" height="43" alt="Portal de Pagos DVP">
                </a>
                <div class="menu cf">
                    <a href="inicio.php?pant=perfil">Mi Perfil</a>
                    <span></span>
                    <a href="inicio.php?pant=perfil">Mis Pagos</a>
                    <span></span>
                    <a href="inicio.php?pant=perfil">Pagar</a>
                    <a href="?pant=salir" class="btn-pagar">Salir</a>
                </div>
                <?php } else { ?>
                <a href="inicio.php?pant=bienvenida" class="logo">
                    <img src="../img/logo.jpg" width="185" height="43" alt="Portal de Pagos DVP">
                </a>
                <div class="menu cf">
                    <a href="inicio.php?pant=perfil">Mi Perfil</a>
                    <span></span>
                    <a href="inicio.php?pant=mis_pagos">Mis Pagos</a>
                    <span></span>
                    <a href="inicio.php?pant=pagar">Pagar</a>
                    <a href="?pant=salir" class="btn-pagar">Salir</a>
                </div>
                <?php }?>
            </div>
        </header>