<?php
require_once('../db/connection.php');
session_start();
if (isset($_SESSION['id_user'])) {
    $user_slq = "SELECT * FROM t_user WHERE id_user='".$_SESSION['id_user']."'";
    $user_qry = $con->query($user_slq) or trigger_error($con->error);
    $user_row = $user_qry->fetch_array();
    if ($user_row['id_tipo_user'] == 1) {
        $venta_area = "CALLCENTER";
    } else {
        $venta_area = "COBRANZA";
    }
} else {
    session_destroy();
    header('location: index.php');
}

if (isset($_GET['pant'])) {
    switch ($_GET['pant']) {
        case 'inicio':
            $title = "Inicio Usuario DVP";
            $body_class = "bienvenido";
            break;
        case 'enviar':
            $title = "Envío de Cobros";
            $body_class = "pagar usuario cobros";
            break;
        case 'consultar':
            $title = "Consultar Cobros";
            $body_class = "pagar usuario cobros consulta";
            $inicio = "inicio.php?pant=bienvenida";
            break;
        case 'anular':
            $title = "Anular Cobros";
            $body_class = "pagar usuario cobros consulta";
            $inicio = "inicio.php?pant=bienvenida";
            break;
        case 'salir':
            session_destroy();
            header('Location: index.php');
            break;
    }
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title><?php echo $title; ?> | Portal de Pagos DVP</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600" rel="stylesheet">
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <link href="../content/style.css" type="text/css" rel="stylesheet">
    </head>
    <body class="<?php echo $body_class; ?>">
        <header>
            <div class="wrapper cf">
                <a href="inicio.php?pant=inicio" class="logo">
                    <img src="../img/logo.jpg" width="185" height="43" alt="Portal de Pagos DVP">
                </a>
                <div class="menu cf">
                    <a href="inicio.php?pant=enviar">Enviar</a>
                    <span></span>
                    <a href="inicio.php?pant=consultar">Consultar</a>
                    <span></span>
                    <a href="inicio.php?pant=anular">Anular</a>
                    <a href="?pant=salir" class="btn-pagar">Salir</a>
                </div>
            </div>
        </header>