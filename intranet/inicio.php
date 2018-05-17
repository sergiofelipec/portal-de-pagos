<?php
require_once 'header.php';
if (isset($_GET['pant'])) {
    switch ($_GET['pant']) {
        case 'inicio':
            include 'inicio-usuario.php'; 
            break;
        case 'enviar':
            include 'envio-cobros.php';
            break;
        case 'consultar':
            include 'consultar-cobros.php';
            break;
        case 'anular':
            include 'anular-cobros.php';
            break;
        case 'salir':
            session_destroy();
            header('Location: index.php');
            break;
    }
}
require_once 'footer.php';
?>