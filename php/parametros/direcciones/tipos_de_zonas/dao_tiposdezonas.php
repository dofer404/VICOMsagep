<?php

class dao_tiposdezonas{

  static function get_listado_tipos_zonas ($where='')
  {

    if($where){
      $where_armado="WHERE $where";
    }else {
      $where_armado="";
    }

    $sql=" SELECT id_tipo_zona, sigla_tipozona, nombre_tipozona, descripcion, mapa
            FROM es_sagep.tipos_zonas

              $where_armado";

    $datos=consultar_fuente($sql);
    return $datos;
  }
}

 ?>
