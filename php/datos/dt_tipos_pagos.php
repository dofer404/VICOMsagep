<?php
class dt_tipos_pagos extends sagep_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_tipo_pago, nombre_tipopago FROM tipos_pagos ORDER BY nombre_tipopago";
		return toba::db('sagep')->consultar($sql);
	}

}

?>