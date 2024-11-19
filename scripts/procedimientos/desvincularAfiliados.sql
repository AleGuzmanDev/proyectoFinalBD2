CREATE OR REPLACE PROCEDURE desvincular_inactivos IS
    CURSOR cur_afiliados_inactivos IS
        SELECT a.id_afiliado, a.nombre
        FROM Afiliado a
        WHERE NOT EXISTS (
            SELECT 1
            FROM Venta v
            WHERE v.id_afiliado = a.id_afiliado
            AND v.fecha_venta > ADD_MONTHS(SYSDATE, -3)  -- Comprobar si ha realizado ventas en los últimos 3 meses
        );
BEGIN
    -- Imprimir encabezado para la salida
    DBMS_OUTPUT.PUT_LINE('ID_AFILIADO | NOMBRE_AFILIADO');
    DBMS_OUTPUT.PUT_LINE('-----------------------------------');
    
    -- Iterar sobre los afiliados inactivos
    FOR afiliado IN cur_afiliados_inactivos LOOP
        -- Eliminar afiliado inactivo
        DELETE FROM Afiliado
        WHERE id_afiliado = afiliado.id_afiliado;
        
        -- Mostrar el afiliado que ha sido desvinculado
        DBMS_OUTPUT.PUT_LINE(afiliado.id_afiliado || ' | ' || afiliado.nombre);
    END LOOP;

    -- Confirmar que la desvinculación se completó
    COMMIT;
END;
/
