<?php
session_start();
if (isset($_SESSION['user_name'])) {
    header('location:inicio.php?pant=inicio');
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Intranet | Portal de Pagos</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600" rel="stylesheet">
        <link href="../content/style.css" type="text/css" rel="stylesheet">
    </head>
    <body class="inicio-sesion">
        <div class="wrapper info">
            <a href="" class="logo">
                <img src="../img/logo.jpg" width="185" height="43" alt="Intranet Portal de Pagos DVP">
            </a>
            <div class="caja-gris">
                <form method="get" id="form_user">
                    <p>
                        E-mail
                        <br>
                        <input type="email" id="email" name="email" placeholder="Ingresa tu E-mail" required>
                    </p>
                    <div id="alert-user_name"></div>
                    <p>
                        Contraseña
                        <br>
                        <input type="password" id="password" name="password" placeholder="Ingresa tu Contraseña" required>
                    </p>
                    <div id="alert-password"></div>
                    <p>
                        <input type="submit" id="login-submit" name="login-submit" value="Iniciar Sesión">
                    </p>
                    <div id="result"></div>
                </form>
            </div>
            <div class="link-password-olvidado">
                <!--<a href="recuperar-contraseña.php">¿Olvidaste tu Contraseña?</a>-->
            </div>
        </div>
    </body>
    <footer>
        <p>DVP S.A. | Todos los derechos reservados
            <br> Innovación en productos plásticos para hogar y construcción.
            <br> Encuentra revestimientos siding, policarbonatos y más en dvp.cl
            <br> Los Nogales 661, Lampa, Santiago - Chile.
            <br> Casa Matriz (56) 2 2392 0000
        </p>
    </footer>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="../controllers/js/intra-sesion.js"></script>