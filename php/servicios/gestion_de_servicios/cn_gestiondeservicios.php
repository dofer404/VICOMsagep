<?php
class cn_gestiondeservicios extends sagep_cn
{
	//-----------------------------------------------------------------------------------
	//---- Variables --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	protected $temp_archivo;
	protected $temp_nombre;
	protected $temp_imagen;

	//--------------------------------------------------------------------------------------
	//---- dr_servicios --------------------------------------------------------------------
	//--------------------------------------------------------------------------------------

	function guardar()
	{
		$this->dep('dr_servicios')->sincronizar();
		$this->dep('dr_servicios')->resetear();
	}
	function reiniciar()
	{
		$this->dep('dr_servicios')->resetear();
	}

	//----------------------------------------------------------------------------------------
	//---- dt_servicios ----------------------------------------------------------------------
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

	function cargar($seleccion)
	{
		$this->dep('dr_servicios')->tabla('dt_servicios')->cargar($seleccion);
	}

	function get_servicios()
	{
		$fp_imagen = $this->dep('dr_servicios')->tabla('dt_servicios')->get_blob('imagen');

		$datos = $this->dep('dr_servicios')->tabla('dt_servicios')->get();

		if (isset($fp_imagen)) {
			$temp_nombre = 'imagen' . $datos['id_servicio'];

			$temp_archivo = toba::proyecto()->get_www_temp($temp_nombre);

			$temp_imagen = fopen($temp_archivo['path'], 'w');
			stream_copy_to_stream($fp_imagen, $temp_imagen);
			fclose($temp_imagen);
			$tamanio_imagen = round(filesize($temp_archivo['path']) / 1024);
			$datos['imagen_vista'] = "<img src = '{$temp_archivo['url']}' alt=\"Imagen\" WIDTH=180 HEIGHT=150 >";
			$datos['imagen'] = 'Tamaño foto actual: '.$tamanio_imagen.' KB';
		} else {
			$datos['imagen'] = null;
		}

		return $datos;
	}

	function hay_cursor()
	{
		if ($this->dep('dr_servicios')->tabla('dt_servicios')->esta_cargada()) {
			return $this->dep('dr_servicios')->tabla('dt_servicios')->hay_cursor();
		}
	}

	function set_cursor($seleccion)
	{
		$id_fila = $this->dep('dr_servicios')->tabla('dt_servicios')->get_id_fila_condicion($seleccion)[0];
		$this->dep('dr_servicios')->tabla('dt_servicios')->set_cursor($id_fila);
	}

	function eliminar()
	{
		$this->dep('dr_servicios')->tabla('dt_servicios')->eliminar_todo();
	}
}
?>
