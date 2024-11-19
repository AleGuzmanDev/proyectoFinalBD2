
    CREATE OR REPLACE PROCEDURE historial_ventas IS
    CURSOR cur_ventas IS
        SELECT 
            v.id_venta,                     -- ID de la venta
            v.fecha_venta,                  -- Fecha de la venta
            v.total AS total_venta,         -- Monto total de la venta
            a.nombre AS afiliado            -- Nombre del afiliado
        FROM 
            Venta v
        JOIN 
            Afiliado a ON v.id_afiliado = a.id_afiliado  -- Relación con el afiliado
        ORDER BY 
            v.fecha_venta DESC;             -- Ordenar por fecha de la venta (más recientes primero)
BEGIN
    -- Encabezados para mostrar resultados en la consola
    DBMS_OUTPUT.PUT_LINE('ID_VENTA | FECHA_VENTA | TOTAL_VENTA | AFILIADO');
    DBMS_OUTPUT.PUT_LINE('----------------------------------------------');
    
    -- Iterar sobre cada registro obtenido por el cursor
    FOR venta IN cur_ventas LOOP
        -- Mostrar los datos de la venta en cada iteración
        DBMS_OUTPUT.PUT_LINE(venta.id_venta || ' | ' || 
                             venta.fecha_venta || ' | ' || 
                             venta.total_venta || ' | ' || 
                             venta.afiliado);
    END LOOP;
END;





