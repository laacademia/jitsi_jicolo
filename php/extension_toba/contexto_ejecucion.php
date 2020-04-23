<?php
class contexto_ejecucion extends toba_contexto_ejecucion
{
	function conf__rest($app){
    	$app->set_autorizador(new proveedor_autorizacion_unlu());
	}
}

?>