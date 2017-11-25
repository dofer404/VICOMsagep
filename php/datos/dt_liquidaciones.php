<?php
class dt_liquidaciones extends sagep_datos_tabla
{
	function get_listado()
	{
		$sql = "SELECT
			t_l.id_liquidacion,
			t_l.nro_cuota,
			t_m.nombre_mes as id_mes_nombre,
			t_l.fecha_vencimiento,
			t_l.pago,
			t_l.descuento,
			t_l.recargo,
			t_l.monto,
			t_c.id_contrato as id_contrato_nombre
		FROM
			liquidaciones as t_l,
			meses as t_m,
			contratos as t_c
		WHERE
				t_l.id_mes = t_m.id_mes
			AND  t_l.id_contrato = t_c.id_contrato
		ORDER BY nro_cuota, t_m.id_mes";
		return toba::db('sagep')->consultar($sql);
	}



}
?>