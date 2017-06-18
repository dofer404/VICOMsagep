<?php

class dao_tiposdedocumentos{

  static function get_listado_tipos_documentos ($where='')
  {

    if($where){
      $where_armado="WHERE $where";
    }else {
      $where_armado="";
    }

    $sql=" SELECT id_tipo_documento, sigla_tipodoc, nombre_tipodoc
            FROM es_sagep.tipos_documentos

              $where_armado";

    $datos=consultar_fuente($sql);
    return $datos;
  }
}

 ?>
