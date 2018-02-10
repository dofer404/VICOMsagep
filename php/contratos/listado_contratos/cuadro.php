<?php
class cuadro extends sagep_ei_cuadro
{
		function ini()
	{
		$this->_pdf_cortar_hoja_cc_0 = true;
			$this->_excel_cortar_hoja_cc_0 = false;
	}
	
	//---- Configuracion de cortes de control -------------------------------------------

	function sumarizar_cc__corte_personas__propia($filas)
	{
		return count($filas);
	}

}
?>