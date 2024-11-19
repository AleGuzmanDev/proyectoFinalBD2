
CREATE OR REPLACE PROCEDURE listar_despachos IS
    -- Declaración del cursor para obtener los despachos
    CURSOR despachos_cursor IS
        SELECT id_despacho, id_venta, estado, fecha_despacho, fecha_entrega
        FROM Despacho;
    
    -- Variables para almacenar los datos del cursor
    v_id_despacho Despacho.id_despacho%TYPE;
    v_id_venta Despacho.id_venta%TYPE;
    v_estado Despacho.estado%TYPE;
    v_fecha_despacho Despacho.fecha_despacho%TYPE;
    v_fecha_entrega Despacho.fecha_entrega%TYPE;
BEGIN
    -- Abrir el cursor
    OPEN despachos_cursor;
    
    -- Bucle para recorrer los resultados
    LOOP
        FETCH despachos_cursor INTO v_id_despacho, v_id_venta, v_estado, v_fecha_despacho, v_fecha_entrega;
        
        -- Salir del bucle si no hay más datos
        EXIT WHEN despachos_cursor%NOTFOUND;
        
        -- Imprimir los resultados
        DBMS_OUTPUT.PUT_LINE('ID Despacho: ' || v_id_despacho || 
                             ', ID Venta: ' || v_id_venta || 
                             ', Estado: ' || v_estado || 
                             ', Fecha Despacho: ' || TO_CHAR(v_fecha_despacho, 'DD-MM-YYYY') || 
                             ', Fecha Entrega: ' || TO_CHAR(v_fecha_entrega, 'DD-MM-YYYY'));
    END LOOP;
    
    -- Cerrar el cursor
    CLOSE despachos_cursor;
END listar_despachos;
/
