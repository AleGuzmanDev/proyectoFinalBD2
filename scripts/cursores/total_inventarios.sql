-- Cursor para los inventarios donde se recorren y se va totalizando el stock global 
-- Habilitar DBMS_OUTPUT
SET SERVEROUTPUT ON;

DECLARE
    v_total_stock NUMBER := 0;
    CURSOR c_inventario IS 
        SELECT ID_INVENTARIO, STOCK 
        FROM INVENTARIO;
BEGIN
    FOR r_inventario IN c_inventario LOOP
        v_total_stock := v_total_stock + r_inventario.STOCK;
        DBMS_OUTPUT.PUT_LINE('ID: ' || r_inventario.ID_INVENTARIO || 
                           ' - Stock: ' || r_inventario.STOCK || 
                           ' - Suma acumulada: ' || v_total_stock);
    END LOOP;
    
    DBMS_OUTPUT.PUT_LINE('Total stock final: ' || v_total_stock);
END;