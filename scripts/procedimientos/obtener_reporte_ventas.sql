CREATE OR REPLACE PROCEDURE obtener_reporte_ventas(p_cursor OUT SYS_REFCURSOR) AS
BEGIN
    OPEN p_cursor FOR
        SELECT ID_VENTA, TOTAL 
        FROM VENTA;
END;
/
