<?php
/**
 * Esta clase fue y será generada automáticamente. NO EDITAR A MANO.
 * @ignore
 */
class sagep_autoload 
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
		'sagep_ci' => 'extension_toba/componentes/sagep_ci.php',
		'sagep_cn' => 'extension_toba/componentes/sagep_cn.php',
		'sagep_datos_relacion' => 'extension_toba/componentes/sagep_datos_relacion.php',
		'sagep_datos_tabla' => 'extension_toba/componentes/sagep_datos_tabla.php',
		'sagep_ei_arbol' => 'extension_toba/componentes/sagep_ei_arbol.php',
		'sagep_ei_archivos' => 'extension_toba/componentes/sagep_ei_archivos.php',
		'sagep_ei_calendario' => 'extension_toba/componentes/sagep_ei_calendario.php',
		'sagep_ei_codigo' => 'extension_toba/componentes/sagep_ei_codigo.php',
		'sagep_ei_cuadro' => 'extension_toba/componentes/sagep_ei_cuadro.php',
		'sagep_ei_esquema' => 'extension_toba/componentes/sagep_ei_esquema.php',
		'sagep_ei_filtro' => 'extension_toba/componentes/sagep_ei_filtro.php',
		'sagep_ei_firma' => 'extension_toba/componentes/sagep_ei_firma.php',
		'sagep_ei_formulario' => 'extension_toba/componentes/sagep_ei_formulario.php',
		'sagep_ei_formulario_ml' => 'extension_toba/componentes/sagep_ei_formulario_ml.php',
		'sagep_ei_grafico' => 'extension_toba/componentes/sagep_ei_grafico.php',
		'sagep_ei_mapa' => 'extension_toba/componentes/sagep_ei_mapa.php',
		'sagep_servicio_web' => 'extension_toba/componentes/sagep_servicio_web.php',
		'sagep_comando' => 'extension_toba/sagep_comando.php',
		'sagep_modelo' => 'extension_toba/sagep_modelo.php',
	);
}
?>