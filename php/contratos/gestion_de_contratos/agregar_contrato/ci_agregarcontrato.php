<?php
require_once('comunes/cache_form_ml.php');
require_once('comunes/cache_form.php');
require_once('comunes/mensajes_error.php');

class ci_agregarcontrato extends sagep_ci
{
	//-----------------------------------------------------------------------------------
	//---- setters y getters ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	// getter form_ml_cache

	function get_cache_form_ml($nombre_ml)
	{
		if (!isset($this->s__datos[$nombre_ml])) {
			$this->s__datos[$nombre_ml] = new cache_form_ml();
		}
		return $this->s__datos[$nombre_ml];
	}

	// getter form_cache

	function get_cache_form($nombre)
	{
		if (!isset($this->s__datos[$nombre])) {
			$this->s__datos[$nombre] = new cache_form();
		}
		return $this->s__datos[$nombre];
	}

	//-----------------------------------------------------------------------------------
	//---- Variables --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	protected $s__datos = [];

	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		try {
			$this->cn()->guardar();
			$this->evt__cancelar();
		} catch (toba_error_db $e) {
			if (mensajes_error::$debug) {
				// Aquí los mensajes que levantemos son para los desarrolladores ($debug == true)
				// $this->cn()->reiniciar(); tal vez no conviene reiniciar el CN si estamos haciendo debug
				$sql_state = $e->get_sqlstate();
				mensajes_error::get_mensaje_error($sql_state);
				throw $e;
			} else {
				// Aquí hay que enviarle un mensaje al usuario como último recurso
				//   Es decir, ocurrió un error inesperado al intentar guardar los datos en la base de datos.
			}
		}
	}

	function evt__cancelar()
	{
		unset($this->s__datos);
		$this->disparar_limpieza_memoria();
		$this->cn()->reiniciar();
		$this->controlador()->set_pantalla('pant_inicial');
	}

	//-----------------------------------------------------------------------------------
	//---- Form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form(sagep_ei_formulario $form)
	{
		$cantidad_meses = 0;
		$cache_form = $this->get_cache_form('form');
		$datos = $cache_form->get_cache();

		if (!$datos) {
			if ($this->cn()->hay_cursor() ) {
				$datos = $this->cn()->get_contratos();
				$cache_form->set_cache($datos);
			}
		}

		if($datos) {
			$cantidad_meses = dao_gestiondecontratos::get_cantidad_meses($datos['id_tipo_contrato']);
		}

		$monto_total = $this->dep('ci_agregardetalle')->calcular_monto($cantidad_meses);

		$datos = array_merge($datos, $monto_total);

		$form->set_datos($datos);

		$form->ef('fecha_inicio')->set_estado_defecto(date('d/m/Y'));
		//$form->ef('fecha_fin')->set_estado_defecto(date('10/01/2019'));
	}

	function evt__form__modificacion($datos)
	{
		$this->get_cache_form('form')->set_cache($datos);
		$this->cn()->set_contratos($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml_roles ----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_roles(sagep_ei_formulario_ml $form_ml)
	{
		//$array_contratante= [];

		$cache_ml_roles = $this->get_cache_form_ml('form_ml_roles');
		$datos = $cache_ml_roles->get_cache();
		$form_ml->set_datos($datos);

		// if($datos){
		// 	$form_ml->set_datos($datos);
		// } else {
		//
		// 	// $array_contratante[0] = ['id_persona' => 14
		//   //                  ,'id_rol' => 1
		// 	// 								];
		// 	//
		// 	//
		// 	// $form_ml->set_datos_defecto($array_contratante);
		// 	// //$form_ml->set_registro_nuevo($array_contratante);
		// 	// $form_ml->set_registro_nuevo();
		// }

	}

	function evt__form_ml_roles__modificacion($datos)
	{
		$this->cn()->procesar_filas_roles($datos);
		$datos = $this->cn()->get_roles();
		$this->get_cache_form_ml('form_ml_roles')->set_cache($datos);
	}


	function traer_contrato()
	{
		$idContrato = $this->s__datos['form']['id_contrato'];
		return $idContrato;
	}

	function get_detalles()
	{
		$datos = $this->cn()->get_detalle();
		return $datos;
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml_cuotas ---------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function generarArrayCuota()
	{
		$fecha_vencimiento = new DateTime();
		$array_cuota = [];
		$monto_total = 0;
		$datos = $this->cn()->get_liquidaciones();

		$datos_contrato = $this->get_cache_form('form')->get_cache();
		$datos_detalle = $this->dep('ci_agregardetalle')->get_cache_form_ml('form_ml_detalle')->get_cache();

		$cantidad_meses = dao_gestiondecontratos::get_cantidad_meses($datos_contrato['id_tipo_contrato']);

		$fecha_inicio = strtotime(str_replace('-','/', $datos_contrato['fecha_inicio']));

		$mes_inicio = getdate($fecha_inicio)['mon'] - 1;
		$anio_inicio = getdate ($fecha_inicio)['year'];
		$anio_vencimiento = $anio_inicio;
		$periodo = $anio_inicio;

		foreach ($datos_detalle as $key => $value) {
		 $monto_total += $value['monto_total'];
		}
		$monto_total=$monto_total*$cantidad_meses;

		for ($i=0; $i < $cantidad_meses; $i++) {

			$dia_vencimiento = 10;

			$mes_inicio = ($mes_inicio + 1 == 13 ? 1 : $mes_inicio + 1);

			if ($mes_inicio + 1 == 13) {
				$anio_vencimiento = $anio_vencimiento + 1;
				$fecha_vencimiento =   $anio_vencimiento. "-1-" .$dia_vencimiento;
			} else {
				$fecha_vencimiento =   $anio_vencimiento. "-" .($mes_inicio + 1). "-" .$dia_vencimiento;
			}

			$array_cuota[] = ['nro_cuota' => $i+1
											 ,'id_mes' => $mes_inicio
												, 'anio' => $periodo
												, 'fecha_vencimiento' => $fecha_vencimiento
												, 'monto' => $monto_total
											];


			if ($mes_inicio + 1 == 13) {
							$periodo = $anio_vencimiento;
				}
		}

		return $array_cuota;
	}

	function conf__form_ml_cuotas(sagep_ei_formulario_ml $form_ml)
	{
		$array_cuota = $this->generarArrayCuota();
		$form_ml->set_datos_defecto($array_cuota);
	}

	function evt__form_ml_cuotas__modificacion($datos)
	{
		$this->cn()->eliminar_cuotas();

		foreach ($datos as $key => $value) {
			$datos[$key]['apex_ei_analisis_fila'] = 'A';
		}

		$this->cn()->procesar_filas_liquidaciones($datos);
	}

}
?>
