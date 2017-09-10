------------------------------------------------------------
--[3861]--  - dr_detalleubicacion - dt_detalle_ubicacion 
------------------------------------------------------------

------------------------------------------------------------
-- apex_objeto
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto (proyecto, objeto, anterior, identificador, reflexivo, clase_proyecto, clase, punto_montaje, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion, posicion_botonera) VALUES (
	'sagep', --proyecto
	'3861', --objeto
	NULL, --anterior
	NULL, --identificador
	NULL, --reflexivo
	'toba', --clase_proyecto
	'toba_datos_tabla', --clase
	'30', --punto_montaje
	NULL, --subclase
	NULL, --subclase_archivo
	NULL, --objeto_categoria_proyecto
	NULL, --objeto_categoria
	'- dr_detalleubicacion - dt_detalle_ubicacion', --nombre
	NULL, --titulo
	NULL, --colapsable
	NULL, --descripcion
	'sagep', --fuente_datos_proyecto
	'sagep', --fuente_datos
	NULL, --solicitud_registrar
	NULL, --solicitud_obj_obs_tipo
	NULL, --solicitud_obj_observacion
	NULL, --parametro_a
	NULL, --parametro_b
	NULL, --parametro_c
	NULL, --parametro_d
	NULL, --parametro_e
	NULL, --parametro_f
	NULL, --usuario
	'2017-06-06 23:03:14', --creacion
	NULL  --posicion_botonera
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_db_registros
------------------------------------------------------------
INSERT INTO apex_objeto_db_registros (objeto_proyecto, objeto, max_registros, min_registros, punto_montaje, ap, ap_clase, ap_archivo, tabla, tabla_ext, alias, modificar_claves, fuente_datos_proyecto, fuente_datos, permite_actualizacion_automatica, esquema, esquema_ext) VALUES (
	'sagep', --objeto_proyecto
	'3861', --objeto
	NULL, --max_registros
	NULL, --min_registros
	'30', --punto_montaje
	'1', --ap
	NULL, --ap_clase
	NULL, --ap_archivo
	'detalle_ubicacion', --tabla
	NULL, --tabla_ext
	NULL, --alias
	'0', --modificar_claves
	'sagep', --fuente_datos_proyecto
	'sagep', --fuente_datos
	'1', --permite_actualizacion_automatica
	'es_sagep', --esquema
	'es_sagep'  --esquema_ext
);

------------------------------------------------------------
-- apex_objeto_db_registros_col
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'sagep', --objeto_proyecto
	'3861', --objeto
	'1669', --col_id
	'direccion', --columna
	'C', --tipo
	'0', --pk
	'', --secuencia
	'70', --largo
	NULL, --no_nulo
	'1', --no_nulo_db
	'0', --externa
	'detalle_ubicacion'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'sagep', --objeto_proyecto
	'3861', --objeto
	'1670', --col_id
	'altura', --columna
	'E', --tipo
	'0', --pk
	'', --secuencia
	NULL, --largo
	NULL, --no_nulo
	'1', --no_nulo_db
	'0', --externa
	'detalle_ubicacion'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'sagep', --objeto_proyecto
	'3861', --objeto
	'1671', --col_id
	'id_ubicacion', --columna
	'E', --tipo
	'1', --pk
	'detalle_ubicacion_id_ubicacion_seq', --secuencia
	NULL, --largo
	NULL, --no_nulo
	'1', --no_nulo_db
	'0', --externa
	'detalle_ubicacion'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'sagep', --objeto_proyecto
	'3861', --objeto
	'1672', --col_id
	'id_barrio', --columna
	'E', --tipo
	'0', --pk
	'', --secuencia
	NULL, --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	'0', --externa
	'detalle_ubicacion'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'sagep', --objeto_proyecto
	'3861', --objeto
	'1673', --col_id
	'id_pais', --columna
	'E', --tipo
	'0', --pk
	NULL, --secuencia
	NULL, --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	'1', --externa
	NULL  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'sagep', --objeto_proyecto
	'3861', --objeto
	'1674', --col_id
	'id_provincia', --columna
	'E', --tipo
	'0', --pk
	NULL, --secuencia
	NULL, --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	'1', --externa
	NULL  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'sagep', --objeto_proyecto
	'3861', --objeto
	'1675', --col_id
	'id_localidad', --columna
	'E', --tipo
	'0', --pk
	NULL, --secuencia
	NULL, --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	'1', --externa
	NULL  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'sagep', --objeto_proyecto
	'3861', --objeto
	'1833', --col_id
	'id_zona', --columna
	'E', --tipo
	'0', --pk
	'', --secuencia
	NULL, --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	'0', --externa
	'detalle_ubicacion'  --tabla
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_db_registros_ext
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto_db_registros_ext (objeto_proyecto, objeto, externa_id, tipo, sincro_continua, metodo, clase, include, punto_montaje, sql, dato_estricto, carga_dt, carga_consulta_php, permite_carga_masiva, metodo_masivo) VALUES (
	'sagep', --objeto_proyecto
	'3861', --objeto
	'15', --externa_id
	'dao', --tipo
	'1', --sincro_continua
	'get_idsExtBarrio', --metodo
	'dao_detalleubicacion', --clase
	'parametros/direcciones/detalle_ubicacion/dao_detalleubicacion.php', --include
	'30', --punto_montaje
	NULL, --sql
	'0', --dato_estricto
	NULL, --carga_dt
	NULL, --carga_consulta_php
	'0', --permite_carga_masiva
	NULL  --metodo_masivo
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_db_registros_ext_col
------------------------------------------------------------
INSERT INTO apex_objeto_db_registros_ext_col (objeto_proyecto, objeto, externa_id, col_id, es_resultado) VALUES (
	'sagep', --objeto_proyecto
	'3861', --objeto
	'15', --externa_id
	'1672', --col_id
	'0'  --es_resultado
);
INSERT INTO apex_objeto_db_registros_ext_col (objeto_proyecto, objeto, externa_id, col_id, es_resultado) VALUES (
	'sagep', --objeto_proyecto
	'3861', --objeto
	'15', --externa_id
	'1673', --col_id
	'1'  --es_resultado
);
INSERT INTO apex_objeto_db_registros_ext_col (objeto_proyecto, objeto, externa_id, col_id, es_resultado) VALUES (
	'sagep', --objeto_proyecto
	'3861', --objeto
	'15', --externa_id
	'1674', --col_id
	'1'  --es_resultado
);
INSERT INTO apex_objeto_db_registros_ext_col (objeto_proyecto, objeto, externa_id, col_id, es_resultado) VALUES (
	'sagep', --objeto_proyecto
	'3861', --objeto
	'15', --externa_id
	'1675', --col_id
	'1'  --es_resultado
);
