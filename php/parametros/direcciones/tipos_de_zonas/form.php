<?php
class form extends sagep_ei_formulario
{

	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------

		{$this->objeto_js}.evt__sigla_tipozona__procesar = function(es_inicial)
		{
		var ef=this.ef('sigla_tipozona');

		if(ef.tiene_estado){
		ef.set_estado(ef.get_estado().toUpperCase());
		}
		}

		{$this->objeto_js}.evt__nombre_tipozona__procesar = function(es_inicial)
		{
		}
		";
	}

}
?>