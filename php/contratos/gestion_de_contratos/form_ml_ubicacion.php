<?php
class form_ml_ubicacion extends sagep_ei_formulario_ml
{
	//---- Config. EVENTOS sobre fila ---------------------------------------------------

	function conf_evt__vinculo($evento, $fila)
	{
		if (isset($this->_datos[$fila]['id_detalle_contrato'])){
			$evento->activar();
			$evento->vinculo()->agregar_parametro('ubicacion', $this->_datos[$fila]['id_ubicacion']);
			$evento->vinculo()->agregar_parametro('detalle_contrato', $this->_datos[$fila]['id_detalle_contrato']);
		} else {
			$evento->desactivar();
		}
	}

	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------

		{$this->objeto_js}.evt__cantidad__procesar = function(es_inicial, fila)
		{
		}

		{$this->objeto_js}.calcular_cantidad = function()
		{
			var cant_total = 0;
			for (i = 0; i < this.filas().length; i++) {
				fila = this.filas()[i];
				cant_total = cant_total + this.ef('cantidad').ir_a_fila(fila).get_estado();
			}
			return cant_total;
		}

		{$this->objeto_js}.calcular_monto = function()
		{
			var mon_total = 0;
			for (i = 0; i < this.filas().length; i++) {
				fila = this.filas()[i];
				mon_total = mon_total + this.ef('monto_total').ir_a_fila(fila).get_estado();
			}
			return mon_total;
		}
		";
	}

}
?>
