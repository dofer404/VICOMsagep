<?php
class dt_tipos_contratos extends sagep_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_tipo_contrato, descripcion FROM tipos_contratos ORDER BY descripcion";
		return toba::db('sagep')->consultar($sql);
	}

}

?>