<?php
class cn_entidadesfinancieras extends sagep_cn
{
  //-----------------------------------------------------------------------------------
	//---- dr_entidadesfinancieras --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function reiniciar()
	{
		$this->dep('dr_entidadesfinancieras')->resetear();
	}

	function guardar()
	{
		$this->dep('dr_entidadesfinancieras')->sincronizar();
		$this->dep('dr_entidadesfinancieras')->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- dt_entidad_financiera ---------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function set_entidad_financiera($datos)
	{
		$this->dep('dr_entidadesfinancieras')->tabla('dt_entidad_financiera')->set($datos);
	}

	function cargar($seleccion)
	{
		$this->dep('dr_entidadesfinancieras')->tabla('dt_entidad_financiera')->cargar($seleccion);
	}

	function get_entidad_financiera()
	{
		$datos = $this->dep('dr_entidadesfinancieras')->tabla('dt_entidad_financiera')->get();
		return $datos;
	}

	function hay_cursor()
	{
		if ($this->dep('dr_entidadesfinancieras')->tabla('dt_entidad_financiera')->esta_cargada()) {
			return $this->dep('dr_entidadesfinancieras')->tabla('dt_entidad_financiera')->hay_cursor();
		}
	}

	function set_cursor($seleccion)
	{
		$id_fila = $this->dep('dr_entidadesfinancieras')->tabla('dt_entidad_financiera')->get_id_fila_condicion($seleccion)[0];
		$this->dep('dr_entidadesfinancieras')->tabla('dt_entidad_financiera')->set_cursor($id_fila);
	}

	function eliminar()
	{
		$this->dep('dr_entidadesfinancieras')->tabla('dt_entidad_financiera')->eliminar_todo();
	}
}

?>
