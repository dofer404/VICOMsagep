<?php
require_once('comunes/cache_form_ml.php');
require_once('comunes/cache_form.php');

class ci_modificarservicio extends sagep_ci
{

  //-----------------------------------------------------------------------------------
	//---- Variables --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	protected $sql_state;
	protected $s__datos = [];
	protected $cont;

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

	// form_servicios

	function get_cache_form_servicio()
	{
		$datos = [];
		if (isset($this->s__datos['form'])) {
			$datos = $this->s__datos['form'];
		}
		return $datos;
	}

	function set_cache_form_servicio(array $datos)
	{
		$this->s__datos['form'] = $datos;
	}

	function unset_datos_form_servicio()
	{
		$datos = $this->get_cache_form_servicio();
		unset($this->s__datos['form']);
	}

  //-----------------------------------------------------------------------------------
  //---- Form -------------------------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function evt__form__modificacion($datos)
  {
    $this->cn()->set_servicios($datos);
		$this->set_cache_form_servicio($datos);
  }

  function conf__form(sagep_ei_formulario $form)
  {
		$datos = $this->get_cache_form_servicio();

    if (!$datos) {
      if ($this->cn()->hay_cursor() ) {
        $datos = $this->cn()->get_servicios();
				$this->set_cache_form_servicio($datos);
      }
    }
    $form->set_datos($datos);
  }

	//-----------------------------------------------------------------------------------
	//---- form_ml_tarifa ---------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_tarifa(sagep_ei_formulario_ml $form_ml)
	{
		$cache_ml_tarifa = $this->get_cache_form_ml('form_ml_tarifa');
		$datos = $cache_ml_tarifa->get_cache();

		if(!$datos){
			if ($this->cn()->hay_cursor()) {
				$datos = $this->cn()->get_tarifa();
				$cache_ml_tarifa->set_cache($datos);
			}
		}

		$form_ml->set_datos($datos);
	}

	function evt__form_ml_tarifa__modificacion($datos)
	{
		$this->cn()->procesar_filas_tarifa($datos);
		$datos = $this->cn()->get_servicios();
		//$this->get_cache_form_ml('form_ml_tarifa')->set_cache($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- jasperreports ----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function vista_jasperreports(toba_vista_jasperreports $reporte)
	{
		// /home/marianofrezz/proyectos/toba_2_7_2/exportaciones/jasper/sagep
		$path_toba = '/home/marianofrezz/proyectos/toba_2_7_2';
		$path_reporte = $path_toba . '/exportaciones/jasper/sagep/informacion_servicio.jasper';
		$reporte->set_path_reporte($path_reporte);
		$usuario = toba::usuario()->get_nombre();
		$idServicio = $this->traer_servicio();

		$datos_servicio = $this->get_cache_form_servicio();

		//$reporte->set_parametro('idUsuarioToba', 'S', $usuario);
		$reporte->set_parametro('id_servicio', 'E', $idServicio);

		// if (!isset($this->s__datos['form']['razon_social'])) {
		// 	$nombre_archivo = '"' . $this->s__datos['form']['apellidos'] . ' ' .$this->s__datos['form']['nombres'];
		// } else {
			$nombre_archivo = '"' . $datos_servicio['nombre_serv'];
		// }
		//$cadena1 = str_replace(', ', ' ', $nombre_archivo);

		$cadena = str_replace(' ', '_', $nombre_archivo);
		$reporte->set_nombre_archivo($cadena. '.pdf');
		$bd = toba::db('sagep');
		$reporte->set_conexion($bd);
	}

	function traer_servicio()
	{
		$datos_servicio = $this->get_cache_form_servicio();

		$idServicio = $datos_servicio['id_servicio'];
		return $idServicio;
	}
}
?>
