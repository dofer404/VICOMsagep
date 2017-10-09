<?php
class cn_configurarempresa extends sagep_cn
{
	//-----------------------------------------------------------------------------------
	//---- dr_datos_empresa -------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function reiniciar()
	{
		$this->dep('dr_datos_empresa')->resetear();
	}
	
	function guardar()
	{
		$this->dep('dr_datos_empresa')->sincronizar();
		$this->dep('dr_datos_empresa')->resetear();
	}
	
	//-----------------------------------------------------------------------------------
	//---- dt_datos_empresa -------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function set_empresa($datos)
	{
		$this->dep('dr_datos_empresa')->tabla('dt_datos_empresa')->set($datos);
	}
	
	function cargar($seleccion)
	{
		$this->dep('dr_datos_empresa')->tabla('dt_datos_empresa')->cargar($seleccion);
	}
	
	function get_empresa()
	{
		$datos = $this->dep('dr_datos_empresa')->tabla('dt_datos_empresa')->get();
		return $datos;
	}
	
	function hay_cursor()
	{
		if ($this->dep('dr_datos_empresa')->tabla('dt_datos_empresa')->esta_cargada()) {
			return $this->dep('dr_datos_empresa')->tabla('dt_datos_empresa')->hay_cursor();
		}
	}
	
	function set_cursor($seleccion)
	{
		$id_fila = $this->dep('dr_datos_empresa')->tabla('dt_datos_empresa')->get_id_fila_condicion($seleccion)[0];
		$this->dep('dr_datos_empresa')->tabla('dt_datos_empresa')->set_cursor($id_fila);
	}
	
	function eliminar()
	{
		$this->dep('dr_datos_empresa')->tabla('dt_datos_empresa')->eliminar_todo();
	}
}
?>