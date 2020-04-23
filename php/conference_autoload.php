<?php
/**
 * Esta clase fue y será generada automáticamente. NO EDITAR A MANO.
 * @ignore
 */
class conference_autoload 
{
	static function existe_clase($nombre)
	{
		return isset(self::$clases[$nombre]);
	}

	static function cargar($nombre)
	{
		if (self::existe_clase($nombre)) { 
			 require_once(dirname(__FILE__) .'/'. self::$clases[$nombre]); 
		}
	}

	static protected $clases = array(
		'conference_ci' => 'extension_toba/componentes/conference_ci.php',
		'conference_cn' => 'extension_toba/componentes/conference_cn.php',
		'conference_datos_relacion' => 'extension_toba/componentes/conference_datos_relacion.php',
		'conference_datos_tabla' => 'extension_toba/componentes/conference_datos_tabla.php',
		'conference_ei_arbol' => 'extension_toba/componentes/conference_ei_arbol.php',
		'conference_ei_archivos' => 'extension_toba/componentes/conference_ei_archivos.php',
		'conference_ei_calendario' => 'extension_toba/componentes/conference_ei_calendario.php',
		'conference_ei_codigo' => 'extension_toba/componentes/conference_ei_codigo.php',
		'conference_ei_cuadro' => 'extension_toba/componentes/conference_ei_cuadro.php',
		'conference_ei_esquema' => 'extension_toba/componentes/conference_ei_esquema.php',
		'conference_ei_filtro' => 'extension_toba/componentes/conference_ei_filtro.php',
		'conference_ei_firma' => 'extension_toba/componentes/conference_ei_firma.php',
		'conference_ei_formulario' => 'extension_toba/componentes/conference_ei_formulario.php',
		'conference_ei_formulario_ml' => 'extension_toba/componentes/conference_ei_formulario_ml.php',
		'conference_ei_grafico' => 'extension_toba/componentes/conference_ei_grafico.php',
		'conference_ei_mapa' => 'extension_toba/componentes/conference_ei_mapa.php',
		'conference_servicio_web' => 'extension_toba/componentes/conference_servicio_web.php',
		'conference_comando' => 'extension_toba/conference_comando.php',
		'conference_modelo' => 'extension_toba/conference_modelo.php',
		'proveedor_autorizacion_unlu' => 'rest/proveedor_autorizacion_unlu.php',
	);
}
?>