<?php
class ci_modificarpersona extends sagep_ci
{
	//-----------------------------------------------------------------------------------
	//---- Variables --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	protected $sql_state;
	protected $s__datos;
	protected $s__datos_ml_telefonos;

	//-----------------------------------------------------------------------------------
	//---- Form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form(form $form)
	{
		if (isset($this->s__datos['form'])) {
			$form->set_datos($this->s__datos['form']);
		} else {

			if ($this->cn()->hay_cursor()) {
				$datos = $this->cn()->get_personas();
				$this->s__datos['form'] = $datos;
				$form->set_datos($datos);
			}
		}
	}

	function evt__form__modificacion($datos)
	{
		$this->s__datos['form'] = $datos;
		$this->cn()->set_personas($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- Form_ml_telefonos ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_telefonos(sagep_ei_formulario_ml $form_ml)
	{
		$datos = $this->cn()->get_telefonos();
		$form_ml->set_datos($datos);
	}

	function evt__form_ml_telefonos__modificacion($datos)
	{
		$this->s__datos['form_ml_telefonos'] = $datos;
		$this->cn()->procesar_filas_telefonos($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- Form_ml_correos --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_correos(sagep_ei_formulario_ml $form_ml)
	{
		$datos = $this->cn()->get_correos();
		$form_ml->set_datos($datos);
	}

	function evt__form_ml_correos__modificacion($datos)
	{
		$this->s__datos['form_ml_correos'] = $datos;
		$this->cn()->procesar_filas_correos($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- Form_ml_direcciones ----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_direcciones(sagep_ei_formulario_ml $form_ml)
	{
			$datos = $this->cn()->get_direcciones();
			$form_ml->set_datos($datos);
	}

	function evt__form_ml_direcciones__modificacion($datos)
	{
		$this->s__datos['form_ml_direcciones'] = $datos;
		$this->cn()->procesar_filas_direcciones($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- Form_ml_cuentas --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_cuentas(sagep_ei_formulario_ml $form_ml)
	{
		$datos = $this->cn()->get_cuentas_per();
		$form_ml->set_datos($datos);
	}

	function evt__form_ml_cuentas__modificacion($datos)
	{
		$this->s__datos['form_ml_cuentas'] = $datos;
		$this->cn()->procesar_filas_cuentas_per($datos);
	}

}
?>