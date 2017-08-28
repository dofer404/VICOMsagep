<?php

class dao_configurar_empresa{

  static function get_descPopUpPersonas($id_persona)
  {

  $id_persona = quote($id_persona);
    $sql = "SELECT
              coalesce(per.razon_social, per.apellidos || ', ' || per.nombres) entidad
            FROM
              es_sagep.personas per
            WHERE
              per.id_persona = $id_persona";

    $resultado = consultar_fuente($sql);

  if (count($resultado) > 0) {
      return $resultado[0]['entidad'];
  } else {
      return 'Fallo. Intente nuevamente';
    }

  }

}

 ?>
