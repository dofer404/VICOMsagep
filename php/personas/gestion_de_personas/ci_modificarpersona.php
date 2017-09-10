<?php
class ci_modificarpersona extends sagep_ci
{
	//-----------------------------------------------------------------------------------
	//---- Variables --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	protected $sql_state;
	protected $s__datos;
	protected $s__datos_ml_telefonos;
	
	//-----------------------------------------------------------------------------------
	//---- Form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function conf__form(form $form)
	{
		if (isset($this->s__datos['form'])) {
			$form->set_datos($this->s__datos['form']);
		} else {
			
			if ($this->cn()->hay_cursor()) {
				$datos = $this->cn()->get_personas();
				$this->s__datos['form'] = $datos;
				$form->set_datos($datos);
			}
		}
	}
	
	function evt__form__modificacion($datos)
	{
		$this->s__datos['form'] = $datos;
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
		$this->s__datos['form_ml_telefonos'] = $datos;
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
		$this->s__datos['form_ml_correos'] = $datos;
		$this->cn()->procesar_filas_correos($datos);
	}
	
	//-----------------------------------------------------------------------------------
	//---- Form_ml_direcciones ----------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function conf__form_ml_direcciones(sagep_ei_formulario_ml $form_ml)
	{
		if (isset($this->s__datos['form_ml_direcciones'])) {
			$this->controlador()->marcar_direccionSeteada();
			$form_ml->set_datos($this->s__datos['form_ml_direcciones']);
		} else {
			if ($this->cn()->hay_cursor_direcciones()) {
				$datos = $this->cn()->get_direcciones();
				$this->s__datos['form_ml_direcciones'] = $datos;
				$form_ml->set_datos($datos);
			}
		}
	}
	
	function evt__form_ml_direcciones__modificacion($datos)
	{
		$this->s__datos['form_ml_direcciones'] = $datos;
		$this->cn()->procesar_filas_direcciones($datos);
	}
	
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
		$this->s__datos['form_ml_cuentas'] = $datos;
		$this->cn()->procesar_filas_cuentas_per($datos);
	}
	
	//-----------------------------------------------------------------------------------
	//---- form_ml_direcciones ----------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function evt__form_ml_direcciones__seleccion($seleccion)
	{
		$this->s__datos['form_ml_direcciones'] = $seleccion;
		$form_ml->set_datos($seleccion);
	}
	
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