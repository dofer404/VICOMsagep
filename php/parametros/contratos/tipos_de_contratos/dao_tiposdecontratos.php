<?php

class dao_tiposdecontratos{

  static function get_listado_tipos_contratos ($where='')
  {

    if($where){
      $where_armado="WHERE $where";
    }else {
      $where_armado="";
    }

    $sql=" SELECT id_tipo_contrato, nombre_tipocon, descripcion, cantidad
            FROM es_sagep.tipos_contratos

              $where_armado";

    $datos=consultar_fuente($sql);
    return $datos;
  }
}

 ?>
