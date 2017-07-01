<?php
class cn_tiposdecontratos extends sagep_cn
{
	//-----------------------------------------------------------------------------------
	//---- dr_tiposdecontratos ----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function guardar ()
	{
		$this->dep('dr_tiposdecontratos')->sincronizar();
		$this->dep('dr_tiposdecontratos')->resetear();
	}

	function reiniciar()
	{
		$this->dep('dr_tiposdecontratos')->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- dt_tipos_contratos -----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function set_tipos_contratos($datos)
	{
		$this->dep('dr_tiposdecontratos')->tabla('dt_tipos_contratos')->set($datos);
	}

	function cargar($seleccion)
	{
		$this->dep('dr_tiposdecontratos')->tabla('dt_tipos_contratos')->cargar($seleccion);
	}

	function get_tipos_contratos()
	{
		$datos = $this->dep('dr_tiposdecontratos')->tabla('dt_tipos_contratos')->get();
		return $datos;
	}

	function hay_cursor()
	{
		if ($this->dep('dr_tiposdecontratos')->tabla('dt_tipos_contratos')->esta_cargada()) {
			return $this->dep('dr_tiposdecontratos')->tabla('dt_tipos_contratos')->hay_cursor();
		}
	}

	function set_cursor($seleccion)
	{
		$id_fila = $this->dep('dr_tiposdecontratos')->tabla('dt_tipos_contratos')->get_id_fila_condicion($seleccion)[0];
		$this->dep('dr_tiposdecontratos')->tabla('dt_tipos_contratos')->set_cursor($id_fila);
	}

	function eliminar()
	{
		$this->dep('dr_tiposdecontratos')->tabla('dt_tipos_contratos')->eliminar_todo();
	}

}
?>
