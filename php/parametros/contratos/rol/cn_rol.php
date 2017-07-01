<?php
class cn_rol extends sagep_cn
{
  //-----------------------------------------------------------------------------------
	//---- dr_rol -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function guardar ()
	{
		$this->dep('dr_rol')->sincronizar();
		$this->dep('dr_rol')->resetear();
	}

	function reiniciar()
	{
		$this->dep('dr_rol')->resetear();
	}


	//-----------------------------------------------------------------------------------
	//---- dt_rol -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function set_rol($datos)
	{
		$this->dep('dr_rol')->tabla('dt_rol')->set($datos);
	}

	function cargar($seleccion)
	{
		$this->dep('dr_rol')->tabla('dt_rol')->cargar($seleccion);
	}

	function get_rol()
	{
		$datos = $this->dep('dr_rol')->tabla('dt_rol')->get();
		return $datos;
	}

	function hay_cursor()
	{
		if ($this->dep('dr_rol')->tabla('dt_rol')->esta_cargada()) {
			return $this->dep('dr_rol')->tabla('dt_rol')->hay_cursor();
		}
	}

	function set_cursor($seleccion)
	{
		$id_fila = $this->dep('dr_rol')->tabla('dt_rol')->get_id_fila_condicion($seleccion)[0];
		$this->dep('dr_rol')->tabla('dt_rol')->set_cursor($id_fila);
	}

	function eliminar()
	{
		$this->dep('dr_rol')->tabla('dt_rol')->eliminar_todo();
	}

}

?>
