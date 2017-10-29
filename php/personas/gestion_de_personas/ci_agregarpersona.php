<?php

require_once('comunes/cache_form.php');
require_once('comunes/cache_form_ml.php');

class ci_agregarpersona extends sagep_ci
{
	//-----------------------------------------------------------------------------------
	//---- Variables --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	protected $sql_state;
	protected $s__datos;

	//-----------------------------------------------------------------------------------
	//---- setters y getters ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function get_cache_form($nombre)
	{
		if (!isset($this->s__datos[$nombre])) {
			$this->s__datos[$nombre] = new cache_form();
		}
		return $this->s__datos[$nombre];
	}

	function get_cache_form_ml($nombre_ml)
	{
		if (!isset($this->s__datos[$nombre_ml])) {
			$this->s__datos[$nombre_ml] = new cache_form_ml();
		}
		return $this->s__datos[$nombre_ml];
	}

	//-----------------------------------------------------------------------------------
	//---- Form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form(form $form)
	{
		$cache_form = $this->get_cache_form('form');
		$datos = $cache_form->get_cache();
		if (!$datos) {
			if ($this->cn()->hay_cursor() ) {
				$datos = $this->cn()->get_personas();
				$cache_form->set_cache($datos);
			}
		}
		$form->set_datos($datos);
	}

	function evt__form__modificacion($datos)
	{
		$this->get_cache_form('form')->set_cache($datos);
		$this->cn()->set_personas($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- Form_ml_telefonos ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_telefonos(sagep_ei_formulario_ml $form_ml)
	{
		$datos = $this->cn()->get_telefonos();
		$form_ml->set_datos($datos);
	}

	function evt__form_ml_telefonos__modificacion($datos)
	{
		$this->get_cache_form_ml('form_ml_telefonos')->set_cache($datos);
		$this->cn()->procesar_filas_telefonos($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- Form_ml_correos --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_correos(sagep_ei_formulario_ml $form_ml)
	{
		$datos = $this->cn()->get_correos();
		$form_ml->set_datos($datos);
	}

	function evt__form_ml_correos__modificacion($datos)
	{
		$this->get_cache_form_ml('form_ml_correos')->set_cache($datos);
		$this->cn()->procesar_filas_correos($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- Form_ml_direcciones ----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_direcciones(sagep_ei_formulario_ml $form_ml)
	{
		$cache_form_ml_direcciones = $this->get_cache_form_ml('form_ml_direcciones');
		$datos = $cache_form_ml_direcciones->get_cache();

		if (!$datos) {
			if ($this->cn()->hay_cursor_direcciones() ) {
				$datos = $this->cn()->get_direcciones();
				$cache_form_ml_direcciones->set_cache($datos);
			}
		} else {
			$this->controlador()->marcar_direccionSeteada();
		}
		if($datos){
			$form_ml->set_datos($datos);
		}
	}

	function evt__form_ml_direcciones__modificacion($datos)
	{
		$this->cn()->procesar_filas_direcciones($datos);
		$datos = $this->cn()->get_direcciones();
		$this->get_cache_form_ml('form_ml_direcciones')->set_cache($datos);
	}

	// function evt__form_ml_direcciones__seleccion($seleccion)
	// {
	// 	$this->s__datos['form_ml_direcciones'] = $seleccion;
	// 	$form_ml->set_datos($seleccion);
	// }

	//-----------------------------------------------------------------------------------
	//---- Form_ml_cuentas --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_cuentas(sagep_ei_formulario_ml $form_ml)
	{
		$datos = $this->cn()->get_cuentas_per();
		$form_ml->set_datos($datos);
	}

	function evt__form_ml_cuentas__modificacion($datos)
	{
		$this->get_cache_form_ml('form_ml_cuentas')->set_cache($datos);
		$this->cn()->procesar_filas_cuentas_per($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- jasperreports ----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function vista_jasperreports(toba_vista_jasperreports $reporte)
	{
		// /home/marianofrezz/proyectos/toba_2_7_2/exportaciones/jasper/sagep
		$path_toba = '/home/marianofrezz/proyectos/toba_2_7_2';
		$path_reporte = $path_toba . '/exportaciones/jasper/sagep/reporte_personas.jasper';
		$reporte->set_path_reporte($path_reporte);
		$usuario = toba::usuario()->get_nombre();
		$idPersona = $this->s__datos['form']['id_persona'];

		$reporte->set_parametro('usuarioToba', 'S', $usuario);
		$reporte->set_parametro('idPersona', 'E', $idPersona);

		if (!isset($this->s__datos['form']['razon_social'])) {
			$nombre_archivo = '"' . $this->s__datos['form']['apellidos'] . ' ' .$this->s__datos['form']['nombres'];
		} else {
			$nombre_archivo = '"' . $this->s__datos['form']['razon_social'];
		}

		$cadena = str_replace(' ', '_', $nombre_archivo);
		$reporte->set_nombre_archivo($cadena . '.pdf');
		$bd = toba::db('sagep');
		$reporte->set_conexion($bd);
	}

	function traer_persona()
	{
		$idPersona = $this->s__datos['form']['id_persona'];
		return $idPersona;
	}

}
?>
