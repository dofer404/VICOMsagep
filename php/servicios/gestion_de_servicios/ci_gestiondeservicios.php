<?php
require_once('servicios/gestion_de_servicios/dao_gestiondeservicios.php');
require_once('adebug.php');

class ci_gestiondeservicios extends sagep_ci
{

	//-----------------------------------------------------------------------------------
	//---- Variables --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	protected $sql_state;
	protected $s__datos_filtro;
	protected $s__datos;

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
			if (adebug::$debug) {
				throw $e;
			} else {
				$this->cn()->reiniciar();
				$sql_state = $e->get_sqlstate();
				if ($sql_state == 'db_23505') {
					throw new toba_error_usuario('Ya existe el Servicio');
				}
			}
		}
	}

	function evt__cancelar()
	{
		$this->cn()->reiniciar();
		unset($this->s__datos);
		$this->set_pantalla('pant_inicial');
	}

	function evt__eliminar()
	{
		$this->cn()->eliminar();
		$this->evt__procesar();
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

			$datos = dao_gestiondeservicios::get_listado_servicios($sql_where);
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
		$this->s__datos['form'] = $datos;
		$this->cn()->set_servicios($datos);
	}

	function conf__form(sagep_ei_formulario $form)
	{
		if (isset($this->s__datos['form'])) {
			$form->set_datos($this->s__datos['form']);
		} else {

			if ($this->cn()->hay_cursor()) {
				$datos = $this->cn()->get_servicios();
				$this->s__datos['form'] = $datos;
				$form->set_datos($datos);
			} else {
				$this->pantalla()->eliminar_evento('eliminar');
			}
		}
	}
}

?>
