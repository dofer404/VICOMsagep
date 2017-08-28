<?php

require_once('parametros/direcciones/paises/dao_paises.php');


class dao_provincias{

  static function get_listado_provincias ($where='')
  {

    if($where){
      $where_armado="WHERE $where";
    }else {
      $where_armado="";
    }

    $sql=" SELECT
              pais.id_pais,
	            prov.id_provincia,
            	pais.nombre_pais,
            	prov.sigla_prov,
            	prov.nombre_prov
            FROM es_sagep.provincias prov
            JOIN es_sagep.pais pais ON prov.id_pais=pais.id_pais
              $where_armado";

    $datos=consultar_fuente($sql);
    return $datos;
  }

  static function get_paises()
  {
    return dao_paises::get_listado_paises();
  }

  static function get_descripcionPopUpPais($id_pais)
  {

  $id_pais = quote($id_pais);
    $sql = "SELECT
              pais.nombre_pais
            FROM
              es_sagep.pais pais
            WHERE
              pais.id_pais = $id_pais";

    $resultado = consultar_fuente($sql);

  if (count($resultado) > 0) {
      return $resultado[0]['nombre_pais'];
  } else {
      return 'Falló. Intente nuevamente';
  }

  }

}
