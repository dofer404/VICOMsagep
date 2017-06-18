<?php
class cn_tiposdecorreos extends sagep_cn
{
	//-----------------------------------------------------------------------------------
	//---- dr_tiposdecorreos ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function resetear()
	{
		$this->dep('dr_tiposdecorreos')->resetear();
	}

	function sincronizar()
	{
		$this->dep('dr_tiposdecorreos')->sincronizar();
	}

	//-----------------------------------------------------------------------------------
	//---- dt_tipos_correos -------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function set_tipos_correos($datos)
	{
		$this->dep('dr_tiposdecorreos')->tabla('dt_tipos_correos')->set($datos);
	}

	function cargar($seleccion)
	{
		$this->dep('dr_tiposdecorreos')->tabla('dt_tipos_correos')->cargar($seleccion);
	}

	function get_tipos_correos()
	{
		$datos = $this->dep('dr_tiposdecorreos')->tabla('dt_tipos_correos')->get();
		return $datos;
	}

	function hay_cursor()
	{
		if ($this->dep('dr_tiposdecorreos')->tabla('dt_tipos_correos')->esta_cargada()) {
			return $this->dep('dr_tiposdecorreos')->tabla('dt_tipos_correos')->hay_cursor();
		}
	}

	function set_cursor($seleccion)
	{
		$id_fila = $this->dep('dr_tiposdecorreos')->tabla('dt_tipos_correos')->get_id_fila_condicion($seleccion)[0];
		$this->dep('dr_tiposdecorreos')->tabla('dt_tipos_correos')->set_cursor($id_fila);
	}

	function eliminar()
	{
		$this->dep('dr_tiposdecorreos')->tabla('dt_tipos_correos')->eliminar_todo();
	}
}
?>
