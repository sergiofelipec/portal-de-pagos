<?php
$url = "http://". $_SERVER["HTTP_HOST"] ."/portal-de-pagos";
$header_mail = '<!DOCTYPE html>
<html dir="ltr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title></title>
    </head>
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
        <div id="wrapper" dir="ltr" style="background-color:#f5f5f5;margin:0;padding:70px 0 70px 0;width:100%">
            <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                <tr>
                    <td align="center" valign="top">
                        <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container" style="background-color:#fdfdfd;border:1px solid #dcdcdc;border-radius:3px!important">
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
                                        <tr>
                                            <td valign="top" id="body_content" style="background-color:#fdfdfd">
                                                <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td valign="top" style="padding:0;">';

$footer_mail = '</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr> 
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer" style="background:#003d79; padding:20px 0 0; margin-top:20px">
                                        <tr>
                                            <td valign="top">
                                                <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td colspan="2" valign="middle" id="credit" style="padding:0 48px 27px 48px;border:0;color:#668baf;font-family:Arial;font-size:12px;line-height:125%;text-align:center">
                                                            <p style="color:#fff!important;line-height:18px">DVP S.A. | Todos los
                                                                derechos reservados<br>
                                                                Casa Matriz: <a href="https://maps.google.com/?q=Los+Nogales+661,+Lampa,+Santiago+%E2%80%93+Chile&amp;entry=gmail&amp;source=g" style="color:#fff" target="_blank">Los Nogales 661, Lampa, Santiago - Chile</a><br>
                                                                Contáctanos en Servicio al Cliente al <a href="tel:+5622392000" style="color:#fff">(56) 2 2392 0000</a>
                                                            </p>
                                                            <p style="color:#fff;font-family:Calibri,Arial,sans-serif;font-size:12px;font-weight:700;line-height:150%;text-align:center">
                                                                <a href="http://dvp.cl/sucursales/" style="color:#fff!important;font-weight:normal;text-decoration:underline" target="_blank">SUCURSALES</a>
                                                                &nbsp;|&nbsp; 
                                                                <a href="http://dvp.cl/catalogos/" style="color:#fff!important;font-weight:normal;text-decoration:underline" target="_blank">CATÁLOGOS</a>
                                                                &nbsp;|&nbsp; 
                                                                <a href="http://dvp.cl/contacto/" style="color:#fff!important;font-weight:normal;text-decoration:underline" target="_blank" >CONTACTO</a>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>';
?>