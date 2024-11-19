-- Funciones
-- Autores: Anderson Fonseca Lopez, Alejandra Guzman, Johan Manuel Colorado

--------------------------------------------------------
--  Crear funcion validar usuario
--------------------------------------------------------
CREATE OR REPLACE FUNCTION validar_usuario(
    p_nombre_usuario IN VARCHAR2,
    p_contrasena IN VARCHAR2
) RETURN NUMBER AS
    v_contrasena_db VARCHAR2(20); -- Variable para almacenar la contrase�a desde la base de datos
    resultado NUMBER; -- Variable para el resultado interno
BEGIN
    -- Inicializar resultado en �xito por defecto
    resultado := 1;

    BEGIN
        -- Intentar obtener la contrase�a del usuario desde la base de datos
        SELECT CONTRASENIA INTO v_contrasena_db
        FROM CUENTA
        WHERE USUARIO = p_nombre_usuario;

        -- Comparar la contrase�a ingresada con la almacenada
        IF v_contrasena_db != p_contrasena THEN
            -- Contrase�a incorrecta
            resultado := 0;
        END IF;
    EXCEPTION
        WHEN NO_DATA_FOUND THEN
            -- Usuario no encontrado
            resultado := 0;
        WHEN OTHERS THEN
            -- Error inesperado
            resultado := -1;
    END;

    -- Retornar el resultado
    RETURN resultado;
END validar_usuario;