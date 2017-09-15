<?php
class filtro extends sagep_ei_filtro
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		{$this->objeto_js}.actualizar_datos = function(datos)
		{
		}
		//---- Procesamiento de EFs --------------------------------
		
			{$this->objeto_js}.evt__apellidos__procesar = function(es_inicial)
			{
			if (!es_inicial) {
			apellidos = this.ef('apellidos').get_estado();
			this.controlador.ajax('get_datos_apellido', apellidos, this, this.actualizar_datos);
			}
		}
		";
	}



}
?>