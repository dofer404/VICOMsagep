------------------------------------------------------------
--[4252]--  ci_gestiondepersonas - ci_agregarpersona 
------------------------------------------------------------

------------------------------------------------------------
-- apex_objeto
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto (proyecto, objeto, anterior, identificador, reflexivo, clase_proyecto, clase, punto_montaje, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion, posicion_botonera) VALUES (
	'sagep', --proyecto
	'4252', --objeto
	NULL, --anterior
	NULL, --identificador
	NULL, --reflexivo
	'toba', --clase_proyecto
	'toba_ci', --clase
	'30', --punto_montaje
	'ci_agregarpersona', --subclase
	'personas/gestion_de_personas/agregar_persona/ci_agregarpersona.php', --subclase_archivo
	NULL, --objeto_categoria_proyecto
	NULL, --objeto_categoria
	'ci_gestiondepersonas - ci_agregarpersona', --nombre
	'Agregar', --titulo
	'0', --colapsable
	NULL, --descripcion
	NULL, --fuente_datos_proyecto
	NULL, --fuente_datos
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
	'2017-10-21 19:28:06', --creacion
	'abajo'  --posicion_botonera
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_mt_me
------------------------------------------------------------
INSERT INTO apex_objeto_mt_me (objeto_mt_me_proyecto, objeto_mt_me, ev_procesar_etiq, ev_cancelar_etiq, ancho, alto, posicion_botonera, tipo_navegacion, botonera_barra_item, con_toc, incremental, debug_eventos, activacion_procesar, activacion_cancelar, ev_procesar, ev_cancelar, objetos, post_procesar, metodo_despachador, metodo_opciones) VALUES (
	'sagep', --objeto_mt_me_proyecto
	'4252', --objeto_mt_me
	NULL, --ev_procesar_etiq
	NULL, --ev_cancelar_etiq
	'100%', --ancho
	NULL, --alto
	NULL, --posicion_botonera
	'tab_h', --tipo_navegacion
	'0', --botonera_barra_item
	'1', --con_toc
	NULL, --incremental
	NULL, --debug_eventos
	NULL, --activacion_procesar
	NULL, --activacion_cancelar
	NULL, --ev_procesar
	NULL, --ev_cancelar
	NULL, --objetos
	NULL, --post_procesar
	NULL, --metodo_despachador
	NULL  --metodo_opciones
);

------------------------------------------------------------
-- apex_objeto_dependencias
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'sagep', --proyecto
	'2849', --dep_id
	'4252', --objeto_consumidor
	'4253', --objeto_proveedor
	'form', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'sagep', --proyecto
	'2851', --dep_id
	'4252', --objeto_consumidor
	'4255', --objeto_proveedor
	'form_ml_correos', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'sagep', --proyecto
	'2853', --dep_id
	'4252', --objeto_consumidor
	'4257', --objeto_proveedor
	'form_ml_cuentas', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'sagep', --proyecto
	'2850', --dep_id
	'4252', --objeto_consumidor
	'4254', --objeto_proveedor
	'form_ml_direcciones', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'sagep', --proyecto
	'2852', --dep_id
	'4252', --objeto_consumidor
	'4256', --objeto_proveedor
	'form_ml_telefonos', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_ci_pantalla
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto_ci_pantalla (objeto_ci_proyecto, objeto_ci, pantalla, identificador, orden, etiqueta, descripcion, tip, imagen_recurso_origen, imagen, objetos, eventos, subclase, subclase_archivo, template, template_impresion, punto_montaje) VALUES (
	'sagep', --objeto_ci_proyecto
	'4252', --objeto_ci
	'1815', --pantalla
	'persona', --identificador
	'1', --orden
	'Persona', --etiqueta
	'Ingrese los datos personales <br/>
		<ul>
		  <li>Seleccione un Tipo de Persona y continué con la carga según lo ingresado </li>
		  <li>Ingrese el numero de CUIL / CUIT, sin guiones ni puntos</li>
		  <li>Ingrese la Fecha de Nacimiento. En caso de Personas Jurídicas, ingrese la fecha de inicio de actividad</li>
		  <li>Opcionalmente puede adjuntar imagen de la Persona</li>
		</ul>

Seleccione una nueva pestaña para continuar con la carga.<br/>
		<div style="border: 0px #000000 solid; text-align:right">Nota:  Para finalizar presione "Guardar" o "Cancelar" para anular la operación.</div>', --descripcion
	NULL, --tip
	'apex', --imagen_recurso_origen
	NULL, --imagen
	NULL, --objetos
	NULL, --eventos
	NULL, --subclase
	NULL, --subclase_archivo
	NULL, --template
	NULL, --template_impresion
	'30'  --punto_montaje
);
INSERT INTO apex_objeto_ci_pantalla (objeto_ci_proyecto, objeto_ci, pantalla, identificador, orden, etiqueta, descripcion, tip, imagen_recurso_origen, imagen, objetos, eventos, subclase, subclase_archivo, template, template_impresion, punto_montaje) VALUES (
	'sagep', --objeto_ci_proyecto
	'4252', --objeto_ci
	'1816', --pantalla
	'direccion', --identificador
	'2', --orden
	'Direccion', --etiqueta
	'Ingrese la información sobre la dirección <br/>
		<ul>
		  <li>Seleccione un Tipo de Persona. Según lo ingresado, se solicitaran los datos correspondientes </li>
		  <li>Cargue el numero de CUIL de la persona, sin guiones ni puntos</li>
		  <li>Ingrese la fecha de Nacimiento. En caso de Personas Físicas, ingrese la fecha de inicio de actividad</li>
		  <li>Opcionalmente puede adjuntar imagen de la Persona</li>
		  <li>Seleccione una pestaña para posicionarse en otra Pantalla</li>
		</ul>
		<div style="border: 0px #000000 solid; text-align:right">Nota: Al finalizar la carga presione "Guardar" o "Cancelar".</div>
		<div style="border: 0px #000000 solid; text-align:right"></div>', --descripcion
	NULL, --tip
	'apex', --imagen_recurso_origen
	NULL, --imagen
	NULL, --objetos
	NULL, --eventos
	NULL, --subclase
	NULL, --subclase_archivo
	NULL, --template
	NULL, --template_impresion
	'30'  --punto_montaje
);
INSERT INTO apex_objeto_ci_pantalla (objeto_ci_proyecto, objeto_ci, pantalla, identificador, orden, etiqueta, descripcion, tip, imagen_recurso_origen, imagen, objetos, eventos, subclase, subclase_archivo, template, template_impresion, punto_montaje) VALUES (
	'sagep', --objeto_ci_proyecto
	'4252', --objeto_ci
	'1817', --pantalla
	'contacto', --identificador
	'3', --orden
	'Contacto', --etiqueta
	'Ingrese la información de contacto <br/>
		<ul>
		  <li>Seleccione un Tipo de Persona. Según lo ingresado, se solicitaran los datos correspondientes </li>
		  <li>Cargue el numero de CUIL de la persona, sin guiones ni puntos</li>
		  <li>Ingrese la fecha de Nacimiento. En caso de Personas Físicas, ingrese la fecha de inicio de actividad</li>
		  <li>Opcionalmente puede adjuntar imagen de la Persona</li>
		  <li>Seleccione una pestaña para posicionarse en otra Pantalla</li>
		</ul>
		<div style="border: 0px #000000 solid; text-align:right">Nota: Al finalizar la carga presione "Guardar" o "Cancelar".</div>
		<div style="border: 0px #000000 solid; text-align:right"></div>', --descripcion
	NULL, --tip
	'apex', --imagen_recurso_origen
	NULL, --imagen
	NULL, --objetos
	NULL, --eventos
	NULL, --subclase
	NULL, --subclase_archivo
	NULL, --template
	NULL, --template_impresion
	'30'  --punto_montaje
);
INSERT INTO apex_objeto_ci_pantalla (objeto_ci_proyecto, objeto_ci, pantalla, identificador, orden, etiqueta, descripcion, tip, imagen_recurso_origen, imagen, objetos, eventos, subclase, subclase_archivo, template, template_impresion, punto_montaje) VALUES (
	'sagep', --objeto_ci_proyecto
	'4252', --objeto_ci
	'1818', --pantalla
	'cuenta', --identificador
	'4', --orden
	'Cuenta', --etiqueta
	NULL, --descripcion
	NULL, --tip
	'apex', --imagen_recurso_origen
	NULL, --imagen
	NULL, --objetos
	NULL, --eventos
	NULL, --subclase
	NULL, --subclase_archivo
	NULL, --template
	NULL, --template_impresion
	NULL  --punto_montaje
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objetos_pantalla
------------------------------------------------------------
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'sagep', --proyecto
	'1815', --pantalla
	'4252', --objeto_ci
	'0', --orden
	'2849'  --dep_id
);
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'sagep', --proyecto
	'1816', --pantalla
	'4252', --objeto_ci
	'0', --orden
	'2850'  --dep_id
);
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'sagep', --proyecto
	'1817', --pantalla
	'4252', --objeto_ci
	'0', --orden
	'2851'  --dep_id
);
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'sagep', --proyecto
	'1817', --pantalla
	'4252', --objeto_ci
	'1', --orden
	'2852'  --dep_id
);
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'sagep', --proyecto
	'1818', --pantalla
	'4252', --objeto_ci
	'0', --orden
	'2853'  --dep_id
);
