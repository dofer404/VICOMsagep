<?php
class ci_fotosdeservicio extends sagep_ci
{
		//-----------------------------------------------------------------------------------
	//---- Variables --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	protected $sql_state;
	protected $s__datos_filtro;
	//protected $s__datos;

	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
			$this->cn()->sincronizar();
			$this->cn()->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- Form_ml_fotos ----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_fotos(sagep_ei_formulario_ml $form_ml)
	{
		$parametros = toba::memoria()->get_parametros();
		// ei_arbol($parametros, 'PARAMETROS recibidos');
		$seleccion = toba::memoria()->get_parametro('fila');
		$clave_get = toba::memoria()->get_parametro('fila_safe');   
		ei_arbol($clave_get);
		$id_ubicacion = toba::memoria()->get_parametro('ubicacion');
		$id_detalle_contrato = toba::memoria()->get_parametro('detalle_contrato');
		
		$this->cn()->set_cursor_ubicaciones($seleccion);
						$datos = $this->cn()->get_fotos();
				$datos = $this->cn()->get_blobs($datos);
				$this->s__datos['form_ml_fotos'] = $datos;
				$form_ml->set_datos($datos);
		
		//if (isset($this->s__datos['form_ml_fotos'])) {
		//   $form->set_datos($this->s__datos['form_ml_fotos']);
		// } else {
			//if ($this->cn()->hay_cursor_ubicaciones()) {
				//$datos = $this->cn()->get_fotos();
				//$datos = $this->cn()->get_blobs($datos);
				// $this->s__datos['form_ml_fotos'] = $datos;
				//$form_ml->set_datos($datos);
			// }
		//}

		}

	function evt__form_ml_fotos__modificacion($datos)
	{
		$this->s__datos['form_ml_fotos'] = $datos;
		$this->cn()->procesar_filas_fotos($datos);
		$this->cn()->set_blobs($datos);
	}

}
?>