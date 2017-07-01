<?php
class ci_detallesdecontrato extends sagep_ci
{
  protected $s__datos;
	protected $s__datos_filtro;
  public $fila0;

  //-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

  function evt__nuevo()
	{
		$this->set_pantalla('pant_edicion');
	}

  function evt__procesar()
	{
    try {
      $this->cn()->sincronizar();
      $this->cn()->resetear();
      $this->evt__volver();
    } catch (toba_error_db $e) {
			$this->cn()->resetear();
      if (adebug::$debug) {
        throw $e;
      } else {
        toba::notificacion()->agregar('No se guardó. Intente nuevamente mas tarde', 'error');
      }
    }
	}

  function evt__volver()
  {
    unset($this->s__datos);
    //$this->dep('ci_modificarcontrato')->disparar_limpieza_memoria();
    $this->cn()->resetear();
    $this->set_pantalla('pant_inicial');
  }

  //-----------------------------------------------------------------------------------
  //---- form_ml_detalle --------------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function evt__form_ml_detalle__modificacion($datos)
  {
    $this->s__datos['form_ml_detalle']= $datos;
    $this->cn()->procesar_filas_detalle($datos);
  }

  function conf__form_ml_detalle(sagep_ei_formulario_ml $form_ml)
  {

    if (isset($this->s__datos)) {
      $form_ml->set_datos($this->s__datos);
    }

    if ($this->cn()->hay_cursor()) {
      $datos = $this->cn()->get_detalle();
      $form_ml->set_datos($datos);
    }
  }

  function evt__form_ml_detalle__edicion($seleccion)
  {
    //$this->cn()->cargar_detalle()[$seleccion]['id_contrato']['id_servicio'];
    //$this->cn()->dep('dr_contratos')->tabla('dt_detalles_contrato')->cargar($seleccion);
    $this->cn()->dep('dr_contratos')->tabla('dt_detalles_contrato')->set_cursor($seleccion);
    //$this->cn()->set_cursor_detalle($seleccion);
    $this->cn()->get_unDetalle();
    // $this->cn()->set_cursor_detalle($seleccion['id_contrato']['id_servicio']);

  //  ei_arbol($seleccion);
    $this->set_pantalla('pant_edicion');
  }

	//-----------------------------------------------------------------------------------
	//---- form_detalle -----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_detalle(sagep_ei_formulario $form)
	{
        if ($this->cn()->hay_cursor()) {
          $datos = $this->cn()->get_unDetalle();
          ei_arbol($datos);
          $form->set_datos($datos);
          // if (isset($datos)) {
    			// 	$form->set_datos($datos);
    			// } else {
          //   if (isset($this->s__datos['form_detalle'])) {
          //     $form->set_datos($this->s__datos['form_detalle']);
          //   }
          // }
	       }
    }

	function evt__form_detalle__modificacion($seleccion)
	{
  //  $seleccion = $this->cn()->get_unDetalled();
    $this->cn()->set_cursor_detalle($seleccion);
    //ei_arbol($seleccion);
    $this->set_pantalla('pant_edicion');
	}

}
?>
