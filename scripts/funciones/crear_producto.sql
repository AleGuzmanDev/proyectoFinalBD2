CREATE OR REPLACE PROCEDURE crear_producto (
    p_id_producto IN NUMBER,         -- ID del producto (obligatorio)
    p_nombre IN VARCHAR2,            -- Nombre del producto (obligatorio)
    p_categoria IN VARCHAR2,         -- Categoría del producto
    p_precio IN NUMBER,              -- Precio del producto (obligatorio)
    p_stock IN NUMBER                -- Stock del producto (obligatorio)
) AS
BEGIN
    -- Insertar los datos del producto en la tabla
    INSERT INTO PRODUCTO (
        ID_PRODUCTO,
        NOMBRE,
        CATEGORIA,
        PRECIO,
        STOCK
    ) VALUES (
        p_id_producto,
        p_nombre,
        p_categoria,
        p_precio,
        p_stock
    );

    COMMIT; -- Confirmar la transacción
EXCEPTION
    WHEN OTHERS THEN
        -- En caso de error, deshacer los cambios y mostrar un mensaje
        ROLLBACK;
        RAISE;
END crear_producto;
