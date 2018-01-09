<?php
class form_ml_roles extends sagep_ei_formulario_ml
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
				
		//---- Validacion de EFs -----------------------------------
		
		{$this->objeto_js}.evt__id_persona__validar = function(fila)
		{
			this.ef('id_persona').ir_a_fila(fila).set_error('error');

		}
		
		{$this->objeto_js}.evt__id_rol__validar = function(fila)
		{
			this.ef('id_rol').ir_a_fila(fila).set_error('Debe seleccionar una Opcion');
		}
		";
	}





}
?>