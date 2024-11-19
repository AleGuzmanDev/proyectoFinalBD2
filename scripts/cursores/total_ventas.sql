-- Cursor para las ventas donde se recorren y se va totalizando el total global

-- Habilitar DBMS_OUTPUT
SET SERVEROUTPUT ON;

DECLARE
   v_total_ventas NUMBER := 0;
   CURSOR c_ventas IS 
       SELECT ID_VENTA, TOTAL 
       FROM VENTA;
BEGIN
   FOR r_venta IN c_ventas LOOP
       v_total_ventas := v_total_ventas + r_venta.TOTAL;
       DBMS_OUTPUT.PUT_LINE('ID Venta: ' || r_venta.ID_VENTA || 
                          ' - Total: $' || r_venta.TOTAL || 
                          ' - Suma acumulada: $' || v_total_ventas);
   END LOOP;
   
   DBMS_OUTPUT.PUT_LINE('Total ventas final: $' || v_total_ventas);
END;