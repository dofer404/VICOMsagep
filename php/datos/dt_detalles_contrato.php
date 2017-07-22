<?php
class dt_detalles_contrato extends sagep_datos_tabla
{
	function get_listado($filtro=array())
	{
		$where = array();
		if (isset($filtro['id_detalle_contrato'])) {
			$where[] = "id_detalle_contrato = ".quote($filtro['id_detalle_contrato']);
		}
		if (isset($filtro['id_servicio'])) {
			$where[] = "id_servicio = ".quote($filtro['id_servicio']);
		}
		$sql = "SELECT
			t_dc.id_detalle_contrato,
			t_s.descripcion as id_servicio_nombre,
			t_c.id_contrato as id_contrato_nombre,
			t_dc.cantidad,
			t_dc.monto_unitario,
			t_dc.monto_total,
			t_dc.observaciones
		FROM
			detalles_contrato as t_dc,
			servicios as t_s,
			contratos as t_c
		WHERE
				t_dc.id_servicio = t_s.id_servicio
			AND  t_dc.id_contrato = t_c.id_contrato
		ORDER BY observaciones";
		if (count($where)>0) {
			$sql = sql_concatenar_where($sql, $where);
		}
		return toba::db('sagep')->consultar($sql);
	}




	function get_descripciones()
	{
		$sql = "SELECT id_detalle_contrato, observaciones FROM detalles_contrato ORDER BY observaciones";
		return toba::db('sagep')->consultar($sql);
	}




}
?>