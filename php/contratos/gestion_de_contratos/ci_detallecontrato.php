<?php
require_once('contratos/gestion_de_contratos/dao_gestiondecontratos.php');

class ci_detallecontrato extends sagep_ci
{
	protected $sql_state;
	protected $s__datos_detalle;

	//-----------------------------------------------------------------------------------
	//---- form__ml_detalle -------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_detalle($form_ml)
	{
			if ($this->cn()->hay_cursor()) {
				$datos = $this->cn()->get_detalle();
				//$this->s__datos['form_ml_detalle'] = $datos;
				$form_ml->set_datos($datos);
			}
	}

	function evt__form_ml_detalle__modificacion($datos)
	{
		$this->s__datos['form__ml_detalle'] = $datos;
		$this->cn()->procesar_filas_detalle($datos);
	}

	function evt__form_ml_detalle__detalle($seleccion)
	{
		$this->cn()->set_cursor_detalle($seleccion);
		$this->set_pantalla('pant_edicion');
		$this->controlador()->controlador()->eliminar_evento('procesar');
	}

	function evt__form_ml_detalle__registro_alta($datos, $id_fila)
	{
		ei_arbol($datos);
		$this->cn()->reiniciar();
		$this->set_pantalla('pant_edicion');

		//$this->s__datos_detalle[$id_fila] = $datos;
	}

	function evt__form_ml_detalle__registro_modificacion($datos, $id_fila)
	{
		//$this->cn()->reiniciar();
	//	ei_arbol($datos);
		$this->set_pantalla('pant_edicion');
		//ei_arbol($datos[$id_fila]);

		//$this->s__datos[$id_fila] = $datos;
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml_ubicacion ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_ubicacion(sagep_ei_formulario_ml $form_ml)
	{
		if (isset($this->s__datos['form_ml_ubicacion'])) {
			$form_ml->set_datos($this->s__datos_detalle['form_ml_ubicacion']);
		} else {

			if ($this->cn()->hay_cursor_detalle()) {
				$datos = $this->cn()->get_ubicacion();
				$this->s__datos_detalle['form_ml_ubicacion'] = $datos;
				$form_ml->set_datos($datos);
			}
		}
	}

	function evt__form_ml_ubicacion__modificacion($datos)
	{
		$this->s__datos['form_ml_ubicacion'] = $datos;
		$this->cn()->procesar_filas_ubicacion($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__cancelar()
	{
		unset($this->s__datos_detalle['form_detalle']);
		$this->set_pantalla('pant_inicial');
	}

	function evt__procesar()
	{
		try {
			//$this->cn()->guardar();
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

	//-----------------------------------------------------------------------------------
	//---- Configuraciones --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__pant_edicion(toba_ei_pantalla $pantalla)
	{
		$this->controlador()->controlador()->pantalla()->eliminar_evento('procesar');
		$this->controlador()->controlador()->pantalla()->eliminar_evento('eliminar');
		$this->controlador()->controlador()->pantalla()->eliminar_evento('cancelar');

	}

	//-----------------------------------------------------------------------------------
	//---- form_detalle -----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__form_detalle__modificacion($datos)
	{
		$this->s__datos_detalle['form_detalle'] = $datos;
		$this->cn()->set_detalle($datos);
	}

	function conf__form_detalle(sagep_ei_formulario $form)
	{

		if (isset($this->s__datos_detalle['form_detalle'])) {
			$form->set_datos($this->s__datos_detalle['form_detalle']);
		} else {
			if ($this->cn()->hay_cursor_detalle()) {
				$datos = $this->cn()->get_unDetalle();
				//$this->s__datos['form_detalle'] = $datos;
				$form->set_datos($datos);
			}
		}

				// if ($this->cn()->hay_cursor_detalle()) {
				// 	//unset($this->s__datos);
				//
				// 	$datos = $this->cn()->get_unDetalle();
				// 	unset($this->s__datos['form_detalle']);
				// 	$this->s__datos['form_detalle'] = $datos;
				// 	//unset($this->s__datos['form_detalle']);
				// 	ei_arbol($this->s__datos['form_detalle']);
				// 	$form->set_datos($datos);
				// }
				// unset($this->s__datos);

	}

}
?>
