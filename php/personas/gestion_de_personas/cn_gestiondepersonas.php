<?php
class cn_gestiondepersonas extends sagep_cn
{
	
	//-----------------------------------------------------------------------------------
	//---- Variables --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	protected $temp_archivo;
	protected $temp_nombre;
	protected $temp_imagen;
	
	//-----------------------------------------------------------------------------------
	//---- dr_personas ------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function reiniciar()
	{
		$this->dep('dr_personas')->resetear();
	}
	
	function guardar()
	{
		$this->dep('dr_personas')->sincronizar();
		$this->dep('dr_personas')->resetear();
	}
	
	function eliminar()
	{
		$this->dep('dr_personas')->eliminar_todo();
	}
	
	function cargar($seleccion)
	{
		$this->dep('dr_personas')->cargar($seleccion);
	}
	
	//-----------------------------------------------------------------------------------
	//---- dt_personas ------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function set_personas($datos)
	{
		$this->dep('dr_personas')->tabla('dt_personas')->set($datos);
		if (is_array($datos['logo'])) {
			
			$temp_archivo = $datos['logo']['tmp_name'];
			$fp = fopen($temp_archivo, 'rb');
			$this->dep('dr_personas')->tabla('dt_personas')->set_blob('logo', $fp);
		}
	}
	
	function get_personas()
	{
		$fp_imagen = $this->dep('dr_personas')->tabla('dt_personas')->get_blob('logo');
		
		$datos = $this->dep('dr_personas')->tabla('dt_personas')->get();
		
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
		if ($this->dep('dr_personas')->tabla('dt_personas')->esta_cargada()) {
			return $this->dep('dr_personas')->tabla('dt_personas')->hay_cursor();
		}
	}
	
	function set_cursor($seleccion)
	{
		$id_fila = $this->dep('dr_personas')->tabla('dt_personas')->get_id_fila_condicion($seleccion)[0];
		$this->dep('dr_personas')->tabla('dt_personas')->set_cursor($id_fila);
	}
	
	//-----------------------------------------------------------------------------------
	//---- dt_cuentas -----------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function set_cuentas($datos)
	{
		$this->dep('dr_personas')->tabla('dt_cuentas')->set($datos);
	}
	
	function get_cuentas()
	{
		$datos = $this->dep('dr_personas')->tabla('dt_cuentas')->get();
		return $datos;
	}
	
	//-----------------------------------------------------------------------------------
	//---- dt_telefonos -----------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function procesar_filas_telefonos($datos)
	{
		$this->dep('dr_personas')->tabla('dt_telefonos')->procesar_filas($datos);
	}
	
	function get_telefonos()
	{
		$datos = $this->dep('dr_personas')->tabla('dt_telefonos')->get_filas();
		return $datos;
	}
	
	//-----------------------------------------------------------------------------------
	//---- dt_correos -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function procesar_filas_correos($datos)
	{
		$this->dep('dr_personas')->tabla('dt_correos')->procesar_filas($datos);
	}
	
	function get_correos()
	{
		$datos = $this->dep('dr_personas')->tabla('dt_correos')->get_filas();
		return $datos;
	}
	
	//-----------------------------------------------------------------------------------
	//---- dt_ubicacion -----------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function procesar_filas_direcciones($datos)
	{
		$this->dep('dr_personas')->tabla('dt_personas_detalleubicacion')->procesar_filas($datos);
	}
	
	function get_direcciones()
	{
		$datos = $this->dep('dr_personas')->tabla('dt_personas_detalleubicacion')->get_filas();
		return $datos;
	}
	
	function hay_cursor_direcciones()
	{
		if ($this->dep('dr_personas')->tabla('dt_personas_detalleubicacion')->esta_cargada()) {
			return true;
		}
	}
	
	//-----------------------------------------------------------------------------------
	//---- dt_cuentas -----------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function procesar_filas_cuentas_per($datos)
	{
		$this->dep('dr_personas')->tabla('dt_cuentas')->procesar_filas($datos);
	}
	
	function get_cuentas_per()
	{
		$datos = $this->dep('dr_personas')->tabla('dt_cuentas')->get_filas();
		return $datos;
	}
	
}
?>