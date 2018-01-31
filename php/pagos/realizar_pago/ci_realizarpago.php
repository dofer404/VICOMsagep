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
		$array_meses = '';
		$cache_ml_contratos= $this->get_cache_form_ml('form_ml_contratos');
		$datos = $cache_ml_contratos->get_cache();

		$datos_persona = $this->get_cache_form('form')->get_cache();
		$contrato = dao_realizarpago::get_contratos($datos_persona['id_persona']);

		if (isset($contrato)) {
				foreach ($contrato as $key => $valor) {
					$array_meses = '';
					$cantidad_impaga=dao_realizarpago::get_cantidad_impagas($contrato[$key]['id_contrato']);
					$cuotas_impagas = dao_realizarpago::get_cuotas_impagas($contrato[$key]['id_contrato']);
					for($i=0;$i<$cantidad_impaga;$i++){
						if($array_meses == ''){
							$array_meses = $cuotas_impagas[$i]['periodo'];
						}else {
							$array_meses = $array_meses . ', ' . $cuotas_impagas[$i]['periodo'];
						}
					}
					$array_cuota[] = ['id_contrato' => $contrato[$key]['id_contrato']
														, 'fecha_contrato' => $contrato[$key]['fecha_inicio']
													, 'cuota_pendiente' => $array_meses];
				}
		}
		if($array_cuota){
			$form_ml->set_datos($array_cuota);
		}
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
		$cache_ml_contratos= $this->get_cache_form_ml('form_ml_contratos');
		$datos_contrato = $cache_ml_contratos->get_cache();

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
