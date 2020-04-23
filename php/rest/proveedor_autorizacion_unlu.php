<?php

class proveedor_autorizacion_unlu extends \SIUToba\rest\seguridad\proveedor_autorizacion
{
    public function tiene_acceso($usuario, $ruta){
    	return true;
    }
}