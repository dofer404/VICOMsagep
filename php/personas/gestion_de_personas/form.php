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

			{$this->objeto_js}.evt__apellidos__procesar = function(es_inicial) //Pasar a mayusculas
			{
			var ef=this.ef('apellidos');
			if(ef.tiene_estado)
			{
			}

			}

			{$this->objeto_js}.evt__nombres__procesar = function(es_inicial)
			{
			var ef=this.ef('nombres');

			if(ef.tiene_estado)
			{
			}
			}
			//---- Procesamiento de EFs --------------------------------

			{$this->objeto_js}.evt__razon_social__procesar = function(es_inicial)
			{
			var ef=this.ef('razon_social');

			if(ef.tiene_estado)
			{
			ef.set_estado(ef.get_estado().charAt(0).toUpperCase()+ef.get_estado().slice(1).toLowerCase());
			}
			}
			//---- Procesamiento de EFs --------------------------------

			{$this->objeto_js}.evt__id_tipo_persona__procesar = function(es_inicial)
			{

			var nodo = this.ef('id_tipo_persona').input();

			var indice = nodo.selectedIndex;
			var valor='';

			if (indice) {
			valor = nodo.options[indice].text;
			}

			var resultado = valor.substring(0,3);


			if (resultado.toUpperCase()=='JUR')
			{
			this.ef('razon_social').mostrar();
			this.ef('nombres').ocultar();
			this.ef('apellidos').ocultar();
			this.ef('nro_documento').ocultar();
			this.ef('id_tipo_documento').ocultar();
			this.ef('fecha_nacimiento').ocultar();
			} else {
			this.ef('razon_social').ocultar();
			this.ef('nombres').mostrar();
			this.ef('apellidos').mostrar();
			this.ef('nro_documento').mostrar();
			this.ef('id_tipo_documento').mostrar();
			this.ef('fecha_nacimiento').mostrar();
			}
			}
			//---- Procesamiento de EFs --------------------------------

			{$this->objeto_js}.evt__fecha_nacimiento__procesar = function(es_inicial)
			{

			var edad = this.ef('fecha_nacimiento').calcular_edad();

			if (this.ef('fecha_nacimiento').get_estado()!='') {
			var ef_fecha_nacimiento = this.ef('fecha_nacimiento');
			var fecha_nacimiento = ef_fecha_nacimiento.fecha();

			var fecha_actual = new Date();
			if (fecha_nacimiento!='') {
			if (fecha_actual < fecha_nacimiento) {
			alert('La Fecha de Nacimiento NO Puede ser Mayor a la Fecha Actual');
			this.ef('fecha_nacimiento').set_estado('');
			ef_fecha_nacimiento.set_error('La Fecha de Nacimiento debe ser mayor a 1900 y menor o igual a la Fecha Actual');

			} else {
			var anio_nacimiento = fecha_nacimiento.getFullYear();
			if (anio_nacimiento < 1900) {
			alert('La Fecha de Nacimiento debe ser mayor a 1900 y menor o igual a la Fecha Actual');
			this.ef('fecha_nacimiento').set_estado('');
			ef_fecha_nacimiento.set_error('La Fecha de Nacimiento debe ser mayor a 1900 y menor o igual a la Fecha Actual');

			} else {

			var edad = this.ef('fecha_nacimiento').calcular_edad();
			if (edad < 18) {
			alert('La Persona debe ser Mayor de edad. EDAD :' +edad);
			this.ef('fecha_nacimiento').set_estado('');
			ef_fecha_nacimiento.set_error('La Persona debe ser Mayor de edad');
			}

			}


			}
			}
			}
			}


			//---- Procesamiento de EFs --------------------------------

			{$this->objeto_js}.evt__cuil_cuit__procesar = function(es_inicial)
			{
			var documento = this.ef('nro_documento');
			var cuil = this.ef('cuil_cuit');
			if(cuil.tiene_estado)
			{
			documento.set_estado(this.ef('cuil_cuit').get_estado().substring(2, 10));
			}
			}
			";
	}


}
?>