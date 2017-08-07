<?php
class dt_estados extends sagep_datos_tabla
{
	function get_listado()
	{
		$sql = "SELECT
			t_e.id_tipo_estado,
			t_e.id_detalle_contrato,
			t_e.id_ubicacion,
			t_e.fecha_cambio
		FROM
			estados as t_e";
		return toba::db('sagep')->consultar($sql);
	}

}

?>