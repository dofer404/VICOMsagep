<?php

require_once('parametros/direcciones/provincias/dao_provincias.php');


class dao_localidades{

  static function get_listado_localidades ($where='')
  {

    if($where){
      $where_armado="WHERE $where";
    }else {
      $where_armado="";
    }

    $sql=" SELECT
              loc.id_localidad,
	            prov.id_provincia,
              pais.id_pais,
              loc.nombre_loc ||', '|| prov.nombre_prov localidad_provincia,
              prov.nombre_prov,
              pais.nombre_pais,
            	loc.nombre_loc,
            	loc.sigla_loc,
              loc.codigo_postal
            FROM es_sagep.localidades loc
            JOIN es_sagep.provincias  prov ON loc.id_provincia=prov.id_provincia
            JOIN es_sagep.pais pais ON pais.id_pais=prov.id_pais
              $where_armado";

    $datos=consultar_fuente($sql);
    return $datos;
  }

  static function get_idsExtPais($id_provincia)
  {
    $id_provincia = quote($id_provincia);

    $sql = "SELECT prov.id_pais
              FROM es_sagep.provincias prov
              JOIN es_sagep.localidades loc ON loc.id_provincia=prov.id_provincia
             WHERE prov.id_provincia = $id_provincia";

    $resultado = consultar_fuente($sql);

    return $resultado[0];
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

  static function get_OpProvincias($id_pais)
  {
    $id_pais = quote($id_pais);
      $sql = "SELECT
                prov.id_provincia,
                prov.nombre_prov
              FROM
                es_sagep.provincias prov
              WHERE
                prov.id_pais = $id_pais";

      $resultado = consultar_fuente($sql);
      return $resultado;
  }

  static function get_provincias()
  {
    return dao_provincias::get_listado_provincias();
  }
}
 ?>
