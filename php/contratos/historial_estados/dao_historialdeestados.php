<?php

class dao_historialdeestados
{
  static function get_listado_estados($id_ubicacion, $id_detalle_contrato)
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
}

?>
