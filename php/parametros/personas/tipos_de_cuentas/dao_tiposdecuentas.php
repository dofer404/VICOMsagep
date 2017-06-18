<?php


/**
 *
 */
class dao_tiposdecuentas
{

  static function get_listado_tipos_cuentas($where='')
  {
    if($where){
      $where_armado="WHERE $where";
    }else {
      $where_armado="";
    }

    $sql=" SELECT id_tipo_cuenta, sigla_tipocuen, nombre_tipocuen
              FROM es_sagep.tipos_cuentas

    $where_armado";

    $datos=consultar_fuente($sql);
    return $datos;
  }
}


 ?>
