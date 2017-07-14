<?php
class cn_tiposdepersonas extends sagep_cn
{

	//-----------------------------------------------------------------------------------
	//---- dr_tiposdepersonas -----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function reiniciar()
	{
		$this->dep('dr_tiposdepersonas')->resetear();
	}

	function guardar()
	{
		$this->dep('dr_tiposdepersonas')->sincronizar();
		$this->dep('dr_tiposdepersonas')->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- dt_tipos_personas ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function set_tipos_personas($datos)
	{
		$this->dep('dr_tiposdepersonas')->tabla('dt_tipos_personas')->set($datos);
	}

	function cargar($seleccion)
	{
		$this->dep('dr_tiposdepersonas')->tabla('dt_tipos_personas')->cargar($seleccion);
	}

	function get_tipos_personas()
	{
		$datos = $this->dep('dr_tiposdepersonas')->tabla('dt_tipos_personas')->get();
		return $datos;
	}

	function hay_cursor()
	{
		if ($this->dep('dr_tiposdepersonas')->tabla('dt_tipos_personas')->esta_cargada()) {
			return $this->dep('dr_tiposdepersonas')->tabla('dt_tipos_personas')->hay_cursor();
		}
	}

	function set_cursor($seleccion)
	{
		$id_fila = $this->dep('dr_tiposdepersonas')->tabla('dt_tipos_personas')->get_id_fila_condicion($seleccion)[0];
		$this->dep('dr_tiposdepersonas')->tabla('dt_tipos_personas')->set_cursor($id_fila);
	}

	function eliminar()
	{
		$this->dep('dr_tiposdepersonas')->tabla('dt_tipos_personas')->eliminar_todo();
	}

}
?>
