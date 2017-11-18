<?php
class dt_tipos_personas extends sagep_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_tipo_persona, nombre_tipoper FROM tipos_personas ORDER BY nombre_tipoper";
		return toba::db('sagep')->consultar($sql);
	}

}

?>