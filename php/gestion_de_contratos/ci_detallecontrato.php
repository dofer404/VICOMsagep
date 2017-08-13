<?php
require_once('gestion_de_contratos/dao_gestiondecontratos.php');

class ci_detallecontrato extends sagep_ci
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
		//$this->cn()->reiniciar();
		$this->set_pantalla('pant_edicion');
	}

	function evt__cancelar()
	{
		unset($this->s__datos);
		$this->cn()->reiniciar();
		$this->set_pantalla('pant_inicial');
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
			$this->cn()->eliminar_detalle();
			$this->cn()->guardar_detalle();
			$this->evt__cancelar();
		} catch (toba_error_db $e) {
			if (mensajes_error::$debug) {
				throw $e;
			} else {
				$this->cn()->reiniciar_detalle();
				$sql_state = $e->get_sqlstate();
				mensajes_error::get_mensaje_error($sql_state);
			}
		}
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro_detalle -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_detalle(sagep_ei_cuadro $cuadro)
	{
				$datos = dao_gestiondecontratos::get_listado_detalles_contrato();
				$cuadro->set_datos($datos);
	}

	function evt__cuadro_detalle__edicion($seleccion)
	{
	$this->cn()->cargar($seleccion);
	$this->cn()->set_cursor_detalle($seleccion);
	$this->set_pantalla('pant_edicion');
	}

	//-----------------------------------------------------------------------------------
	//---- form_detalle -----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_detalle(sagep_ei_formulario $form)
	{
	if (isset($this->s__datos['form_detalle'])) {
		$form->set_datos($this->s__datos['form_detalle']);
	} else {
		if ($this->cn()->hay_cursor_detalle()) {
		$datos = $this->cn()->get_detalle();
		$this->s__datos['form_detalle'] = $datos;
		$form->set_datos($datos);
		}
	}
	}

	function evt__form_detalle__modificacion($datos)
	{
		$this->s__datos['form_detalle'] = $datos;
		$this->cn()->set_detalle($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml_ubicacion ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_ubicacion(form_ml_ubicacion $form_ml)
	{
		if ($this->cn()->hay_cursor_detalle()) {
			$datos = $this->cn()->get_ubicacion();
			$this->s__datos['form_ml_ubicacion'] = $datos;
			$form_ml->set_datos($datos);
		} else {
			//$this->dep('form_ml_ubicacion')->colapsar();
			//$form_ml->desactivar_agregado_filas();
		}
	}

	function evt__form_ml_ubicacion__modificacion($datos)
	{
		$this->s__datos['form_ml_ubicacion'] = $datos;
		$this->cn()->procesar_filas_ubicacion($datos);
	}

}
?>