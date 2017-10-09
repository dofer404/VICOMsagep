<?php
class cn_tiposdepagos extends sagep_cn
{
	//-----------------------------------------------------------------------------------
	//---- dr_tiposdepagos --------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function reiniciar()
	{
		$this->dep('dr_tiposdepagos')->resetear();
	}
	
	function guardar()
	{
		$this->dep('dr_tiposdepagos')->sincronizar();
		$this->dep('dr_tiposdepagos')->resetear();
		
	}
	
	//-----------------------------------------------------------------------------------
	//---- dt_tipos_pagos ---------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function set_tipos_pagos($datos)
	{
		$this->dep('dr_tiposdepagos')->tabla('dt_tipos_pagos')->set($datos);
	}
	
	function cargar($seleccion)
	{
		$this->dep('dr_tiposdepagos')->tabla('dt_tipos_pagos')->cargar($seleccion);
	}
	
	function get_tipos_pagos()
	{
		$datos = $this->dep('dr_tiposdepagos')->tabla('dt_tipos_pagos')->get();
		return $datos;
	}
	
	function hay_cursor()
	{
		if ($this->dep('dr_tiposdepagos')->tabla('dt_tipos_pagos')->esta_cargada()) {
			return $this->dep('dr_tiposdepagos')->tabla('dt_tipos_pagos')->hay_cursor();
		}
	}
	
	function set_cursor($seleccion)
	{
		$id_fila = $this->dep('dr_tiposdepagos')->tabla('dt_tipos_pagos')->get_id_fila_condicion($seleccion)[0];
		$this->dep('dr_tiposdepagos')->tabla('dt_tipos_pagos')->set_cursor($id_fila);
	}
	
	function eliminar()
	{
		$this->dep('dr_tiposdepagos')->tabla('dt_tipos_pagos')->eliminar_todo();
	}
	
}
?>