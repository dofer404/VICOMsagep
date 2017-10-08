<?php
require_once('contratos/gestion_de_contratos/dao_gestiondecontratos.php');
require_once('comunes/cache_form_ml.php');

class ci_ubicacion extends sagep_ci
{
  //-----------------------------------------------------------------------------------
	//---- Variables ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	protected $sql_state;
	protected $s__datos;

  //-----------------------------------------------------------------------------------
	//---- setters y getters ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	// getter form_ml_cache

	function get_cache($nombre_ml)
	{
		if (!isset($this->s__datos[$nombre_ml])) {
			$this->s__datos[$nombre_ml] = new cache_form_ml();
		}
		return $this->s__datos[$nombre_ml];
	}

  // form_ubicacion

	function get_cache_form_ubicacion()
	{
		$datos = [];
		if (isset($this->s__datos['form_ubicacion'])) {
			$datos = $this->s__datos['form_ubicacion'];
		}
		return $datos;
	}

	function set_cache_form_ubicacion(array $datos)
	{
		$this->s__datos['form_ubicacion'] = $datos;
	}

	function unset_datos_form_ubicacion()
	{
		$datos = $this->get_cache_form_ubicacion();
		unset($this->s__datos['form_ubicacion']);
	}

	function unset_datos_form_estados()
	{
		$datos = $this->get_cache('form_ml_estados');
		unset($this->s__datos['form_ml_estados']);
	}

	function set_cursor_ubicacion($id_fila)
	{
		$this->s__datos['form_ubicacion.cursor'] = $id_fila;
	}

	function unset_cursor_ubicacion()
	{
		unset($this->s__datos['form_ubicacion.cursor']);
	}

	function get_cursor_ubicacion()
	{
		return $this->s__datos['form_ubicacion.cursor'];
	}

	function hay_cursor_ubicacion()
	{
		return isset($this->s__datos['form_ubicacion.cursor']);
	}

  //-----------------------------------------------------------------------------------
	//---- Auxiliares -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function procesar_cancelar_pedido_registro_nueva_ubicacion()
	{
		$this->procesar_pedido_registro_nueva_ubicacion(true);
	}

	function procesar_aceptar_pedido_registro_nueva_ubicacion()
	{
		$this->procesar_pedido_registro_nueva_ubicacion(false);
	}

	function procesar_pedido_registro_nueva_ubicacion($cancelar=false)
	{
		$ml_dets = $this->get_cache('form_ml_ubicacion');
		if ($ml_dets->hay_pedido_registro_nuevo()) {
			$ml_dets->set_pedido_registro_nuevo(false);
			if ($this->cn()->hay_cursor_ubicaciones()) {
				if ($cancelar) {
					$this->cn()->eliminar_fila_cursor_ubicacion();
				} else {
					$this->cn()->resetear_cursor_ubicaciones();
					$ml_dets->unset_cache();
				}
			}
		}
	}

  //-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__cancelar()
	{
		$this->borrar_memoria();
		unset($this->s__datos);
		$this->cn()->resetear_cursor_estados();
		$this->set_pantalla('pant_inicial');
	}

	function evt__procesar()
	{
		$this->procesar_aceptar_pedido_registro_nueva_ubicacion();
		$this->set_pantalla('pant_inicial');
	}

  //-----------------------------------------------------------------------------------
	//---- form_ml_ubicacion --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_ubicacion($form_ml)
	{

		$this->procesar_cancelar_pedido_registro_nueva_ubicacion();

		$cache_ml = $this->get_cache('form_ml_ubicacion');
		$datos = $cache_ml->get_cache();

		if (!$datos) {
			if ($this->cn()->hay_cursor_detalle()) {
				$datos = $this->cn()->get_ubicacion();
				$cache_ml->set_cache($datos);
			}
		}
		$form_ml->set_datos($datos);
		$cache_ml->set_ml_procesado();
		$this->cn()->resetear_cursor_ubicaciones();
	}

