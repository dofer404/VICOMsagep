<?php


/**
 *
 */
class dao_entidadesfinancieras
{

  static function get_listado_entidades_financieras ($where='')
  {
    if($where){
      $where_armado="WHERE $where";
    }else {
      $where_armado="";
    }

    $sql=" SELECT id_entidad_financiera, nombre_enfi
              FROM es_sagep.entidades_financieras

    $where_armado";

    $datos=consultar_fuente($sql);
    return $datos;
  }
}


 ?>
