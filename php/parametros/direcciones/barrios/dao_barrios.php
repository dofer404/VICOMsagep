<?php

require_once('parametros/direcciones/localidades/dao_localidades.php');
require_once('parametros/direcciones/provincias/dao_provincias.php');

class dao_barrios{

  static function get_listado_barrios ($where='')
  {

    if($where){
      $where_armado="WHERE $where";
    }else {
      $where_armado="";
    }

    $sql=" SELECT
              bar.id_barrio,
              loc.id_localidad,
              prov.id_provincia,
              pais.id_pais,
              bar.nombre_bar,
              loc.nombre_loc || ', ' || prov.nombre_prov || ', ' || pais.nombre_pais as pais_provincia_localidad
            FROM es_sagep.barrios bar

            JOIN es_sagep.localidades loc on bar.id_localidad = loc.id_localidad
            JOIN es_sagep.provincias prov on loc.id_provincia = prov.id_provincia
            JOIN es_sagep.pais pais on prov.id_pais = pais.id_pais

              $where_armado";

    $datos=consultar_fuente($sql);
    return $datos;
  }

  static function get_idsExtLocalidad($id_localidad)
  {
    $id_localidad = quote($id_localidad);

    $sql = "SELECT prov.id_pais,
                   prov.id_provincia
              FROM es_sagep.provincias prov
              JOIN es_sagep.localidades loc ON loc.id_provincia = prov.id_provincia
             WHERE loc.id_localidad = $id_localidad";

    $resultado = consultar_fuente($sql);

    return $resultado[0];
  }

  static function get_descPopUpPais($id_pais)
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
      return 'Fallo. Intente nuevamente';
  }

  }

  static function get_provincias()
  {
    return dao_provincias::get_listado_provincias();
  }

  static function get_localidades()
  {
    return dao_localidades::get_listado_localidades();
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

  static function get_OpLocalidades($id_provincia)
  {
    $id_provincia = quote($id_provincia);
      $sql = "SELECT
                loc.id_localidad,
                loc.nombre_loc
              FROM
                es_sagep.localidades loc
              WHERE
                loc.id_provincia = $id_provincia";

      $resultado = consultar_fuente($sql);
      return $resultado;
  }

}

 ?>
