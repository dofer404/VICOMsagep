<?php

require_once('personas/gestion_de_personas/dao_gestiondepersonas.php');
require_once('parametros/direcciones/detalle_ubicacion/dao_detalleubicacion.php');

class dao_configurarempresa{

  static function get_listado_empresa ()
  {

    $sql=" SELECT
              coalesce(per.razon_social, per.apellidos || ', ' || per.nombres) entidad,
              per.cuil_cuit,
              emp.id_empresa,
              emp.id_persona,
              emp.id_correo,
              emp.id_telefono,
              emp.nombre_formal
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

  // static function get_opcionesUbicacion($id_persona)
  // {
  //   $id_persona = quote($id_persona);
  //     $sql = "SELECT
  //               det.id_ubicacion,
  //               ub.direccion
  //             FROM
  //               es_sagep.personas_detalleubicacion det
  //             JOIN es_sagep.detalle_ubicacion ub ON det.id_ubicacion = ub.id_ubicacion
  //             WHERE
  //               det.id_persona = $id_persona";
  //
  //     $resultado = consultar_fuente($sql);
  //     return $resultado;
  // }

  static function get_cuilCuit()
  {
      $sql = "SELECT
                per.cuil_cuit,
                per.id_persona,
                emp.id_persona
              FROM
                es_sagep.personas per
              JOIN
                es_sagep.datos_empresa emp on per.id_persona = emp.id_persona";

      $resultado = consultar_fuente($sql);
      return $resultado;
  }

  static function get_opcionesTelefonos($id_persona)
  {
    $id_persona = quote($id_persona);
      $sql = "SELECT
                tel.id_telefono,
                tel.caracteristica || ' - ' || tel.numero telefono,
                per.id_persona
              FROM
                es_sagep.telefonos tel
              JOIN es_sagep.personas per ON tel.id_persona = per.id_persona
              WHERE
                tel.id_persona = $id_persona";

      $resultado = consultar_fuente($sql);
      return $resultado;
  }

  static function get_opcionesCorreo($id_persona)
  {
    $id_persona = quote($id_persona);
      $sql = "SELECT
                cor.id_correo,
                cor.direccion,
                per.id_persona
              FROM
                es_sagep.correos cor
              JOIN es_sagep.personas per ON cor.id_persona = per.id_persona
              WHERE
                cor.id_persona = $id_persona";

      $resultado = consultar_fuente($sql);
      return $resultado;
  }

  static function get_opcionesUbicacion($id_persona)
  {
    $id_persona = quote($id_persona);
      $sql = "SELECT
                ub_per.id_ubicacion,
                ub_det.direccion,
                ub_det.altura,
                loc.nombre_loc,
                bar.nombre_bar,
                prov.nombre_prov,
                pais.nombre_pais,
                ub_det.direccion || ' al ' || ub_det.altura ||' - Barrio '|| bar.nombre_bar ||' - '||loc.nombre_loc || ', ' || prov.nombre_prov || ', ' || pais.nombre_pais as direccion_localidad
              FROM
                es_sagep.personas_detalleubicacion ub_per
              JOIN es_sagep.detalle_ubicacion ub_det ON ub_per.id_ubicacion = ub_det.id_ubicacion
              JOIN es_sagep.barrios bar ON ub_det.id_barrio = bar.id_barrio
              JOIN es_sagep.localidades loc ON bar.id_localidad = loc.id_localidad
              JOIN es_sagep.provincias prov ON loc.id_provincia = prov.id_provincia
              JOIN es_sagep.pais pais ON prov.id_pais = pais.id_pais
              WHERE
                ub_per.id_persona = $id_persona";

      $resultado = consultar_fuente($sql);
      return $resultado;
  }

}

 ?>
