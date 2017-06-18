<?php

class dao_rol{

  static function get_listado_roles ($where='')
  {

    if($where){
      $where_armado="WHERE $where";
    }else {
      $where_armado="";
    }

    $sql=" SELECT id_rol, nombre_rol
            FROM es_sagep.rol

              $where_armado";

    $datos=consultar_fuente($sql);
    return $datos;
  }
}

 ?>
