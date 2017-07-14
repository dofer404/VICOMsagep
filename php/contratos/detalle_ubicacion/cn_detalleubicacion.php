<?php
class cn_detalleubicacion extends sagep_cn
{

	function guardar()
	{
	$this->dep('dr_detalleubicacion_detallecontrato')->sincronizar();
	$this->dep('dr_detalleubicacion_detallecontrato')->resetear();
	}

	function cargar()
	{
	$this->dep('dr_detalleubicacion_detallecontrato')->cargar();
	}

	function hay_cursor()
	{
	if ($this->dep('dr_detalleubicacion_detallecontrato')->tabla('dt_detalleubicacion_detallecontrato')->esta_cargada()) {
	return $this->dep('dr_detalleubicacion_detallecontrato')->tabla('dt_detalleubicacion_detallecontrato')->hay_cursor();
	}
	}

	//-----------------------------------------------------------------------------------
	//---- dt_detalleubicacion_detallecontrato -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function procesar_filas_ubicacion($datos)
	{
	//ei_arbol($datos);
	$this->dep('dr_detalleubicacion_detallecontrato')->tabla('dt_detalleubicacion_detallecontrato')->procesar_filas($datos);
	}

	function get_ubicacion()
	{
	$datos = $this->dep('dr_detalleubicacion_detallecontrato')->tabla('dt_detalleubicacion_detallecontrato')->get_filas();
	//ei_arbol($datos);
	return $datos;
	}
}
?>
