<?php

class dao_tiposdeestados{

  static function get_listado_tipos_estados ($where='')
  {

    if($where){
      $where_armado="WHERE $where";
    }else {
      $where_armado="";
    }

    $sql=" SELECT id_tipo_estado, nombre_tipoest
            FROM es_sagep.tipo_estado

              $where_armado";

    $datos=consultar_fuente($sql);
    return $datos;
  }
}

 ?>
