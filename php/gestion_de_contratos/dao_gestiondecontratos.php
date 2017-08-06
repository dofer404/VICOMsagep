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
    JOIN es_sagep.rol t_r on t_rs.id_rol = t_r.id_rol and t_r.nombre_rol = 'Contratante'
    JOIN es_sagep.personas t_p on t_rs.id_persona = t_p.id_persona

              $where_armado ";

    $datos=consultar_fuente($sql);
    return $datos;
  }

  static function get_listado_detalles_contrato ()
  {
    // $sql=" SELECT
    //       t_dc.id_detalle_contrato,
    //       t_s.id_servicio,
    //       t_c.id_contrato,
    //       t_dc.cantidad,
    //       t_dc.monto_unitario,
    //       t_dc.monto_total,
    //       t_dc.observaciones
    //       FROM es_sagep.detalles_contrato t_dc
    //       JOIN es_sagep.contratos t_c on t_dc.id_contrato = t_c.id_contrato
    //       JOIN es_sagep.servicios t_s on t_dc.id_servicio = t_s.id_servicio" ;

          $sql=" SELECT
                id_detalle_contrato,
                id_servicio,
                id_contrato,
                cantidad,
                monto_unitario,
                monto_total,
                observaciones
                FROM es_sagep.detalles_contrato" ;

    $datos=consultar_fuente($sql);
    return $datos;
  }

  static function get_id_detalle($id_contrato)
  {
    $id_contrato = quote($id_contrato);

    $sql = "SELECT id_servicio FROM es_sagep.detalles_contrato WHERE id_contrato = $id_contrato";

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

  static function get_idExtUbicacion($id_ubicacion)
  {
    $id_ubicacion = quote($id_ubicacion);

    $sql = "SELECT det.id_ubicacion,
                   zon.id_tipo_zona
              FROM es_sagep.detalleubicacion_detallecontrato det
              JOIN es_sagep.tipos_de_zonas zon ON det.id_zona = zon.id_tipo_zona
             WHERE det.id_ubicacion = $id_ubicacion";

    $resultado = consultar_fuente($sql);

    return $resultado[0];
  }

  static function get_OpZonas($id_ubicacion)
  {
    $id_ubicacion = quote($id_ubicacion);
      $sql = "SELECT
                zon.id_tipo_zona,
                zon.nombre_tipozona
              FROM
                es_sagep.tipos_de_zonas zon
              WHERE
                det.id_zona = $id_pais";

      $resultado = consultar_fuente($sql);
      return $resultado;
  }

  static function get_descripcionPopUpUbicacion($id_ubicacion)
  {

  $id_ubicacion = quote($id_ubicacion);
    $sql = "SELECT
              det.direccion
            FROM
              es_sagep.detalle_ubicacion det
            WHERE
              det.id_ubicacion = $id_ubicacion";

    $resultado = consultar_fuente($sql);

  if (count($resultado) > 0) {
      return $resultado[0]['direccion'];
  } else {
      return 'Fallo. Intente nuevamente';
    }

  }

}

 ?>
