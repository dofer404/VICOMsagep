<?php
class cn_barrios extends sagep_cn
{
	
	//-----------------------------------------------------------------------------------
	//---- dr_barrios -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function guardar()
	{
		$this->dep('dr_barrios')->sincronizar();
		$this->dep('dr_barrios')->resetear();
	}
	
	function reiniciar()
	{
		$this->dep('dr_barrios')->resetear();
	}
	
	//-----------------------------------------------------------------------------------
	//---- dt_barrios -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function set_barrios($datos)
	{
		$this->dep('dr_barrios')->tabla('dt_barrios')->set($datos);
	}
	
	function cargar($seleccion)
	{
		$this->dep('dr_barrios')->tabla('dt_barrios')->cargar($seleccion);
	}
	
	function get_barrios()
	{
		$datos = $this->dep('dr_barrios')->tabla('dt_barrios')->get();
		return $datos;
	}
	
	function hay_cursor()
	{
		if ($this->dep('dr_barrios')->tabla('dt_barrios')->esta_cargada()) {
			return $this->dep('dr_barrios')->tabla('dt_barrios')->hay_cursor();
		}
	}
	
	function set_cursor($seleccion)
	{
		$id_fila = $this->dep('dr_barrios')->tabla('dt_barrios')->get_id_fila_condicion($seleccion)[0];
		$this->dep('dr_barrios')->tabla('dt_barrios')->set_cursor($id_fila);
	}
	
	function eliminar()
	{
		$this->dep('dr_barrios')->tabla('dt_barrios')->eliminar_todo();
	}
	
}
?>