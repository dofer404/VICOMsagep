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

		{$this->objeto_js}.evt__direccion__procesar = function(es_inicial)
		{
      var ef=this.ef('direccion');

      if(ef.tiene_estado)
      {
      ef.set_estado(ef.get_estado().charAt(0).toUpperCase()+ef.get_estado().slice(1).toLowerCase());
      }
		}

		{$this->objeto_js}.evt__calle2__procesar = function(es_inicial)
		{
      var ef=this.ef('calle2');

      if(ef.tiene_estado)
      {
      ef.set_estado(ef.get_estado().charAt(0).toUpperCase()+ef.get_estado().slice(1).toLowerCase());
      }
		}
		";
	}

}
?>
