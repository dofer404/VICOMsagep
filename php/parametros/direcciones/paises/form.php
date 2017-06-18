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

		{$this->objeto_js}.evt__nombre_pais__procesar = function(es_inicial)
		{
			var ef=this.ef('nombre_pais');

			if(ef.tiene_estado)
			{
			ef.set_estado(ef.get_estado().charAt(0).toUpperCase()+ef.get_estado().slice(1).toLowerCase());
			}
		}
		//---- Procesamiento de EFs --------------------------------

		{$this->objeto_js}.evt__sigla_pais__procesar = function(es_inicial)
		{
      var ef=this.ef('sigla_pais');

      if(ef.tiene_estado){
        ef.set_estado(ef.get_estado().toUpperCase());
      }
		}
		";
	}


}
?>
