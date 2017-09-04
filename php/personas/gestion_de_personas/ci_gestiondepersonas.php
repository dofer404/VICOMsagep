<?php
require_once('personas/gestion_de_personas/dao_gestiondepersonas.php');
require_once('mensajes_error.php');

class ci_gestiondepersonas extends sagep_ci
{
	//-----------------------------------------------------------------------------------
	//---- Variables --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	protected $sql_state;
	protected $s__datos_filtro;
	protected $s__datos;

	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__nuevo()
	{
		$this->cn()->reiniciar();
		$this->set_pantalla('pant_edicion');
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
			if (mensajes_error::$debug) {
				throw $e;
			} else {
				$this->cn()->reiniciar();
				$sql_state = $e->get_sqlstate();
				mensajes_error::get_mensaje_error($sql_state);
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
				$this->cn()->reiniciar();
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
				if (isset($this->s__datos_filtro)) {
					$filtro = $this->dep('filtro');
					$filtro->set_datos($this->s__datos_filtro);
					$sql_where = $filtro->get_sql_where();

					$datos = dao_gestiondepersonas::get_listado_personas($sql_where);

					$cuadro->set_datos($datos);
				}
			}

			function evt__cuadro__edicion($seleccion)
			{
				$this->cn()->cargar($seleccion);
				$this->cn()->set_cursor($seleccion);
				$this->set_pantalla('pant_edicion');
			}

			function evt__cuadro__eliminar($seleccion)
			{
			}

				//-----------------------------------------------------------------------------------
				//---- Configuraciones --------------------------------------------------------------
				//-----------------------------------------------------------------------------------

			function conf__pant_edicion(toba_ei_pantalla $pantalla)
			{
				if (! $this->cn()->hay_cursor()) {
					$this->pantalla()->eliminar_evento('eliminar');
					$this->pantalla()->eliminar_evento('imprimir');
					$this->dep('ci_modificarpersona')->evento('imprimir')->ocultar();
				}
			}

			function marcar_direccionSeteada()
			{
				$this->s__datos['frm_ml_dir_seteada'] = true;
			}

			function vista_jasperreports(toba_vista_jasperreports $reporte)
			{
				// /home/marianofrezz/proyectos/toba_2_7_2/exportaciones/jasper/sagep
				$path_toba = '/home/marianofrezz/proyectos/toba_2_7_2';
				$path_reporte = $path_toba . '/exportaciones/jasper/sagep/reporte_personas.jasper';
				$reporte->set_path_reporte($path_reporte);
				$usuario = toba::usuario()->get_nombre();
				$idPersona = $this->dep('ci_modificarpersona')->traer_persona();

				$reporte->set_parametro('usuarioToba', 'S', $usuario);
				$reporte->set_parametro('idPersona', 'E', $idPersona);

				$nombre_archivo = $this->s__datos['form']['entidad'];
				$reporte->set_nombre_archivo($nombre_archivo . '.pdf');
				$bd = toba::db('sagep');
				$reporte->set_conexion($bd);
			}

		}
?>
