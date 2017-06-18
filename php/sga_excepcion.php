<?php

class sga_excepcion
{
	// La siguiente variable nos dice si debemos ocultar los errores de la base
	//  de datos
	//  true: Mostrar los errores de la base de datos (Solo en desarrollo)
	//  false: Ocultar los errores de la base de datos (Modo Producción)
	public static $debug = true;

	public static function get_mensaje_error($codigo = null, $tabla = null, $pronombre = null, $mensaje = null)
	{
		$codigo = quote($codigo);

		$sql = "SELECT pe.cod_error,
						   pe.descripcion mensaje,
						   pte.descripcion tipo,
							 pe.b_mostrarmensajeerror
	  		  FROM tfitec.par_error pe
    INNER JOIN tfitec.par_tipo_error pte
		  			ON pte.idtipo_error = pe.idtipo_error
				 WHERE pe.cod_error = $codigo";

		$error = consultar_fuente($sql);

		if (isset($error[0])) {
			$mensaje_error = $pronombre.' '.$tabla.' '.$error[0]['mensaje'];
			if ($error[0]['b_mostrarmensajeerror'] && isset($mensaje)) {
				$mensaje_error = $mensaje_error.'. Mensaje de error la aplicación: '.$mensaje;
			}
			toba::notificacion()->agregar($mensaje_error, $error[0]['tipo']);
		} else {
			toba::notificacion()->agregar('Error de carga, consulta con el administrador del sistema',
			'error');
		}
	}
}
