<?php
class dt_tipo_estado extends sagep_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_tipo_estado, nombre_tipoest FROM tipo_estado ORDER BY nombre_tipoest";
		return toba::db('sagep')->consultar($sql);
	}

}

?>