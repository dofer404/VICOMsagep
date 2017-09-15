<?php
class dt_provincias extends sagep_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_provincia, nombre_prov FROM provincias ORDER BY nombre_prov";
		return toba::db('sagep')->consultar($sql);
	}

}

?>