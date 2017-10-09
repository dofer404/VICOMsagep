<?php
class cn_condiciondeiva extends sagep_cn
{
	
	//-----------------------------------------------------------------------------------
	//---- dr_condiciondeiva ------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function reiniciar()
	{
		$this->dep('dr_condiciondeiva')->resetear();
	}
	
	function guardar()
	{
		$this->dep('dr_condiciondeiva')->sincronizar();
		$this->dep('dr_condiciondeiva')->resetear();
	}
	
	//-----------------------------------------------------------------------------------
	//---- dt_condicion_iva -------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function set_condicion_iva($datos)
	{
		$this->dep('dr_condiciondeiva')->tabla('dt_condicion_iva')->set($datos);
	}
	
	function cargar($seleccion)
	{
		$this->dep('dr_condiciondeiva')->tabla('dt_condicion_iva')->cargar($seleccion);
	}
	
	function get_condicion_iva()
	{
		$datos = $this->dep('dr_condiciondeiva')->tabla('dt_condicion_iva')->get();
		return $datos;
	}
	
	function hay_cursor()
	{
		if ($this->dep('dr_condiciondeiva')->tabla('dt_condicion_iva')->esta_cargada()) {
			return $this->dep('dr_condiciondeiva')->tabla('dt_condicion_iva')->hay_cursor();
		}
	}
	
	function set_cursor($seleccion)
	{
		$id_fila = $this->dep('dr_condiciondeiva')->tabla('dt_condicion_iva')->get_id_fila_condicion($seleccion)[0];
		$this->dep('dr_condiciondeiva')->tabla('dt_condicion_iva')->set_cursor($id_fila);
	}
	
	function eliminar()
	{
		$this->dep('dr_condiciondeiva')->tabla('dt_condicion_iva')->eliminar_todo();
	}
	
}
?>