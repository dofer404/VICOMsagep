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
			var ef_descuento = this.ef('descuento');
			var ef_recargo = this.ef('recargo');

			for (i=0; i<this.filas().length;i++) {
			var fila_idx = this.filas()[i]
			var estado = ef.ir_a_fila(fila_idx).get_estado();
				if (estado) {
			for(i=0; i<fila_idx;i++){
				this.ef('seleccionar').ir_a_fila(fila_idx).chequear(true);
			}
				
				ef_total.ir_a_fila(fila_idx).set_estado(ef_importe.get_estado());
				ef_descuento.ir_a_fila(fila_idx).set_solo_lectura(false);
				ef_descuento.ir_a_fila(fila_idx).set_estado(0);
				ef_recargo.ir_a_fila(fila_idx).set_solo_lectura(false);
				ef_recargo.ir_a_fila(fila_idx).set_estado(0);
				} else {
				ef_total.ir_a_fila(fila_idx).set_estado(0);
				ef_descuento.ir_a_fila(fila_idx).set_solo_lectura(true);
				ef_descuento.ir_a_fila(fila_idx).set_estado('');
				ef_recargo.ir_a_fila(fila_idx).set_solo_lectura(true);
				ef_recargo.ir_a_fila(fila_idx).set_estado('');

			}
			}
		}
		";
	}


}
?>