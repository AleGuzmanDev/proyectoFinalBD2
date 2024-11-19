--------------------------------------------------------
--  DDL for Sequence SEQ_INVENTARIO_ID
--------------------------------------------------------

DECLARE
  v_max NUMBER;
BEGIN
  SELECT NVL(MAX(ID_INVENTARIO),0) + 1 INTO v_max FROM INVENTARIO;
  EXECUTE IMMEDIATE 'CREATE SEQUENCE SEQ_INVENTARIO_ID START WITH ' || v_max || ' INCREMENT BY 1 NOMAXVALUE NOCACHE NOCYCLE';
END;
/
--------------------------------------------------------
--  DDL for Trigger TRG_INVENTARIO_ID
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "TRG_INVENTARIO_ID" 
BEFORE INSERT ON INVENTARIO
FOR EACH ROW
BEGIN
    IF :NEW.ID_INVENTARIO IS NULL THEN
        SELECT SEQ_INVENTARIO_ID.NEXTVAL
        INTO :NEW.ID_INVENTARIO
        FROM DUAL;
    END IF;
END;

/
ALTER TRIGGER "TRG_INVENTARIO_ID" ENABLE;