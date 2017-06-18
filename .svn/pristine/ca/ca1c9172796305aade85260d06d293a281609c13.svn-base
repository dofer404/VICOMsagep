<?php

require_once('parametros/contratos/tipos_de_contratos/dao_tiposdecontratos.php');
require_once('parametros/contratos/rol/dao_rol.php');
require_once('personas/gestion_de_personas/dao_gestiondepersonas.php');
require_once('servicios/gestion_de_servicios/dao_gestiondeservicios.php');

class dao_gestiondecontratos{

  static function get_listado_contratos ($where='')
  {

    if($where){
      $where_armado="WHERE $where";
    }else {
      $where_armado='';
    }

    $sql=" SELECT
      t_rs.id_persona,
      t_rs.id_contrato,
      t_r.nombre_rol,
      t_p.cuil_cuit as id_persona_cuil_cuit,
      t_c.id_contrato,
      t_c.fecha_inicio,
      t_c.fecha_fin,
      t_c.monto_total,
      t_c.id_tipo_contrato,
      t_tc.nombre_tipocon as id_tipo_contrato_nombre
    FROM es_sagep.contratos t_c

    JOIN es_sagep.tipos_contratos t_tc on t_c.id_tipo_contrato = t_tc.id_tipo_contrato
    JOIN es_sagep.roles t_rs on t_c.id_contrato = t_rs.id_contrato
    JOIN es_sagep.rol t_r on t_rs.id_rol = t_r.id_rol and t_r.nombre_rol = 'Contratante'
    JOIN es_sagep.personas t_p on t_rs.id_persona = t_p.id_persona

              $where_armado ";

    $datos=consultar_fuente($sql);
    return $datos;
  }

  static function get_tiposContratos()
  {
    return dao_tiposdecontratos::get_listado_tipos_contratos();
  }

  static function get_tiposRol()
  {
    return dao_rol::get_listado_roles();
  }

  static function get_personas()
  {
    return dao_gestiondepersonas::get_listado_personas();
  }

  static function get_servicios()
  {
    return dao_servicios::get_listado_servicios();
  }

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
