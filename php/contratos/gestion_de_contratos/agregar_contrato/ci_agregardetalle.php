<?php
require_once('contratos/gestion_de_contratos/dao_gestiondecontratos.php');
require_once('comunes/cache_form_ml.php');

class ci_agregardetalle extends sagep_ci
{
  //-----------------------------------------------------------------------------------
	//---- Variables ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	protected $sql_state;
	protected $s__datos;


	//-----------------------------------------------------------------------------------
	//---- setters y getters ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	// getter form_ml_cache

	function get_cache_form_ml($nombre_ml)
	{
		if (!isset($this->s__datos[$nombre_ml])) {
			$this->s__datos[$nombre_ml] = new cache_form_ml();
		}
		return $this->s__datos[$nombre_ml];
	}

	// form_detalle

	function get_cache_form_detalle()
	{
		$datos = [];
		if (isset($this->s__datos['form_detalle'])) {
			$datos = $this->s__datos['form_detalle'];
		}
		return $datos;
	}

	function set_cache_form_detalle(array $datos)
	{
		$this->s__datos['form_detalle'] = $datos;
	}

	function unset_datos_form_detalle()
	{
		$datos = $this->get_cache_form_detalle();
		unset($this->s__datos['form_detalle']);
	}

	function unset_datos_form_ubicacion()
	{
		$datos = $this->get_cache_form_ml('form_ml_ubicacion');
		unset($this->s__datos['form_ml_ubicacion']);
	}

	function set_cursor_detalle($id_fila)
	{
		$this->s__datos['form_detalle.cursor'] = $id_fila;
	}

	function unset_cursor_detalle()
	{
		unset($this->s__datos['form_detalle.cursor']);
	}

	function get_cursor_detalle()
	{
		return $this->s__datos['form_detalle.cursor'];
	}

	function hay_cursor_detalle()
	{
		return isset($this->s__datos['form_detalle.cursor']);
	}

	//-----------------------------------------------------------------------------------
	//---- Auxiliares -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function procesar_cacnelar_pedido_registro_nuevo_detalle()
	{
		$this->procesar_pedido_registro_nuevo_detalle(true);
	}

	function procesar_aceptar_pedido_registro_nuevo_detalle()
	{
		$this->procesar_pedido_registro_nuevo_detalle(false);
	}

	function procesar_pedido_registro_nuevo_detalle($cancelar=false)
	{
		$ml_dets = $this->get_cache_form_ml('form_ml_detalle');
		if ($ml_dets->hay_pedido_registro_nuevo()) {
			$ml_dets->set_pedido_registro_nuevo(false);
			if ($this->cn()->hay_cursor_detalle()) {
				if ($cancelar) {
					$this->cn()->eliminar_fila_cursor_detalle();
				} else {
					$this->cn()->resetear_cursor_detalle();
					$ml_dets->unset_cache();
				}
			}
		}
	}

	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__cancelar()
	{
		$this->procesar_cacnelar_pedido_registro_nuevo_detalle();

		$this->borrar_memoria();
		unset($this->s__datos);
		$this->dep('ci_agregarubicacion')->unset_datos_form_ml_ubicacion();
		$this->set_pantalla('detalle');
	}

