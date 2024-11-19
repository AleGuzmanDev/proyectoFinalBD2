CREATE OR REPLACE PROCEDURE crear_venta (
    p_id_venta IN NUMBER,            -- ID de la venta (obligatorio)
    p_id_afiliado IN NUMBER,         -- ID del afiliado (obligatorio)
    p_total_venta IN NUMBER,         -- Total de la venta (obligatorio)
    p_fecha_venta IN DATE            -- Fecha de la venta (obligatorio)
) AS
BEGIN
    -- Insertamos los datos de la venta en la tabla
    INSERT INTO VENTA (
        ID_VENTA,
        ID_AFILIADO,
        TOTAL_VENTA,
        FECHA_VENTA
    ) VALUES (
        p_id_venta,
        p_id_afiliado,
        p_total_venta,
        p_fecha_venta
    );

    COMMIT; -- Confirmamos la transacción
EXCEPTION
    WHEN OTHERS THEN
        -- En caso de error, deshacemos los cambios y mostramos un mensaje
        ROLLBACK;
        RAISE;
END crear_venta;
