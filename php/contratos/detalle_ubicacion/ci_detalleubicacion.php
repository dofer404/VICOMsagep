<?php
class ci_detalleubicacion extends sagep_ci
{

  //-----------------------------------------------------------------------------------
  //---- Variables --------------------------------------------------------------------
  //-----------------------------------------------------------------------------------

  protected $s__datos;

  //-----------------------------------------------------------------------------------
  //---- Eventos ----------------------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function evt__procesar()
  {
      $this->cn()->guardar();
      $this->cn()->cargar();
  }

  //-----------------------------------------------------------------------------------
  //---- form_ml_detalle_ubicacion ----------------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function conf__form_ml_ubicacion(sagep_ei_formulario_ml $form_ml)
  {
  //  $this->cn()->dep('dr_contratos')->tabla('dt_detalles_contrato')->set_cursor($seleccion);

  //  $this->cn()->dep('dr_detalleubicacion_detallecontrato')->tabla('dt_detalleubicacion_detallecontrato')->cargar();
$parametros = toba::memoria()->get_parametros();
ei_arbol($parametros, 'PARAMETROS recibidos');
    $form_ml->set_datos($this->cn()->dep('dr_detalleubicacion_detallecontrato')->tabla('dt_detalleubicacion_detallecontrato')->get_filas());
    //  $datos = $this->cn()->get_ubicacion();
      //$form_ml->set_datos($datos);
  }

  function evt__form_ml_ubicacion__modificacion($datos)
  {
  ei_arbol($datos);
  //  $this->s__datos['form_ml_ubicacion'] = $datos;
    $this->cn()->dep('dr_detalleubicacion_detallecontrato')->tabla('dt_detalleubicacion_detallecontrato')->procesar_filas($datos);
  }

}
?>
