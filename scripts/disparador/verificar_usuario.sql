CREATE OR REPLACE TRIGGER VERIFICAR_USUARIO
BEFORE INSERT OR UPDATE ON CUENTA
FOR EACH ROW
DECLARE
    v_count NUMBER;  -- Variable para almacenar el conteo
BEGIN
    -- Verifica si ya existe un usuario con el mismo nombre de usuario
    SELECT COUNT(*)
    INTO v_count
    FROM CUENTA
    WHERE USUARIO = :NEW.USUARIO;

    IF v_count > 0 THEN
        -- Si ya existe, genera un error y evita la inserción o actualización
        RAISE_APPLICATION_ERROR(-20001, 'El nombre de usuario ya existe. No se puede duplicar.');
    END IF;
END;
