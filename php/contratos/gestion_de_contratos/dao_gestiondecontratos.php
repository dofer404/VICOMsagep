<?php

require_once('parametros/contratos/tipos_de_contratos/dao_tiposdecontratos.php');
require_once('parametros/contratos/rol/dao_rol.php');
require_once('parametros/direcciones/tipos_de_zonas/dao_tiposdezonas.php');
require_once('personas/gestion_de_personas/dao_gestiondepersonas.php');
require_once('servicios/gestion_de_servicios/dao_gestiondeservicios.php');

class dao_gestiondecontratos{

  static function get_listado_contratos ($where='')
  {

    if($where){
      $where_armado="WHERE $where";
    }else {
      $where_armado='';
    }

    $sql=" SELECT
      t_rs.id_persona,
      t_rs.id_contrato,
      t_r.nombre_rol,
      t_p.cuil_cuit as id_persona_cuil_cuit,
      t_c.id_contrato,
      t_c.fecha_inicio,
      t_c.fecha_fin,
      t_c.monto_total,
      t_c.id_tipo_contrato,
      t_tc.nombre_tipocon as id_tipo_contrato_nombre
    FROM es_sagep.contratos t_c

    JOIN es_sagep.tipos_contratos t_tc on t_c.id_tipo_contrato = t_tc.id_tipo_contrato
    JOIN es_sagep.roles t_rs on t_c.id_contrato = t_rs.id_contrato
    JOIN es_sagep.rol t_r on t_rs.id_rol = t_r.id_rol and t_r.nombre_rol = 'Contratado'
    JOIN es_sagep.personas t_p on t_rs.id_persona = t_p.id_persona

              $where_armado ";

    $datos=consultar_fuente($sql);
    return $datos;
  }

  static function get_listado_detalles_contrato ($where='')
  {

    if($where){
      $where_armado="WHERE $where";
    }else {
      $where_armado='';
    }

    $sql=" SELECT
          id_detalle_contrato,
          id_servicio,
          id_contrato,
          cantidad,
          monto_unitario,
          monto_total,
          observaciones
          FROM es_sagep.detalles_contrato

              $where_armado ";

    $datos=consultar_fuente($sql);
    return $datos;
  }

  static function get_id_detalle($id_contrato)
  {
    $id_contrato = quote($id_contrato);

    $sql = "SELECT id_servicio FROM es_sagep.detalles_contrato WHERE id_contrato = $id_contrato";

    return consultar_fuente($sql);
  }

  static function get_lista_detalles()
  {
    $sql = "SELECT det.id_detalle_contrato, det.id_servicio, serv.nombre_serv
            FROM es_sagep.detalles_contrato det, es_sagep.servicios serv
            WHERE det.id_servicio = serv.id_servicio";

    return consultar_fuente($sql);
  }

  static function get_tiposContratos()
  {
    return dao_tiposdecontratos::get_listado_tipos_contratos();
  }

  static function get_tiposRol()
  {
    return dao_rol::get_listado_roles();
  }

  static function get_personas()
  {
    return dao_gestiondepersonas::get_listado_personas();
  }

  static function get_tiposZonas()
  {
    return dao_tiposdezonas::get_listado_tipos_zonas();
  }

  static function get_servicios()
  {
    return dao_gestiondeservicios::get_listado_servicios();
  }

  static function get_descPopUpPersonas($id_persona)
  {

  $id_persona = quote($id_persona);
    $sql = "SELECT
              coalesce(per.razon_social, per.apellidos || ', ' || per.nombres) entidad
            FROM
              es_sagep.personas per
            WHERE
              per.id_persona = $id_persona";

    $resultado = consultar_fuente($sql);

  if (count($resultado) > 0) {
      return $resultado[0]['entidad'];
  } else {
      return 'Fallo. Intente nuevamente';
    }

  }

  static function get_descripcionPopUpUbicacion($id_ubicacion)
  {

  $id_ubicacion = quote($id_ubicacion);
    $sql = "SELECT
              det.direccion,
              det.altura,
              loc.nombre_loc,
              bar.nombre_bar,
              prov.nombre_prov,
              pais.nombre_pais,
              det.direccion || ' al ' || det.altura ||' - Barrio '|| bar.nombre_bar ||' - '||loc.nombre_loc || ', ' || prov.nombre_prov || ', ' || pais.nombre_pais as direccion_localidad
            FROM
              es_sagep.detalle_ubicacion det,
              es_sagep.localidades loc,
              es_sagep.barrios bar,
              es_sagep.provincias prov,
              es_sagep.pais pais
            WHERE
            bar.id_barrio = det.id_barrio and
            loc.id_localidad = bar.id_localidad and
            prov.id_provincia = loc.id_provincia and
            pais.id_pais = prov.id_pais and
            det.id_ubicacion = $id_ubicacion";

    $resultado = consultar_fuente($sql);

  if (count($resultado) > 0) {
      return $resultado[0]['direccion_localidad'];
  } else {
      return 'Fallo. Intente nuevamente';
    }

  }

}

 ?>
