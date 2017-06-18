<?php
class cn_gestiondecontratos extends sagep_cn
{
	//--------------------------------------------------------------------------------------
	//---- dr_contratos --------------------------------------------------------------------
	//--------------------------------------------------------------------------------------

	function resetear()
	{
		$this->dep('dr_contratos')->resetear();
	}

	function sincronizar()
	{
		$this->dep('dr_contratos')->sincronizar();
	}

	function eliminar()
	{
		$this->dep('dr_contratos')->eliminar_todo();
	}

	function cargar($seleccion)
	{
		$this->dep('dr_contratos')->cargar($seleccion);
	}

	//----------------------------------------------------------------------------------------
	//---- dt_contratos ----------------------------------------------------------------------
	//----------------------------------------------------------------------------------------

	function get_contratos()
	{
		$datos = $this->dep('dr_contratos')->tabla('dt_contratos')->get();
		return $datos;
	}

	function hay_cursor()
	{
		if ($this->dep('dr_contratos')->tabla('dt_contratos')->esta_cargada()) {
			return $this->dep('dr_contratos')->tabla('dt_contratos')->hay_cursor();
		}
	}

	function set_contratos($datos)
	{
		$this->dep('dr_contratos')->tabla('dt_contratos')->set($datos);
	}

	function set_cursor($seleccion)
	{
		$id_fila = $this->dep('dr_contratos')->tabla('dt_contratos')->get_id_fila_condicion($seleccion)[0];
		$this->dep('dr_contratos')->tabla('dt_contratos')->set_cursor($id_fila);
	}

	//-----------------------------------------------------------------------------------
	//---- dt_roles ---------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function procesar_filas_roles($datos)
	{
		$this->dep('dr_contratos')->tabla('dt_roles')->procesar_filas($datos);
	}

	function get_roles()
	{
		$datos = $this->dep('dr_contratos')->tabla('dt_roles')->get_filas();
		return $datos;
	}

}
?>
