<?php
class form_ubicacion extends sagep_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------

		{$this->objeto_js}.evt__monto_unitario__procesar = function(es_inicial)
		{
			var direccion=this.ef('id_ubicacion');

      if(direccion.tiene_estado)
      {
      this.ef('monto_unitario').set_estado(100);
      }

		}

		{$this->objeto_js}.evt__monto_total__procesar = function(es_inicial)
		{
			var cantidad=this.ef('cantidad');
			var monto=this.ef('monto_unitario');


			if(cantidad.tiene_estado)
			{
			this.ef('monto_total').set_estado(cantidad.get_estado()*monto.get_estado());
			}

		}
		";
	}

}

?>
