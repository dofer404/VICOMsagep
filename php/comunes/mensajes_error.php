<?php

class mensajes_error {

	public static $debug = false;

	public static function get_mensaje_error($codigo = null, $tabla = null, $pronombre = null, $mensaje = null)
	{
		$codigo = quote($codigo);

		$sql = "SELECT t_er.codigo_error,
						   t_er.descripcion mensaje,
						   t_ter.nombre_tipoerror tipo,
							 t_er.mostrar_mensaje
	  		  FROM es_sagep.error t_er
          JOIN es_sagep.tipos_error t_ter
		  			ON t_er.id_tipo_error = t_ter.id_tipo_error
				 WHERE t_er.codigo_error = $codigo";

		$error = consultar_fuente($sql);

		if (isset($error[0])) {
			$mensaje_error = $pronombre.' '.$tabla.' '.$error[0]['mensaje'];
			if ($error[0]['mostrar_mensaje'] && isset($mensaje)) {
				$mensaje_error = $mensaje_error.'. Mensaje de error la aplicación: '.$mensaje;
			}
			toba::notificacion()->agregar($mensaje_error, $error[0]['tipo']);
		} else {
			toba::notificacion()->agregar('Error de carga, consulta con el administrador del sistema',
			'error');
		}
	}
}
 ?>
