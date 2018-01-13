<?php
require_once('servicios/gestion_de_servicios/dao_gestiondeservicios.php');

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
			var ef=this.ef('monto_unitario');
		}
		//---- Procesamiento de EFs --------------------------------

		{$this->objeto_js}.evt__id_ubicacion__procesar = function(es_inicial)
		{
			if(this.ef('id_ubicacion').tiene_estado()){
				this.controlador.ajax('get_tarifa', this.ef('id_ubicacion').get_estado(), this, this.setTarifa);
			} else {
				this.ef('monto_unitario').set_estado(0);
				this.ef('monto_total').set_estado(0);
			}
		}

		{$this->objeto_js}.setTarifa = function (datos)
		        {
					if(datos['monto']){
						this.ef('monto_unitario').set_estado(datos['monto']);
						this.ef('monto_total').set_estado(datos['monto']*this.ef('cantidad').get_estado());
					} else {
						this.ef('monto_unitario').set_estado(0);
						this.ef('monto_total').set_estado(0);
					}
		        }

		{$this->objeto_js}.actualizar_subtotal = function(cantidad)
				{
					this.ef('monto_total').set_estado(this.ef('monto_unitario').get_estado()*cantidad);
				}
		//---- Procesamiento de EFs --------------------------------

		{$this->objeto_js}.evt__cantidad__procesar = function(es_inicial)
		{
			this.actualizar_subtotal(this.ef('cantidad').get_estado());
		}
		";
	}



}
?>
