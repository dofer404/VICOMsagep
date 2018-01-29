<?php
class cn_configurarempresa extends sagep_cn
{

	//-----------------------------------------------------------------------------------
	//---- Variables --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	protected $temp_archivo;
	protected $temp_nombre;
	protected $temp_imagen;

	//-----------------------------------------------------------------------------------
	//---- dr_datos_empresa -------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function reiniciar()
	{
		$this->dep('dr_datos_empresa')->resetear();
	}

	function guardar()
	{
		$this->dep('dr_datos_empresa')->sincronizar();
		$this->dep('dr_datos_empresa')->resetear();
	}

	function eliminar()
	{
		$this->dep('dr_datos_empresa')->eliminar_todo();
	}

	//-----------------------------------------------------------------------------------
	//---- dt_datos_empresa -------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function set_empresa($datos)
	{
		$this->dep('dr_datos_empresa')->tabla('dt_datos_empresa')->set($datos);

		if (is_array($datos['logo'])) {

			$temp_archivo = $datos['logo']['tmp_name'];
			$fp = fopen($temp_archivo, 'rb');
			$this->dep('dr_datos_empresa')->tabla('dt_datos_empresa')->set_blob('logo', $fp);
		}
	}

	function cargar($seleccion)
	{
		$this->dep('dr_datos_empresa')->tabla('dt_datos_empresa')->cargar($seleccion);
	}

	function get_empresa()
	{
		$fp_imagen = $this->dep('dr_datos_empresa')->tabla('dt_datos_empresa')->get_blob('logo');

		$datos = $this->dep('dr_datos_empresa')->tabla('dt_datos_empresa')->get();

		if (isset($fp_imagen)) {
			$temp_nombre = 'logo' . $datos['id_persona'];

			$temp_archivo = toba::proyecto()->get_www_temp($temp_nombre);

			$temp_imagen = fopen($temp_archivo['path'], 'w');
			stream_copy_to_stream($fp_imagen, $temp_imagen);
			fclose($temp_imagen);
			$tamanio_logo = round(filesize($temp_archivo['path']) / 1024);

			$datos['logo_vista'] = "<img src = '{$temp_archivo['url']}' alt=\"Imagen\" WIDTH=180 HEIGHT=150 >";
			$datos['logo'] = 'Tamaño foto actual: '.$tamanio_logo.' KB';
		} else {
			$datos['logo'] = null;
		}

		return $datos;
	}

	function hay_cursor()
	{
		if ($this->dep('dr_datos_empresa')->tabla('dt_datos_empresa')->esta_cargada()) {
			return $this->dep('dr_datos_empresa')->tabla('dt_datos_empresa')->hay_cursor();
		}
	}

	function set_cursor($seleccion)
	{
		$id_fila = $this->dep('dr_datos_empresa')->tabla('dt_datos_empresa')->get_id_fila_condicion($seleccion)[0];
		$this->dep('dr_datos_empresa')->tabla('dt_datos_empresa')->set_cursor($id_fila);
	}

}
?>
