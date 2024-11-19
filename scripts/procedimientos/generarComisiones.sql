
CREATE OR REPLACE PROCEDURE generar_comisiones(
    p_venta_id IN NUMBER
) AS
    -- Definición de variables
    v_id_afiliado NUMBER;
    v_nivel_hierarquia NUMBER;  -- Cambiado el nombre a hierarquia
    v_total_venta NUMBER;
    v_comision NUMBER;
    v_porcentaje NUMBER;
    v_afiliado_superior_id NUMBER;
BEGIN
    -- Obtener el total de la venta
    SELECT total
    INTO v_total_venta
    FROM Venta
    WHERE id_venta = p_venta_id;

    -- Inicializar el afiliado
    SELECT id_afiliado
    INTO v_id_afiliado
    FROM Venta
    WHERE id_venta = p_venta_id;
    
    -- Recorrer los niveles jerárquicos
    FOR i IN 1..10 LOOP  -- Suponiendo que el máximo nivel de jerarquía es 10
        -- Obtener el nivel y el afiliado superior
        BEGIN
            SELECT NIVEL_HIERARQUIA, AFILIADO_SUPERIOR_ID  -- Usando el nombre correcto
            INTO v_nivel_hierarquia, v_afiliado_superior_id
            FROM Afiliado
            WHERE id_afiliado = v_id_afiliado;
        EXCEPTION
            WHEN NO_DATA_FOUND THEN
                -- Si no hay datos para ese afiliado, salir del bucle
                EXIT;
            WHEN OTHERS THEN
                RAISE;
        END;

        -- Determinar el porcentaje de comisión en función del nivel
        IF v_nivel_hierarquia = 1 THEN
            v_porcentaje := 0.10;  -- 10% para el primer nivel
        ELSIF v_nivel_hierarquia = 2 THEN
            v_porcentaje := 0.08;  -- 8% para el segundo nivel
        ELSIF v_nivel_hierarquia = 3 THEN
            v_porcentaje := 0.05;  -- 5% para el tercer nivel
        ELSE
            v_porcentaje := 0.03;  -- 3% para los niveles a partir del 4
        END IF;

        -- Calcular la comisión
        v_comision := v_total_venta * v_porcentaje;

        -- Insertar la comisión en la tabla de comisiones
        INSERT INTO Comision (id_venta, id_afiliado, nivel_hierarquia, monto_comision)  -- Cambiado para usar hierarquia
        VALUES (p_venta_id, v_id_afiliado, v_nivel_hierarquia, v_comision);
        
        -- Cambiar al afiliado superior para el siguiente nivel
        v_id_afiliado := v_afiliado_superior_id;

        -- Si el afiliado superior es nulo, salir del bucle
        IF v_id_afiliado IS NULL THEN
            EXIT;
        END IF;
    END LOOP;

    COMMIT;
END generar_comisiones;








