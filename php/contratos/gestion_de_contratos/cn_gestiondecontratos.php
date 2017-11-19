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

	function eliminar_fila_cursor_ubicacion()
	{
		$id_interno = $this->dep('dr_contratos')->tabla('dt_detalleubicacion_detallecontrato')->get_cursor();
		$this->dep('dr_contratos')->tabla('dt_detalleubicacion_detallecontrato')->eliminar_fila($id_interno);
	}

	function existe_fila_ubicacion($id_interno)
	{
		return $this->dep('dr_contratos')->tabla('dt_detalleubicacion_detallecontrato')->existe_fila($id_interno);
	}

	function procesar_filas_ubicacion($datos)
	{
		$this->dep('dr_contratos')->tabla('dt_detalleubicacion_detallecontrato')->procesar_filas($datos);
	}

	function get_unaUbicacion()
	{
		$array = $this->dep('dr_contratos')->tabla('dt_detalleubicacion_detallecontrato')->get();
		return $array;
	}

	function get_ubicacion()
	{
		$datos = $this->dep('dr_contratos')->tabla('dt_detalleubicacion_detallecontrato')->get_filas();
		return $datos;
	}

	function set_cursor_ubicaciones($id_interno)
	{
		$this->dep('dr_contratos')->tabla('dt_detalleubicacion_detallecontrato')->set_cursor($id_interno);
	}

	function nueva_fila_ubicacion($datos_fila)
	{
		return $this->dep('dr_contratos')->tabla('dt_detalleubicacion_detallecontrato')->nueva_fila($datos_fila);
	}

	function hay_cursor_ubicaciones()
	{
		return $this->dep('dr_contratos')->tabla('dt_detalleubicacion_detallecontrato')->hay_cursor();
	}

	function resetear_cursor_ubicaciones()
	{
		$this->dep('dr_contratos')->tabla('dt_detalleubicacion_detallecontrato')->resetear_cursor();
	}

	//-----------------------------------------------------------------------------------
	//---- dt_fotos_servicios -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function procesar_filas_fotos($datos)
	{
		$this->dep('dr_contratos')->tabla('dt_fotos_servicio')->procesar_filas($datos);
	}

	function get_fotos()
	{
		$datos = $this->dep('dr_contratos')->tabla('dt_fotos_servicio')->get_filas();
		return $datos;
	}

	function set_cursor_fotos($id_interno)
	{
		$this->dep('dr_contratos')->tabla('dt_detalleubicacion_detallecontrato')->set_cursor($id_interno);
	}

	function hay_cursor_fotos()
	{
		return $this->dep('dr_contratos')->tabla('dt_fotos_servicio')->hay_cursor();
	}

	function resetear_cursor_fotos()
	{
		$this->dep('dr_contratos')->tabla('dt_detalleubicacion_detallecontrato')->resetear_cursor();
	}

	function get_blobs($datos)
	{
		$datos_r = array();
		foreach ($datos as $key => $value) {
			if (isset($value['x_dbr_clave'])) {
			$datos_r[$key] = $this->get_blob($value, $value['x_dbr_clave']);
		}

		}
		return $datos_r;
	}

	function get_blob($datos, $id_fila)
	{
		$html_imagen = null;

		$imagen = $this->dep('dr_contratos')->tabla('dt_fotos_servicio')->get_blob('imagen', $id_fila);
		if (isset($imagen)) {
			$temp_nombre = md5(uniqid(time()));
			$temp_archivo = toba::proyecto()->get_www_temp($temp_nombre);
			$temp_imagen = fopen($temp_archivo['path'], 'w');
			stream_copy_to_stream($imagen, $temp_imagen);
			fclose($temp_imagen);
			//fclose($imagen);
			$tamano = round(filesize($temp_archivo['path']) / 1024);
			$html_imagen =
				"<img width=\"24px\" src='{$temp_archivo['url']}' alt='' />";
			$datos['imagen'] = '<a href="'.$temp_archivo['url'].'" target="_newtab">'.$html_imagen.' Tama?o de archivo actual: '.$tamano.' kb</a>';
			$datos['imagen'.'?html'] = $html_imagen;
			$datos['imagen'.'?url'] = $temp_archivo['url'];
		} else {
			$datos['imagen'] = null;
		}

		return $datos;
	}

	function set_blobs($datos)
	{
		foreach ($datos as $key => $value) {
			$this->set_blob($datos[$key], $key);
		}
	}

	function set_blob($datos, $id_fila)
	{
		if (isset($datos['imagen'])) {
			if (is_array($datos['imagen'])) {
				$temp_archivo = $datos['imagen']['tmp_name'];
				$imagen = fopen($temp_archivo, 'rb');
				$this->dep('dr_contratos')->tabla('dt_fotos_servicio')->set_blob('imagen', $imagen, $id_fila);
			}
		}
	}

	//-----------------------------------------------------------------------------------
	//---- dt_estados -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function set_cursor_estado($id_interno)
	{
		$this->dep('dr_contratos')->tabla('dt_estados')->set_cursor($id_interno);
	}

	function procesar_filas_estados($datos)
	{
		$this->dep('dr_contratos')->tabla('dt_estados')->procesar_filas($datos);
	}

	function get_estado()
	{
		$datos = $this->dep('dr_contratos')->tabla('dt_estados')->get_filas();
		return $datos;
	}

	function resetear_cursor_estados()
	{
		$this->dep('dr_contratos')->tabla('dt_estados')->resetear_cursor();
	}



}
?>
