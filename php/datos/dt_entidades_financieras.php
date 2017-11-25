<?php
class dt_entidades_financieras extends sagep_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_entidad_financiera, nombre_enfi FROM entidades_financieras ORDER BY nombre_enfi";
		return toba::db('sagep')->consultar($sql);
	}

}

?>