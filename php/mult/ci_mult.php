<?php
class ci_mult extends sagep_ci
{
	
	protected $s__datos;
	protected $s__datos_filtro;
	
	//-----------------------------------------------------------------------------------
	//---- form_ml_detalle --------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function evt__form_ml_detalles_contrato__seleccion($id_fila)
	{
		$this->informar_msg('Se selecciona la fila con importe : '.$this->s__datos[$id_fila]['monto_total'], 'info');
	}


	function evt__form_ml_detalles_contrato__modificacion($datos)
	{
		$this->s__datos = $datos;
	}

	function conf__form_ml_detalles_contrato(sagep_ei_formulario_ml $form_ml)
	{

	if (isset($this->s__datos)) {
		$form_ml->set_datos($this->s__datos);
	}
	}
	
		//-----------------------------------------------------------------------------------
	//---- form_ml_detalle --------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	

}
?>