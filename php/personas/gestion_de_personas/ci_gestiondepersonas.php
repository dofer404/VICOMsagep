<?php
require_once('personas/gestion_de_personas/dao_gestiondepersonas.php');
require_once('comunes/mensajes_error.php');

class ci_gestiondepersonas extends sagep_ci
{
	//-----------------------------------------------------------------------------------
	//---- Variables --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	protected $sql_state;
	protected $s__datos_filtro;
	protected $s__datos;
	protected $s__criterios_filtrado;
	protected $s__parametros_reporte;


	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__nuevo()
	{
		$this->cn()->reiniciar();
		$this->set_pantalla('pant_nueva');
	}

	function evt__cancelar()
	{
		unset($this->s__datos);
		$this->dep('ci_modificarpersona')->disparar_limpieza_memoria();
		$this->cn()->reiniciar();
		$this->set_pantalla('pant_inicial');
	}

	function evt__eliminar()
	{
		try {
			$this->cn()->eliminar();
			$this->cn()->guardar();
			$this->evt__cancelar();
		} catch (toba_error_db $e) {
			if (!mensajes_error::$debug) {
				$sql_state = $e->get_sqlstate();
				mensajes_error::get_mensaje_error($sql_state);
				throw $e;
			}
		}
	}

	function evt__procesar()
	{
		try {
			$this->cn()->guardar();
			$this->evt__cancelar();

		} catch (toba_error_db $e) {
			if (mensajes_error::$debug) {
				throw $e;
			} else {
				$sql_state = $e->get_sqlstate();
				mensajes_error::get_mensaje_error($sql_state);
			}
		}
	}

	//-----------------------------------------------------------------------------------
	//---- Filtro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro(sagep_ei_filtro $filtro)
	{
		//$filtro->columna('apellidos')->set_condicion_fija('es_igual_a');
		if (isset($this->s__datos_filtro)) {
			$filtro->set_datos($this->s__datos_filtro);
		}
	}

	function evt__filtro__filtrar($datos)
	{
		$this->s__datos_filtro = $datos;

		if (trim($this->s__criterios_filtrado['apellidos']['valor']) != 'nopar') {
			$filtro['apellidos']['valor'] = utf8_encode(trim($this->s__criterios_filtrado['apellidos']['valor']));
		}
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
		if (isset($this->s__datos_filtro)) {
			$filtro = $this->dep('filtro');
			$filtro->set_datos($this->s__datos_filtro);
			$sql_where = $filtro->get_sql_where();

			$filtro_reporte = $this->s__datos_filtro;
			$this->s__parametros_reporte=$sql_where;

			$datos = dao_gestiondepersonas::get_listado_personas($sql_where);
			$this->s__datos['cuadro'] = $datos;

			$cuadro->set_datos($datos);

		}
		// if (!(isset($datos) && ! empty($datos))) {
		// 	$this->pantalla()->eliminar_evento('vista_jasperreports');
		// 	$this->pantalla()->eliminar_evento('vista_excel');
		// }
	}

