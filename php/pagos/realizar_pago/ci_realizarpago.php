<?php
require_once('comunes/mensajes_error.php');
require_once('comunes/cache_form_ml.php');
require_once('comunes/cache_form.php');
require_once('pagos/realizar_pago/dao_realizarpago.php');


class ci_realizarpago extends sagep_ci
{
	//-----------------------------------------------------------------------------------
	//---- Variables --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	protected $sql_state;
	protected $s__datos;
	protected $valor;

	//-----------------------------------------------------------------------------------
	//---- setters y getters ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function get_cache_form_ml($nombre_ml)
	{
		if (!isset($this->s__datos[$nombre_ml])) {
			$this->s__datos[$nombre_ml] = new cache_form_ml();
		}
		return $this->s__datos[$nombre_ml];
	}

	function get_cache_form($nombre)
	{
		if (!isset($this->s__datos[$nombre])) {
			$this->s__datos[$nombre] = new cache_form();
		}
		return $this->s__datos[$nombre];
	}

	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		try {
			$this->cn()->guardar();
			$this->evt__cancelar();

		} catch (toba_error_db $e) {
			if (!mensajes_error::$debug) {
				$sql_state = $e->get_sqlstate();
				mensajes_error::get_mensaje_error($sql_state);
				throw $e;
			}
		}
	}

	function evt__cancelar()
	{
		unset($this->s__datos);
		$this->cn()->reiniciar();
		$this->set_pantalla('introduccion');
	}

	function evt__volver_contrato()
	{
		$this->set_pantalla('seleccionar_contratos');
	}

	function evt__siguiente_contrato()
	{
		$this->set_pantalla('seleccionar_pago');
	}

	function evt__anterior_pagos()
	{
		$this->set_pantalla('seleccionar_contratos');
	}

	//-----------------------------------------------------------------------------------
	//---- form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form(sagep_ei_formulario $form)
	{
		$cache_form = $this->get_cache_form('form');
		$datos = $cache_form->get_cache();

		$form->set_datos($datos);
	}

	function evt__form__modificacion($datos)
	{
		$this->get_cache_form('form')->set_cache($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- form_persona -----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_persona(sagep_ei_formulario $form)
	{
		$cache_form = $this->get_cache_form('form');
		$datos = $cache_form->get_cache();
		$form->set_datos($datos);
		$form->set_solo_lectura();
	}

	function evt__form_persona__modificacion($datos)
	{
		$this->get_cache_form('form')->set_cache($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml_contratos ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_contratos(sagep_ei_formulario_ml $form_ml)
	{
		$cache_ml_contratos= $this->get_cache_form_ml('form_ml_contratos');
		$datos = $cache_ml_contratos->get_cache();

		$datos_persona = $this->get_cache_form('form')->get_cache();
		$persona = dao_realizarpago::get_contratos($datos_persona['id_persona']);

		if (isset($persona)) {
				foreach ($persona as $key => $valor) {
					$array_cuota[] = ['id_contrato' => $persona[$key]['id_contrato']
														, 'fecha_contrato' => $persona[$key]['fecha_inicio']	];
					//	if (!isset($this->s__datos['frm_ml_detCuotas'][$clave])) {
								//$datos[$clave]['cantidad_cuota'] = '1';
						//}
						//$datos[$clave]['total'] = dao_liquidaciones_asistente::get_total_sin_recargo($valor['id_inscripcion'], $datos[$clave]['cantidad_cuota']);
				}
				//$this->s__datos['frm_detAlumnos'] = $datos;
		}
		//$datos = array_merge($persona[$key]['id_contrato'], $id_contrato);

		//$datos = array_merge($array_cuota, $id_contrato);

		if($array_cuota){
			$form_ml->set_datos($array_cuota);
		}

		//$form_ml->set_datos($datos)
		//
		//
		//
		// if(!$datos){
		// 	$datos = dao_realizarpago::get_contratos($this->s__datos['sel_grupofam']);
		//
		// 	$form_ml->set_datos($datos);
		// }
		//
		// $datos = [];
		// if (isset($this->s__datos['frm_detAlumnos'])) {
		// 		$datos = $this->s__datos['frm_detAlumnos'];
		// } else {
		// 		$datos = dao_liquidaciones_asistente::get_datos_familiares($this->s__datos['sel_grupofam']);
		// 		if (isset($datos)) {
		// 				foreach ($datos as $clave => $valor) {
		// 						if (!isset($this->s__datos['frm_ml_detCuotas'][$clave])) {
		// 								$datos[$clave]['cantidad_cuota'] = '1';
		// 						}
		// 						$datos[$clave]['total'] = dao_liquidaciones_asistente::get_total_sin_recargo($valor['id_inscripcion'], $datos[$clave]['cantidad_cuota']);
		// 				}
		// 				$this->s__datos['frm_detAlumnos'] = $datos;
		// 		}
		// }
		// foreach ($datos as $key => $value) {
		// 		$this->aux_cargarFilaDetalleInscripcion($key, true);
		// }
		// $form_ml->set_datos($datos);
	}

	function evt__form_ml_contratos__modificacion($datos)
	{
		$this->get_cache_form_ml('form_ml_contratos')->set_cache($datos);
	}

	function evt__form_ml_contratos__modificar_cuota($seleccion)
	{
		$datos_fila = $this->get_cache_form_ml('form_ml_contratos')->get_cache_fila($seleccion);
		$this->get_cache_form_ml('form_ml_contratos')->set_cache($datos_fila);
		$this->set_pantalla('seleccionar_cuotas');
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml_cuotas ---------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_cuotas(sagep_ei_formulario_ml $form_ml)
	{
		$datos_contrato = $this->get_cache_form_ml('form_ml_contratos')->get_cache();

		$id_contrato = $datos_contrato['id_contrato'];

		$datos_cuotas = dao_realizarpago::get_cuotas($id_contrato);

		$form_ml->set_datos($datos_cuotas);
	}

	function evt__form_ml_cuotas__modificacion($datos)
	{
	}

	//-----------------------------------------------------------------------------------
	//---- Auxiliares -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function ajax__get_confTiposPagos($id, toba_ajax_respuesta $respuesta)
	{
			$datos = dao_realizarpago::get_confTiposPagos($id);
			$respuesta->set($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- Configuraciones --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf()
	{
		if($this->get_id_pantalla() == 'seleccionar_contratos') {
			$this->pantalla('seleccionar_contratos')->eliminar_evento('cambiar_tab__siguiente');
		}
		if($this->get_id_pantalla() == 'seleccionar_pago') {
			$this->pantalla('seleccionar_pago')->eliminar_evento('cambiar_tab__anterior');
		}
	}

	function conf__seleccionar_cuotas(toba_ei_pantalla $pantalla)
	{
		$pantalla->eliminar_evento('cambiar_tab__anterior');
		$pantalla->eliminar_evento('cambiar_tab__siguiente');
	}

}
?>
