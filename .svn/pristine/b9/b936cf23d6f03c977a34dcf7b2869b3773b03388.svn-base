<?php
class cn_tiposdetelefonos extends sagep_cn
{

	//-----------------------------------------------------------------------------------
	//---- dr_tiposdetelefonos ----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function resetear()
	{
		$this->dep('dr_tiposdetelefonos')->resetear();
	}

	function sincronizar()
	{
		$this->dep('dr_tiposdetelefonos')->sincronizar();
	}

	//-----------------------------------------------------------------------------------
	//---- dt_tipos_telefonos -----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function set_tipos_telefonos($datos)
	{
		$this->dep('dr_tiposdetelefonos')->tabla('dt_tipos_telefonos')->set($datos);
	}

	function cargar($seleccion)
	{
		$this->dep('dr_tiposdetelefonos')->tabla('dt_tipos_telefonos')->cargar($seleccion);
	}

	function get_tipos_telefonos()
	{
		$datos = $this->dep('dr_tiposdetelefonos')->tabla('dt_tipos_telefonos')->get();
		return $datos;
	}

	function hay_cursor()
	{
		if ($this->dep('dr_tiposdetelefonos')->tabla('dt_tipos_telefonos')->esta_cargada()) {
			return $this->dep('dr_tiposdetelefonos')->tabla('dt_tipos_telefonos')->hay_cursor();
		}
	}

	function set_cursor($seleccion)
	{
		$id_fila = $this->dep('dr_tiposdetelefonos')->tabla('dt_tipos_telefonos')->get_id_fila_condicion($seleccion)[0];
		$this->dep('dr_tiposdetelefonos')->tabla('dt_tipos_telefonos')->set_cursor($id_fila);
	}

	function eliminar()
	{
		$this->dep('dr_tiposdetelefonos')->tabla('dt_tipos_telefonos')->eliminar_todo();
	}

}
?>
