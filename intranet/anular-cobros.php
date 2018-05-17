<div class="breadcrumb">
    <div class="wrapper cf">
        <p>
            <a href="inicio.php?pant=inicio">Inicio</a> &nbsp;/&nbsp; Anular Cobros
        </p>
    </div>
</div>

<div id="an-cobros-body" class="wrapper info">
    <div class="titulo">
        <h1>Anular Cobros</h1>
        <p>
        </p>
    </div>
    <div id="an-respuesta"></div>
    <div id="an-cobros-results" class="txt cf">
        <div class="form form-perfil form-cobro form-consultar">
            <div class="buscar">
                <p>
                    Buscar por N° de orden, cliente, estado o forma de pago:<br>
                    <input type="text" id="an-orden" placeholder="Ingresa los datos a buscar" value="">
                    <input type="hidden" id="an-tipo" value="<?php echo $user_row['id_tipo_user']; ?>">
                    <input type="hidden" id="an-user" value="<?php echo $user_row['id_user']; ?>">
                </p>
            </div>
        </div>
        <br>
        <form id="an-form">
            <div id="an-resultados" style="text-align:center;"></div>
            <div class="registros" id="an-agrega-registros"></div>
        </form>
    </div>
</div>