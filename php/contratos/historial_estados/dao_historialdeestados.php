<?php

class dao_historialdeestados
{
  static function get_listado_estados($id_ubicacion, $id_detalle_contrato)
  {

  //$id_ubicacion = toba::memoria()->get_parametro('ubicacion');
//  $id_detalle_contrato = toba::memoria()->get_parametro('detalle_contrato');

    $sql=" SELECT
              t_h_es.id_historial_estado,
              t_te.nombre_tipoest AS id_estado_nombre,
	            t_h_es.id_detalle_contrato,
            	t_h_es.id_ubicacion,
            	t_h_es.fecha_cambio
          	FROM es_sagep.historial_estado t_h_es
              JOIN es_sagep.detalleubicacion_detallecontrato t_ub ON t_h_es.id_ubicacion = t_ub.id_ubicacion AND t_h_es.id_detalle_contrato = t_ub.id_detalle_contrato
              JOIN es_sagep.tipo_estado t_te ON t_h_es.id_tipo_estado = t_te.id_tipo_estado
            WHERE t_h_es.id_detalle_contrato = $id_detalle_contrato AND t_h_es.id_ubicacion = $id_ubicacion";

    $datos=consultar_fuente($sql);
    return $datos;
  }
}

?>