	function evt__procesar()
	{
		$this->procesar_aceptar_pedido_registro_nuevo_detalle();
		$this->set_pantalla('detalle');
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml_detalle --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_detalle($form_ml)
	{

		$this->procesar_cacnelar_pedido_registro_nuevo_detalle();

		$cache_ml = $this->get_cache_form_ml('form_ml_detalle');
		$datos = $cache_ml->get_cache();

		if (!$datos) {
			if ($this->cn()->hay_cursor() ) {
				$datos = $this->cn()->get_detalle();
				$cache_ml->set_cache($datos);
			}
		}
		//
		// if(!$datos){
		// 	$this->controlador()->pantalla()->eliminar_evento('cambiar_tab__siguiente');
		// 	$this->controlador()->controlador()->pantalla()->agregar_notificacion('No hay registros cargados', 'warning');
		// }

		$form_ml->set_datos($datos);
		$cache_ml->set_ml_procesado();
		$this->cn()->resetear_cursor_detalle();
	}

	function evt__form_ml_detalle__modificacion($datos)
	{
		$this->cn()->procesar_filas_detalle($datos);
		$datos = $this->cn()->get_detalle();
		$this->get_cache_form_ml('form_ml_detalle')->set_cache($datos);
	}

	function evt__form_ml_detalle__detalle($seleccion)
	{
		$this->dep('ci_agregarubicacion')->unset_datos_form_ml_ubicacion();

		$datos_fila = $this->get_cache_form_ml('form_ml_detalle')->get_cache_fila($seleccion);
		$this->set_cache_form_detalle($datos_fila);

		if ($this->cn()->existe_fila_detalle($seleccion) ) {
			$this->cn()->set_cursor_detalle($seleccion);
			$datos_ubicaciones = $this->cn()->get_ubicacion();
			$this->get_cache_form_ml('form_ml_ubicacion')->set_cache($datos_ubicaciones);
		}

		$this->set_pantalla('ubicacion');
	}

	function evt__form_ml_detalle__pedido_registro_nuevo()
	{
		$this->get_cache_form_ml('form_ml_detalle')->set_pedido_registro_nuevo(true);
		$this->unset_datos_form_detalle();
		$this->unset_datos_form_ubicacion();
		$this->dep('ci_agregarubicacion')->unset_datos_form_ml_ubicacion();
		$this->set_pantalla('ubicacion');
	}

	//-----------------------------------------------------------------------------------
	//---- form_detalle -----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__form_detalle__modificacion($datos)
	{
		$this->set_cache_form_detalle($datos);

		$cache_ml_dets = $this->get_cache_form_ml('form_ml_detalle');
		if ($cache_ml_dets->hay_pedido_registro_nuevo()) {
			if (!$this->cn()->hay_cursor_detalle()) {
				$id_interno_fila = $this->cn()->nueva_fila_detalle($datos);
				$this->cn()->set_cursor_detalle($id_interno_fila);
			} else {
				$this->cn()->set_detalle($datos); //nueva linea
			}
		} else {
			if ($cache_ml_dets->hay_cursor_cache()) {
				$id_fila = $cache_ml_dets->get_cursor_cache();
				$cache_ml_dets->set_cache_fila($id_fila, $datos);
			} else {
				if($this->cn()->hay_cursor_detalle()){
					$this->cn()->set_detalle($datos);
			}
		}
	}
}

	function conf__form_detalle(sagep_ei_formulario $form)
	{
		if ($this->cn()->hay_cursor_detalle()) {
			$datos = $this->get_cache_form_detalle();
			if (!$datos) {
				$datos = $this->cn()->get_unDetalle();
			}

			$cant_total = $this->dep('ci_agregarubicacion')->calcular_cantidad();

			$datos = array_merge($datos, $cant_total);

			$form->set_datos($datos);
		}
	}

	//-----------------------------------------------------------------------------------
	//---- Auxiliares --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function calcular_monto($meses)
	{
	 $datos_detalle = $this->get_cache_form_ml('form_ml_detalle')->get_cache();
	 $monto = 0;

	 foreach ($datos_detalle as $key => $value) {
		$monto += $value['monto_total'];
	 }
	 $monto=$monto*$meses;

	 return ['monto_total'=>$monto];
}

	//-----------------------------------------------------------------------------------
	//---- form_ml_ubicacion ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_ubicacion(sagep_ei_formulario_ml $form_ml)
	{
		$cache_ml_ubicacion = $this->get_cache_form_ml('form_ml_ubicacion');
		$datos = $cache_ml_ubicacion->get_cache();
		$form_ml->set_datos($datos);
	}

	function evt__form_ml_ubicacion__modificacion($datos)
	{
		$this->cn()->procesar_filas_ubicacion($datos);
		$datos = $this->cn()->get_ubicacion();

		$valores = $this->get_cache_form_ml('form_ml_ubicacion')->set_cache($datos);
	}


	function evt__form_ml_ubicacion__ver_imagenes($seleccion)
	{
		$this->get_cache_form_ml('form_ml_ubicacion')->set_cursor_cache($seleccion);
	}

	function conf_evt__form_ml_ubicacion__agregar_ubicacion(toba_evento_usuario $evento, $fila)
	{
		$cache_ml_ubicacion = $this->get_cache_form_ml('form_ml_ubicacion');
		$datos = $cache_ml_ubicacion->get_cache();

		if (isset($datos[$fila])) {
				//$evento->desactivar();
		} else {
			$evento->activar();
		}
	}

	function evt__form_ml_ubicacion__ver_estado($seleccion)
	{
		$this->get_cache_form_ml('form_ml_ubicacion')->set_cursor_cache($seleccion);
	}

	function conf_evt__form_ml_ubicacion__cambiar_estado(toba_evento_usuario $evento, $fila)
	{
		$cache_ml_ubicacion = $this->get_cache_form_ml('form_ml_ubicacion');
		$datos = $cache_ml_ubicacion->get_cache();

		if (!isset($datos[$fila])) {
			$evento->anular();
		}
	}

		function conf_evt__form_ml_ubicacion__vinculo(toba_evento_usuario $evento, $fila)
		{
			$cache_ml_ubicacion = $this->get_cache_form_ml('form_ml_ubicacion');
			$datos = $cache_ml_ubicacion->get_cache();
			if (!isset($datos[$fila])) {
				$evento->anular();
			}
		}

		function conf_evt__form_ml_ubicacion__ver_imagenes(toba_evento_usuario $evento, $fila)
		{
			$cache_ml_ubicacion = $this->get_cache_form_ml('form_ml_ubicacion');
			$datos = $cache_ml_ubicacion->get_cache();
			if (!isset($datos[$fila])) {
				$evento->anular();
			}
		}

		function evt__form_ml_ubicacion__cambiar_estado($seleccion)
		{
			$cache_ml_ubicacion = $this->get_cache_form_ml('form_ml_ubicacion');
			$cache_ml_ubicacion->set_cursor_cache($seleccion);
		}

	//-----------------------------------------------------------------------------------
	//---- Configuraciones --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__ubicacion(toba_ei_pantalla $pantalla)
	{
		$this->controlador()->pantalla()->eliminar_evento('procesar');
	//	$this->controlador()->pantalla()->eliminar_evento('eliminar');
		$this->controlador()->pantalla()->eliminar_evento('cancelar');
		$this->controlador()->pantalla()->eliminar_evento('cambiar_tab__anterior');
		$this->controlador()->pantalla()->eliminar_evento('cambiar_tab__siguiente');

	// 	$this->controlador()->pantalla()->set_descripcion("Detalles del Contrato <br/>
	// 	 <br/> <li>Presione \"Agregar\" para ingresar un nuevo detalle</li>
  //                         <li>Presione \"Siguiente\" para continuar o \"Cancelar\" para anular la operación </li>
	// 												<div style = 'text-align:right'>Nota: Presione \"Anterior\" para volver a la Pantalla Anterior </div> ");
	}

	function post_eventos()
	{
		// Debemos usar este evento para setear el cursor del dt de cambio_lineas porque de lo contrario el cursor se setea muy temprano y los registros se vinculan incorrectamente
		$cache_frm_ubicacion = $this->get_cache_form_ml('form_ml_ubicacion');
		if ($cache_frm_ubicacion->hay_cursor_cache()) {
			$cursor = $cache_frm_ubicacion->get_cursor_cache();
			$cache_frm_ubicacion->unset_cursor_cache();
			$this->cn()->set_cursor_ubicaciones($cursor);
		}
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml_fotos ----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_fotos(sagep_ei_formulario_ml $form_ml)
	{
		if ($this->cn()->hay_cursor_ubicaciones()) {
			$datos = $this->cn()->get_fotos();
			$datos = $this->cn()->get_blobs($datos);
			$form_ml->set_datos($datos);
		} else {
			$form_ml->desactivar_agregado_filas();
		}

	}

	function evt__form_ml_fotos__modificacion($datos)
	{
		$anterior = $this->get_cache_form_ml('form_ml_fotos');
		foreach ($anterior as $keya => $valuea) {
			foreach ($datos as $keyd => $valued) {
				if (isset($valuea['id_foto_servicio'])){
					if (isset($valued['id_foto_servicio'])){
						if ($valuea['id_foto_servicio']=$valued['id_foto_servicio']){
							if (isset($valuea['imagen']) && !isset($valued['imagen'])){
								$datos[$keyd]['imagen'] = $valuea['imagen'];
								$datos[$keyd]['imagen?html'] = $valuea['imagen?html'];
								$datos[$keyd]['imagen?url'] = $valuea['imagen?url'];
							}
						}
					}
				}
			}
		}
		$this->s__datos['form_ml_fotos'] = $datos;
		if (isset ($this->s__datos['form_ml_fotos'])){
			$this->cn()->procesar_filas_fotos($this->s__datos['form_ml_fotos']);
			$this->cn()->set_blobs($this->s__datos['form_ml_fotos']);
			}

		//$this->cn()->resetear_cursor_ubicaciones();

	}


	//-----------------------------------------------------------------------------------
	//---- form_ml_estados --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_estados(sagep_ei_formulario_ml $form_ml)
	{
		if ($this->cn()->hay_cursor_ubicaciones()) {
			$datos = $this->cn()->get_estados();
			$form_ml->set_datos($datos);
		} else {
			$form_ml->desactivar_agregado_filas();
		}

	}

	function evt__form_ml_estados__modificacion($datos)
	{
		$this->cn()->procesar_filas_estados($datos);
		$this->cn()->resetear_cursor_ubicaciones();
	}

	function evt__form_ml_detalle__registro_alta($datos, $id_fila)
	{
	}

	// function conf__detalle(toba_ei_pantalla $pantalla)
	// {
	// 	if($pantalla->get_etiqueta() == 'Detalles del Contrato'){
	// 		$this->controlador()->pantalla('detalle')->set_descripcion("Ingrese Detalles del Contrato <br/>
	// 		 <br/> <li>Presione \"Agregar\" para ingresar un Nuevo Detalle</li>
	//                           <li>Presione \"Siguiente\" para continuar o \"Cancelar\" para anular la operación </li>
	// 													<div style = 'text-align:right'>Nota: Presione \"Anterior\" para volver a la Pantalla Anterior </div> ");
	// 	}
	// }

	function conf()
	{
			// if($this->pantalla()->get_etiqueta() == 'Detalles del Contrato'){
			// 	$this->controlador()->pantalla('detalle')->set_descripcion("Ingrese Detalles del Contrato <br/>
			// 	 <br/> <li>Presione \"Agregar\" para ingresar un Nuevo Detalle</li>
		  //                         <li>Presione \"Siguiente\" para continuar o \"Cancelar\" para anular la operación </li>
			// 												<div style = 'text-align:right'>Nota: Presione \"Anterior\" para volver a la Pantalla Anterior </div> ");
			// }
	}

}
?>
