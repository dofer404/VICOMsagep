
CREATE OR REPLACE FUNCTION es_sagep.f_concatenar(text, text)
RETURNS text AS
$$
	BEGIN

  if $1 is null then
    return $2;
  end if;
  if $2 is null then
    return $1;
  end if;
  return $1 || ' ' || $2;
	END;
$$LANGUAGE plpgsql;

create aggregate es_sagep.text_concat(text)(sfunc = f_concatenar_correos, stype = text);

select text_concat(cor.direccion ||''||  ',') from es_sagep.correos cor, es_sagep.personas per
where per.id_persona = cor.id_persona and per.id_persona = 14

select text_concat(coalesce(tel.caracteristica ||''|| ')' || ' - ' || tel.numero) ||''||  ',') from es_sagep.telefonos tel, es_sagep.personas per
where per.id_persona = tel.id_persona and per.id_persona = 14
