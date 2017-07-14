<?php
require_once('parametros/direcciones/detalle_ubicacion/dao_detalleubicacion.php');

class ci_selectorubicacion extends sagep_ci
{
  //-----------------------------------------------------------------------------------
  //---- Variables --------------------------------------------------------------------
  //-----------------------------------------------------------------------------------

  protected $s__datos_filtro;

  //-----------------------------------------------------------------------------------
  //---- Filtro -----------------------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function conf__filtro(sagep_ei_filtro $filtro)
  {
    if (isset($this->s__datos_filtro)) {
      $filtro->set_datos($this->s__datos_filtro);
    }
  }

  function evt__filtro__filtrar($datos)
  {
    $this->s__datos_filtro = $datos;
  }

  function evt__filtro__cancelar()
  {
    unset($this->s__datos_filtro);
  }

  //-----------------------------------------------------------------------------------
  //---- Cuadro -----------------------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function conf__cuadro(sagep_ei_cuadro $cuadro)
  {
    $cuadro->desactivar_modo_clave_segura();
    if (isset($this->s__datos_filtro)) {
      $filtro = $this->dep('filtro');
      $filtro->set_datos($this->s__datos_filtro);
      $sql_where = $filtro->get_sql_where();

      $datos = dao_detalleubicacion::get_listado_detalles_ubicacion($sql_where);
      $cuadro->set_datos($datos);
    }
  }
}

?>
