<?php
require_once('contratos/gestion_de_contratos/dao_gestiondecontratos.php');
require_once('comunes/mensajes_error.php');

class ci_gestiondecontratos extends sagep_ci
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
		$this->s__datos['modo_edicion'] = 'nuevo'; //para estados
		$this->set_pantalla('pant_nueva');
	}

	function evt__cancelar()
	{
		unset($this->s__datos);
		$this->dep('ci_modificarcontrato')->disparar_limpieza_memoria();
		$this->cn()->reiniciar();
		$this->set_pantalla('pant_inicial');
	}

	function evt__procesar()
	{
		//$this->dep('ci_modificarcontrato')->dep('ci_detallecontrato')->setear_todos_los_formularios();
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

			$datos = dao_gestiondecontratos::get_listado_contratos($sql_where);
			$cuadro->set_datos($datos);
		}
	}

	function evt__cuadro__edicion($seleccion)
	{
		$this->cn()->cargar($seleccion);
		$this->cn()->set_cursor($seleccion);
		$this->s__datos['modo_edicion'] = 'modificacion';
		$this->s__datos['sel_seleccion'] = $seleccion;
		$this->set_pantalla('pant_edicion');
	}

}
?>
