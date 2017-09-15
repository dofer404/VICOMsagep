<?php
class sagep_exportarPDF extends sagep_ei_cuadro
{
	function vista_pdf(toba_vista_pdf $salida ){
	//configuramos el nombre que tendrá el archivo pdf
	$salida->set_nombre_archivo("LISTADO_personas.pdf");
	//recuperamos el objteo ezPDF para agregar la cabecera y el pie de página
	$pdf = $salida->get_pdf();
	//modificamos los márgenes de la hoja top, bottom, left, right
	$pdf->ezSetMargins(80, 50, 30, 30);
	//Configuramos el pie de página. El mismo, tendra el número de página centrado en la página y la fecha ubicada a la derecha.
	//Primero definimos la plantilla para el número de página.
	$formato = 'Página {PAGENUM} de {TOTALPAGENUM}';
	//Luego definimos la ubicación de la fecha en el pie de página.
	//Determinamos la ubicación del número página en el pié de pagina definiendo las coordenadas x y, tamaño de letra, posición, texto, pagina inicio
	$pdf->ezStartPageNumbers(300, 20, 8, 'left', utf8_d_seguro($formato), 1);
	//Configuración de Título.
	// $salida->titulo(utf8_d_seguro("Convocatoria XXXX - "));
	//Configuración de Subtítulo.
	// $salida->subtitulo(utf8_d_seguro("Listado de Postulantes"));
	//Invoco la salida pdf original del cuadro
	$this->controlador()->dependencia('filtro')->vista_pdf($salida);
	$salida->separacion();
	parent::vista_pdf($salida);
	//Encabezado: Logo Organización - Nombre
	//Recorremos cada una de las hojas del documento para agregar el encabezado
	foreach ($pdf->ezPages as $pageNum=>$id){
		$pdf->reopenObject($id);
		//definimos el path a la imagen de logo de la organizacion
		$imagen = toba::proyecto()->get_path().'/www/img/logo_pdf.jpg';
		//agregamos al documento la imagen y definimos su posición a través de las coordenadas (x,y) y el ancho y el alto.
		$pdf->addJpegFromFile($imagen, 20, 775, 80, 61);
		//Agregamos el nombre de la organización a la cabecera junto al logo
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