<?php

require_once('parametros/direcciones/localidades/dao_localidades.php');
require_once('parametros/direcciones/barrios/dao_barrios.php');
require_once('parametros/direcciones/tipos_de_zonas/dao_tiposdezonas.php');


class dao_detalleubicacion{

  static function get_listado_detalles_ubicacion ($where='')
  {

    if($where){
      $where_armado="WHERE $where";
    }else {
      $where_armado="";
    }

    $sql=" SELECT
              det.id_ubicacion,
              det.direccion,
              det.altura,
              zona.nombre_tipozona as tipo_zona,
              loc.id_localidad,
              bar.id_barrio,
              bar.nombre_bar as nombre_barrio,
              prov.id_provincia,
              pais.id_pais,
              loc.nombre_loc || ', ' || prov.nombre_prov || ', ' || pais.nombre_pais as pais_provincia_localidad,
              det.direccion || ' - ' || zona.nombre_tipozona ||' - '||loc.nombre_loc || ', ' || prov.nombre_prov || ', ' || pais.nombre_pais as direccion_localidad
            FROM es_sagep.detalle_ubicacion det

            JOIN es_sagep.barrios bar ON det.id_barrio = bar.id_barrio
            JOIN es_sagep.localidades loc ON loc.id_localidad = bar.id_localidad
            JOIN es_sagep.provincias prov ON loc.id_provincia = prov.id_provincia
            JOIN es_sagep.pais pais ON prov.id_pais = pais.id_pais
            JOIN es_sagep.tipos_zonas zona ON zona.id_tipo_zona = det.id_zona

              $where_armado";

    $datos=consultar_fuente($sql);
    return $datos;
  }

  static function get_idsExtBarrio($id_barrio)
  {
    $id_barrio = quote($id_barrio);

    $sql = "SELECT prov.id_pais,
                   prov.id_provincia,
                   loc.id_localidad,
                   bar.id_barrio
              FROM es_sagep.barrios bar
              JOIN es_sagep.localidades loc ON bar.id_localidad = loc.id_localidad
              JOIN es_sagep.provincias prov ON loc.id_provincia = prov.id_provincia
             WHERE bar.id_barrio = $id_barrio";

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

  static function get_tiposZonas()
  {
    return dao_tiposdezonas::get_listado_tipos_zonas();
  }

  static function get_localidades()
  {
    return dao_localidades::get_listado_localidades();
  }

  static function get_barrios()
  {
    return dao_barrios::get_listado_barrios();
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

  static function get_OpBarrios($id_localidad)
  {
    $id_localidad = quote($id_localidad);
      $sql = "SELECT
                bar.id_barrio,
                bar.nombre_bar
              FROM
                es_sagep.barrios bar
              WHERE
                bar.id_localidad = $id_localidad";

      $resultado = consultar_fuente($sql);
      return $resultado;
  }

}

 ?>
