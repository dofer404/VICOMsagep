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
	protected  $guardado = 0;

	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
			try {
				$this->cn()->guardar();
				$this->guardado=1;
				//$this->evt__cancelar();
			} catch (toba_error_db $e) {
				if (!mensajes_error::$debug) {
					$this->cn()->reiniciar();
					$sql_state = $e->get_sqlstate();
					mensajes_error::get_mensaje_error($sql_state);
					throw $e;
				} else {
					throw $e;

					$this->cn()->debug_arbol_datos_en_cache_cn();
				}
			}

			$this->guardado=2;
			//$modo = $this->cambiar_modo(true);
			// $this->pantalla()->evento('imprimir')->mostrar();
			// $this->pantalla()->eliminar_evento('cambiar_tab__anterior');
			// $this->pantalla()->eliminar_evento('cancelar');
			// $this->pantalla()->evento('procesar')->set_etiqueta('Guardar');
			//$this->evt__cancelar();

	}

	function evt__aceptar()
	{
			try {
				$this->evt__cancelar();
			} catch (toba_error_db $e) {
				if (!mensajes_error::$debug) {
					$this->cn()->reiniciar();
					$sql_state = $e->get_sqlstate();
					mensajes_error::get_mensaje_error($sql_state);
					throw $e;
				} else {
					throw $e;

					$this->cn()->debug_arbol_datos_en_cache_cn();
				}
			}
			//$modo = $this->cambiar_modo(true);
			// $this->pantalla()->evento('imprimir')->mostrar();
			// $this->pantalla()->eliminar_evento('cambiar_tab__anterior');
			// $this->pantalla()->eliminar_evento('cancelar');
			// $this->pantalla()->evento('procesar')->set_etiqueta('Guardar');
			//$this->evt__cancelar();

	}

	function cambiar_modo($valor)
	{
		if($valor){
			return 0;
		} else {
			return 1;
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

		//$fecha_inicio = date('d/m/Y');
		//$fecha_fin = $this->calcular_fecha_fin($fecha_inicio, $cantidad_meses);

		$datos = array_merge($datos, $monto_total);

		$form->set_datos($datos);

		$form->ef('fecha_inicio')->set_estado_defecto(date('d/m/Y'));
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
		$cache_ml_roles = $this->get_cache_form_ml('form_ml_roles');
		$datos = $cache_ml_roles->get_cache();
		$form_ml->set_datos($datos);
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

	function conf__form_ml_cuotas(sagep_ei_formulario_ml $form_ml)
	{
		$array_cuota = $this->generarPeriodos();
		$form_ml->set_datos_defecto($array_cuota);
	}

	function evt__form_ml_cuotas__modificacion($datos)
	{
		$this->cn()->eliminar_liquidaciones();
		foreach ($datos as $key => $value) {
			$datos[$key]['apex_ei_analisis_fila'] = 'A';
		}

		$this->cn()->procesar_filas_liquidaciones($datos);
	}


		//-----------------------------------------------------------------------------------
		//---- form_cuotas ------------------------------------------------------------------
		//-----------------------------------------------------------------------------------

		function conf__form_cuotas(sagep_ei_formulario $form)
		{
			$array_monto = [];
			$monto_total = 0;

			$datos_contrato = $this->get_cache_form('form')->get_cache();
			$datos_detalle = $this->dep('ci_agregardetalle')->get_cache_form_ml('form_ml_detalle')->get_cache();
			$cantidad_meses = dao_gestiondecontratos::get_cantidad_meses($datos_contrato['id_tipo_contrato']);


			foreach ($datos_detalle as $key => $value) {
			 $monto_total += $value['monto_total'];
			}
			$monto_total=$monto_total;

			$array_monto = ['cantidad' => $cantidad_meses
											, 'monto' => $monto_total
											];

			$form->set_datos($array_monto);
		}


	//-----------------------------------------------------------------------------------
	//---- Auxiliares -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function calcular_fecha_fin($fecha_ini, $cantidad_meses)
	{
		$fecha_inicio = date('d/m/Y');

		$mes_inicio = getdate($fecha_inicio)['mon'] - 1;
		$anio = getdate ($fecha_inicio)['year'];
		$dia_inicio = getdate($fecha_inicio)['wday'];
		$mes_fin = $mes_inicio;
		$anio_vencimiento = $anio;
		$mes_inicio = ($mes_inicio + 1 == 13 ? 1 : $mes_inicio + 1);

		$i=0;
		while($i < $cantidad_meses) {
			$mes_fin = ($mes_fin + 1 == 13 ? 1 : $mes_fin + 1);
			$fecha_vencimiento_fin =   $anio. "-" .($mes_fin). "-" .$dia_inicio;
			//$i=$i+1;


			if ($mes_fin + 1 == 13) {
				$anio = $anio + 1;
				$fecha_vencimiento_fin =   $anio. "-" .$mes_fin. "-" .$dia_inicio;
			} else {
				$fecha_vencimiento_fin =   $anio. "-" .$mes_fin. "-" .$dia_inicio;
			}
			$i=$i+1;
		}
	}

	function generarPeriodos ()
	{
		$array_cuota = [];

		$datos_contrato = $this->get_cache_form('form')->get_cache();
		$datos_detalle = $this->dep('ci_agregardetalle')->get_cache_form_ml('form_ml_detalle')->get_cache();
		$cantidad_meses = dao_gestiondecontratos::get_cantidad_meses($datos_contrato['id_tipo_contrato']);

		$fecha_inicio = strtotime(str_replace('-','/', $datos_contrato['fecha_inicio']));
		$mes_inicio = getdate($fecha_inicio)['mon'] - 1;
		$anio_inicio = getdate ($fecha_inicio)['year'];
		$mes_fin = $mes_inicio;

		$anio_vencimiento = $anio_inicio;
		$mes_inicio = ($mes_inicio + 1 == 13 ? 1 : $mes_inicio + 1);
		$dia_vencimiento = 10;

		if ($mes_inicio + 1 == 13) {
			$anio_vencimiento = $anio_vencimiento + 1;
			$fecha_vencimiento_inicio =   $anio_vencimiento. "-1-" .$dia_vencimiento;
		} else {
			$fecha_vencimiento_inicio =   $anio_vencimiento. "-" .($mes_inicio + 1). "-" .$dia_vencimiento;
		}

		$i=0;
		while($i < $cantidad_meses) {
			$mes_fin = ($mes_fin + 1 == 13 ? 1 : $mes_fin + 1);

			if ($mes_fin + 1 == 13) {
				$anio_vencimiento = $anio_vencimiento + 1;
				$fecha_vencimiento_fin =   $anio_vencimiento. "-1-" .$dia_vencimiento;
			} else {
				$fecha_vencimiento_fin =   $anio_vencimiento. "-" .($mes_fin + 1). "-" .$dia_vencimiento;
			}
			$i=$i+1;
		}

		$periodo_i = dao_gestiondecontratos::get_mes($mes_inicio);
		$periodo_inicio = $periodo_i. " " .$anio_inicio;

		$periodo_f = dao_gestiondecontratos::get_mes($mes_fin);
		$periodo_fin = $periodo_f. " " .$anio_vencimiento;


		$array_cuota[0] = ['descripcion' => 'Inicio'
										, 'id_mes' => 'Inicio: ' .$periodo_inicio
										, 'anio' => $anio_inicio
										, 'fecha_vencimiento' => 'Vencimiento Primer Cuota: ' .$fecha_vencimiento_inicio
										];

		$array_cuota[1] = ['descripcion' => 'Fin'
										, 'id_mes' => 'Fin: ' .$periodo_fin
										, 'anio' => $anio_vencimiento
										, 'fecha_vencimiento' => 'Vencimiento Ultima Cuota: ' .$fecha_vencimiento_fin
										];

		return $array_cuota;
	}

	function generarArrayCuota ()
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
		$monto_total=$monto_total;

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

// ----------------------Pantalla Resumen ---------------------------------------------

	//-----------------------------------------------------------------------------------
	//---- form_contrato ----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_contrato(sagep_ei_formulario $form)
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
	}

	//-----------------------------------------------------------------------------------
	//---- form_resumen_roles -----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_resumen_roles(sagep_ei_formulario_ml $form_ml)
	{
		$datos_roles = $this->get_cache_form_ml('form_ml_roles')->get_cache();
		$form_ml->set_datos($datos_roles);
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml_ubicacion ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_ubicacion(sagep_ei_formulario_ml $form_ml)
	{
		$tabla_ubicaciones = $this->cn()->dep('dr_contratos')->tabla('dt_detalleubicacion_detallecontrato');
		$cache_cn_detalles = $this->cn()->get_detalle();
		$datos = [];
		foreach ($cache_cn_detalles as $detalle) {
			$this->cn()->set_cursor_detalle($detalle ['x_dbr_clave']);
			$id_servicio = ['id_servicio'=>$detalle['id_servicio']];
			$dato_servicio = dao_gestiondecontratos::get_servicio_detalle($detalle['id_servicio']);
			$servicio = ['id_servicio'=>$dato_servicio['servicio']];
			$filas_ubics_detalle = $this->cn()->get_ubicacion();
		 	foreach ($filas_ubics_detalle as $ubicacion) {
		 		unset ($ubicacion['x_dbr_clave']);
				$datos[] = array_merge($servicio, $ubicacion);
		 	}
		 }

		 		$form_ml->set_datos($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- Configuraciones --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	// function conf__liquidaciones(toba_ei_pantalla $pantalla)
	// {
	// 	$pantalla->set_descripcion("Liquidaciones <br/>
	// 	 <br/> <li>Cuotas que se generan</li>
  //                         <li>Presione \"Siguiente\" para continuar o \"Cancelar\" para anular la operación </li>
	// 												<div style = 'text-align:right'>Nota: Presione \"Anterior\" para volver a la Pantalla Anterior </div> ");
	// }

	function conf__resumen(toba_ei_pantalla $pantalla)
	{
		if($this->guardado){
			$pantalla->evento('imprimir')->mostrar();
			$pantalla->evento('aceptar')->mostrar();
			$this->pantalla()->eliminar_evento('cambiar_tab__anterior');
			$this->pantalla()->eliminar_evento('cancelar');
			$this->pantalla()->eliminar_evento('procesar');
		} else {
			$pantalla->evento('imprimir')->ocultar();
			$pantalla->evento('aceptar')->ocultar();
		}

	 	$this->pantalla()->set_descripcion("Resumen <br/>
	 <br/> <li>Resumen del Contrato</li>
                      <li>Presione \"Siguiente\" para continuar o \"Cancelar\" para anular la operación </li>
													<div style = 'text-align:right'>Nota: Presione \"Anterior\" para volver a la Pantalla Anterior </div> ");
	}

	// function conf__contrato(toba_ei_pantalla $pantalla)
	// {
	// 	$this->controlador()->pantalla()->set_descripcion("Liquidaciones <br/>
	// 	 <br/> <li>Cuotas que se generan</li>
  //                         <li>Presione \"Siguiente\" para continuar o \"Cancelar\" para anular la operación </li>
	// 												<div style = 'text-align:right'>Nota: Presione \"Anterior\" para volver a la Pantalla Anterior </div> ");
	// }

	function conf()
	{
		if($this->pantalla()->get_etiqueta() == 'Contrato'){
			$this->pantalla()->set_descripcion("Ingrese Datos del Contrato  <br/>
			<br/> <li>En cada ítem, se brinda una ayuda para la carga</li>
                          <li>Presione \"Agregar\" para ingresar un nuevo Rol</li>
                          <li>Presione \"Siguiente\" para continuar o \"Cancelar\" para anular la operación </li>
													<div style = 'text-align:right'>Nota: Presione \"Anterior\" para volver a la Pantalla Inicial </div> ");
		}

		if($this->pantalla()->get_etiqueta() == 'Detalle de Contrato'){
			$this->pantalla()->set_descripcion("Ingrese Detalles del Contrato <br/>
			 <br/> <li>Presione \"Agregar\" para ingresar un Nuevo Detalle</li>
														<li>Presione \"Siguiente\" para continuar o \"Cancelar\" para anular la operación </li>
														<div style = 'text-align:right'>Nota: Presione \"Anterior\" para volver a la Pantalla Anterior </div> ");
		}

		if($this->dep('ci_agregardetalle')->pantalla()->get_etiqueta() == 'Ubicaciones'){
			$this->pantalla()->set_descripcion("Ingrese un Detalle <br/>
			 <br/> <li>En cada ítem, se brinda una ayuda para la carga</li>
			 <li>Presione \"Agregar\" para ingresar un Nueva Ubicación</li>
	                          <li>Presione \"Aceptar\" para confirmar o \"Volver\" para ir a la Pantalla Anterior </li> ");

		}
		if($this->pantalla()->get_etiqueta() == 'Cuotas'){
			$this->pantalla()->set_descripcion("Liquidaciones <br/>
			 <br/> <li>Cuotas que se generan</li>
	                          <li>Presione \"Siguiente\" para continuar o \"Cancelar\" para anular la operación </li>
														<div style = 'text-align:right'>Nota: Presione \"Anterior\" para volver a la Pantalla Anterior </div> ");

		}
		if($this->dep('ci_agregardetalle')->dep('ci_agregarubicacion')->pantalla()->get_etiqueta() == 'Pantalla Edición'){
			$this->pantalla()->set_descripcion("Ingrese Ubicación <br/>
			 <br/>  <li>En cada ítem, se brinda una ayuda para la carga</li>
		 <li>Presione \"Siguiente\" para continuar o \"Volver\" para ir a la Pantalla Anterior </li>");

		}
	}



}
?>
