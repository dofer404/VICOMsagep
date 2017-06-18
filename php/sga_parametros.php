<?php
require_once('sga_excepcion.php');
class sga_parametros
{
	static function mensajeRegistroExitoso()
	{
		return "<script type='text/javascript'>
		var newItem = document.createElement(\"div\");
		newItem.innerHTML = \"Los cambios se registraron correctamente.\";
		newItem.className = \"mensajeItecSga bounceInDown animated\";
		newItem.setAttribute(\"id\", \"mensajeITEC\");

		function mostrarMensaje () {
			var doc_body = document.getElementsByTagName(\"body\")[0];
			doc_body.insertBefore(newItem, doc_body.childNodes[0]);
	    setTimeout(ocultarMensaje,20000);
		}

		function ocultarMensaje() {
			document.getElementById('mensajeITEC').className = 'mensajeItecSga bounceOut animated';
		}

		mostrarMensaje();
		</script>";
	}	
}
?>
