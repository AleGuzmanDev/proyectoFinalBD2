CREATE OR REPLACE PROCEDURE validar_usuario(
    p_nombre_usuario IN VARCHAR2, 
    p_contrasena IN VARCHAR2
) AS
    v_count NUMBER; -- Variable para contar los usuarios
BEGIN
    -- Verificar si el usuario existe en la base de datos
    SELECT COUNT(*) INTO v_count
    FROM CUENTA
    WHERE USUARIO = p_nombre_usuario;

    -- Si el usuario no existe, generar un error
    IF v_count = 0 THEN
        RAISE_APPLICATION_ERROR(-20001, 'El nombre de usuario no existe.');
    END IF;

    -- Si el usuario existe, validar la contrase�a
    DECLARE
        v_contrasena_db VARCHAR2(20); -- Variable para almacenar la contrase�a de la base de datos
    BEGIN
        -- Obtener la contrase�a almacenada en la base de datos
        SELECT CONTRASENIA INTO v_contrasena_db
        FROM CUENTA
        WHERE USUARIO = p_nombre_usuario;

        -- Comparar la contrase�a ingresada con la almacenada
        IF v_contrasena_db != p_contrasena THEN
            RAISE_APPLICATION_ERROR(-20002, 'La contrase�a es incorrecta.');
        END IF;
    END;
END validar_usuario;
