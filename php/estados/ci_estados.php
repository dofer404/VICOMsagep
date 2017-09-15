<?php
class ci_estados extends sagep_ci
{
	//---- Cuadro -----------------------------------------------------------------------

	function conf__cuadro(toba_ei_cuadro $cuadro)
	{
		//$parametros = toba::memoria()->get_parametros('ubicacion');
		$parametro_externo = toba::memoria()->get_parametro('Ubicacion');
		ei_arbol($parametro_externo, 'PARAMETROS recibidos');
		$clave_get = toba::memoria()->get_parametro('fila_safe');
		//ei_arbol($clave_get);
		$cuadro->set_datos($this->dep('datos')->tabla('estados')->get_listado());
	}

	function evt__cuadro__seleccion($datos)
	{
		$this->dep('datos')->cargar($datos);
		$this->set_pantalla('pant_edicion');
	}

	//---- Formulario -------------------------------------------------------------------

	function conf__formulario(toba_ei_formulario $form)
	{
		$parametro_externo = toba::memoria()->get_parametros('id_ubicacion');
		ei_arbol($parametro_externo, 'PARAMETROS recibidos');
		$clave_get = toba::memoria()->get_parametro('fila_safe');
		//ei_arbol($clave_get);
		//$this->dep('datos')->cargar($parametro_externo);

		if ($this->dep('datos')->esta_cargada()) {
			$form->set_datos($this->dep('datos')->tabla('estados')->get());
		} else {
			$this->pantalla()->eliminar_evento('eliminar');
		}
	}

	function evt__formulario__modificacion($datos)
	{
		$this->dep('datos')->tabla('estados')->set($datos);
	}

	function resetear()
	{
		$this->dep('datos')->resetear();
		$this->set_pantalla('pant_seleccion');
	}

	//---- EVENTOS CI -------------------------------------------------------------------

	function evt__agregar()
	{
		$this->set_pantalla('pant_edicion');
	}

	function evt__volver()
	{
		$this->resetear();
	}

	function evt__eliminar()
	{
		$this->dep('datos')->eliminar_todo();
		$this->resetear();
	}

	function evt__guardar()
	{
		$this->dep('datos')->sincronizar();
		$this->resetear();
	}

}
?>
