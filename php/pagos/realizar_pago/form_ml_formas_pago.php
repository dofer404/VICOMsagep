<?php
class form_ml_formas_pago extends sagep_ei_formulario_ml
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------

		{$this->objeto_js}.evt__id_tipo_pago__procesar = function(es_inicial, fila)
		{
			var ef = this.ef('id_tipo_pago');
			for (i=0; i < this.filas().length; i++) {
					var fila_idx = this.filas()[i]
					if (ef.ir_a_fila(fila_idx).tiene_estado()) {
							var idTipoPago = ef.ir_a_fila(fila_idx).get_estado();
							this.controlador.ajax('get_confTiposPagos', idTipoPago, this, this.setCampos);
					}
			}
		}

{$this->objeto_js}.setCampos = function (datos)
{
		var ef_id = this.ef('id_tipo_pago');
		var ef = this.ef('numero_comprobante');
		var ef2 = this.ef('vencimiento');
		var ef3 = this.ef('entidad_financiera');
		var ef4 = this.ef('titular');
		for (i=0; i<this.filas().length;i++) {
				var fila_idx = this.filas()[i];
				if (ef_id.ir_a_fila(fila_idx).tiene_estado()) {
						if (datos['id_tipo_pago'] == ef_id.ir_a_fila(fila_idx).get_estado()) {
								// datos['numero_comprobante']
								if (datos['numero_comprobante']) {
								console.log('Mostramos comprobante');
										ef.mostrar();
								} else {
									console.log('Ocultamos comprobante');
										ef.ocultar();
								}
								// datos['vencimiento']
								if (datos['vencimiento']) {
									console.log('Mostramos vencimiento');
										ef2.mostrar();
								} else {
									console.log('Ocultamos vencimiento');
										ef2.ocultar();
								}
								// datos['entidad_financiera']
								if (datos['entidad_financiera']) {
										this.ef('entidad_financiera').mostrar();
								} else {
									this.ef('entidad_financiera').ocultar();
								}
								// datos['titular']
								if (datos['titular']) {
										ef4.mostrar();
								} else {
										ef4.ocultar();
								}
						}
				}
		}
}
		";
	}

}
?>
