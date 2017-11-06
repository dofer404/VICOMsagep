<?php
class cn_fotosdeservicios extends sagep_cn
{
		//-----------------------------------------------------------------------------------
	//---- Variables --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	protected $temp_archivo;
	protected $temp_nombre;
	protected $temp_imagen;

	//-----------------------------------------------------------------------------------
	//---- dr_fotos_servicio ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function resetear()
	{
		$this->dep('dr_fotos_servicio')->resetear();
	}

	function sincronizar()
	{
		$this->dep('dr_fotos_servicio')->sincronizar();
	}

	function hay_cursor()
	{
	if ($this->dep('dr_fotos_servicio')->tabla('dt_fotos_servicio')->esta_cargada()) {
		return $this->dep('dr_fotos_servicio')->tabla('dt_fotos_servicio')->hay_cursor();
	}
	}

	function set_cursor($seleccion)
	{
		$id_fila = $this->dep('dr_fotos_servicio')->tabla('dt_fotos_servicio')->get_id_fila_condicion($seleccion)[0];
		$this->dep('dr_fotos_servicio')->tabla('dt_fotos_servicio')->set_cursor($id_fila);
	}

	function cargar($seleccion)
	{
		$this->dep('dr_fotos_servicio')->cargar($seleccion);
	}

	//-----------------------------------------------------------------------------------
	//---- dt_fotos_servicio ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function procesar_filas_fotos($datos)
	{
	$this->dep('dr_fotos_servicio')->tabla('dt_fotos_servicio')->procesar_filas($datos);
	}

	public function set_blob($datos, $id_fila)
	{
	if (is_array($datos['imagen'])) {
		$temp_archivo = $datos['imagen']['tmp_name'];
		$fp = fopen($temp_archivo, 'rb');

		$this->dep('dr_fotos_servicio')->tabla('dt_fotos_servicio')->set_blob('imagen', $fp, $id_fila);
	}
	}

	function set_blobs($datos)
	{
		foreach ($datos as $key => $value) {

		$this->set_blob($datos[$key], $key);
		//  $aux = $datos[$key];
		// if (is_array($aux['imagen'])) {
		//   $temp_archivo = $aux['imagen']['tmp_name'];
		//   $fp = fopen($temp_archivo, 'rb');
		//
		//   $this->dep('dr_fotos_servicio')->tabla('dt_fotos_servicio')->set_blob('imagen', $fp, $key);
		// }
		}
	}

	function get_fotos()
	{
		$datos = $this->dep('dr_fotos_servicio')->tabla('dt_fotos_servicio')->get();
		return $datos;
	}

	public function get_blobs($datos)
	{
	$datos_r = array();
		foreach ($datos as $key => $value) {
			$datos_r[$key] = $this->get_blob($datos[$key], $key);
		}
	return $datos_r;
	}

	public function get_blob($datos, $id_fila)
	{
		$html_imagen = null;

		$fp_imagen = $this->dep('dr_fotos_servicio')->tabla('dt_fotos_servicio')->get_blob('imagen', $id_fila);
		if (isset($fp_imagen)) {
			$temp_nombre = md5(uniqid(time()));
			$temp_archivo = toba::proyecto()->get_www_temp($temp_nombre);
			$temp_imagen = fopen($temp_archivo['path'], 'w');
			stream_copy_to_stream($fp_imagen, $temp_imagen);
			fclose($temp_imagen);
			fclose($fp_imagen);
			$tamano = round(filesize($temp_archivo['path']) / 1024);
			$html_imagen =
			"<img width=\"24px\" src='{$temp_archivo['url']}' alt=''/>";
			$datos['imagen'] = '<a href="'.$temp_archivo['url'].'" target="_newtab">'.$html_imagen.' Tamaño archivo actual: '.$tamano.' kb</a>';
			$datos['imagen'.'?html'] = $html_imagen;
			$datos['imagen'.'?url'] = $temp_archivo['url'];
		} else {
			$datos['imagen'] = null;
		}

		return $datos;
	}
	
		function get_ubicacion()
	{
		$datos = $this->dep('dr_fotos_servicio')->tabla('dt_detalleubicacion_detallecontrato')->get_filas();
		return $datos;
	}

	function set_cursor_ubicaciones($id_interno)
	{
		$this->dep('dr_fotos_servicio')->tabla('dt_detalleubicacion_detallecontrato')->set_cursor($id_interno);
	}

	function nueva_fila_ubicacion($datos_fila)
	{
		return $this->dep('dr_fotos_servicio')->tabla('dt_detalleubicacion_detallecontrato')->nueva_fila($datos_fila);
	}

	function hay_cursor_ubicaciones()
	{
		return $this->dep('dr_fotos_servicio')->tabla('dt_detalleubicacion_detallecontrato')->hay_cursor();
	}
}
?>