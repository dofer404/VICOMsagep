<?php
class cn_localidades extends sagep_cn
{
	
	//-----------------------------------------------------------------------------------
	//---- dr_localidades ---------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function reiniciar()
	{
		$this->dep('dr_localidades')->resetear();
	}
	
	function guardar()
	{
		$this->dep('dr_localidades')->sincronizar();
		$this->dep('dr_localidades')->resetear();
	}
	
	//-----------------------------------------------------------------------------------
	//---- dt_localidades ---------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function set_localidades($datos)
	{
		$this->dep('dr_localidades')->tabla('dt_localidades')->set($datos);
	}
	
	function cargar($seleccion)
	{
		$this->dep('dr_localidades')->tabla('dt_localidades')->cargar($seleccion);
	}
	
	function get_localidades()
	{
		$datos = $this->dep('dr_localidades')->tabla('dt_localidades')->get();
		return $datos;
	}
	
	function hay_cursor()
	{
		if ($this->dep('dr_localidades')->tabla('dt_localidades')->esta_cargada()) {
			return $this->dep('dr_localidades')->tabla('dt_localidades')->hay_cursor();
		}
	}
	
	function set_cursor($seleccion)
	{
		$id_fila = $this->dep('dr_localidades')->tabla('dt_localidades')->get_id_fila_condicion($seleccion)[0];
		$this->dep('dr_localidades')->tabla('dt_localidades')->set_cursor($id_fila);
	}
	
	function eliminar()
	{
		$this->dep('dr_localidades')->tabla('dt_localidades')->eliminar_todo();
	}
	
}
?>