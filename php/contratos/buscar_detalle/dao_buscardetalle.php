<?php

require_once('servicios/gestion_de_servicios/dao_gestiondeservicios.php');
require_once('contratos/gestion_de_contratos/dao_gestiondecontratos.php');

class dao_buscardetalle
{
  static function get_listado_detalles_contrato ($where='')
  {

    if($where){
      $where_armado="WHERE $where";
    }else {
      $where_armado='';
    }

    $sql=" SELECT
    	        coalesce(t_p.razon_social, t_p.apellidos || ', ' || t_p.nombres) entidad,
          	  t_s.nombre_serv as id_servicio_nombre,
          	  t_det.direccion || ' al ' || t_det.altura ||' - Barrio '|| t_bar.nombre_bar ||' - '||t_loc.nombre_loc || ', ' || t_prov.nombre_prov || ', ' || t_pais.nombre_pais as direccion_localidad,
          	  t_te.nombre_tipoest as id_estado_nombre,
          	  t_e.fecha_cambio,
              t_dt.id_detalle_contrato,
              t_c.id_contrato,
              t_dt.monto_total

            FROM es_sagep.estados t_e
    	        JOIN es_sagep.tipo_estado t_te on t_e.id_tipo_estado = t_te.id_tipo_estado	
              JOIN es_sagep.detalleubicacion_detallecontrato t_uc on t_e.id_ubicacion = t_uc.id_ubicacion and t_e.id_detalle_contrato = t_uc.id_detalle_contrato and t_e.fecha_cambio in (SELECT MAX(e2.fecha_cambio) FROM es_sagep.estados e2 WHERE t_e.id_detalle_contrato = e2.id_detalle_contrato)
              JOIN es_sagep.detalles_contrato t_dt on t_uc.id_detalle_contrato = t_dt.id_detalle_contrato
              JOIN es_sagep.detalle_ubicacion t_det on t_uc.id_ubicacion = t_det.id_ubicacion
              JOIN es_sagep.barrios t_bar on t_det.id_barrio = t_bar.id_barrio
              JOIN es_sagep.localidades t_loc on t_bar.id_localidad = t_loc.id_localidad
              JOIN es_sagep.provincias t_prov on t_loc.id_provincia = t_prov.id_provincia
              JOIN es_sagep.pais t_pais on t_prov.id_pais = t_pais.id_pais

              JOIN es_sagep.servicios t_s on t_dt.id_servicio = t_s.id_servicio

              JOIN es_sagep.contratos t_c on t_c.id_contrato = t_dt.id_contrato
              JOIN es_sagep.roles t_rs on t_c.id_contrato = t_rs.id_contrato
              JOIN es_sagep.rol t_r on t_rs.id_rol = t_r.id_rol and t_r.nombre_rol = 'Contratado'
              JOIN es_sagep.personas t_p on t_rs.id_persona = t_p.id_persona

              $where_armado ";

    $datos=consultar_fuente($sql);
    return $datos;
  }
}

?>
