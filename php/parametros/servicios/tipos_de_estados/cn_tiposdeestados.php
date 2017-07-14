<?php
class cn_tiposdeestados extends sagep_cn
{
	//-----------------------------------------------------------------------------------
	//---- dr_tiposdeestados ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function reiniciar()
	{
		$this->dep('dr_tiposdeestados')->resetear();
	}

	function guardar()
	{
		$this->dep('dr_tiposdeestados')->sincronizar();
		$this->dep('dr_tiposdeestados')->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- dt_tipo_estado ---------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function set_tipo_estado($datos)
	{
		$this->dep('dr_tiposdeestados')->tabla('dt_tipo_estado')->set($datos);
	}

	function cargar($seleccion)
	{
		$this->dep('dr_tiposdeestados')->tabla('dt_tipo_estado')->cargar($seleccion);
	}

	function get_tipo_estado()
	{
		$datos = $this->dep('dr_tiposdeestados')->tabla('dt_tipo_estado')->get();
		return $datos;
	}

	function hay_cursor()
	{
		if ($this->dep('dr_tiposdeestados')->tabla('dt_tipo_estado')->esta_cargada()) {
			return $this->dep('dr_tiposdeestados')->tabla('dt_tipo_estado')->hay_cursor();
		}
	}

	function set_cursor($seleccion)
	{
		$id_fila = $this->dep('dr_tiposdeestados')->tabla('dt_tipo_estado')->get_id_fila_condicion($seleccion)[0];
		$this->dep('dr_tiposdeestados')->tabla('dt_tipo_estado')->set_cursor($id_fila);
	}

	function eliminar()
	{
		$this->dep('dr_tiposdeestados')->tabla('dt_tipo_estado')->eliminar_todo();
	}

}
?>
