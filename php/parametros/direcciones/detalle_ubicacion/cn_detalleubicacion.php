<?php
class cn_detalleubicacion extends sagep_cn
{
	
	//-----------------------------------------------------------------------------------
	//---- dr_detalleubicacion ----------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function reiniciar()
	{
		$this->dep('dr_detalleubicacion')->resetear();
	}
	
	function guardar()
	{
		$this->dep('dr_detalleubicacion')->sincronizar();
		$this->dep('dr_detalleubicacion')->resetear();
	}
	
	//-----------------------------------------------------------------------------------
	//---- dt_detalle_ubicacion ---------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function set_detalle_ubicacion($datos)
	{
		$this->dep('dr_detalleubicacion')->tabla('dt_detalle_ubicacion')->set($datos);
	}
	
	function cargar($seleccion)
	{
		$this->dep('dr_detalleubicacion')->tabla('dt_detalle_ubicacion')->cargar($seleccion);
	}
	
	function get_detalle_ubicacion()
	{
		$datos = $this->dep('dr_detalleubicacion')->tabla('dt_detalle_ubicacion')->get();
		return $datos;
	}
	
	function hay_cursor()
	{
		if ($this->dep('dr_detalleubicacion')->tabla('dt_detalle_ubicacion')->esta_cargada()) {
			return $this->dep('dr_detalleubicacion')->tabla('dt_detalle_ubicacion')->hay_cursor();
		}
	}
	
	function set_cursor($seleccion)
	{
		$id_fila = $this->dep('dr_detalleubicacion')->tabla('dt_detalle_ubicacion')->get_id_fila_condicion($seleccion)[0];
		$this->dep('dr_detalleubicacion')->tabla('dt_detalle_ubicacion')->set_cursor($id_fila);
	}
	
	function eliminar()
	{
		$this->dep('dr_detalleubicacion')->tabla('dt_detalle_ubicacion')->eliminar_todo();
	}
	
}
?>