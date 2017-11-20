<?php
require_once('comunes/mensajes_error.php');
require_once('comunes/cache_form_ml.php');
require_once('comunes/cache_form.php');

class ci_agregarservicio extends sagep_ci
{
	//-----------------------------------------------------------------------------------
	//---- Variables --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	protected $sql_state;
	protected $s__datos;

	//-----------------------------------------------------------------------------------
	//---- setters y getters ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function get_cache_form_ml($nombre_ml)
	{
		if (!isset($this->s__datos[$nombre_ml])) {
			$this->s__datos[$nombre_ml] = new cache_form_ml();
		}
		return $this->s__datos[$nombre_ml];
	}

	function get_cache_form($nombre)
	{
		if (!isset($this->s__datos[$nombre])) {
			$this->s__datos[$nombre] = new cache_form();
		}
		return $this->s__datos[$nombre];
	}

	// form_servicios

	function get_cache_form_servicio()
	{
		$datos = [];
		if (isset($this->s__datos['form'])) {
			$datos = $this->s__datos['form'];
		}
		return $datos;
	}

	function set_cache_form_servicio(array $datos)
	{
		$this->s__datos['form'] = $datos;
	}

	function unset_datos_form_servicio()
	{
		$datos = $this->get_cache_form_servicio();
		unset($this->s__datos['form']);
	}

	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		try {
			$this->cn()->guardar();
			$this->evt__cancelar();

		} catch (toba_error_db $e) {
			if (!mensajes_error::$debug) {
				$sql_state = $e->get_sqlstate();
				mensajes_error::get_mensaje_error($sql_state);
				throw $e;
			}
		}
	}

	function evt__cancelar()
	{
		unset($this->s__datos);
		$this->cn()->reiniciar();
		$this->controlador()->set_pantalla('pant_inicial');
	}

	//-----------------------------------------------------------------------------------
	//---- Form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form(form $form)
	{
		$cache_form = $this->get_cache_form('form');
		$datos = $cache_form->get_cache();

		//$datos = $this->get_cache_form_servicio();
		$form->set_datos($datos);
	}

	function evt__form__modificacion($datos)
	{
		$this->cn()->set_servicios($datos);
	//	$this->set_cache_form_servicio($datos);
		$this->get_cache_form('form')->set_cache($datos);

	}

	//-----------------------------------------------------------------------------------
	//---- form_ml_tarifa ---------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_tarifa(sagep_ei_formulario_ml $form_ml)
	{
		$cache_ml_tarifa= $this->get_cache_form_ml('form_ml_tarifa');
		$datos = $cache_ml_tarifa->get_cache();
		if($datos){
			$form_ml->set_datos($datos);
		}
	}

	function evt__form_ml_tarifa__modificacion($datos)
	{
		$this->cn()->procesar_filas_tarifa($datos);
		$datos = $this->cn()->get_tarifa();
		$this->get_cache_form_ml('form_ml_tarifa')->set_cache($datos);
	}

}
?>
