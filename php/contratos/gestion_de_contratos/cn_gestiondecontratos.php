<?php
class cn_gestiondecontratos extends sagep_cn
{
	protected $s__datos;

	//--------------------------------------------------------------------------------------
	//---- dr_contratos --------------------------------------------------------------------
	//--------------------------------------------------------------------------------------

	function reiniciar()
	{
		$this->dep('dr_contratos')->resetear();
	}

	function guardar()
	{
		$this->dep('dr_contratos')->sincronizar();
		$this->dep('dr_contratos')->resetear();
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
		return $this->dep('dr_contratos')->tabla('dt_contratos')->hay_cursor();
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

	//-----------------------------------------------------------------------------------
	//---- dt_detalle -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

  function existe_fila_detalle($id_interno)
	{
	  return $this->dep('dr_contratos')->tabla('dt_detalles_contrato')->existe_fila($id_interno);
	}

	function hay_cursor_detalle()
	{
		return $this->dep('dr_contratos')->tabla('dt_detalles_contrato')->hay_cursor();
	}

	function resetear_cursor_detalle()
	{
		$this->dep('dr_contratos')->tabla('dt_detalles_contrato')->resetear_cursor();
	}

	function set_detalle($datos)
	{
		$this->dep('dr_contratos')->tabla('dt_detalles_contrato')->set($datos);
	}

	function set_cursor_detalle($seleccion)
	{
				$this->dep('dr_contratos')->tabla('dt_detalles_contrato')->set_cursor($seleccion);
	}

	function get_unDetalle()
	{
		$array = $this->dep('dr_contratos')->tabla('dt_detalles_contrato')->get();
		return $array;
		}

	function procesar_filas_detalle($datos)
	{
		$this->dep('dr_contratos')->tabla('dt_detalles_contrato')->procesar_filas($datos);
	}

	function get_detalle()
	{
		$datos = $this->dep('dr_contratos')->tabla('dt_detalles_contrato')->get_filas();
		return $datos;
	}

	function eliminar_fila_cursor_detalle()
  {
		$id_interno = $this->dep('dr_contratos')->tabla('dt_detalles_contrato')->get_cursor();
    $this->dep('dr_contratos')->tabla('dt_detalles_contrato')->eliminar_fila($id_interno);
   }

	function nueva_fila_detalle($datos_fila)
  {
		return $this->dep('dr_contratos')->tabla('dt_detalles_contrato')->nueva_fila($datos_fila);
  }

	function setDatos_nuevoDetalle(array $datos) //
	{
		$this->dep('dr_contratos')->tabla('dt_detalles_contrato')->nueva_fila($datos);
		$id_fila_condicion = $this->dep('dr_contratos')->tabla('dt_detalles_contrato')->get_filas()[0]['x_dbr_clave'];
		$this->dep('dr_contratos')->tabla('dt_detalles_contrato')->set_cursor($id_fila_condicion);
	}


	//-----------------------------------------------------------------------------------
	//---- dt_detalleubicacion_detallecontrato -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function procesar_filas_ubicacion($datos)
	{
		$this->dep('dr_contratos')->tabla('dt_detalleubicacion_detallecontrato')->procesar_filas($datos);
	}

	public function get_ubicacion()
	{
		$datos = $this->dep('dr_contratos')->tabla('dt_detalleubicacion_detallecontrato')->get_filas();
		return $datos;
	}

	function set_cursor_ubicaciones($id_interno)
	{
		$this->dep('dr_contratos')->tabla('dt_detalleubicacion_detallecontrato')->set_cursor($id_interno);
	}

	function hay_cursor_ubicaciones($id_interno)
	{
		return $this->dep('dr_contratos')->tabla('dt_detalleubicacion_detallecontrato')->hay_cursor();
	}

	function resetear_cursor_ubicaciones($id_interno)
	{
		$this->dep('dr_contratos')->tabla('dt_detalleubicacion_detallecontrato')->resetear_cursor();
	}



}
?>
