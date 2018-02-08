<?php
require_once('personas/listado_personas/dao_listadodepersonas.php');

class ci_listadodepersonas extends sagep_ci
{

	//-----------------------------------------------------------------------------------
	//---- Variables --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	protected $s__parametros_reporte;

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
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(sagep_ei_cuadro $cuadro)
	{
		//$cuadro->desactivar_modo_clave_segura();
		if (isset($this->s__datos_filtro)) {
			$filtro = $this->dep('filtro');
			$filtro->set_datos($this->s__datos_filtro);
			//$s__parametros_reporte=$sql_where;
			$sql_where = $filtro->get_sql_where();
			$this->s__parametros_reporte=$sql_where;
			ei_arbol($this->s__parametros_reporte);


			$datos = dao_listadodepersonas::get_listado_personas($sql_where);

			$cuadro->set_datos($datos);
		}
	}

	function vista_jasperreports(toba_vista_jasperreports $reporte)
	{
		//home/marianofrezz/proyectos/toba_2_7_2/exportaciones/jasper/sagep
		$path_toba = '/home/marianofrezz/proyectos/toba_2_7_2';
		$path_reporte = $path_toba . '/exportaciones/jasper/sagep/personas_reporte.jasper';
		$reporte->set_path_reporte($path_reporte);
		$usuario = toba::usuario()->get_nombre();
		$reporte->set_parametro('idUsuarioToba', 'S', $usuario);
		$reporte->set_parametro('sql_parameto', 'S', $this->s__parametros_reporte);

		$nombre_archivo = 'listado_personas';
		$reporte->set_nombre_archivo($nombre_archivo . '.pdf');
		$bd = toba::db('sagep');
		$reporte->set_conexion($bd);
	 }
}
?>
