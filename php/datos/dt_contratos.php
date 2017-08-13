<?php
class dt_contratos extends sagep_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_contrato, id_contrato FROM contratos ORDER BY id_contrato";
		return toba::db('sagep')->consultar($sql);
	}






	function get_listado()
	{
		$sql = "SELECT
			t_c.id_contrato,
			t_c.fecha_inicio,
			t_c.fecha_fin,
			t_c.monto_total,
			t_tc.descripcion as id_tipo_contrato_nombre
		FROM
			contratos as t_c,
			tipos_contratos as t_tc
		WHERE
				t_c.id_tipo_contrato = t_tc.id_tipo_contrato";
		return toba::db('sagep')->consultar($sql);
	}

}
?>