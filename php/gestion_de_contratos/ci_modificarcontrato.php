<?php
class ci_modificarcontrato extends sagep_ci
{

	//-----------------------------------------------------------------------------------
	//---- Variables --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	protected $sql_state;
	//protected $s__datos;

	//-----------------------------------------------------------------------------------
	//---- Form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form(sagep_ei_formulario $form)
	{
		if (isset($this->s__datos['form'])) {
			$form->set_datos($this->s__datos['form']);
		} else {
			if ($this->cn()->hay_cursor()) {
				$datos = $this->cn()->get_contratos();
				$this->s__datos['form'] = $datos;
				$form->set_datos($datos);
			}
		}
	}

	function evt__form__modificacion($datos)
	{
		$this->s__datos['form'] = $datos;
		$this->cn()->set_contratos($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml_roles ----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_roles(sagep_ei_formulario_ml $form_ml)
	{
		if ($this->cn()->hay_cursor()) {
			$datos = $this->cn()->get_roles();
			$form_ml->set_datos($datos);
		}
	}

	function evt__form_ml_roles__modificacion($datos)
	{
		$this->s__datos['form_ml_roles'] = $datos;
		$this->cn()->procesar_filas_roles($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- form__ml_detalles_contrato ---------------------------------------------------
	//-----------------------------------------------------------------------------------

	function cambiar_pantalla() {
		$this->set_pantalla('detalles');
	}
	function conf__form_ml_detalles_contrato($form_ml)
	{
		 if ($this->cn()->hay_cursor()) {
		$datos = $this->cn()->get_detalle();
		$form_ml->set_datos($datos);
		}
	}

	function evt__form_ml_detalles_contrato__modificacion($datos)
	{
		$this->s__datos['form_ml_detalles_contrato'] = $datos;
		$this->cn()->procesar_filas_detalle($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml_ubicacion ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_ubicacion($form_ml)
	{
		// $datos = $this->cn()->get_ubicacion();
		// if(isset($datos)){
		//     $form_ml->set_datos($datos);
		// } else {
		//     $form_ml->desactivar_agregado_filas();
		// }

		if ($this->cn()->hay_cursor_detalle()) {
			$datos = $this->cn()->get_ubicacion();
			$this->s__datos['form_ml_ubicacion'] = $datos;
			//ei_arbol($this->s__datos['form_ml_ubicacion']);
			$form_ml->set_datos($datos);
		} else {
			$form_ml->desactivar_agregado_filas();
		}
	}

	function evt__form_ml_ubicacion__modificacion($datos)
	{
		//$this->cn()->set_cursor_ubicacion($seleccion);
		$this->s__datos['form_ml_ubicacion'] = $datos;
		$this->cn()->procesar_filas_ubicacion($datos);
	}

	function evt__form_ml_ubicacion__ver_imagenes($seleccion)
	{
	}

	function conf_evt__form_ml_ubicacion__ver_imagenes(toba_evento_usuario $evento, $fila)
	{
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml_detalles_contrato ----------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__form_ml_detalles_contrato__ver_ubicacion($seleccion)
	{
		$this->cn()->set_cursor_detalle($seleccion);
	}

}
?>
