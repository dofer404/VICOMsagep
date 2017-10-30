<?php

class ci_modificarcontrato extends sagep_ci
{
	//-----------------------------------------------------------------------------------
	//---- Variables --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	protected $s__datos = [];

	//-----------------------------------------------------------------------------------
	//---- Form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form(sagep_ei_formulario $form)
	{
		//$datos = $this->dep('ci_detallecontrato')->get_cache_detalle();
		$datos = $this->cn()->get_detalle();

		ei_arbol($datos);

		if (isset($this->s__datos['form'])) {
			$form->set_datos($this->s__datos['form']);
		} else {

			if ($this->cn()->hay_cursor()) {
				$datos = $this->cn()->get_contratos();
				$this->s__datos['form'] = $datos;
				$form->set_datos($datos);
			}
		}
	}

	function evt__form__modificacion($datos)
	{
		$this->s__datos['form'] = $datos;
		$this->cn()->set_contratos($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml_roles ----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_roles(sagep_ei_formulario_ml $form_ml)
	{
		if ($this->cn()->hay_cursor()) {
			$datos = $this->cn()->get_roles();
			$form_ml->set_datos($datos);
		}
	}

	function evt__form_ml_roles__modificacion($datos)
	{
		$this->s__datos['form_ml_roles'] = $datos;
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
		//$datos = $this->dep('ci_detallecontrato')->get_cache_detalle();
		$datos = $this->cn()->get_detalle();
		return $datos;
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml_detalle_ubicacion ----------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_detalle_ubicacion(sagep_ei_formulario_ml $form_ml)
	{
		if (isset($this->s__datos['form_ml_detalle_ubicacion'])) {
			$form_ml->set_datos($this->s__datos['form_ml_detalle_ubicacion']);
		} else {

			if ($this->cn()->hay_cursor_detalle()) {
				$datos = $this->cn()->get_ubicacion();
				$this->s__datos['form_ml_detalle_ubicacion'] = $datos;
				$form_ml->set_datos($datos);
			}
		}
	}

	function evt__form_ml_detalle_ubicacion__modificacion($datos)
	{
		$this->s__datos['form_ml_detalle_ubicacion'] = $datos;
		$this->cn()->procesar_filas_ubicacion($datos);
	}

}
?>
