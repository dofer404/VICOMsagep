<?php
class cn_tiposdecuentas extends sagep_cn
{
	//-----------------------------------------------------------------------------------
	//---- dr_tiposdecuentas --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function reiniciar()
	{
		$this->dep('dr_tiposdecuentas')->resetear();
	}

	function guardar()
	{
		$this->dep('dr_tiposdecuentas')->sincronizar();
		$this->dep('dr_tiposdecuentas')->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- dt_tipos_cuentas ---------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function set_tipos_cuentas($datos)
	{
		$this->dep('dr_tiposdecuentas')->tabla('dt_tipos_cuentas')->set($datos);
	}

	function cargar($seleccion)
	{
		$this->dep('dr_tiposdecuentas')->tabla('dt_tipos_cuentas')->cargar($seleccion);
	}

	function get_tipos_cuentas()
	{
		$datos = $this->dep('dr_tiposdecuentas')->tabla('dt_tipos_cuentas')->get();
		return $datos;
	}

	function hay_cursor()
	{
		if ($this->dep('dr_tiposdecuentas')->tabla('dt_tipos_cuentas')->esta_cargada()) {
			return $this->dep('dr_tiposdecuentas')->tabla('dt_tipos_cuentas')->hay_cursor();
		}
	}

	function set_cursor($seleccion)
	{
		$id_fila = $this->dep('dr_tiposdecuentas')->tabla('dt_tipos_cuentas')->get_id_fila_condicion($seleccion)[0];
		$this->dep('dr_tiposdecuentas')->tabla('dt_tipos_cuentas')->set_cursor($id_fila);
	}

	function eliminar()
	{
		$this->dep('dr_tiposdecuentas')->tabla('dt_tipos_cuentas')->eliminar_todo();
	}
}
?>