CREATE OR REPLACE PROCEDURE crear_configuracion_comision (
    p_nivel IN NUMBER,                 -- Nivel de la comisión
    p_porcentaje_comision IN NUMBER,    -- Porcentaje de la comisión
    p_id_configuracion OUT NUMBER      -- ID generado para la configuración
) AS
BEGIN
    -- Insertamos la configuración de comisión en la tabla
    INSERT INTO CONFIGURACION_COMISION (
        NIVEL,
        PORCENTAJE_COMISION
    ) VALUES (
        p_nivel,
        p_porcentaje_comision
    )
    RETURNING ID_CONFIGURACION INTO p_id_configuracion; -- Regresamos el ID generado

    COMMIT; -- Confirmamos la transacción
EXCEPTION
    WHEN OTHERS THEN
        -- En caso de error, deshacemos los cambios y mostramos un mensaje
        ROLLBACK;
        RAISE;
END crear_configuracion_comision;
