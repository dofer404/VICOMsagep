<?php
class cn_fotosdeservicios extends sagep_cn
{
  //-----------------------------------------------------------------------------------
  //---- Variables --------------------------------------------------------------------
  //-----------------------------------------------------------------------------------

  protected $temp_archivo;
  protected $temp_nombre;
  protected $temp_imagen;

  //-----------------------------------------------------------------------------------
	//---- dr_fotos_servicio ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

  function resetear()
	{
		$this->dep('dr_fotos_servicio')->resetear();
	}

	function sincronizar()
	{
		$this->dep('dr_fotos_servicio')->sincronizar();
	}

  //-----------------------------------------------------------------------------------
	//---- dt_fotos_servicio ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

  function procesar_filas_fotos($datos)
  {
    $this->dep('dr_fotos_servicio')->tabla('dt_fotos_servicio')->procesar_filas($datos);
    if (is_array($datos['imagen'])) {
        $temp_archivo = $datos['imagen']['tmp_name'];
        $fp = fopen($temp_archivo, 'rb');
        $this->dep('dr_fotos_servicio')->tabla('dt_fotos_servicio')->set_blob('imagen', $fp);
    }
  }

  function get_fotos()
  {
        $datos = $this->dep('dr_fotos_servicio')->tabla('dt_fotos_servicio')->get();
        $fp_imagen = $this->dep('dr_fotos_servicio')->tabla('dt_fotos_servicio')->get_blob('imagen');
        if (isset($fp_imagen)) {

              $temp_nombre = md5(uniqid(time()));
              $temp_archivo = toba::proyecto()->get_www_temp($temp_nombre);

              $temp_imagen = fopen($temp_archivo['path'], 'w');
              stream_copy_to_stream($fp_imagen, $temp_imagen);
              fwrite($temp_imagen, $fp_imagen);
              fclose($temp_imagen);
              $tamanio = round(filesize($temp_archivo['path']) / 1024);

              $datos['imagen_vista'] = "<img src='{$temp_archivo['url']}' alt=\"Imagen\" WIDTH=180 HEIGHT=150 >";
              $datos['imagen'] = 'Tamaño: '.$tamanio. ' KB';
        } else {
            $datos['imagen'] = null;
        }
      return $datos;
  }

}

?>
