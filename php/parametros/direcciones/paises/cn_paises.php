<?php
class cn_paises extends sagep_cn
{

	//-----------------------------------------------------------------------------------
	//---- dr_paises --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function reiniciar()
	{
		$this->dep('dr_paises')->resetear();
	}

	function guardar()
	{
		$this->dep('dr_paises')->sincronizar();
		$this->dep('dr_paises')->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- dt_pais ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function set_pais($datos)
	{
		$this->dep('dr_paises')->tabla('dt_pais')->set($datos);
	}

	function cargar($seleccion)
	{
		$this->dep('dr_paises')->tabla('dt_pais')->cargar($seleccion);
	}

	function get_pais()
	{
		$datos = $this->dep('dr_paises')->tabla('dt_pais')->get();
		return $datos;
	}

	function hay_cursor()
	{
		if ($this->dep('dr_paises')->tabla('dt_pais')->esta_cargada()) {
			return $this->dep('dr_paises')->tabla('dt_pais')->hay_cursor();
		}
	}

	function set_cursor($seleccion)
	{
		$id_fila = $this->dep('dr_paises')->tabla('dt_pais')->get_id_fila_condicion($seleccion)[0];
		$this->dep('dr_paises')->tabla('dt_pais')->set_cursor($id_fila);
	}

	function eliminar()
	{
		$this->dep('dr_paises')->tabla('dt_pais')->eliminar_todo();
	}

}
?>
