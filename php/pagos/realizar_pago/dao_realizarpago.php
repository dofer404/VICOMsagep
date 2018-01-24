<?php

require_once('parametros/pagos/tipos_de_pagos/dao_tiposdepagos.php');
require_once('parametros/pagos/entidades_financieras/dao_entidadesfinancieras.php');
require_once('personas/gestion_de_personas/dao_gestiondepersonas.php');

class dao_realizarpago{

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

  static function get_listado_pagos ($where='')
  {

    if($where){
      $where_armado="WHERE $where";
    }else {
      $where_armado='';
    }

    $sql=" SELECT
      coalesce(t_p.razon_social, t_p.apellidos || ', ' || t_p.nombres) entidad,
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
    JOIN es_sagep.rol t_r on t_rs.id_rol = t_r.id_rol and t_r.nombre_rol = 'Contratado'
    JOIN es_sagep.personas t_p on t_rs.id_persona = t_p.id_persona

              $where_armado ";

    $datos=consultar_fuente($sql);
    return $datos;
  }

  static function get_contratos($id_persona)
  {
    $id_persona = quote($id_persona);

    $sql = "SELECT  rol.nombre_rol,
        coalesce(per.razon_social, per.apellidos || ', ' || per.nombres) entidad,
	       roles.id_contrato,
         cont.fecha_inicio
  FROM es_sagep.roles roles, es_sagep.rol rol, es_sagep.personas per, es_sagep.contratos cont
	WHERE roles.id_rol = rol.id_rol AND roles.id_persona = per.id_persona AND roles.id_contrato = cont.id_contrato AND rol.nombre_rol='Contratado' AND roles.id_persona = $id_persona";

    return consultar_fuente($sql);
  }

  static function get_cuotas($id_contrato)
  {
    $id_contrato = quote($id_contrato);

    $sql = "SELECT  	liq.nro_cuota,
                mes.nombre_mes,
		liq.anio,
                liq.fecha_vencimiento,
                liq.descuento,
                liq.recargo,
                liq.monto
  FROM es_sagep.liquidaciones liq, es_sagep.meses mes
  WHERE mes.id_mes = liq.id_mes AND liq.id_contrato = $id_contrato";

    return consultar_fuente($sql);
  }

  static function get_tiposPagos()
  {
    return dao_tiposdepagos::get_listado_tipos_pagos();
  }

  static function get_entidadFInanciera()
  {
    return dao_entidadesfinancieras::get_listado_entidades_financieras();
  }

  static function get_confTiposPagos($idTipoPago)
{
  if (!$idTipoPago && $idTipoPago != 0) {
    return null;
  }

  $idTipoPago = quote($idTipoPago);

  $sql = "SELECT *
            FROM es_sagep.tipos_pagos t_pago
            WHERE t_pago.id_tipo_pago = $idTipoPago";

  $resultado = consultar_fuente($sql);

  return $resultado[0];
}

}

 ?>
