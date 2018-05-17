<div class="mensaje-bienvenida">
    <div class="wrapper cf">
        <h1>Bienvenido (a) <?php echo strtoupper($cliente_row['user_name']); ?>.</h1>
        <p>
        Te damos la bienvenida nuestro "Portal de pagos", donde podrás realizar pagos en línea, abonos a cuentas o consultar por tus pagos realizados en esta plataforma.<br>
        Ante cualquier consulta llámanos al (56) 2 2392 0000. 
        </p>
    </div>
</div>
<div class="wrapper info cf">
    <div class="caja-gris columna">
        <h2>Conoce tu perfil de usuario y modifica tu contraseña de acceso al Portal de Pagos</h2>
        <a href="inicio.php?pant=perfil">Ir a Mi Perfil</a>
    </div>
    <div class="caja-gris columna">
        <h2>Revisa en detalle todos tus pagos realizados y los pagos pendientes</h2>
        <a href="inicio.php?pant=mis_pagos">Revisar Mis Pagos</a>
    </div>
    <div class="caja-gris columna last">
        <h2>Ingresa directamente a completar un pago pendiente enviado por nuestros ejecutivos</h2>
        <a href="inicio.php?pant=pagar">Pagar</a>
    </div>
</div>