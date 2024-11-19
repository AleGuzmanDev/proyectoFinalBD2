CREATE OR REPLACE PROCEDURE crear_comision (
    p_id_venta IN NUMBER,
    p_id_afiliado IN NUMBER,
    p_nivel_hierarquia IN NUMBER,
    p_monto_comision IN NUMBER,
    p_id_comision OUT NUMBER
) AS
BEGIN
    -- Insertamos la comisión en la tabla
    INSERT INTO COMISION (
        ID_VENTA,
        ID_AFILIADO,
        NIVEL_HIERARQUIA,
        MONTO_COMISION
    ) VALUES (
        p_id_venta,
        p_id_afiliado,
        p_nivel_hierarquia,
        p_monto_comision
    )
    RETURNING ID_COMISION INTO p_id_comision; -- Regresamos el ID generado

    COMMIT; -- Confirmamos la transacción
EXCEPTION
    WHEN OTHERS THEN
        -- En caso de error, deshacemos los cambios y mostramos un mensaje
        ROLLBACK;
        RAISE;
END crear_comision;
