<?php
require_once('contratos/estados/dao_estados.php');

class ci_estados extends sagep_ci
{
  //-----------------------------------------------------------------------------------
  //---- Cuadro -----------------------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function conf__cuadro(sagep_ei_cuadro $cuadro)
  {
    $parametro_externo = toba::memoria()->get_parametros();
    $clave_get = array (
      'id_ubicacion' => toba::memoria()->get_parametro('ubicacion'),
      'id_detalle_contrato' => toba::memoria()->get_parametro('detalle_contrato')
    );

    $id_ubicacion = toba::memoria()->get_parametro('ubicacion');
    $id_detalle_contrato = toba::memoria()->get_parametro('detalle_contrato');

     $datos = dao_estados::get_listado_estados($id_ubicacion, $id_detalle_contrato);
     $cuadro->set_datos($datos);

  }
}

?>
