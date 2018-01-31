<?php
require_once('parametros/configuracion/configurar_empresa/dao_configurarempresa.php');
require_once('comunes/mensajes_error.php');
require_once('comunes/cache_form.php');

class ci_configurarempresa extends sagep_ci
{

	//-----------------------------------------------------------------------------------
	//---- Variables --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	protected $sql_state;
	protected $s__datos_filtro;
	protected $s__datos = [];

	//-----------------------------------------------------------------------------------
	//---- setters y getters ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	// getter form_cache

	function get_cache_form($nombre)
	{
		if (!isset($this->s__datos[$nombre])) {
			$this->s__datos[$nombre] = new cache_form();
		}
		return $this->s__datos[$nombre];
	}

	//-----------------------------------------------------------------------------------
	//---- form_muestra -----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_muestra(sagep_ei_formulario $form)
	{
		if (isset(dao_configurarempresa::get_listado_empresa()[0])) {
			$datos = dao_configurarempresa::get_listado_empresa()[0];
			$id_empresa = ['id_empresa' => $datos['id_empresa']];

			$this->cn()->cargar($id_empresa);
			$this->cn()->set_cursor($id_empresa);
			$datos = $this->cn()->get_empresa();
			$form->set_datos($datos);
		}
	}

	//-----------------------------------------------------------------------------------
	//---- form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form(sagep_ei_formulario $form)
	{
		$cache_form = $this->get_cache_form('form');
		$datos = $cache_form->get_cache();

		if (!$datos) {
			if ($this->cn()->hay_cursor() ) {
				$datos = $this->cn()->get_empresa();
				$cache_form->set_cache($datos);
			} else {
				$this->pantalla()->eliminar_evento('eliminar');
			}
		}

		$form->set_datos($datos);
	}

	function evt__form__modificacion($datos)
	{
		$this->cn()->set_empresa($datos);
		$this->get_cache_form('form')->set_cache($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__editar()
	{
		$this->set_pantalla('pant_edicion');
	}

	function evt__procesar()
	{
		$this->cn()->guardar();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
		$this->cn()->reiniciar();
		$this->set_pantalla('pant_inicial');
	}

	//-----------------------------------------------------------------------------------
	//---- Auxiliares -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function ajax__setear_telefonos($id, toba_ajax_respuesta $respuesta)
	{
		$datos = dao_configurarempresa::get_opcionesTelefonos($id);
		$respuesta->set($datos);
	}

	function ajax__setear_correos($id, toba_ajax_respuesta $respuesta)
	{
		$datos = dao_configurarempresa::get_opcionesCorreo($id);
		$respuesta->set($datos);
	}

	function ajax__setear_direcciones($id, toba_ajax_respuesta $respuesta)
	{
		$datos = dao_configurarempresa::get_opcionesUbicacion($id);
		$respuesta->set($datos);
	}

}
?>
