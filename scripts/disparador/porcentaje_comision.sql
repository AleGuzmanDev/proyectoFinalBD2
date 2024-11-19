CREATE OR REPLACE TRIGGER verificar_comision
BEFORE INSERT OR UPDATE ON Comision
FOR EACH ROW
BEGIN
    -- Verificar que el monto_comision sea mayor a cero
    IF :NEW.monto_comision <= 0 THEN
        RAISE_APPLICATION_ERROR(-20001, 'La comisión debe ser mayor a cero.');
    END IF;
END;