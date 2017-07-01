<?php

require_once('parametros/contratos/rol/dao_rol.php');
require_once('adebug.php');
require_once('mensajes_error.php');

class ci_rol extends sagep_ci
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

  function evt__nuevo()
  {
    $this->cn()->reiniciar(); //Se resetea
    $this->set_pantalla('pant_edicion'); //Cambia a la Pantalla de Edición
  }

	/* El usuario selecciona una accion sobre el registro, se sincroniza y se resetea */

  function evt__procesar()
  {
    try {
      $this->cn()->guardar(); //Sincroniza con la base de datos ejecutando comandos SQL
      $this->evt__cancelar(); //Para limpiar la seleccion

    } catch (toba_error_db $e) {
      if (adebug::$debug) {
        throw $e;
      } else {
        $this->cn()->reiniciar();
        $sql_state = $e->get_sqlstate();
        if ($sql_state == 'db_23505') {
          throw new toba_error_usuario('Ya existe el Rol');
        }
      }
    }
  }

  function evt__eliminar()
  {
    $this->cn()->eliminar();
    $this->evt__procesar();
  }

  function evt__cancelar()
  {
    unset($this->s__datos);
		$this->cn()->reiniciar(); //Descarta los cambios
    $this->set_pantalla('pant_inicial'); //Cambia a la Pantalla Inicial
  }

  //-----------------------------------------------------------------------------------
	//---- Filtro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro(sagep_ei_filtro $filtro)
	{
		if (isset($this->s__datos_filtro)) {
			$filtro->set_datos($this->s__datos_filtro);
		}
	}

	function evt__filtro__filtrar($datos)
	{
		$this->s__datos_filtro = $datos; 	/* Guardar las condiciones en una variable de sesion
																				para poder usarla en la configuracion del cuadro */
	}

	function evt__filtro__cancelar()
	{
		unset($this->s__datos_filtro);
	}

	//-----------------------------------------------------------------------------------
	//---- Cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	/* El cuadro se carga con un conjunto de datos traidos desde la base de datos */

	function conf__cuadro(sagep_ei_cuadro $cuadro)
	{
		if (isset($this->s__datos_filtro)) {
			$filtro = $this->dep('filtro');
			$filtro->set_datos($this->s__datos_filtro);
			$sql_where = $filtro->get_sql_where();

			$datos = dao_rol::get_listado_roles($sql_where);
			$cuadro->set_datos($datos);
		}
	}

	/* Cuando del cuadro se selecciona un elemento, el datos_tabla se carga con ese elemento,
	marcando que a partir de aqui las operaciones que se harán sobre este registro. En
	esta operación el registro cargado del datos_tabla funciona como un cursor que representa
	la fila actualmente seleccionada, si no está cargado, no hay selección y viceversa */

  function evt__cuadro__edicion($seleccion)
  {
    $this->cn()->cargar($seleccion);
    $this->cn()->set_cursor($seleccion);
    $this->set_pantalla('pant_edicion'); //Cambia a la Pantalla de edicion
  }

  function evt__cuadro__eliminar($seleccion)
  {
  }

  //-----------------------------------------------------------------------------------
	//---- Form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	/* Evento Implicito. Salta cuando el usuario acciona el evento procesar */

	function evt__form__modificacion($datos)
	{
		$this->s__datos['form'] = $datos;
		$this->cn()->set_rol($datos);
	}

	/* Se carga el formulario con el registro seleccionado */

  function conf__form(sagep_ei_formulario $form)
  {
    if (isset($this->s__datos['form'])) {
      $form->set_datos($this->s__datos['form']);
    } else {

      if ($this->cn()->hay_cursor()) {
        $datos = $this->cn()->get_rol();
        $this->s__datos['form'] = $datos;
        $form->set_datos($datos);
      } else {
        $this->pantalla()->eliminar_evento('eliminar');
      }
    }

  }
}

?>
