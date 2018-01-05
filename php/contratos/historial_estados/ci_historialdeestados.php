<?php
require_once('contratos/historial_estados/dao_historialdeestados.php');

class ci_historialdeestados extends sagep_ci
{
	//-----------------------------------------------------------------------------------
	//---- Cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(sagep_ei_cuadro $cuadro)
	{

		$cuadro->desactivar_modo_clave_segura();
	$parametro_externo = toba::memoria()->get_parametros();
	//
	// // $clave_get = array (
	// //   'id_ubicacion' => toba::memoria()->get_parametro('ubicacion');
	// //   'id_detalle_contrato' => toba::memoria()->get_parametro('detalle_contrato');
	// //   )
	//
		$id_ubicacion = toba::memoria()->get_parametro('ubicacion');
		$id_detalle_contrato = toba::memoria()->get_parametro('detalle_contrato');



		$datos = dao_historialdeestados::get_listado_estados($id_ubicacion, $id_detalle_contrato);
		$cuadro->set_datos($datos);

	}
}
?>