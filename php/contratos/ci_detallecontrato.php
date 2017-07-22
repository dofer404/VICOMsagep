<?php
require_once('contratos/gestion_de_contratos/dao_gestiondecontratos.php');

class ci_detallecontrato extends sagep_ci
{
	protected $sql_state;
	//protected $s__datos;

	//-----------------------------------------------------------------------------------
	//---- form__ml_detalle -------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_detalle($form_ml)
	{

		if (isset($this->s__datos['form_ml_detalle'])) {
			$form_ml->set_datos($this->s__datos['form_ml_detalle']);
		} else {

			if ($this->cn()->hay_cursor()) {
				$datos = $this->cn()->get_detalle();
				$this->s__datos['form_ml_detalle'] = $datos;
				$form_ml->set_datos($datos);
			}
		}

		// if ($this->cn()->hay_cursor()) {
		// 	$datos = $this->cn()->get_detalle();
		// 	$this->s__datos['form_ml_detalle'] = $datos;
		// 	$form_ml->set_datos($datos);
		// }

		// if (isset($this->s__datos['form_ml_detalle'])) {
		//     $form_ml->set_datos($this->s__datos['form_ml_detalle']);
		// } else {
		//
		//     if ($this->cn()->hay_cursor()) {
		//         $datos = $this->cn()->get_detalle();
		//         $this->s__datos['form_ml_detalle'] = $datos;
		//         $form_ml->set_datos($datos);
		//     }
		// }

		// //--- $form == $this->dep('form')
		//         if ($this->cn()->hay_cursor()) {
		//             $form_ml->evento('ubicacion')->set_etiqueta('Ver Ubicacion');
		//             $datos = $this->cn()->get_detalle();
		//          $form_ml->set_datos($datos);
		//          }
		//          //$this->pantalla()->set_descripcion('Recuerde Guardar los datos antes de salir');
	}

	function evt__form_ml_detalle__modificacion($datos)
	{
		$this->s__datos['form__ml_detalle'] = $datos;
		$this->cn()->procesar_filas_detalle($datos);
	}

	function evt__form_ml_detalle__ubicacion($seleccion)
	{
		$this->cn()->set_cursor_detalle($seleccion);
		$this->set_pantalla('pant_edicion');
		$this->controlador()->controlador()->pantalla()->eliminar_evento('procesar');
		$this->controlador()->controlador()->eliminar_evento('procesar');
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml_ubicacion ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_ubicacion(sagep_ei_formulario_ml $form_ml)
	{
		// if ($this->cn()->hay_cursor_detalle()) {
		//     $datos = $this->cn()->get_ubicacion();
		//     $this->s__datos['form_ml_ubicacion'] = $datos;
		//     //ei_arbol($this->s__datos['form_ml_ubicacion']);
		//     $form_ml->set_datos($datos);
		// } else {
		//     //$this->dep('form_ml_ubicacion')->colapsar();
		//     //$form_ml->desactivar_agregado_filas();
		// }


		if (isset($this->s__datos['form_ml_ubicacion'])) {
			$form_ml->set_datos($this->s__datos['form_ml_ubicacion']);
		} else {

			if ($this->cn()->hay_cursor_detalle()) {
				$datos = $this->cn()->get_ubicacion();
				$this->s__datos['form_ml_ubicacion'] = $datos;
				$form_ml->set_datos($datos);
			}
		}
	}

	function evt__form_ml_ubicacion__modificacion($datos)
	{
		// //$this->cn()->set_cursor_ubicacion($seleccion);
		// $this->s__datos['form_ml_ubicacion'] = $datos;
		// $this->cn()->procesar_filas_ubicacion($datos);

		$this->s__datos['form_ml_ubicacion'] = $datos;
		$this->cn()->procesar_filas_ubicacion($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__cancelar()
	{
		$this->set_pantalla('pant_inicial');
	}

	//-----------------------------------------------------------------------------------
	//---- Configuraciones --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__pant_edicion(toba_ei_pantalla $pantalla)
	{
		//$this->controlador()->controlador()->pantalla()->eliminar_evento('procesar');
	}

}
?>
