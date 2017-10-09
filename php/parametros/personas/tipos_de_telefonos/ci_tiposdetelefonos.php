<?php
require_once('parametros/personas/tipos_de_telefonos/dao_tiposdetelefonos.php');
require_once('comunes/mensajes_error.php');
require_once('comunes/cache_form.php');

class ci_tiposdetelefonos extends sagep_ci
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
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function evt__nuevo()
	{
		$this->cn()->reiniciar();
		$this->set_pantalla('pant_edicion');
	}
	
	function evt__procesar()
	{
		try {
			$this->cn()->guardar();
			$this->evt__cancelar();
			
		} catch (toba_error_db $e) {
			if (mensajes_error::$debug) {
				throw $e;
			} else {
				$this->cn()->reiniciar();
				$sql_state = $e->get_sqlstate();
				mensajes_error::get_mensaje_error($sql_state);
			}
		}
	}
	
	function evt__eliminar()
	{
		try {
			$this->cn()->eliminar();
			$this->cn()->guardar();
			$this->evt__cancelar();
		} catch (toba_error_db $e) {
			if (mensajes_error::$debug) {
				throw $e;
			} else {
				$this->cn()->reiniciar();
				$sql_state = $e->get_sqlstate();
				mensajes_error::get_mensaje_error($sql_state);
			}
		}
	}
	
	function evt__cancelar()
	{
		$this->cn()->reiniciar();
		$this->get_cache('form')->unset_cache();
		$this->set_pantalla('pant_inicial');
	}
	
	//-----------------------------------------------------------------------------------
	//---- Filtro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function conf__filtro(sagep_ei_filtro $filtro)
	{
		if (isset($this->s__datos_filtro)) {
			$filtro->set_datos($this->s__datos_filtro);
		}
	}
	
	function evt__filtro__filtrar($datos)
	{
		$this->s__datos_filtro = $datos;
	}
	
	function evt__filtro__cancelar()
	{
		unset($this->s__datos_filtro);
	}
	
	//-----------------------------------------------------------------------------------
	//---- Cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function conf__cuadro(sagep_ei_cuadro $cuadro)
	{
		if (isset($this->s__datos_filtro)) {
			$filtro = $this->dep('filtro');
			$filtro->set_datos($this->s__datos_filtro);
			$sql_where = $filtro->get_sql_where();
			
			$datos = dao_tiposdetelefonos::get_listado_tipos_telefonos($sql_where);
			$cuadro->set_datos($datos);
		}
	}
	
	function evt__cuadro__edicion($seleccion)
	{
		$this->cn()->cargar($seleccion);
		$this->cn()->set_cursor($seleccion);
		$this->set_pantalla('pant_edicion');
	}
	
	function evt__cuadro__eliminar($seleccion)
	{
	}
	
	//-----------------------------------------------------------------------------------
	//---- Form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function evt__form__modificacion($datos)
	{
		$this->get_cache('form')->set_cache($datos);
		$this->cn()->set_tipos_telefonos($datos);
	}
	
	function conf__form(sagep_ei_formulario $form)
	{
		$cache_form = $this->get_cache('form');
		$datos = $cache_form->get_cache();
		if (!$datos) {
			if ($this->cn()->hay_cursor() ) {
				$datos = $this->cn()->get_tipos_telefonos();
				$cache_form->set_cache($datos);
			} else {
				$this->pantalla()->eliminar_evento('eliminar');
			}
		}
		$form->set_datos($datos);
	}
	
}
?>