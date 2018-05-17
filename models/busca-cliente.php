<?php
include('../lib/nusoap/nusoap.php');
$id_qad = $_GET['id_qad'];
/*** DESA ***/
$qad = "http://integraciones.crm.dvp.cl:81/wwwdesa/sv_boton.php?wsdl";
/*** PROD ***/
//$qad = "http://integraciones.crm.dvp.cl:81/wwwdvp/sv_boton.php?wsdl";
if (isset($id_qad)) {
    $client = new nusoap_client($qad,'wsdl');
    //Variable para obtener errores
    $err = $client->getError();
    if ($err) {
        //Muestra error de conexión
        $orden = [
            "nombre" => "ERROR",
            "correo" => "ERROR",
            "rut" => "ERROR",
            "label" => "Error Mediador: ".$err
        ];
        $datos = [];
        array_push($datos,$orden);
        echo json_encode($datos);
    }
    //Variable a entregar a WS
    $param = array('id_qad' => $id_qad);
    //Variable donde guardamos la peticion del metodo WS
    $result = $client->call('MetodoConsulta', $param);
    if ($client->fault) {
        //Muestra si cliente falla
        $orden = [
            "nombre" => "ERROR",
            "correo" => "ERROR",
            "rut" => "ERROR",
            "label" => "Existen problemas de comunicación con QAD:".$client->fault
        ];
        $datos = [];
        array_push($datos,$orden);
        echo json_encode($datos);
    } else {
        // Chequea errores
        $err = $client->getError();
        if ($err) {
            // Muestra el error
            $orden = [
                "nombre" => "ERROR",
                "correo" => "ERROR",
                "rut" => "ERROR",
                "label" => "Ocurrió un problema:".$err
            ];
            $datos = [];
            array_push($datos,$orden);
            echo json_encode($datos);
        } else {
            $orden = [
                "nombre" => $result['tCustportal']['tCustportalRow']['tcustnombre'],
                "correo" => $result['tCustportal']['tCustportalRow']['tcustemail'],
                "rut" => $result['tCustportal']['tCustportalRow']['tcustrut'],
                "label" => $result['tCustportal']['tCustportalRow']['tcustcmaddr']
            ];
            $datos = [];
            array_push($datos,$orden);
            echo json_encode($datos);
        }
    }
}
?>