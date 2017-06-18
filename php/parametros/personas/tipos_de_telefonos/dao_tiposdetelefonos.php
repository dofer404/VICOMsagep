<?php

class dao_tiposdetelefonos{

  static function get_listado_tipos_telefonos($where='')
  {
    if ($where) {
      $where_armado="WHERE $where";
    }else {
      $where_armado="";
    }

    $sql=" SELECT id_tipo_telefono, nombre_tipotel
            FROM es_sagep.tipos_telefonos

              $where_armado";

    $datos=consultar_fuente($sql);
    return $datos;

  }
}

 ?>
