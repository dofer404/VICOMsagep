<?php
class dt_detalle_ubicacion extends sagep_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_ubicacion, direccion FROM detalle_ubicacion ORDER BY direccion";
		return toba::db('sagep')->consultar($sql);
	}



}
?>