<?php
require_once('parametros/servicios/tipos_de_estados/dao_tiposdeestados.php');

class dao_ubicacion
{
  static function get_listado_ubicacion($id_ubicacion, $id_detalle_contrato)
  {

  //  $id_ubicacion = toba::memoria()->get_parametro('ubicacion');
    //$id_detalle_contrato = toba::memoria()->get_parametro('detalle_contrato');

    $sql=" SELECT
              t_te.nombre_tipoest AS id_estado_nombre,
	            t_h.id_detalle_contrato,
            	t_h.id_ubicacion,
            	t_ub.fecha_cambio
          	FROM es_sagep.historial_estados t_h
              JOIN es_sagep.detalleubicacion_detallecontrato t_ub ON t_h.id_ubicacion = t_ub.id_ubicacion
              JOIN es_sagep.tipo_estado t_te on t_ub.id_tipo_estado = t_te.id_tipo_estado
            WHERE t_e.id_detalle_contrato = $id_detalle_contrato AND t_e.id_ubicacion = $id_ubicacion";

    $datos=consultar_fuente($sql);
    return $datos;
  }

  static function get_tiposEstados()
  {
    return dao_tiposdeestados::get_listado_tipos_estados();
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
