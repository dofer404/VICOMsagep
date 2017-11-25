<?php
class dt_formas_pago extends sagep_datos_tabla
{
	function get_listado()
	{
		$sql = "SELECT
			t_fp.id_formas_pago,
			t_tp.nombre_tipopago as id_tipo_pago_nombre,
			t_p.id_pago as id_pago_nombre,
			t_fp.titular,
			t_fp.monto,
			t_fp.vencimiento,
			t_fp.numero_comprobante,
			t_fp.descuento_porcentaje,
			t_ef.nombre_enfi as id_entidad_financiera_nombre
		FROM
			formas_pago as t_fp,
			tipos_pagos as t_tp,
			pagos as t_p,
			entidades_financieras as t_ef
		WHERE
				t_fp.id_tipo_pago = t_tp.id_tipo_pago
			AND  t_fp.id_pago = t_p.id_pago
			AND  t_fp.id_entidad_financiera = t_ef.id_entidad_financiera
		ORDER BY titular";
		return toba::db('sagep')->consultar($sql);
	}

}

?>