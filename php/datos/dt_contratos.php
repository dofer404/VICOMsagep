<?php
class dt_contratos extends sagep_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_contrato, id_contrato FROM contratos ORDER BY id_contrato";
		return toba::db('sagep')->consultar($sql);
	}






}
?>