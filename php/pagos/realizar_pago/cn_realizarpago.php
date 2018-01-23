<?php
class cn_realizarpago extends sagep_cn
{
	//--------------------------------------------------------------------------------------
	//---- dr_realizarpago --------------------------------------------------------------------
	//--------------------------------------------------------------------------------------

	function guardar()
	{
		$this->dep('dr_realizarpago')->sincronizar();
		$this->dep('dr_realizarpago')->resetear();
	}
	function reiniciar()
	{
		$this->dep('dr_realizarpago')->resetear();
	}

	function cargar($seleccion)
	{
		$this->dep('dr_realizarpago')->cargar($seleccion);
	}

	function eliminar()
	{
		$this->dep('dr_realizarpago')->eliminar_todo();
	}

  //----------------------------------------------------------------------------------------
  //---- dt_ ----------------------------------------------------------------------
  //----------------------------------------------------------------------------------------

  function set_servicios($datos)
  {
    $this->dep('dr_servicios')->tabla('dt_servicios')->set($datos);

    if (is_array($datos['imagen'])) {

      $temp_archivo = $datos['imagen']['tmp_name'];
      $fp = fopen($temp_archivo, 'rb');
      $this->dep('dr_servicios')->tabla('dt_servicios')->set_blob('imagen', $fp);
    }
  }

	//-----------------------------------------------------------------------------------
	//---- dt_cuotas -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function existe_fila_contrato($id_interno)
	{
		return $this->dep('dr_realizarpago')->tabla('dt_contratos')->existe_fila($id_interno);
	}

	function set_cursor_contrato($seleccion)
	{
		$this->dep('dr_realizarpago')->tabla('dt_contratos')->set_cursor($seleccion);
	}

	function get_cuotas()
	{
		$datos = $this->dep('dr_realizarpago')->tabla('dt_liquidaciones')->get_filas();
		return $datos;
	}


}

?>
