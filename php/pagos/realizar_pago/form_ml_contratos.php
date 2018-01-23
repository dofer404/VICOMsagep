<?php
class form_ml_contratos extends sagep_ei_formulario_ml
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__fecha_contrato__procesar = function(es_inicial, fila)
		{
			mi_ef = this.ef('fecha_contrato').ir_a_fila(fila);

			if (mi_ef.fecha() < (new Date(new Date().getFullYear(),new Date().getMonth(),new Date().getDate()))) {
				mi_ef.input().style='border-color: red; background-color: red; color: whitesmoke; font-weight: bold;';
			} else {
				mi_ef.input().style='';
			}
		}
		";
	}

}
?>