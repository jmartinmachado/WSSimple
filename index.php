<?php
/**
 * Configuracion
 */
define("PATH_BASE", dirname(__file__));
define("PATH_CLASES", PATH_BASE . "/operaciones/");

/**
 * Seteo el timezone
 */
date_default_timezone_set('America/Argentina/Buenos_Aires');

/**
 * Seteo el header json
 */
header('Content-Type: application/json');

/**
 * Leo el contenido del json y lo parseo
 */
echo json_encode(inicio(file_get_contents("php://input")));

/**
 * Cargo automaticamente las clases
 */
function inicio($json)
{
    try {
        /**
         * Respuesta pocr defecto
         */
        $datosTransaccion            = new stdclass();
        $datosTransaccion->fecha     = date("Y-m-d");
        $datosTransaccion->servicio  = null;
        $datosTransaccion->operacion = null;
        $datosTransaccion->mensaje   = "ERROR";
        $datosTransaccion->idTrans   = time();
        $datosTransaccion->resultado = null;

        /**
         * Parseo el json
         */
        $datos = json_decode($json);
    } catch (Exception $e) {
        $datosTransaccion->mensaje = $e->getMessage();
    }
    return $datosTransaccion;
}





function cargarClases()
{
    if ($manejador = opendir(PATH_CLASES)) {
        $thelist= '';
        while (false !== ($archivo = readdir($manejador))) {
            if ($archivo != "." && $archivo != ".." && strtolower(substr($archivo, strrpos($archivo, '.') + 1)) == 'php') {
                require_once PATH_CLASES . $archivo;
            }
        }
        closedir($manejador);
    }
}