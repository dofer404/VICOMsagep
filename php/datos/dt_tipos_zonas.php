<?php
class dt_tipos_zonas extends sagep_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_tipo_zona, descripcion FROM tipos_zonas ORDER BY descripcion";
		return toba::db('sagep')->consultar($sql);
	}



}
?>