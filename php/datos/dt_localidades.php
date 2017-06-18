<?php
class dt_localidades extends sagep_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_localidad, nombre_loc FROM localidades ORDER BY nombre_loc";
		return toba::db('sagep')->consultar($sql);
	}

}

?>