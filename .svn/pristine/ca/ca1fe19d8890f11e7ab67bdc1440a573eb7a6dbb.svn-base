<?php

class dao_paises{

  static function get_listado_paises ($where='')
  {

    if($where){
      $where_armado="WHERE $where";
    }else {
      $where_armado="";
    }

    $sql=" SELECT id_pais, sigla_pais, nombre_pais
            FROM es_sagep.pais

              $where_armado";

    $datos=consultar_fuente($sql);
    return $datos;
  }
}
