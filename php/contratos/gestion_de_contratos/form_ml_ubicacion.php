<?php
class form_ml_ubicacion extends sagep_ei_formulario_ml
{
	//---- Config. EVENTOS sobre fila ---------------------------------------------------

	function conf_evt__vinculo($evento, $fila)
	{
		$evento->vinculo()->agregar_parametro('ubicacion', $this->_datos[$fila]['id_ubicacion']);
		$evento->vinculo()->agregar_parametro('detalle_contrato', $this->_datos[$fila]['id_detalle_contrato']);
	}

			protected function generar_layout_fila($clave_fila)
	{
		$this->set_ancho_etiqueta('65px');
		$columnas = 3;
		$i = 0;
		foreach ($this->get_nombres_ef() as $ef) {
			$ultimo = ($i == $this->get_cantidad_efs());
			if ($i % $columnas == 0) {
				echo "<td colspan='$columnas' class='{$this->estilo_celda_actual}'>";
			}
			$this->generar_html_ef($ef);
			$i++;
			if ($i % $columnas == 0 || $ultimo) {
				echo '</td>';
			}
		}
	}




}
?>