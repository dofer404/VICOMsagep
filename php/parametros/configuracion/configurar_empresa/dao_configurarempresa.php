<?php

require_once('personas/gestion_de_personas/dao_gestiondepersonas.php');
class dao_configurarempresa{

  static function get_listado_empresa ()
  {

    $sql=" SELECT
              coalesce(per.razon_social, per.apellidos || ', ' || per.nombres) entidad,
              emp.id_empresa,
              emp.id_persona,
              per.razon_social
            FROM es_sagep.datos_empresa emp
            JOIN  es_sagep.personas per on emp.id_persona=per.id_persona";

    $datos=consultar_fuente($sql);
    return $datos;
  }

  static function get_descPopUpPersonas($id_persona)
  {

  $id_persona = quote($id_persona);
    $sql = "SELECT
              per.razon_social as id_persona_nombre,
              coalesce(per.razon_social, per.apellidos || ', ' || per.nombres) as entidad
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

  static function get_persona()
  {
    return dao_gestiondepersonas::get_listado_personas();
  }

}

 ?>
