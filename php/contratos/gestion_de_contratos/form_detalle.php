<?php
class form_detalle extends sagep_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------

		{$this->objeto_js}.evt__cantidad__procesar = function(es_inicial)
		{
			var cant_total = this.controlador.dep('ci_detalleubicacion').dep('form_ml_ubicacion').calcular_cantidad();
			this.ef('cantidad').set_estado(cant_total);
		}

		{$this->objeto_js}.evt__monto_total__procesar = function(es_inicial)
		{
			var mon_total = this.controlador.dep('ci_detalleubicacion').dep('form_ml_ubicacion').calcular_monto();
			this.ef('monto_total').set_estado(mon_total);
		}

		{$this->objeto_js}.evt__observaciones__procesar = function(es_inicial)
		{
		}
		";
	}

}
?>
