<?php
class form_layout extends sagep_ei_formulario
{

  protected function generar_layout_fila($clave_fila)
{
  $this->set_ancho_etiqueta('65px');
  $columnas = 2;
  $i = 0;
  foreach ($this->get_nombres_ef() as $ef) {
    echo "<td colspan='$ef' class='{$this->estilo_celda_actual}'>";
    $ultimo = ($i == $this->get_cantidad_efs());
    if ($i % $columnas == 0) {
      echo "<td colspan='$columnas' class='{$this->estilo_celda_actual}'>";
    }
    $this->generar_html_ef($ef);
    $i++;
    if ($i % $columnas == 0 || $ultimo) {
      echo '</td>';
    }
  }
}
	function generar_layout()
	{
    if (! $this->cambiar_layout) {
                parent::generar_layout();
            } else {
                echo '<table>';
                $i = 0;
                foreach ($this->get_nombres_ef() as $ef) {
                    $ultimo = ($i == $this->get_cantidad_efs());
                    if ($i % 2 == 0) {
                        echo '<tr>';
                    }
                    echo '<td>';

                    //--- Llamada a la generacion estandar de un ef
                    $this->generar_html_ef($ef);

                    echo '</td>';
                    $i++;
                    if ($i % 2 == 0 || $ultimo) {
                        echo '</tr>';
                    }
                }
                echo '</table>';
            }
	}

}
?>
