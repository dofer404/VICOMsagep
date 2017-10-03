<?php
class dt_estados extends sagep_datos_tabla
{
	function get_listado()
	{
		$sql = "SELECT
			t_e.id_estado,
			t_e.fecha_inicio,
			t_e.fecha_fin,
			t_te.nombre_tipoest as id_tipo_estado_nombre,
			t_e.id_ubicacion,
			t_e.id_detalle_contrato
		FROM
			estados as t_e,
			tipo_estado as t_te
		WHERE
				t_e.id_tipo_estado = t_te.id_tipo_estado";
		return toba::db('sagep')->consultar($sql);
	}





	function get_descripciones()
	{
		$sql = "SELECT id_ubicacion,  FROM estados ORDER BY ";
		return toba::db('sagep')->consultar($sql);
	}

}
?>