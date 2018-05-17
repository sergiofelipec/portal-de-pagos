<?php
require_once 'header.php';
if (isset($_GET['pant'])) {
    switch ($_GET['pant']) {
        case 'bienvenida':
            include 'bienvenida.php'; 
            break;
        case 'perfil':
            include 'perfil.php';
            break;
        case 'mis_pagos':
            include 'mis-pagos.php';
            break;
        case 'pagar':
            include 'pagar.php'; 
            break;
        case 'pago':
            include 'pagar_tbk.php';
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
            include 'pagar_tbk.php';
            break;
    }
}
require_once 'footer.php';
?>