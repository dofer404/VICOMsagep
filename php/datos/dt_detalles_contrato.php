<?php
class dt_detalles_contrato extends sagep_datos_tabla
{
	function get_listado()
	{
		$sql = "SELECT
			t_dc.id_contrato,
			t_dc.id_servicio,
			t_dc.cantidad,
			t_dc.monto_unitario,
			t_dc.monto_total,
			t_dc.observaciones
		FROM
			detalles_contrato as t_dc
		ORDER BY observaciones";
		return toba::db('sagep')->consultar($sql);
	}

}

?>