<?php
class cn_tiposdezonas extends sagep_cn
{
	//-----------------------------------------------------------------------------------
	//---- Variables --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	protected $temp_archivo;
	protected $temp_nombre;
	protected $temp_imagen;

	//-----------------------------------------------------------------------------------
	//---- dr_tiposdezonas --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function resetear()
	{
		$this->dep('dr_tiposdezonas')->resetear();
	}

	function sincronizar()
	{
		$this->dep('dr_tiposdezonas')->sincronizar();
	}

	//-----------------------------------------------------------------------------------
	//---- dt_tipos_zonas ----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function set_tipos_zonas($datos)
	{
		$this->dep('dr_tiposdezonas')->tabla('dt_tipos_zonas')->set($datos);
		if (is_array($datos['mapa'])) {

			$temp_archivo = $datos['mapa']['tmp_name'];
			$fp = fopen($temp_archivo, 'rb');
			$this->dep('dr_tiposdezonas')->tabla('dt_tipos_zonas')->set_blob('mapa', $fp);
		}
	}

	function cargar($seleccion)
	{
		$this->dep('dr_tiposdezonas')->cargar($seleccion);
	}

	function get_tipos_zonas()
	{
		$fp_imagen = $this->dep('dr_tiposdezonas')->tabla('dt_tipos_zonas')->get_blob('mapa');

		$datos = $this->dep('dr_tiposdezonas')->tabla('dt_tipos_zonas')->get();

		if (isset($fp_imagen)) {
			$temp_nombre = 'mapa' . $datos['id_tipo_zona'];

			$temp_archivo = toba::proyecto()->get_www_temp($temp_nombre);

			$temp_imagen = fopen($temp_archivo['path'], 'w');
			stream_copy_to_stream($fp_imagen, $temp_imagen);
			fclose($temp_imagen);
			$tamanio_mapa = round(filesize($temp_archivo['path']) / 1024);
			$datos['mapa_vista'] = "<img src = '{$temp_archivo['url']}' alt=\"Imagen\" WIDTH=180 HEIGHT=150 >";
			$datos['mapa'] = 'Tama�o foto actual: '.$tamanio_mapa.' KB';
		} else {
			$datos['mapa'] = null;
		}
		return $datos;
	}

	function hay_cursor()
	{
		if ($this->dep('dr_tiposdezonas')->tabla('dt_tipos_zonas')->esta_cargada()) {
			return $this->dep('dr_tiposdezonas')->tabla('dt_tipos_zonas')->hay_cursor();
		}
	}

	function set_cursor($seleccion)
	{
		$id_fila = $this->dep('dr_tiposdezonas')->tabla('dt_tipos_zonas')->get_id_fila_condicion($seleccion)[0];
		$this->dep('dr_tiposdezonas')->tabla('dt_tipos_zonas')->set_cursor($id_fila);
	}

	function eliminar()
	{
		$this->dep('dr_tiposdezonas')->tabla('dt_tipos_zonas')->eliminar_todo();
	}

}
?>
