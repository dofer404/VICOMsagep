<?php
class ci_modificarcontrato extends sagep_ci
{
	//-----------------------------------------------------------------------------------
	//---- Variables --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	protected $sql_state;
	protected $s__datos;

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
	//---- form_ml_detalle --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__form_ml_detalle__modificacion($datos)
	{
		$this->controlador()->marcar_contratosSeteados();
  }

	function conf__form_ml_detalle(sagep_ei_formulario_ml $form_ml)
	{
		if ($this->cn()->hay_cursor()) {
			$datos = $this->cn()->get_detalle();
			$form_ml->set_datos($datos);
		}
	}

}
?>
