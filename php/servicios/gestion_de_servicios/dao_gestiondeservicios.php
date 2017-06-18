<?php

class dao_gestiondeservicios{

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

}

 ?>
