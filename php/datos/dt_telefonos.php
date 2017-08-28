<?php
class dt_telefonos extends sagep_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_telefono,  FROM telefonos ORDER BY ";
		return toba::db('sagep')->consultar($sql);
	}


}
?>