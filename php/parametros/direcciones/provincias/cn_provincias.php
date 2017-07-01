<?php
class cn_provincias extends sagep_cn
{
	//-----------------------------------------------------------------------------------
	//---- dr_provincias ----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function reiniciar()
	{
		$this->dep('dr_provincias')->resetear();
	}

	function guardar()
	{
		$this->dep('dr_provincias')->sincronizar();
		$this->dep('dr_provincias')->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- dt_provincias ----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function set_provincias($datos)
	{
		$this->dep('dr_provincias')->tabla('dt_provincias')->set($datos);
	}

	function cargar($seleccion)
	{
		$this->dep('dr_provincias')->tabla('dt_provincias')->cargar($seleccion);
	}

	function get_provincias()
	{
		$datos = $this->dep('dr_provincias')->tabla('dt_provincias')->get();
		return $datos;
	}

	function hay_cursor()
	{
		if ($this->dep('dr_provincias')->tabla('dt_provincias')->esta_cargada()) {
			return $this->dep('dr_provincias')->tabla('dt_provincias')->hay_cursor();
		}
	}

	function set_cursor($seleccion)
	{
		$id_fila = $this->dep('dr_provincias')->tabla('dt_provincias')->get_id_fila_condicion($seleccion)[0];
		$this->dep('dr_provincias')->tabla('dt_provincias')->set_cursor($id_fila);
	}

	function eliminar()
	{
		$this->dep('dr_provincias')->tabla('dt_provincias')->eliminar_todo();
	}
}
?>
