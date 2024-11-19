CREATE OR REPLACE FUNCTION crear_afiliado(
    p_nombre IN VARCHAR2,
    p_cedula IN VARCHAR2,
    p_email IN VARCHAR2,
    p_telefono IN VARCHAR2 DEFAULT NULL,
    p_direccion IN VARCHAR2 DEFAULT NULL,
    p_estado IN VARCHAR2 DEFAULT 'Activo',
    p_nivel_hierarquia IN NUMBER DEFAULT 1,
    p_afiliado_superior_id IN NUMBER DEFAULT NULL
) RETURN NUMBER AS
    resultado NUMBER;
    error_mensaje VARCHAR2(500);
BEGIN
    BEGIN
        -- Intentar insertar los datos en la tabla AFILIADO
        INSERT INTO AFILIADO (
            ID_AFILIADO,
            NOMBRE,
            CEDULA,
            EMAIL,
            TELEFONO,
            DIRECCION,
            FECHA_AFILIACION,
            ESTADO,
            NIVEL_HIERARQUIA,
            AFILIADO_SUPERIOR_ID
        ) VALUES (
            9999,
            p_nombre,
            p_cedula,
            p_email,
            p_telefono,
            p_direccion,
            SYSDATE,
            p_estado,
            p_nivel_hierarquia,
            p_afiliado_superior_id
        );

        -- Si la operación es exitosa, establecer el resultado en 1
        resultado := 1;
    EXCEPTION
         WHEN DUP_VAL_ON_INDEX THEN
            -- Si el correo ya existe, retornar 0
            resultado := 0;
        WHEN NO_DATA_FOUND THEN
            -- Si no se encuentra el registro solicitado
            resultado := -2;
        WHEN OTHERS THEN
            -- Si ocurre otro error, capturar mensaje y retornar -1
            error_mensaje := SUBSTR(SQLERRM, 1, 255);  -- Capturar mensaje del error
            resultado := -1;
            RAISE_APPLICATION_ERROR(-20004, 'Error al crear afiliado: ' || error_mensaje);  -- Pasar mensaje detallado
    END;

    -- Retornar el resultado
    RETURN resultado;
END crear_afiliado;
