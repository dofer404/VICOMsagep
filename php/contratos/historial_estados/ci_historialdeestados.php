<?php
require_once('contratos/historial_estados/dao_historialdeestados.php');

class ci_historialdeestados extends sagep_ci
{
  //-----------------------------------------------------------------------------------
  //---- Cuadro -----------------------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function conf__cuadro(sagep_ei_cuadro $cuadro)
  {
    $parametro_externo = toba::memoria()->get_parametros();

     $datos = dao_historialdestados::get_listado_estados($id_ubicacion, $id_detalle_contrato);
     $cuadro->set_datos($datos);

  }
}

?>
