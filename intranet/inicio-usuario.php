<div class="mensaje-bienvenida">
    <div class="wrapper cf">
        <h1>Bienvenido (a) <?php echo $user_row['user_name']." ".$venta_area; ?>.</h1>
        <p></p>
    </div>
</div>
<div class="wrapper info cf">
    <div class="caja-gris columna">
        <a href="inicio.php?pant=enviar">Enviar Cobros a Cliente</a>
    </div>
    <div class="caja-gris columna">
        <a href="inicio.php?pant=consultar">Consultar Cobros</a>
    </div>
    <div class="caja-gris columna last">
        <a href="inicio.php?pant=anular">Anular Cobros</a>
    </div>
</div>