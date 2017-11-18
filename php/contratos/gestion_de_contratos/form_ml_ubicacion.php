<?php
class form_ml_ubicacion extends sagep_ei_formulario_ml
{
	//---- Config. EVENTOS sobre fila ---------------------------------------------------

	function conf_evt__vinculo($evento, $fila)
	{
		$evento->vinculo()->agregar_parametro('ubicacion', $this->_datos[$fila]['id_ubicacion']);
		$evento->vinculo()->agregar_parametro('detalle_contrato', $this->_datos[$fila]['id_detalle_contrato']);
	}

}
?>