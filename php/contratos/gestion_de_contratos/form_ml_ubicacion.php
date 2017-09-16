<?php
class form_ml_ubicacion extends sagep_ei_formulario_ml
{
	//---- Config. EVENTOS sobre fila ---------------------------------------------------

	function conf_evt__vinculo($evento, $fila)
	{
		$evento->vinculo()->agregar_parametro('ubicacion', $this->_datos[$fila]['id_ubicacion']);
		$evento->vinculo()->agregar_parametro('detalle_contrato', $this->_datos[$fila]['id_detalle_contrato']);
		//$evento->vinculo->agregar_parametro(id_ubicacion);
	}

	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------

		{$this->objeto_js}.evt__id_ubicacion__procesar = function(es_inicial, fila)
		{
						if(!es_inicial){
				var id_vinculo = this.ef('id_ubicacion').ir_a_fila(fila).get_id_vinculo();
				var parametros =  {'id_detalle_contrato': this.ef('id_detalle_contrato').ir_a_fila(fila).get_estado()} ;
				vinculador.agregar_parametros(id_vinculo, parametros);
			}

		}
		//---- Eventos ---------------------------------------------

		{$this->objeto_js}.modificar_vinculo__vinculo = function(id_vinculo)
		{
		}
		";
	}


}
?>
