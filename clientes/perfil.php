<?php
include '../lib/nusoap/nusoap.php';
/*** DESA ***/
$qad = "http://integraciones.crm.dvp.cl:81/wwwdesa/sv_boton.php?wsdl";
/*** PROD ***/
//$qad = "http://integraciones.crm.dvp.cl:81/wwwdvp/sv_boton.php?wsdl";
$rut_ori = $cliente_row['user_rut'];
$subcadena = "-";
$posicionsubcadena = strpos($rut_ori, $subcadena);
$cod_verif = substr($rut_ori,($posicionsubcadena));
$rut_new = str_replace($cod_verif,"",$rut_ori);
$client = new nusoap_client($qad,'wsdl');
//Variable para obtener errores
$err = $client->getError();
if ($err) {
    //Muestra error de conexciÃ³n
    echo 'Error en Constructor' . $err ;
}
//Variable a entregar a WS
$param = array('id_qad' => $rut_new);
//Variable donde guardamos la peticion del metodo WS
$result = $client->call('MetodoConsulta', $param);
if ($client->fault) {
    //Muestra si cliente falla
    echo 'Fallo';
} else {
    // Chequea errores
    $err = $client->getError();
    if ($err) {
        // Muestra el error
        echo 'Error' . $err ;
    } else {
        //retorna datos WS
        $datos = $result;
        //print_r($datos);
    }
}
?>
<div class="breadcrumb">
    <div class="wrapper cf">
        <p><a href="<?php echo $inicio; ?>">Inicio</a> &nbsp;/&nbsp; Mi Perfil</p>
    </div>
</div>
<div class="wrapper info">
    <?php if ($cliente_row['id_status'] == 1) { ?>
    <div class="titulo">
        <h1>Mi Perfil</h1>
        <p>
            Bienvenido a tu perfil en DVP S.A.
            <br>
            Acá encontrarás los detalles de tu información que tenemos registrados en nuestros sistemas y podrás cambiar tu contraseña cada vez que lo necesites.
            <br>
            Debes cambiar la contraseña que te hemos enviado por una que recuerdes. Esta debe tener letras, numeros, por lo menos una mayúscula y una minúscula.
            <br>
            Si tienes dudas, contactanos al (56) 2 2392 0000.
        </p>
    </div>
    <?php } else { ?>
    <div class="titulo">
        <h1>Mi Perfil</h1>
        <p>
            Bienvenido a tu perfil en DVP S.A.
            <br>
            Acá encontrarás los detalles de tu información que tenemos registrados en nuestros sistemas y podrás cambiar tu contraseña cada vez que lo necesites. Si tienes dudas, contactanos al (56) 2 2392 0000.
        </p>
    </div>
    <?php } ?>
    <div class="txt cf">
        <div class="form form-perfil">
            <h2>Mi Perfil DVP</h2>
            <table width="440">
                <tr>
                    <td>Rut:</td>
                    <td><?php echo $datos['tCustportal']['tCustportalRow']['tcustrut']; ?></td>
                </tr>
                <tr>
                    <td>Nombre:</td>
                    <td><?php echo strtoupper($datos['tCustportal']['tCustportalRow']['tcustnombre']); ?></td>
                </tr>
                <tr>
                    <td>Teléfono:</td>
                    <td><?php echo $datos['tCustportal']['tCustportalRow']['tcustfono']; ?></td>
                </tr>
                <tr>
                    <td>Dirección:</td>
                    <td><?php echo strtoupper($datos['tCustportal']['tCustportalRow']['tcustdireccion1'].$datos['tCustportal']['tCustportalRow']['tcustdireccion2']); ?></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><?php echo $datos['tCustportal']['tCustportalRow']['tcustemail']; ?></td>
                </tr>
            </table>
        </div>
        <div class=" form form-cambiar-contrasena last" id="contact_body">
            <h2>Cambiar Contraseña</h2>
            <form id="form_con">
                <input type="hidden" id="user_rut" name="user_rut" value="<?php echo $datos['tCustportal']['tCustportalRow']['tcustrut']; ?>">
                <p>Actual contraseña
                    <br>
                    <input type="password" id="old_con" required></p>
                <p>Nueva contraseña
                    <br>
                    <input type="password" id="new_con" required></p>
                <p>Repetir contraseña
                    <br>
                    <input type="password" id="rep_con" required>
                </p>
                <p><input type="submit" id="btn_send_pass" value="Cambiar contraseña"></p>
            </form>
            <div id="contact_results"></div>
            <div id="loading-result"></div>
        </div>
    </div>
</div>