  function evt__form_ml_ubicacion__modificacion($datos)
	{
		$this->cn()->procesar_filas_ubicacion($datos);
		$datos = $this->cn()->get_ubicacion();
		$this->get_cache('form_ml_ubicacion')->set_cache($datos);
	}

  function evt__form_ml_ubicacion__ubicacion($seleccion)
  {
    $datos_fila = $this->get_cache('form_ml_ubicacion')->get_cache_fila($seleccion);
    $this->set_cache_form_ubicacion($datos_fila);

    if ($this->cn()->existe_fila_ubicacion($seleccion) ) {
      $this->cn()->set_cursor_ubicaciones($seleccion);
      $datos_ubicaciones = $this->cn()->get_estado();
      $this->get_cache('form_ml_estados')->set_cache($datos_ubicaciones);
    }
    $this->set_pantalla('pant_edicion');
  }

  function evt__form_ml_ubicacion__pedido_registro_nuevo()
  {
    $this->get_cache('form_ml_ubicacion')->set_pedido_registro_nuevo(true);
    $this->unset_datos_form_ubicacion();
    $this->unset_datos_form_estados();
    $this->set_pantalla('pant_edicion');
  }

  //-----------------------------------------------------------------------------------
	//---- form_ubicacion ---------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__form_ubicacion__modificacion($datos)
	{
		$cache_ml_dets = $this->get_cache('form_ml_ubicacion');
		if ($cache_ml_dets->hay_pedido_registro_nuevo()) {
			if (!$this->cn()->hay_cursor_ubicaciones()) {
				$id_interno_fila = $this->cn()->nueva_fila_ubicacion($datos);
				$this->cn()->set_cursor_ubicaciones($id_interno_fila);
			}
		} else {
			$this->set_cache_form_ubicacion($datos);
			if ($cache_ml_dets->hay_cursor_cache()) {
				$id_fila = $cache_ml_dets->get_cursor_cache();
				$cache_ml_dets->set_cache_fila($id_fila, $datos);
			}
		}
	}

  function conf__form_ubicacion(sagep_ei_formulario $form)
	{
		if ($this->cn()->hay_cursor_ubicaciones()) {
			$datos = $this->get_cache_form_ubicacion();
			if (!$datos) {
				$datos = $this->cn()->get_unaUbicacion();
			}
			$form->set_datos($datos);
		}
	}

  //-----------------------------------------------------------------------------------
	//---- form_ml_estados --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_estados(sagep_ei_formulario_ml $form_ml)
	{

		$cache_ml_estado = $this->get_cache('form_ml_estados');
		$datos = $cache_ml_estado->get_cache();
		if (!$datos) {
			if ($this->cn()->hay_cursor_ubicaciones() ) {
				$datos = $this->cn()->get_estado();
				$cache_ml_estado->set_cache($datos);
			}
		}
		if($datos){
			$form_ml->set_datos($datos);
		}
	}

  function evt__form_ml_estados__modificacion($datos)
	{
		$this->cn()->procesar_filas_estados($datos);
		$datos = $this->cn()->get_estado();

		$valores = $this->get_cache('form_ml_estados')->set_cache($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- Configuraciones --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__pant_edicion(toba_ei_pantalla $pantalla)
	{
    $this->controlador()->pantalla()->eliminar_evento('procesar');
    $this->controlador()->pantalla()->eliminar_evento('cancelar');
	}

  function post_eventos()
  {
    // Debemos usar este evento para setear el cursor del dt de cambio_lineas porque de lo contrario el cursor se setea muy temprano y los registros se vinculan incorrectamente
    $cache_frm_estado = $this->get_cache('form_ml_estados');
    if ($cache_frm_estado->hay_cursor_cache()) {
      $cursor = $cache_frm_estado->get_cursor_cache();
      $cache_frm_estado->unset_cursor_cache();
      $this->cn()->set_cursor_estado($cursor);
    }
  }

}
?>
