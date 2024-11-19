CREATE SEQUENCE afiliado_seq
START WITH 1
INCREMENT BY 1
NOCACHE;


CREATE OR REPLACE TRIGGER trg_afiliado_id
BEFORE INSERT ON AFILIADO
FOR EACH ROW
BEGIN
    -- Asigna el valor de la secuencia al ID_AFILIADO antes de insertar
    :NEW.ID_AFILIADO := afiliado_seq.NEXTVAL;
END;
/
