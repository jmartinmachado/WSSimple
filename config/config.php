<?php
/**
 * Descripción: Configuracion
 *
 * @category Categoria
 * @package  WSSimple
 * @author   Machado, Juan Martín <machado.juanmartin@gmail.com>
 * @license  www.juanmartinmachado.com.ar
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
 * Configuracion de directorios
 */
define("PATH_BASE", "/home/jmartinmachado/Codigo/Pruebas/WSSimple");
define("PATH_CLASES", PATH_BASE . "/servicios/");

/**
 * Configuracion de logs
 */
define("LOG_CARPETA", PATH_BASE . "/logs/");
define("AMBIENTE", "PRODUC CION");
define("LOG_MAXFILESIZE", "5MB");
define("LOG_MAXBACKUPINDEX", "5");
define("LOG_NOMBRE", "wssimple");


/**
 * Configuracion de Mensajes
 */
define("MSJ_ERROR", "Ocurrió un error durante la ejecución de la api");
define("MSJ_OK",    "La operación se realizó correctamente");

