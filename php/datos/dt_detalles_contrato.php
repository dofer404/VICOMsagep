<?php
class dt_detalles_contrato extends sagep_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_detalle_contrato, observaciones FROM detalles_contrato ORDER BY observaciones";
		return toba::db('sagep')->consultar($sql);
	}

}

?>