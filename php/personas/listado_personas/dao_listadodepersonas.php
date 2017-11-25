<?php
require_once('parametros/personas/condicion_de_iva/dao_condiciondeiva.php');
require_once('parametros/personas/tipos_de_personas/dao_tiposdepersonas.php');
require_once('parametros/personas/tipos_de_documentos/dao_tiposdedocumentos.php');
require_once('parametros/personas/tipos_de_telefonos/dao_tiposdetelefonos.php');
require_once('parametros/personas/tipos_de_correos/dao_tiposdecorreos.php');
require_once('parametros/direcciones/provincias/dao_provincias.php');
require_once('parametros/direcciones/localidades/dao_localidades.php');
require_once('parametros/pagos/entidades_financieras/dao_entidadesfinancieras.php');
require_once('parametros/personas/tipos_de_cuentas/dao_tiposdecuentas.php');


class dao_listadodepersonas{

  static function get_listado_personas ($where='')
  {

    if($where){
      $where_armado="WHERE $where";
    }else {
      $where_armado='';
    }

    $sql=" SELECT
      t_p.id_persona,
      t_ci.id_iva,
      t_td.id_tipo_documento,
      t_tp.id_tipo_persona,
      t_p.cuil_cuit,
      coalesce(t_p.razon_social, t_p.apellidos || ', ' || t_p.nombres) entidad,
      t_p.razon_social,
      t_p.nro_documento,
      t_td.sigla_tipodoc || ' ' || t_p.nro_documento tipo_y_numero,
      t_p.apellidos || ', ' || t_p.nombres apellido_y_nombre,
      t_p.fecha_nacimiento,
      t_p.activo,
      t_p.logo,
      t_ci.nombre_coniva as id_iva_nombre,
      t_td.sigla_tipodoc as id_tipo_documento_nombre,
      t_tp.nombre_tipoper as id_tipo_persona_nombre
    FROM es_sagep.personas t_p

    JOIN es_sagep.condicion_iva t_ci on t_p.id_iva = t_ci.id_iva
    JOIN es_sagep.tipos_personas t_tp ON t_p.id_tipo_persona = t_tp.id_tipo_persona
    LEFT JOIN es_sagep.tipos_documentos t_td ON t_p.id_tipo_documento = t_td.id_tipo_documento

              $where_armado";

    $datos=consultar_fuente($sql);
    return $datos;
  }



  static function get_condicionIVA()
  {
    return dao_condiciondeiva::get_listado_condicion_iva();
  }

  static function get_tiposPersonas()
  {
    return dao_tiposdepersonas::get_listado_tipos_personas();
  }

  static function get_tiposDocumentos()
  {
    return dao_tiposdedocumentos::get_listado_tipos_documentos();
  }

  static function get_tiposTelefonos()
  {
    return dao_tiposdetelefonos::get_listado_tipos_telefonos();
  }

  static function get_tiposCorreos()
  {
    return dao_tiposdecorreos::get_listado_tipos_correos();
  }

  static function get_tiposCuentas()
  {
    return dao_tiposdecuentas::get_listado_tipos_cuentas();
  }

  static function get_entidadesFinancieras()
  {
    return dao_entidadesfinancieras::get_listado_entidades_financieras();
  }

  static function get_confTiposPersonas($idTipoPer)
  {
    if (!$idTipoPer && $idTipoPer != 0) {
      return null;
    }

    $idTipoPer = quote($idTipoPer);

    $sql = "SELECT *
              FROM es_sagep.tipos_personas tper
              WHERE tper.id_tipo_persona = $idTipoPer";

    $resultado = consultar_fuente($sql);

    return $resultado[0];
  }

  static function get_descPopUpDirecciones($id_ubicacion)
  {

  $id_ubicacion = quote($id_ubicacion);
    $sql = "SELECT
              det.direccion
            FROM
              es_sagep.detalle_ubicacion det
            WHERE
              det.id_ubicacion = $id_ubicacion";

    $resultado = consultar_fuente($sql);

  if (count($resultado) > 0) {
      return $resultado[0]['direccion'];
  } else {
      return 'Fallo. Intente nuevamente';
    }

  }

  static function get_idsExtLocalidad($id_localidad)
  {
    $id_localidad = quote($id_localidad);

    $sql = "SELECT prov.id_pais,
                   prov.id_provincia
              FROM es_sagep.provincias prov
              JOIN es_sagep.localidades loc ON loc.id_provincia = prov.id_provincia
             WHERE loc.id_localidad = $id_localidad";

    $resultado = consultar_fuente($sql);

    return $resultado[0];
  }

  static function get_descripcionPopUpPais($id_pais)
  {

  $id_pais = quote($id_pais);
    $sql = "SELECT
              pais.nombre_pais
            FROM
              es_sagep.pais pais
            WHERE
              pais.id_pais = $id_pais";

    $resultado = consultar_fuente($sql);

  if (count($resultado) > 0) {
      return $resultado[0]['nombre_pais'];
  } else {
      return 'Fallo. Intente nuevamente';
  }

  }

  static function get_provincias()
  {
    return dao_provincias::get_listado_provincias();
  }

  static function get_localidades()
  {
    return dao_localidades::get_listado_localidades();
  }

  static function get_OpProvincias($id_pais)
  {
    $id_pais = quote($id_pais);
      $sql = "SELECT
                prov.id_provincia,
                prov.nombre_prov
              FROM
                es_sagep.provincias prov
              WHERE
                prov.id_pais = $id_pais";

      $resultado = consultar_fuente($sql);
      return $resultado;
  }

  static function get_OpLocalidades($id_provincia)
  {
    $id_provincia = quote($id_provincia);
      $sql = "SELECT
                loc.id_localidad,
                loc.nombre_loc
              FROM
                es_sagep.localidades loc
              WHERE
                loc.id_provincia = $id_provincia";

      $resultado = consultar_fuente($sql);
      return $resultado;
  }


}

 ?>
