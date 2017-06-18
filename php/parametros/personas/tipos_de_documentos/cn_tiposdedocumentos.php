<?php
class cn_tiposdedocumentos extends sagep_cn
{

	//-----------------------------------------------------------------------------------
	//---- dr_tiposdedocumentos ---------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function resetear()
	{
		$this->dep('dr_tiposdedocumentos')->resetear();
	}

	function sincronizar()
	{
		$this->dep('dr_tiposdedocumentos')->sincronizar();
	}

	//-----------------------------------------------------------------------------------
	//---- dt_tipos_documentos ----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function set_tipos_documentos($datos)
	{
		$this->dep('dr_tiposdedocumentos')->tabla('dt_tipos_documentos')->set($datos);
	}

	function cargar($seleccion)
	{
		$this->dep('dr_tiposdedocumentos')->tabla('dt_tipos_documentos')->cargar($seleccion);
	}

	function get_tipos_documentos()
	{
		$datos = $this->dep('dr_tiposdedocumentos')->tabla('dt_tipos_documentos')->get();
		return $datos;
	}

	function hay_cursor()
	{
		if ($this->dep('dr_tiposdedocumentos')->tabla('dt_tipos_documentos')->esta_cargada()) {
			return $this->dep('dr_tiposdedocumentos')->tabla('dt_tipos_documentos')->hay_cursor();
		}
	}

	function set_cursor($seleccion)
	{
		$id_fila = $this->dep('dr_tiposdedocumentos')->tabla('dt_tipos_documentos')->get_id_fila_condicion($seleccion)[0];
		$this->dep('dr_tiposdedocumentos')->tabla('dt_tipos_documentos')->set_cursor($id_fila);
	}

	function eliminar()
	{
		$this->dep('dr_tiposdedocumentos')->tabla('dt_tipos_documentos')->eliminar_todo();
	}
}
?>
