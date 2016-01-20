<?php
/**
*
*/
class Autenticacion
{

    function __construct()
    {

    }

    public function login($parametros)
    {
        try {
            return $parametros;
        } catch (Exception $e) {
            $respuesta->mensaje = $e->getMessage();
        }
        return $parametros;
    }
}