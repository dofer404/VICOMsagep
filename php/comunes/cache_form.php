<?php

class cache_form
{
  //-----------------------------------------------------------------------------------
	//---- Variables --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	protected $s__datos = [];

	//-----------------------------------------------------------------------------------
	//---- setters y getters ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	// form_cache


  function get_cache()
  {
    $datos = [];
    if (isset($this->s__datos['datos'])) {
      $datos = $this->s__datos['datos'];
    }
    return $datos;
  }

  function set_cache(array $datos)
  {
    $this->s__datos['datos'] = $datos;
  }

  function unset_cache()
  {
    unset($this->s__datos['datos']);
  }

  // function set_pedido_registro_nuevo($si=true)
  // {
  //   $this->s__datos['pedido_nuevo?'] = !!$si;
  // }
  //
  // function hay_pedido_registro_nuevo()
  // {
  //   if (isset($this->s__datos['pedido_nuevo?'])) {
  //     return !!$this->s__datos['pedido_nuevo?'];
  //   } else {
  //     return false;
  //   }
  // }
  //
	// function set_cache_form(array $datos)
	// {
	// 	$this->s__datos['datos'] = $datos;
	// }
  //
  //
	// function unset_datos_form_ubicacion()
	// {
	// 	$datos = $this->get_cache('form_ml_ubicacion');
	// 	unset($this->s__datos['form_ml_ubicacion']);
	// }
  //
	// function set_cursor_detalle($id_fila)
	// {
	// 	$this->s__datos['form_detalle.cursor'] = $id_fila;
	// }
  //
	// function unset_cursor_detalle()
	// {
	// 	unset($this->s__datos['form_detalle.cursor']);
	// }
  //
	// function get_cursor_detalle()
	// {
	// 	return $this->s__datos['form_detalle.cursor'];
	// }
  //
	// function hay_cursor_detalle()
	// {
	// 	return isset($this->s__datos['form_detalle.cursor']);
	// }
}

?>
