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

		{$this->objeto_js}.evt__id_persona__procesar = function(es_inicial)
		{
			if(this.ef('id_persona').tiene_estado()){
				this.controlador.ajax('setear_telefonos', this.ef('id_persona').get_estado(), this, this.setTelefono);
				this.controlador.ajax('setear_correos', this.ef('id_persona').get_estado(), this, this.setCorreo);
				this.controlador.ajax('setear_direcciones', this.ef('id_persona').get_estado(), this, this.setDireccion);

			}
		}

		{$this->objeto_js}.setTelefono = function (datos)
						{
					if(datos['telefono']){
						this.ef('telefono').set_estado(datos['telefono']);
					}
						}

						{$this->objeto_js}.setCorreo = function (datos)
										{
									if(datos['correo']){
										this.ef('correo').set_estado(datos['correo']);
									}
										}

										{$this->objeto_js}.setDireccion = function (datos)
														{
													if(datos['ubicacion']){
														this.ef('ubicacion').set_estado(datos['ubicacion']);
													}
														}
		";
	}

}
?>
