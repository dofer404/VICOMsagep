<?php
require_once('contratos/gestion_de_contratos/dao_gestiondecontratos.php');

class ci_detallecontrato extends sagep_ci
{
	protected $sql_state;
	protected $s__datos_detalle;

	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__cancelar()
	{
		$this->borrar_memoria();
		$this->dep('form_detalle')->limpiar_interface();
		unset($this->s__datos_detalle['form_detalle']);
		unset($this->s__datos_detalle['form_ml_detalle']);
		unset($this->s__datos_detalle);
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
	//---- form__ml_detalle -------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_detalle($form_ml)
	{
			if ($this->cn()->hay_cursor()) {
				$datos = $this->cn()->get_detalle();
				$this->s__datos_detalle['form_ml_detalle'] = $datos;
				$form_ml->set_datos($datos);
			}
	}

	function evt__form_ml_detalle__modificacion($datos)
	{
		$this->s__datos_detalle['form__ml_detalle'] = $datos;
		$this->cn()->procesar_filas_detalle($datos);
	}

	function evt__form_ml_detalle__detalle($seleccion)
	{
		unset($this->s__datos_detalle['form_detalle']);
		$this->set_pantalla('pant_edicion');
		$this->controlador()->controlador()->eliminar_evento('procesar');
	}

	function evt__form_ml_detalle__registro_alta($datos, $id_fila)
	{
		$this->cn()->reiniciar();
		$this->set_pantalla('pant_edicion');
	}

	function evt__form_ml_detalle__registro_modificacion($datos, $id_fila)
	{
		if ($this->cn()->hay_cursor_detalle()) {
			//$datos = $this->cn()->get_unDetalle();
			$this->cn()->set_detalle($datos);
		//	$this->s__datos_detalle['form_detalle'] = $datos;
			//$form->set_datos($datos);
		} else {
			ei_arbol('nuevo');
			$this->cn()->setDatos_nuevoDetalle($datos);
		}

		//$this->cn()->reiniciar();
	//	ei_arbol($datos);
	  ei_arbol('nuevo');
		//$this->dep('form_detalle')->limpiar_interface();
		$this->s__datos_detalle['form_detalle'] = $datos;

		$this->set_pantalla('pant_edicion');
		//ei_arbol($datos[$id_fila]);

		//$this->s__datos_detalle[$id_fila] = $datos;
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
				$this->s__datos_detalle['form_detalle'] = $datos;
				$form->set_datos($datos);
			} else {
				ei_arbol('sin datos');
			}
		}
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml_ubicacion ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_ubicacion(sagep_ei_formulario_ml $form_ml)
	{
		if (isset($this->s__datos_detalle['form_ml_ubicacion'])) {
			$form_ml->set_datos($this->s__datos_detalle['form_ml_ubicacion']);
		} else {

			if ($this->cn()->hay_cursor_detalle()) {
				$datos = $this->cn()->get_ubicacion();
				//$parametros['id_ubicacion'] =  $proyecto['id_ubicacion'];
				//$form_ml->ef('id_ubicacion')->vinculo()->set_parametros($parametros);
				$this->s__datos_detalle['form_ml_ubicacion'] = $datos;
				$form_ml->set_datos($datos);
			}
		}
	}

	function evt__form_ml_ubicacion__modificacion($datos)
	{
		$this->s__datos_detalle['form_ml_ubicacion'] = $datos;
		$this->cn()->procesar_filas_ubicacion($datos);
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

	function conf__pant_inicial(toba_ei_pantalla $pantalla)
	{
		unset($this->s__datos_detalle['form_detalle']);
	}

}
?>
