<?php

class dao_tiposdecorreos{

  static function get_listado_tipos_correos ($where='')
  {

    if($where){
      $where_armado="WHERE $where";
    }else {
      $where_armado="";
    }

    $sql=" SELECT id_tipo_correo, nombre_tipocor
            FROM es_sagep.tipos_correos

              $where_armado";

    $datos=consultar_fuente($sql);
    return $datos;
  }
}

 ?>
