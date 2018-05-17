<?php
session_start();
if (isset($_SESSION['user_rut'])) {
    header('location:clientes/inicio.php?pant=bienvenida');
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Inicio Sesión | Portal de Pagos</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600" rel="stylesheet">
        <link href="content/style.css" type="text/css" rel="stylesheet">
    </head>
    <body class="inicio-sesion">
        <div class="wrapper info">
            <a href="" class="logo">
                <img src="img/logo.jpg" width="185" height="43" alt="Portal de Pagos DVP">
            </a>
            <div class="caja-gris">
                <form id="sesion-form">
                    <p>
                        Rut
                        <br>
                        <input type="text" id="user_rut" name="user_rut" placeholder="Ingresa tu Rut">
                    </p>
                    <div id="alert-user_rut"></div>
                    <p>
                        Contraseña
                        <br>
                        <input type="password" id="password" name="password" placeholder="Ingresa tu Contraseña">
                    </p>
                    <div id="alert-password"></div>
                    <p>
                        <input type="submit" id="login-submit" name="login-submit" value="Iniciar Sesión">
                    </p>
                    <div id="result"></div>
                </form>
            </div>
            <div class="link-password-olvidado">
                <a href="clientes/recuperar-contrasena.php">¿Olvidaste tu Contraseña?</a>
            </div>
        </div>
    </body>
    <footer>
        <p>
            DVP S.A. | Todos los derechos reservados
            <br> Innovación en productos plásticos para hogar y construcción.
            <br> Encuentra revestimientos siding, policarbonatos y más en dvp.cl
            <br> Los Nogales 661, Lampa, Santiago - Chile.
            <br> Casa Matriz (56) 2 2392 0000
        </p>
    </footer>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="controllers/js/inicio-sesion.js"></script>
