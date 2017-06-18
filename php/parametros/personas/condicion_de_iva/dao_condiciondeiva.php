<?php

class dao_condiciondeiva{

  static function get_listado_condicion_iva ($where='')
  {

    if($where){
      $where_armado="WHERE $where";
    }else {
      $where_armado="";
    }

    $sql=" SELECT id_iva, sigla_coniva, nombre_coniva
            FROM es_sagep.condicion_iva

              $where_armado";

    $datos=consultar_fuente($sql);
    return $datos;
  }
}

 ?>
