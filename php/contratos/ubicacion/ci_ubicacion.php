<?php
require_once('contratos/ubicacion/dao_ubicacion.php');

class ci_ubicacion extends sagep_ci
{
	//-----------------------------------------------------------------------------------
	//---- form_ml_estados --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_estados(sagep_ei_formulario_ml $form_ml)
	{
	}

	function evt__form_ml_estados__modificacion($datos)
	{
	}

	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
	}

	function evt__cancelar()
	{
	}

	//-----------------------------------------------------------------------------------
	//---- form_ubicacion ---------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ubicacion(sagep_ei_formulario $form)
	{
		$parametro_externo = toba::memoria()->get_parametros();

		$clave_get = array (
      'id_ubicacion' => toba::memoria()->get_parametro('ubicacion'),
      'id_detalle_contrato' => toba::memoria()->get_parametro('detalle_contrato')
    );

		$clave_get = toba::memoria()->get_parametro('fila_safe');

    $id_ubicacion = toba::memoria()->get_parametro('id_ubicacion');
    $id_detalle_contrato = toba::memoria()->get_parametro('id_detalle_contrato');

		ei_arbol($clave_get);
	}

	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Eventos ---------------------------------------------

		{$this->objeto_js}.evt__procesar = function()
		{
			window.close();
		}

		{$this->objeto_js}.evt__cancelar = function()
		{
			window.close();
		}
		";
	}

}
?>
