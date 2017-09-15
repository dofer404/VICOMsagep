<?php
class sagep_exportarPDF extends sagep_ei_cuadro
{
	function vista_pdf(toba_vista_pdf $salida ){
	//configuramos el nombre que tendr� el archivo pdf
	$salida->set_nombre_archivo("LISTADO_personas.pdf");
	//recuperamos el objteo ezPDF para agregar la cabecera y el pie de p�gina
	$pdf = $salida->get_pdf();
	//modificamos los m�rgenes de la hoja top, bottom, left, right
	$pdf->ezSetMargins(80, 50, 30, 30);
	//Configuramos el pie de p�gina. El mismo, tendra el n�mero de p�gina centrado en la p�gina y la fecha ubicada a la derecha.
	//Primero definimos la plantilla para el n�mero de p�gina.
	$formato = 'P�gina {PAGENUM} de {TOTALPAGENUM}';
	//Luego definimos la ubicaci�n de la fecha en el pie de p�gina.
	//Determinamos la ubicaci�n del n�mero p�gina en el pi� de pagina definiendo las coordenadas x y, tama�o de letra, posici�n, texto, pagina inicio
	$pdf->ezStartPageNumbers(300, 20, 8, 'left', utf8_d_seguro($formato), 1);
	//Configuraci�n de T�tulo.
	// $salida->titulo(utf8_d_seguro("Convocatoria XXXX - "));
	//Configuraci�n de Subt�tulo.
	// $salida->subtitulo(utf8_d_seguro("Listado de Postulantes"));
	//Invoco la salida pdf original del cuadro
	$this->controlador()->dependencia('filtro')->vista_pdf($salida);
	$salida->separacion();
	parent::vista_pdf($salida);
	//Encabezado: Logo Organizaci�n - Nombre
	//Recorremos cada una de las hojas del documento para agregar el encabezado
	foreach ($pdf->ezPages as $pageNum=>$id){
		$pdf->reopenObject($id);
		//definimos el path a la imagen de logo de la organizacion
		$imagen = toba::proyecto()->get_path().'/www/img/logo_pdf.jpg';
		//agregamos al documento la imagen y definimos su posici�n a trav�s de las coordenadas (x,y) y el ancho y el alto.
		$pdf->addJpegFromFile($imagen, 20, 775, 80, 61);
		//Agregamos el nombre de la organizaci�n a la cabecera junto al logo
		$pdf->addText(110,820,10,'Instituto Tecnologico Iguazu (ITEC)');
		$pdf->addText(10,772,12,'______________________________________________________________________________________');
		$pdf->addText(480,20,8,date('d/m/Y h:i:s a'));
		$usuario = toba::usuario()->get_nombre();
		$pdf->addText(20,20,8,"Usuario: $usuario");
		$pdf->closeObject();
	}
		}
}
?>