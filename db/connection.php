<?php
$con = new mysqli('localhost','root','20Ta06to07;(','boton_pago');
$acentos = $con->query("SET NAMES 'utf8'");
if ($con->connect_error) {
    die ("FALLA DE CONECCION: ".$con->connect_error);
}
?>