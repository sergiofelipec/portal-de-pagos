<div class="breadcrumb">
    <div class="wrapper cf">
        <p>
            <a href="inicio.php?pant=inicio">Inicio</a> &nbsp;/&nbsp; Consultar Cobros
        </p>
    </div>
</div>

<div class="wrapper info">
    <div class="titulo">
        <h1>Consultar Estado de Cobros</h1>
        <p>
        </p>
    </div>

    <div class="txt cf">
        <div class="form form-perfil form-cobro form-consultar">
            <div class="buscar">
                <p>
                    Buscar por N° de orden, cliente, estado o forma de pago:<br>
                    <input type="text" id="bs-orden" placeholder="Ingresa los datos a buscar" value="">
                    <input type="hidden" id="bs-tipo" value="<?php echo $user_row['id_tipo_user']; ?>">
                </p>
            </div>
        </div>
        <br>
        <div id="resultados" style="text-align:center;"></div>
        <div class="registros" id="agrega-registros"></div>
    </div>
</div>