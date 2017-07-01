<?php
class ci_fotosdeservicios extends sagep_ci
{

  //-----------------------------------------------------------------------------------
  //---- Variables --------------------------------------------------------------------
  //-----------------------------------------------------------------------------------

  protected $sql_state;
  protected $s__datos_filtro;
  protected $s__datos;

  //-----------------------------------------------------------------------------------
  //---- Eventos ----------------------------------------------------------------------
  //-----------------------------------------------------------------------------------

  function evt__procesar()
	{
			$this->cn()->sincronizar();
			$this->cn()->resetear();
	}

  //-----------------------------------------------------------------------------------
	//---- Form_ml_fotos ----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_fotos(sagep_ei_formulario_ml $form_ml)
	{
      if (isset($this->s__datos['form_ml_fotos'])) {
  			$form_ml->set_datos($this->s__datos['form_ml_fotos']);
  		} else {
  			if ($this->cn()->hay_cursor()) {
          $datos = $this->cn()->get_fotos();
          $datos = $this->cn()->get_blobs($datos);
  				$this->s__datos['form_ml_fotos'] = $datos;
  				$form_ml->set_datos($datos);
  			}
  		}
	}

	function evt__form_ml_fotos__modificacion($datos)
	{
		$this->s__datos['form_ml_fotos'] = $datos;
		$this->cn()->procesar_filas_fotos($datos);
    $this->cn()->set_blob_foto($datos);
	}

}
?>
