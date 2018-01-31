<?php
class dt_detalles_contrato extends sagep_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT det.id_detalle_contrato,
						ser.nombre_serv servicio
					FROM detalles_contrato det, servicios ser
					WHERE det.id_servicio = ser.id_servicio
			ORDER BY servicio";
		return toba::db('sagep')->consultar($sql);
	}

}
?>