<?php


/**
 *
 */
class dao_tiposdepagos
{

  static function get_listado_tipos_pagos($where='')
  {
    if($where){
      $where_armado="WHERE $where";
    }else {
      $where_armado="";
    }

    $sql=" SELECT id_tipo_pago, nombre_tipopago, numero_comprobante, vencimiento, entidad_financiera, titular
              FROM es_sagep.tipos_pagos

    $where_armado";

    $datos=consultar_fuente($sql);
    return $datos;
  }
}


 ?>
