SET search_path TO es_sagep;

CREATE OR REPLACE FUNCTION sf_tgr_contratos_monto_total() RETURNS TRIGGER
	AS $$
	DECLARE var_montoTotalCalc NUMERIC;
	DECLARE var_cantMeses INTEGER;
	BEGIN
		SELECT SUM(monto_total)
			INTO var_montoTotalCalc
			FROM detalles_contrato
			WHERE id_contrato = NEW.id_contrato;

		SELECT cantidad * var_montoTotalCalc
			INTO var_montoTotalCalc
			FROM es_sagep.tipos_contratos
			WHERE id_tipo_contrato = NEW.id_tipo_contrato;

		IF NEW.monto_total <> var_montoTotalCalc::REAL THEN
			RAISE EXCEPTION
				'%', 'Error: La operación que intenta realizar fue'
				|| ' cancelada. Intentó registrar un contrato con un monto_total'
				|| ' distinto al que da la suma de todos los detalles multiplicada'
				|| ' por la cantidad de meses. Monto Total Ingresado: '
				|| NEW.monto_total::VARCHAR || '; Monto Total Calculado: '
				|| var_montoTotalCalc::REAL::VARCHAR || '. Verifique los datos e'
				|| ' intente nuevamente. Si continua recibiendo este mensaje'
				|| ' comuniquese con el administrador.';
		END IF;

		RETURN NEW;
	END $$
	LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS tgr_contratos_monto_total ON contratos;

CREATE CONSTRAINT TRIGGER tgr_contratos_monto_total
	AFTER INSERT OR UPDATE ON contratos DEFERRABLE INITIALLY DEFERRED
	FOR EACH ROW EXECUTE PROCEDURE sf_tgr_contratos_monto_total();
