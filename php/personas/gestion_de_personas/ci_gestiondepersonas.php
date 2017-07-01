<?php
require_once('personas/gestion_de_personas/dao_gestiondepersonas.php');
require_once('adebug.php');

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
		$this->cn()->resetear();
		$this->set_pantalla('pant_edicion');
	}

	function evt__cancelar()
	{
		unset($this->s__datos);
		$this->dep('ci_modificarpersona')->disparar_limpieza_memoria();
		$this->cn()->resetear();
		$this->set_pantalla('pant_inicial');
	}

	function evt__eliminar()
	{
		$this->cn()->eliminar();
		$this->evt__procesar();
	}

	function evt__procesar()
	{
		$guardado = false;
		try {
			$this->cn()->sincronizar();
			$this->cn()->resetear();
			$this->evt__cancelar();

		} catch (toba_error_db $e) {
			if (adebug::$debug) {
				throw $e;
			} else {
				$this->cn()->resetear();
				$sql_state = $e->get_sqlstate();
				if ($sql_state == 'db_23505') {
					throw new toba_error_usuario('Ya existe la Persona');
				}
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
				$cuadro->desactivar_modo_clave_segura();
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
				$this->cn()->resetear();
				$this->cn()->cargar($seleccion);
				$this->cn()->eliminar();
				$this->cn()->resetear();
				$this->set_pantalla('pant_inicial');
			}

			//-----------------------------------------------------------------------------------
			//---- Configuraciones --------------------------------------------------------------
			//-----------------------------------------------------------------------------------

			function conf__pant_edicion(toba_ei_pantalla $pantalla)
			{
				if (! $this->cn()->hay_cursor()) {
					$this->pantalla()->eliminar_evento('eliminar');
				}
			}
			
			function marcar_direccionSeteada()
			{
				$this->s__datos['frm_ml_dir_seteada'] = true;
			}

		}
?>
