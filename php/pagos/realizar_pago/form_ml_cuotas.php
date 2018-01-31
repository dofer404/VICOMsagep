<?php
class form_ml_cuotas extends sagep_ei_formulario_ml
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__seleccionar__procesar = function(es_inicial, fila)
		{
			var ef = this.ef('seleccionar');
			var ef_importe = this.ef('monto');
			var ef_total = this.ef('monto_total');
			
			for (i=0; i<this.filas().length;i++) {
			var fila_idx = this.filas()[i]
			var estado = ef.ir_a_fila(fila_idx).get_estado()
				if (estado) {
				ef_total.ir_a_fila(fila_idx).set_estado(ef_importe.get_estado());
				} else {
				ef_total.ir_a_fila(fila_idx).set_estado(0);
			}
			}
		}
		";
	}

}
?>