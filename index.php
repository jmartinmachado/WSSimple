<?php
/**
 * Descripción: Punto de entrada WS
 *
 * @category Categoria
 * @package  WSSimple
 * @author   Machado, Juan Martín <machado.juanmartin@gmail.com>
 * @license  juanmartinmachado www.juanmartinmachado.com.ar
 * @version  1.0.0
 * @link     jmartinmachado, https://github.com/jmartinmachado/WSSimple
 *
 * @internal Fecha de creación:   2016-01-19
 * @internal Ultima modificación: 2016-01-19
 *
 * @internal Audit trail
 * (AAAA-MM-DD) Autor: Modificación
 */

/**
 * Configuracion
 */
require_once dirname(__file__) . "/config/config.php";

/**
 * Libreria de logs
 */
require_once dirname(__file__) . "/lib/FuncionLog/log.php";

/**
 * Seteo el timezone
 */
date_default_timezone_set("America/Argentina/Buenos_Aires");

/**
 * Seteo el header de respuesta json
 */
header("Content-Type: application/json");

/**
 * Leo el contenido del json y lo parseo
 */
$resultado = json_encode(inicio(file_get_contents("php://input")));
ws_info($resultado);
echo $resultado;

/**
 * Descripcion: Cargo automaticamente las clases
 *
 * @param json $json json de entrada
 *
 * @author Juan Martin Machado
 *
 * @internal Fecha de creación: 2016-01-19
 * @internal Ultima modificación: 2016-01-19
 * @internal Razón: Creacion
 *
 * @return json Resultado de la operacion
 */
function inicio($json)
{
    try {
        /**
         * Respuesta pocr defecto
         */
        $datosTransaccion            = new stdclass();
        $datosTransaccion->fecha     = date("Y-m-d H-i-s");
        $datosTransaccion->mensaje   = MSJ_ERROR;
        $datosTransaccion->resultado = null;

        /**
         * Parseo el json
         */
        ws_info($json);
        $datos = json_decode($json);
        if (!$datos) {
            $datosTransaccion->mensaje = "Error al intentar parsear el json";
            return $datosTransaccion;
        }

        /**
         * Controlo que esten los necesarios del json
         */
        if (!isset($datos->servicio)) {
            $datosTransaccion->mensaje = "Error al intentar parsear el json. No se encontro el campo 'servicio'";
            return $datosTransaccion;
        }
        if (!isset($datos->operacion)) {
            $datosTransaccion->mensaje = "Error al intentar parsear el json. No se encontro el campo 'operacion'";
            return $datosTransaccion;
        }
        if (!isset($datos->param)) {
            $datosTransaccion->mensaje = "Error al intentar parsear el json. No se encontro el campo 'param'";
            return $datosTransaccion;
        }

        /**
         * Intento cargar la clase del servicio
         */
        if (!cargarClase($datos->servicio)) {
            $datosTransaccion->mensaje = "No se encontro clase '". $datos->servicio . "'";
            return $datosTransaccion;
        }

        /**
         * Intento instanciar la clase
         */
        if (class_exists($datos->servicio)) {
            $clase = new $datos->servicio();
        } else {
            $datosTransaccion->mensaje = "Error al tratar de instanciar clase '". $datos->servicio . "'";
            return $datosTransaccion;
        }

        /**
         * Controlo que exista el metodo exista
         */
        if (method_exists($clase, $datos->operacion)) {
            $metodo = $datos->operacion;
            $datosTransaccion->resultado = $clase->$metodo($datos->param);
            $datosTransaccion->mensaje   = MSJ_OK;
            return $datosTransaccion;
        } else {
            $datosTransaccion->mensaje = "Error al tratar de invocar al metodo '". $datos->operacion . "'";
            return $datosTransaccion;
        }
    } catch (Exception $e) {
        $datosTransaccion->mensaje = $e->getMessage();
    }
    return $datosTransaccion;
}

/**
 * Descripcion: carga la clases y metodos
 *
 * @param string $nombreClase Nombre de la clase a cargar
 *
 * @author Juan Martin Machado
 *
 * @internal Fecha de creación: 2016-01-19
 * @internal Ultima modificación: 2016-01-19
 * @internal Razón: Creacion
 *
 * @return boolean Resultado de la operacion
 */
function cargarClase($nombreClase)
{
    $archivoClase = PATH_CLASES . $nombreClase . "/" . $nombreClase . ".php";
    if (file_exists($archivoClase)) {
        include_once $archivoClase;
        return true;
    } else {
        return false;
    }
}