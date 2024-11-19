CREATE OR REPLACE PROCEDURE obtener_reporte_por_vendedor(p_cursor OUT SYS_REFCURSOR) AS
BEGIN
    OPEN p_cursor FOR
        SELECT 
            v.ID_AFILIADO,
            vend.NOMBRE,
            COUNT(v.ID_VENTA) AS NUMERO_VENTAS,
            SUM(v.TOTAL) AS TOTAL_VENTAS
        FROM 
            VENTA v
        JOIN 
            AFILIADO vend
        ON 
            v.ID_AFILIADO = vend.ID_AFILIADO
        GROUP BY 
            v.ID_AFILIADO, vend.NOMBRE
        ORDER BY 
            TOTAL_VENTAS DESC;
END;
/
