<?php
require_once('personas/listado_personas/dao_listadodepersonas.php');
require_once('mensajes_error.php');

class ci_listadodepersonas extends sagep_ci
{
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
  //---- cuadro -----------------------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function conf__cuadro(sagep_ei_cuadro $cuadro)
  {
    //$cuadro->desactivar_modo_clave_segura();
    if (isset($this->s__datos_filtro)) {
      $filtro = $this->dep('filtro');
      $filtro->set_datos($this->s__datos_filtro);
      $sql_where = $filtro->get_sql_where();

      $datos = dao_listadodepersonas::get_listado_personas($sql_where);

      $cuadro->set_datos($datos);
    }
  }
}

?>
