<?php
require_once('contratos/listado_detalle/dao_listadodedetalle.php');

class ci_listadodedetalle extends sagep_ci
{
	//-----------------------------------------------------------------------------------
	//---- Variables --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	protected $sql_state;
	protected $s__datos_filtro;
	protected $s__datos;
	
	//-----------------------------------------------------------------------------------
	//---- Filtro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function conf__filtro(sagep_ei_filtro $filtro)
	{
		if (isset($this->s__datos_filtro)) {
			$filtro->set_datos($this->s__datos_filtro);
		}
	}
	
	function evt__filtro__filtrar($datos)
	{
		$this->s__datos_filtro = $datos;
	}
	
	function evt__filtro__cancelar()
	{
		unset($this->s__datos_filtro);
	}
	
	//-----------------------------------------------------------------------------------
	//---- Cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function conf__cuadro(sagep_ei_cuadro $cuadro)
	{
		if (isset($this->s__datos_filtro)) {
			$filtro = $this->dep('filtro');
			$filtro->set_datos($this->s__datos_filtro);
			$sql_where = $filtro->get_sql_where();
			
			$datos = dao_listadodedetalle::get_listado_detalles_contrato($sql_where);
			$cuadro->set_datos($datos);
		}
	}
	
}
?>