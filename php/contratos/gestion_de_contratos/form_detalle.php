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
		}
		
		{$this->objeto_js}.evt__monto_total__procesar = function(es_inicial)
		{
					var cantidad = this.ef('cantidad').valor();
					this.ef('monto_total').cambiar_valor(cantidad*200);

		}
		
		{$this->objeto_js}.evt__observaciones__procesar = function(es_inicial)
		{
		}
		";
	}

}
?>