<?php
require_once('servicios/listado_servicios/dao_listadodeservicios.php');

class ci_listadoservicios extends sagep_ci
{

	//-----------------------------------------------------------------------------------
	//---- Variables --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	protected $sql_state;
	protected $s__datos_filtro;
	protected $s__datos;
	protected $s__parametros_reporte;

	//-----------------------------------------------------------------------------------
	//---- filtro -----------------------------------------------------------------------
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
			$sql_where = $filtro->get_sql_where();
			$this->s__parametros_reporte=$sql_where;

			$datos = dao_listadodeservicios::get_listado_servicios($sql_where);

			$cuadro->set_datos($datos);
		}
	}

	function vista_jasperreports(toba_vista_jasperreports $reporte)
	{
		//home/marianofrezz/proyectos/toba_2_7_2/exportaciones/jasper/sagep
		$path_toba = '/home/marianofrezz/proyectos/toba_2_7_2';
		$path_reporte = $path_toba . '/exportaciones/jasper/sagep/listado_servicios.jasper';
		$reporte->set_path_reporte($path_reporte);
		$usuario = toba::usuario()->get_nombre();

		$reporte->set_parametro('sql_parametro', 'S', $this->s__parametros_reporte);
	//	$reporte->set_parametro('sql_parametro', 'S', '1=1');

		//$reporte->set_parametro('idUsuarioToba', 'S', $usuario);

		$nombre_archivo = 'listado_servicios';
		$reporte->set_nombre_archivo($nombre_archivo . '.pdf');
		$bd = toba::db('sagep');
		$reporte->set_conexion($bd);
	 }


}
?>
