<?php

require_once('parametros/direcciones/tipos_de_zonas/dao_tiposdezonas.php');

class dao_listadodeservicios{

  static function get_listado_servicios ($where='')
  {

    if($where){
      $where_armado="WHERE $where";
    }else {
      $where_armado='';
    }

    $sql=" SELECT t_s.id_servicio,
                  t_s.sigla_serv,
                  t_s.nombre_serv,
                  t_s.descripcion,
                  t_s.tamano,
                  t_s.imagen,
                  t_sr.parent_id_servicio,
                  t_sr.nombre_serv || ' : ' || t_s.nombre_serv  servicios,
                  t_sr.nombre_serv as parent_id_servicio_nombre

          FROM es_sagep.servicios t_s
          JOIN es_sagep.servicios t_sr ON t_s.parent_id_servicio = t_sr.id_servicio 

              $where_armado";

    $datos=consultar_fuente($sql);
    return $datos;
  }

  static function get_serviciosPadre()
  {
    $sql = " SELECT t_s.id_servicio,
                    t_s.nombre_serv,
                    t_s.parent_id_servicio
              FROM
              es_sagep.servicios as t_s
              WHERE t_s.parent_id_servicio=t_s.id_servicio ";
    $datos=consultar_fuente($sql);
    return $datos;
  }

  static function get_tiposZonas()
  {
    return dao_tiposdezonas::get_listado_tipos_zonas();
  }

  static function get_OpDescripcion($id_tipo_zona)
  {
    $id_tipo_zona = quote($id_tipo_zona);
      $sql = "SELECT
                zona.id_tipo_zona,
                zona.descripcion
              FROM
                es_sagep.tipos_zonas zona
              WHERE
                zona.id_tipo_zona = $id_tipo_zona";

      $resultado = consultar_fuente($sql);
      return $resultado;
  }

}

 ?>
