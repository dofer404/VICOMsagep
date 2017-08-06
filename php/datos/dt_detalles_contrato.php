<?php
class dt_detalles_contrato extends sagep_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_detalle_contrato, observaciones FROM detalles_contrato ORDER BY observaciones";
		return toba::db('sagep')->consultar($sql);
	}
	function get_listado()
	{
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
		return toba::db('sagep')->consultar($sql);
	}

}
?>