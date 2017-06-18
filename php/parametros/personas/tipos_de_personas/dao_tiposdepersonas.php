<?php

class dao_tiposdepersonas {

  static function get_listado_tipos_personas($where=''){

    if ($where) {
      $where_armado="WHERE $where";
    }else {
      $where_armado="";
    }

    $sql=" SELECT id_tipo_persona, nombre_tipoper, razon_social, nombres_per, apellidos_per, fecha_nacimiento, documento
            FROM es_sagep.tipos_personas

              $where_armado";

    $datos=consultar_fuente($sql);
    return $datos;
  }
}
 ?>