	function evt__cuadro__edicion($seleccion)
	{
		$this->cn()->cargar($seleccion);
		$this->cn()->set_cursor($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	//-----------------------------------------------------------------------------------
	//---- Configuraciones --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	// function conf__pant_edicion(toba_ei_pantalla $pantalla)
	// {
	// 	if (! $this->cn()->hay_cursor()) {
	// 		$pantalla->eliminar_evento('eliminar');
	// 		$pantalla->eliminar_evento('imprimir');
	//
	// 		$this->dep('ci_modificarpersona')->evento('imprimir')->ocultar();
	// 	}
	// }

	function marcar_direccionSeteada()
	{
		$this->s__datos['frm_ml_dir_seteada'] = true;
	}

	function vista_jasperreports(toba_vista_jasperreports $reporte)
	{

		$path_toba = '/home/marianofrezz/proyectos/toba_2_7_2';
		$path_reporte = $path_toba . '/exportaciones/jasper/sagep/persona.jasper';

		$reporte->set_path_reporte($path_reporte);
		$usuario = toba::usuario()->get_nombre();
		$reporte->set_parametro('idUsuarioToba', 'S', $usuario);
		//$reporte->set_parametro('sql_parameto', 'S', $this->s__parametros_reporte);

		$nombre_archivo = 'listado_personas';
		$reporte->set_nombre_archivo($nombre_archivo . '.pdf');
		$bd = toba::db('sagep');
		$reporte->set_conexion($bd);

	// 	$reporte->set_path_reporte($path_reporte);
	//
	// 	$filtro_reporte = $this->s__datos_filtro;
	//
	// 	//$report='personas.jasper';
	// 	//$path_reporte = toba::proyecto()->get_path().'/exportaciones/jasper/'.$report;
	//
	// 	//$reporte->set_path_reporte($path_reporte);
	// 	$usuario = toba::usuario()->get_nombre();
	// //	$reporte->set_parametro('usuarioToba', 'S', $usuario);
	//
	//
	// 	//Parametro para el titulo
	// 	$reporte->set_parametro('titulo', 'S', 'LISTADO PERSONAL POR APELLIDO');
	//
	// 	//Parametros para el encabezado del titulo
	// 	//$report->set_parametro('imagenpj','S',$path_imagen_pj['path']);
	// 	//$report->set_parametro('imagenprov','S',$path_imagen_provincia['path']);
	//
	// 	//Parametros para el usuario
	// 	$reporte->set_parametro('usuario', 'S', toba::usuario()->get_id());
	//
	// 	//Parametros segun las opciones de filtrado
	// 	// $filtro = '%%';
	// 	//
	// 	// if ((trim($this->s__criterios_filtrado['apellidos']['valor']) != '')) {
	// 	// 	if (trim($this->s__criterios_filtrado['apellidos']['valor']) != 'nopar') {
	// 	// 		$filtro = utf8_encode(trim($this->s__criterios_filtrado['apellidos']['valor']));
	// 	// 	}
	// 	// }
	//
	// $reporte->set_parametro('idpersona', 'S', $filtro_reporte);
	// 	$reporte->set_parametro('nombres', 'S', $filtro);
	//
	// 	$nombre_archivo = 'listado_personas';
	// 	$reporte->set_nombre_archivo($nombre_archivo . '.pdf');
	// 	$bd = toba::db('sagep');
	// 	$reporte->set_conexion($bd);
	// }
	//
	// function ajax__get_datos_apellido($apellidos, toba_ajax_respuesta $respuesta)
	// {
	// 	$this->s__criterios_filtrado['apellidos']['condicion'] = 'es_igual_a';
	// 	$this->s__criterios_filtrado['apellidos']['valor'] = $apellidos;
	// 	$respuesta->set($apellidos);
	// }
	//
	// function ajax__get_datos_nombre($nombres, toba_ajax_respuesta $respuesta)
	// {
	// 	$this->s__criterios_filtrado['apellidos']['condicion'] = 'es_igual_a';
	// 	$this->s__criterios_filtrado['nombres']['valor'] = $nombres;
	// 	$respuesta->set($nombres);
	// }
	//
	// function vista_pdf(toba_vista_pdf $salida)
	// {
	// 	// /home/marianofrezz/proyectos/toba_2_7_2/exportaciones/jasper/sagep
	// 	$path_toba = '/home/marianofrezz/proyectos/toba_2_7_2';
	// 	$path_reporte = $path_toba . '/exportaciones/jasper/sagep/personas.jasper';
	// 	$reporte->set_path_reporte($path_reporte);
	// 	$usuario = toba::usuario()->get_nombre();
	// 	//$apellido = $this->dep('filtro')->columna('apellidos')->get_estado();
	//
	//
	//
	// 	$reporte->set_parametro('usuarioToba', 'S', $usuario);
	// 	//$reporte->set_parametro('apellido', 'E', $apellido);
	//
	// 	$nombre_archivo = 'listado_personas';
	// 	$reporte->set_nombre_archivo($nombre_archivo . '.pdf');
	// 	$bd = toba::db('sagep');
	// 	$reporte->set_conexion($bd);
	}

	function vista_excel(toba_vista_excel $salida)
	{
		$excel = $salida->get_excel();
		$excel->setActiveSheetIndex(0);
		$excel->getActiveSheet()->setTitle('Principal');
		$this->dependencia('cuadro')->vista_excel($salida);
	}

}
?>
