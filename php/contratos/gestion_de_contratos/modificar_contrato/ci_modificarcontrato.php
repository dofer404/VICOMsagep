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

	//-----------------------------------------------------------------------------------
	//---- Variables --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	protected $s__datos = [];

	//-----------------------------------------------------------------------------------
	//---- Form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form(sagep_ei_formulario $form)
	{
		$cache_form = $this->get_cache_form('form');
		$datos = $cache_form->get_cache();
		if (!$datos) {
			if ($this->cn()->hay_cursor() ) {
				$datos = $this->cn()->get_contratos();
				$cache_form->set_cache($datos);
			}
		}
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
	}

	function vista_jasperreports(toba_vista_jasperreports $reporte)
	{
		// /home/marianofrezz/proyectos/toba_2_7_2/exportaciones/jasper/sagep
		$path_toba = '/home/marianofrezz/proyectos/toba_2_7_2';
		$path_reporte = $path_toba . '/exportaciones/jasper/sagep/reporte_contrato.jasper';
		$reporte->set_path_reporte($path_reporte);
		$usuario = toba::usuario()->get_nombre();
		$idContrato = $this->s__datos['form']['id_contrato'];

		//$reporte->set_parametro('usuarioToba', 'S', $usuario);
		//$reporte->set_parametro('idPersona', 'E', $idPersona);

		// if (!isset($this->s__datos['form']['razon_social'])) {
		// 	$nombre_archivo = '"' . $this->s__datos['form']['apellidos'] . ' ' .$this->s__datos['form']['nombres'];
		// } else {
		// 	$nombre_archivo = '"' . $this->s__datos['form']['razon_social'];
		// }

		//$cadena = str_replace(' ', '_', $nombre_archivo);
		$reporte->set_nombre_archivo('contrato' . '.pdf');
		$bd = toba::db('sagep');
		$reporte->set_conexion($bd);
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
	//---- form_ml_detalle_ubicacion ----------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_detalle_ubicacion(sagep_ei_formulario_ml $form_ml)
	{
		$cache_form_ml_detalle_ubicacion = $this->get_cache_form_ml('form_ml_detalle_ubicacion');
		$datos = $cache_form_ml_detalle_ubicacion->get_cache();

		if (!$datos) {
			if ($this->cn()->hay_cursor_detalle() ) {
				$datos = $this->cn()->get_ubicacion();
				$cache_form_ml_detalle_ubicacion->set_cache($datos);
			}
		}
		if($datos){
			$form_ml->set_datos($datos);
		}
	}

	function evt__form_ml_detalle_ubicacion__modificacion($datos)
	{
		$this->get_cache_form_ml('form_ml_detalle_ubicacion')->set_cache($datos);
		$this->cn()->procesar_filas_ubicacion($datos);
	}

}
?>
