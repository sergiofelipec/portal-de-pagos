<div class="breadcrumb">
    <div class="wrapper cf">
        <p>
            <a href="inicio.php?pant=inicio">Inicio</a> 
            &nbsp;/&nbsp; Enviar Cobros
        </p>
    </div>
</div>
<div class="wrapper info">
    <div class="titulo">
        <h1>Enviar Cobros</h1>
        <p>Ingrese un RUT sin dígito verificador (Si es menor a 10 millones debe anteponer un cero).</p>
    </div>
    <div id="envio-cobros-body" class="txt cf">
        <div id="envio-cobros-results"></div>
        <div id="enviar-cobro" class="form form-perfil form-cobro">
            <form>
                <p>
                    Id QAD
                    <br>
                    <input type="text" id="envio_id" class="ui-widget" maxlength="8" placeholder="RUT sin dígito verificador">
                    <input type="hidden" id="envio_tipo" class="ui-widget" value="<?php echo $user_row['id_tipo_user']; ?>">
                    <input type="hidden" id="envio_user" class="ui-widget" value="<?php echo $user_row['id_user']; ?>">
                </p>
                <p>
                    Rut
                    <br>
                    <input type="text" id="envio_rut" style="background-color:#e6e6e6;" required="true" readonly>
                </p>
                <p>
                    Cliente
                    <br>
                    <input type="text" id="envio_cliente" style="background-color:#e6e6e6;" required="true" readonly>
                </p>
                <p>
                    Email
                    <br>
                    <input type="email" id="envio_email" required="true">
                </p>
                <p>
                    Confirmación email
                    <br>
                    <input type="email" id="envio_confir_email" required="true">
                </p>
                <p>
                    Detalle de pago
                    <br>
                    <textarea id="envio_detalle" required="true"></textarea>
                </p>
                <p>
                    Monto a cobrar
                    <br>
                    <input type="text" id="envio_monto" title="Ingresa algo" onchange="format_valores('envio_monto');" required="true">
                </p>
                <p>
                    <input type="submit" id="envio_enviar" value="Enviar Cobro">
                </p>
                <div id="envio-cargando"></div>
            </form>
        </div>
    </div>
</div>