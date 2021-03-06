<?php
require_once('comunes/cache_form_ml.php');
require_once('comunes/cache_form.php');

class ci_modificarcontrato extends sagep_ci
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

	function get_cache_form_contrato()
	{
		$datos = [];
		if (isset($this->s__datos['form'])) {
			$datos = $this->s__datos['form'];
		}
		return $datos;
	}

	//-----------------------------------------------------------------------------------
	//---- Variables --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	protected $s__datos = [];

	//-----------------------------------------------------------------------------------
	//---- Auxiliares -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function activar_persona($guardado)
	{
		$datos_contrato = $this->get_cache_form('form')->get_cache();
		$contratado['id_persona'] = dao_gestiondecontratos::get_contratado($datos_contrato['id_contrato']);

		$this->cn()->cargar_persona($contratado);
		$this->cn()->set_cursor_persona($contratado);

		$datos = $this->cn()->get_datos_persona();

		if($guardado){
			$datos['activo'] = true;
		} else {
			$auxiliar = dao_gestiondecontratos::get_contrato_activo($contratado['id_persona']);
			if($auxiliar == 1) {
							$datos['activo'] = false;
			}
		}
		$this->cn()->set_persona($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- Form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form(sagep_ei_formulario $form)
	{
		$cache_form = $this->get_cache_form('form');
		$datos = $cache_form->get_cache();

		//$datos_contrato = $this->get_cache_form_contrato();

		//$idContrato = $this->traer_contrato();
		//$idContrato = $datos['id_contrato'];
		//$contratado['id_persona'] = dao_gestiondecontratos::get_contratado($idContrato);

		if (!$datos) {
			if ($this->cn()->hay_cursor() ) {
				$datos = $this->cn()->get_contratos();
				$cache_form->set_cache($datos);
			}
		}

		$idContrato = $datos['id_contrato'];
		$contratado['id_persona'] = dao_gestiondecontratos::get_contratado($idContrato);

		$cadena = str_replace(' ', '_', $contratado['id_persona']);

		$cantidad_meses = dao_gestiondecontratos::get_cantidad_meses($datos['id_tipo_contrato']);
		$monto_total = $this->dep('ci_detallecontrato')->calcular_monto($cantidad_meses);

		$datos = array_merge($datos, $monto_total);

		$form->set_datos($datos);

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
		$datos = $this->cn()->get_roles();
		$form_ml->set_datos($datos);
	}

	function evt__form_ml_roles__modificacion($datos)
	{
		$this->get_cache_form_ml('form_ml_roles')->set_cache($datos);
		$this->cn()->procesar_filas_roles($datos);

		//$this->activar_persona();
	}

	// function vista_jasperreports(toba_vista_jasperreports $reporte)
	// {
	// 	// /home/marianofrezz/proyectos/toba_2_7_2/exportaciones/jasper/sagep
	// 	$path_toba = '/home/marianofrezz/proyectos/toba_2_7_2';
	// 	$path_reporte = $path_toba . '/exportaciones/jasper/sagep/reporte_contrato.jasper';
	// 	$reporte->set_path_reporte($path_reporte);
	// 	$usuario = toba::usuario()->get_nombre();
	// 	$idContrato = $this->s__datos['form']['id_contrato'];
	//
	// 	//$reporte->set_parametro('usuarioToba', 'S', $usuario);
	// 	//$reporte->set_parametro('idPersona', 'E', $idPersona);
	//
	// 	// if (!isset($this->s__datos['form']['razon_social'])) {
	// 	// 	$nombre_archivo = '"' . $this->s__datos['form']['apellidos'] . ' ' .$this->s__datos['form']['nombres'];
	// 	// } else {
	// 	// 	$nombre_archivo = '"' . $this->s__datos['form']['razon_social'];
	// 	// }
	//
	// 	//$cadena = str_replace(' ', '_', $nombre_archivo);
	// 	$reporte->set_nombre_archivo('contrato' . '.pdf');
	// 	$bd = toba::db('sagep');
	// 	$reporte->set_conexion($bd);
	// }
	//
	// function traer_contrato()
	// {
	// 	$idContrato = $this->s__datos['form']['id_contrato'];
	// 	return $idContrato;
	// }

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
		$fecha_vencimiento = new DateTime();
		$array_cuota = [];
		$datos = $this->cn()->get_liquidaciones();

		$datos_contrato = $this->get_cache_form('form')->get_cache();

		$cantidad_meses = dao_gestiondecontratos::get_cantidad_meses($datos_contrato['id_tipo_contrato']);

		$fecha_inicio = strtotime(str_replace('-','/', $datos_contrato['fecha_inicio']));

		$mes_inicio = getdate($fecha_inicio)['mon'] - 1;
		$anio_inicio = getdate ($fecha_inicio)['year'];
		$anio_vencimiento = $anio_inicio;
		$periodo = $anio_inicio;

		for ($i=0; $i < $cantidad_meses; $i++) {

			$dia_vencimiento = 10;

			$mes_inicio = ($mes_inicio + 1 == 13 ? 1 : $mes_inicio + 1);

			if ($mes_inicio + 1 == 13) {
				$anio_vencimiento = $anio_vencimiento + 1;
				$fecha_vencimiento =   $anio_vencimiento. "-1-" .$dia_vencimiento;
			} else {
				$fecha_vencimiento =   $anio_vencimiento. "-" .($mes_inicio + 1). "-" .$dia_vencimiento;
			}

			$monto = $datos_contrato['monto_total'] / $cantidad_meses;

			// if ($mes_inicio + 1 == 13) {
			// 	$fecha_vencimiento =   $anio_vencimiento. "-1-" .$dia_vencimiento;
			// } else {
			// 	$fecha_vencimiento =   $anio_vencimiento. "-" .($mes_inicio + 1). "-" .$dia_vencimiento;
			// }

			$array_cuota[] = ['nro_cuota' => $i+1
		                   ,'id_mes' => $mes_inicio
										 		, 'anio' => $periodo
												, 'fecha_vencimiento' => $fecha_vencimiento
												, 'monto' => $monto
												//, 'pago' => val5
											];

			if ($mes_inicio + 1 == 13) {
							$periodo = $anio_vencimiento;
				}
		}

		$form_ml->set_datos_defecto($array_cuota);

	}

	function evt__form_ml_cuotas__modificacion($datos)
	{
		foreach ($datos as $key => $value) {
			$datos[$key]['apex_ei_analisis_fila'] = 'A';
		}

		$this->cn()->procesar_filas_liquidaciones($datos);
		$datos = $this->cn()->get_liquidaciones();

		$this->get_cache_form_ml('form_ml_cuotas')->set_cache($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- jasperreports ----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function vista_jasperreports(toba_vista_jasperreports $reporte)
	{
		// /home/marianofrezz/proyectos/toba_2_7_2/exportaciones/jasper/sagep
		$path_toba = '/home/marianofrezz/proyectos/toba_2_7_2';
		$path_reporte = $path_toba . '/exportaciones/jasper/sagep/informacion_contrato.jasper';
		$reporte->set_path_reporte($path_reporte);
		$usuario = toba::usuario()->get_nombre();
		$idContrato = $this->traer_contrato();
		$contratado['id_persona'] = dao_gestiondecontratos::get_contratado($idContrato);

		//$reporte->set_parametro('idUsuarioToba', 'S', $usuario);
		$reporte->set_parametro('id_contrato', 'E', $idContrato);

		// if (!isset($this->s__datos['form']['razon_social'])) {
		// 	$nombre_archivo = '"' . $this->s__datos['form']['apellidos'] . ' ' .$this->s__datos['form']['nombres'];
		// } else {
			$nombre_archivo = '"' . $contratado['id_persona'];
		// }
		$cadena1 = str_replace(', ', ' ', $nombre_archivo);

		$cadena = str_replace(' ', '_', $cadena1);
		$reporte->set_nombre_archivo($cadena. '.pdf');
		$bd = toba::db('sagep');
		$reporte->set_conexion($bd);
	}

	function traer_contrato()
	{
		$datos_contrato = $this->get_cache_form('form')->get_cache();
		$idContrato = $datos_contrato['id_contrato'];
		return $idContrato;
	}

}
?>
