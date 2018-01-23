<?php
class dt_pagos extends sagep_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_pago, id_pago FROM pagos ORDER BY id_pago";
		return toba::db('sagep')->consultar($sql);
	}

}
?>