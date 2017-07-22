<?php
class form_ml_ubicacion extends sagep_ei_formulario_ml
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Eventos ---------------------------------------------

		{$this->objeto_js}.modificar_vinculo__ver_imagenes = function(id_vinculo)
		{

			var parametros = { nota2: 'Esto se agrego en JAVASCRIPT', mes: 'octubre', estacion: 'primavera'};
			vinculador.agregar_parametros(id_vinculo, parametros);
		}
		";
	}


}
?>
