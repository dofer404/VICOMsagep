<?php
require_once('comunes/cache_form.php');
require_once('comunes/cache_form_ml.php');
require_once('comunes/mensajes_error.php');


class ci_agregarpersona extends sagep_ci
{
	//-----------------------------------------------------------------------------------
	//---- Variables --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	protected $sql_state;
	protected $s__datos;

	//-----------------------------------------------------------------------------------
	//---- setters y getters ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function get_cache_form($nombre)
	{
		if (!isset($this->s__datos[$nombre])) {
			$this->s__datos[$nombre] = new cache_form();
		}
		return $this->s__datos[$nombre];
	}

	function get_cache_form_ml($nombre_ml)
	{
		if (!isset($this->s__datos[$nombre_ml])) {
			$this->s__datos[$nombre_ml] = new cache_form_ml();
		}
		return $this->s__datos[$nombre_ml];
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
				//$this->cn()->reiniciar();
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
		$form->set_datos($datos);
	}

	function evt__form__modificacion($datos)
	{
		$this->cn()->set_personas($datos);
		$this->get_cache_form('form')->set_cache($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- Form_ml_telefonos ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_telefonos(sagep_ei_formulario_ml $form_ml)
	{
		$cache_ml_telefonos = $this->get_cache_form_ml('form_ml_telefonos');
		$datos = $cache_ml_telefonos->get_cache();
		if($datos){
			$form_ml->set_datos($datos);
		} else {
			$form_ml->set_registro_nuevo();
		}
	}

	function evt__form_ml_telefonos__modificacion($datos)
	{
		$this->cn()->procesar_filas_telefonos($datos);
		$datos = $this->cn()->get_telefonos();
		$this->get_cache_form_ml('form_ml_telefonos')->set_cache($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- Form_ml_correos --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_correos(sagep_ei_formulario_ml $form_ml)
	{
		$cache_ml_correos = $this->get_cache_form_ml('form_ml_correos');
		$datos = $cache_ml_correos->get_cache();

		if($datos){
			$form_ml->set_datos($datos);
		} else {
			$form_ml->set_registro_nuevo();
		 }
	}

	function evt__form_ml_correos__modificacion($datos)
	{
		$this->cn()->procesar_filas_correos($datos);
		$datos = $this->cn()->get_correos();
		$this->get_cache_form_ml('form_ml_correos')->set_cache($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- Form_ml_direcciones ----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_direcciones(sagep_ei_formulario_ml $form_ml)
	{
		$cache_form_ml_direcciones = $this->get_cache_form_ml('form_ml_direcciones');
		$datos = $cache_form_ml_direcciones->get_cache();
		if($datos){
			$form_ml->set_datos($datos);
		} else {
		 	$form_ml->set_registro_nuevo();
		 }
	}

	function evt__form_ml_direcciones__modificacion($datos)
	{
		$this->cn()->procesar_filas_direcciones($datos);
		$datos = $this->cn()->get_direcciones();
		$this->get_cache_form_ml('form_ml_direcciones')->set_cache($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- Form_ml_cuentas --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_cuentas(sagep_ei_formulario_ml $form_ml)
	{
		$cache_form_ml_cuentas = $this->get_cache_form_ml('form_ml_cuentas');
		$datos = $cache_form_ml_cuentas->get_cache();
		$form_ml->set_datos($datos);
	}

	function evt__form_ml_cuentas__modificacion($datos)
	{
		$this->cn()->procesar_filas_cuentas_per($datos);
		$datos = $this->cn()->get_cuentas_per();
		$this->get_cache_form_ml('form_ml_cuentas')->set_cache($datos);
	}

}
?>
