CREATE OR REPLACE PROCEDURE obtener_productos(p_cursor OUT SYS_REFCURSOR) AS
BEGIN
    OPEN p_cursor FOR
        SELECT ID_PRODUCTO, NOMBRE, CATEGORIA, PRECIO, STOCK
        FROM PRODUCTO;
END;