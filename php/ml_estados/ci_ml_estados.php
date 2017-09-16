<?php
class ci_ml_estados extends sagep_ci
{
	function ini__operacion()
	{
		$this->dep('datos')->cargar();
	}

	function evt__guardar()
	{
		$this->dep('datos')->sincronizar();
		$this->dep('datos')->resetear();
		$this->dep('datos')->cargar();
	}

	function evt__formulario__modificacion($datos)
	{
		$this->dep('datos')->procesar_filas($datos);
	}

	function conf__formulario(toba_ei_formulario_ml $componente)
	{
		$parametro_externo = toba::memoria()->get_parametros();
		//ei_arbol($parametro_externo, 'PARAMETROS recibidos');
		$clave_get = array (
			'id_ubicacion' => toba::memoria()->get_parametro('ubicacion'),
			'id_detalle_contrato' => toba::memoria()->get_parametro('detalle_contrato'),
		);
		ei_arbol($clave_get);

		$datos=$this->dep('datos')->get_filas($clave_get);

		$componente->set_datos($datos);
	}

}

?>
