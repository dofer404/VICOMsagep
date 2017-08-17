<?php
class dt_servicios extends sagep_datos_tabla
{
		function get_descripciones()
		{
			$sql = "SELECT id_servicio, descripcion FROM servicios ORDER BY descripcion";
			return toba::db('sagep')->consultar($sql);
		}
















}
?>