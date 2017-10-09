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
	protected $s__datos;

	//-----------------------------------------------------------------------------------
	//---- setters y getters ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function get_cache($nombre)
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
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__editar()
	{
		$this->set_pantalla('pant_edicion');
	}

	function evt__procesar()
	{
		$this->cn()->dep('dr_datos_empresa')->sincronizar();
		$this->cn()->dep('dr_datos_empresa')->resetear();
		$this->set_pantalla('pant_inicial');

	}

	function evt__cancelar()
	{
		$this->cn()->reiniciar();
		$this->get_cache('form')->unset_cache();
		$this->set_pantalla('pant_inicial');
	}

	//-----------------------------------------------------------------------------------
	//---- Cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(sagep_ei_cuadro $cuadro)
	{
		$cuadro->desactivar_modo_clave_segura();

		$datos = dao_configurarempresa::get_listado_empresa();
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->cn()->cargar($seleccion);
		$this->cn()->set_cursor($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	//-----------------------------------------------------------------------------------
	//---- form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form(sagep_ei_formulario $form)
	{

		$cache_form = $this->get_cache('form');
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
		$this->get_cache('form')->set_cache($datos);
		$this->cn()->set_empresa($datos);
	}

}
?>
